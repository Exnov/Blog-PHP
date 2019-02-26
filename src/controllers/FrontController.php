<?php

namespace App\src\controllers;

use App\src\DAO\ManagerArticles; 
use App\src\DAO\ManagerCommentaires;
use App\src\DAO\ManagerAccueil; 
use App\src\DAO\ManagerAbout;
use App\src\entities\Admin;
use App\src\entities\View;

use App\src\entities\ArticlePeriph;

class FrontController{

	private $managerArticles; 
	private $managerCommentaires;
	private $admin;
	private $view;
	private $aArticle; 
	private $nArticle; 
	private $managerAccueil; 
    private $managerAbout;	
    private $articlePeriph;

	public function __construct(){

		$this->managerArticles=new ManagerArticles();
		$this->managerCommentaires=new ManagerCommentaires();
		$this->admin = new Admin();
		$this->view = new View();
		$this->aArticle=0;
		$this->nArticle=6; 
		$this->managerAccueil=new ManagerAccueil();
        $this->managerAbout=new ManagerAbout(); 	
        $this->articlePeriph=new ArticlePeriph();
	}

    public function home(){
    	
        session_start();

		$articles=$this->managerArticles->getArticles($this->aArticle,$this->nArticle);
		$nArticles=$this->managerArticles->getNbreArticles();
		$accueil=$this->managerAccueil->getData();

        $this->view->render('public/accueil', [ 
            'articles' => $articles,
            'nArticles'=>$nArticles,
            'classe'=>'pagination',
            'managerCommentaires'=>$this->managerCommentaires,
            'accueil'=>$accueil
        ]);
    }

   	public function article($article_id){

		$article=$this->managerArticles->getArticle($article_id);

		if($article){
			session_start();
			$commentaires=$this->managerCommentaires->getCommentaires($article_id);
            //---------------
            //recupération des id des article précédent et suivant l'article en cours
            $articles_periph=$this->managerArticles->getTotalArticles($article_id);
            $articlePrevious=$articles_periph['previous'];
            $articleNext=$articles_periph['next'];     

            $htmlArticlePrevious=$this->articlePeriph->getHtml($articlePrevious,'L\' histoire commence ... ');
            $htmlArticleNext=$this->articlePeriph->getHtml($articleNext,'La suite bientôt ...');
            //-------------------------------------------------	        
	        $this->view->render('public/article', [ 
	            'article' => $article,
	            'commentaires' => $commentaires,
                'htmlArticlePrevious'=>$htmlArticlePrevious,
                'htmlArticleNext'=>$htmlArticleNext
	        ]);		
		}
        else{
            $this->view->render('error', [
                'error' => 'Article inconnu au bataillon'
            ]);
        }  
    }

    public function pagination(){

        $this->aArticle=$_POST['aArticle'];   
         
		$articles=$this->managerArticles->getArticles($this->aArticle,$this->nArticle);
        
        session_start();
        $validation=false; //pour récupérer le lien d'édition des articles si user connecté

        if(isset($_SESSION['user'])){
            $validation=true;
        }
        //maj des billets dans le template
        $viewArticles=$this->view->renderFile('src/templates/public/articles.php', [ 
        	'articles' => $articles,
        	'managerCommentaires'=>$this->managerCommentaires,
            'validation'=>$validation
        ]);

        $nArticles=$this->managerArticles->getNbreArticles();
        echo (json_encode(array('vueArticles'=>$viewArticles,'totalArticles'=>$nArticles['nbre'])));        
    }

    public function about(){

    	session_start();

        $about=$this->managerAbout->getData();
        $description="";
        $avatar="";
        $email="";
        $contenu="";

        if(isset($about)){

            $description=$about->getDescription();
            $avatar=$about->getAvatar();
            $email=$about->getEmail();
            $contenu=$about->getContenu();
            if(!empty($avatar)){
                $avatar='web/images/'.$avatar;
            }                 
        }     
        $this->view->render('public/about', [
            'description'=>$description,
            'avatar'=>$avatar,
            'email'=>$email,
            'contenu'=>$contenu
         ]);   	
    }
    //---------------------
}