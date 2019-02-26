<?php

namespace App\src\controllers;

use App\src\DAO\ManagerArticlesBack;
use App\src\DAO\ManagerCommentaires;
use App\src\DAO\ManagerUser;
use App\src\DAO\ManagerAccueil; 
use App\src\DAO\ManagerAbout;
use App\src\DAO\ManagerLogos;
use App\src\DAO\ManagerFooter;
use App\src\entities\Auth; 
use App\src\entities\View;
use App\src\entities\Imagor;
use App\src\entities\Admin;


class BackController{

    private $managerArticles; 
    private $managerCommentaires;
    private $auth; 
    private $view;
    private $aArticle; 
    private $nArticle; 
    private $aCommentaire;
    private $nCommentaire;    
    private $admin;
    private $managerUser;
    private $managerAccueil;
    private $managerAbout;
    private $managerLogos;
    private $managerFooter;

    public function __construct(){

        $this->managerArticles=new ManagerArticlesBack();
        $this->managerCommentaires=new ManagerCommentaires();
        $this->auth=new Auth(); 
        $this->view = new View();
        $this->aArticle=0;
        $this->nArticle=6;  
        $this->aCommentaire=0;
        $this->nCommentaire=10;  
        $this->admin=new Admin();
        $this->managerUser=new ManagerUser(); 
        $this->managerAccueil=new ManagerAccueil(); 
        $this->managerAbout=new ManagerAbout();  
        $this->managerLogos=new ManagerLogos();
        $this->managerFooter=new ManagerFooter();

    }

    public function login(){

        $this->view->render('edition/login',array()); 
    }

    public function check($post){

        session_start();

        if(isset($_SESSION['user'])){ //accès page admin après connexion

            $donnees= $this->admin->buildData($this->managerArticles,$this->managerCommentaires,$this->aArticle,$this->nArticle);
             $this->view->render('edition/articles', $donnees);
        }        
        //--------------
        else if(isset($post['submit'])) { //accès page admin au moment de la connexion

            $user=$this->auth->check($post["login"],$post["password"]);

            if($user){

                $_SESSION['auteur']=$user->getNom();
                $_SESSION['user'] = $user->getLogin();

                //--------------------------------------------------------------------------------------
                $donnees= $this->admin->buildData($this->managerArticles,$this->managerCommentaires,$this->aArticle,$this->nArticle);
                 $this->view->render('edition/articles', $donnees); 
                //-------------------------------------------------------------------------------------- 
            }
            else{
                 $message="informations non correctes";
                 $this->view->render('edition/login', [ 
                     "message"=>$message
                ]); 
            }
        }  
        else{ //si tentative d'affichage de la page via url, sans être connecté, retour à la page d'accueil
            header('Location: accueil'); 
        }
        //-------------------------               
    }

     public function logout($post){

        session_start();
        session_unset();
        session_destroy ();
        header('Location: accueil'); 

    }

     public function edit(){

        session_start();

        if(isset($_SESSION['user'])){

            $article=$this->managerArticles->getArticle($_GET['id']);

            if($article){
                $this->view->render('edition/article', [ 
                    'article' => $article
                ]);   
            }
            else{
                 $this->view->render('public/error', [ 
                    'error' => 'Article inconnu au bataillon'
                ]);               
            }            
        }
        else{
             header('Location: accueil'); 
        }      
    }

    public function save(){

        $action=$_POST['action'];

        if($action=='enregistrer' || $action=='publier' || $action=='retirer'){

            $imagor=new Imagor($_FILES['illustration']);
            $imagor->copie(); 
            $imagor->resize(500,300); 
            $illustration=$_FILES['illustration']['name'];   
            $medium=$imagor->getMedium();  

            if(empty($illustration) && $_POST['actionImage']!="retirer"){ //si pas d'ajout de nouvelle image, on récupère la ref de l'image éventuellement déjà enregistrée
                $illustration=$_POST['memoImg'];
                $medium=$_POST['memoMedium']; 
            }    

            //cas de publication
            if($action=='publier'){
                $_POST['statut_publication']=1;
            }  

            //cas de retrait
            if($action=='retirer'){
                $_POST['statut_publication']=2;
            }               
            //enregistrement bdd    
             $this->managerArticles->editArticle($_POST,$illustration,$medium);
        }

        else if($action=='supprimer'){

            $this->managerArticles->deleteArticle($_POST['idArticle']);
        }
    }   

    public function saveComment(){
        
        //enregistrement bdd
        $this->managerCommentaires->addCommentaires($_POST);

        $commentaires=$this->managerCommentaires->getCommentaires($_POST['idArticle']); 
        $this->view->render('public/commentaires', [ 
                'commentaires' => $commentaires,
        ]); 
    }     

    public function signalement(){

        //on récupère le commentaire
        $commentaire=$this->managerCommentaires->getCommentaire($_POST['id']);
        //on met son signal à jour
        $commentaire->setSignalement(1); //incrémente de 1 à chaque signalement
        //on l'enregistre dans la bdd
        $this->managerCommentaires->signalCommentaire($commentaire);

    } 

     public function add(){

        session_start();

        if(isset($_SESSION['user'])){
            if(isset($_POST['submit'])) {
                //--------------------------------------------------------------------------
                //partie enregistrement du nouvel article
                //image :
                $imagor=new Imagor($_FILES['illustration']);
                $imagor->copie();  
                $imagor->resize(500,300);
                $illustration=$_FILES['illustration']['name'];     

                $medium=$imagor->getMedium();                      
                $this->managerArticles->addArticle($_POST,$illustration,$medium);

                //direction la page d'édition de l'article en récupérant l'id du dernier billet enregistré
                $id=$this->managerArticles->getLastId();
                header('Location: edition-article-'.$id);
                 //--------------------------------------------------------------------------
            }
            $this->view->render('edition/add-article', [ 
                'auteur'=> $_SESSION['auteur'],
                'post' => $_POST
            ]);
            
        }
        else{
             header('Location: accueil'); 
        }
    }   


    public function pagination(){

        $this->aArticle=$_POST['aArticle'];     
        
        //les articles et le manager de commentaires :
        $donnees=[];
        $articles=$this->managerArticles->getArticles($this->aArticle,$this->nArticle);
        $donnees["articles"]=$articles;
        $donnees["managerCommentaires"]=$this->managerCommentaires;
       
        //maj des billets dans le template
        $viewTableau=$this->view->renderFile('src/templates/edition/tableau-articles.php',$donnees); 

        //affichage récupéré en ajax dans variable 'data' (cf js.js)
        echo (json_encode(array('vueArticles'=>$viewTableau)));  
               
    }

   
    public function apercu($article_id){

        session_start();

        if(isset($_SESSION['user'])){

            $article=$this->managerArticles->getArticle($article_id);

            if($article){

                $commentaires=$this->managerCommentaires->getCommentaires($article_id);        

                $this->view->render('public/article', [ 
                    'article' => $article,
                    'commentaires' => $commentaires               
                ]);     
            }
            else{
                 $this->view->render('public/error', [
                    'error' => 'Article inconnu au bataillon'
                ]);               
            } 
        }
        else{
             header('Location: 404'); 
        }
    }
    

    public function deleteArticle(){ //suppression d'articles via le tableau d'administration 

        //on recupère l'id de l'article, et le numéro de la page
        $nPage=intval($_POST['nPage']);

        //suppression de l'article
        $this->managerArticles->deleteArticle($_POST['aArticle']);

        $nArticles=$this->managerArticles->getNbreArticles();
        //on transmet à ajax le nbre maj d'articles enregistrés

        //on verifie si après suppression de l'article, le numéro de page est toujours valide, cad s'il a lieu d'exister encore
        //on calcule le nombre de page 
        $totalPages=ceil(intval($nArticles['nbre'])/6); 

        //calcul de l'intervalle :
        if($totalPages<$nPage){ //cas de suppression d'un dernier article dans une dernière page
            $nPage=$totalPages;
        }

        $this->aArticle=($nPage-1)*6; 
             
        //les articles et le manager de commentaires :
        $donnees=[];

        $articles=$this->managerArticles->getArticles($this->aArticle,$this->nArticle);
        $donnees["articles"]=$articles;
        $donnees["managerCommentaires"]=$this->managerCommentaires;
        
        //maj des articles  dans le template
        $viewTableau=$this->view->renderFile('src/templates/edition/tableau-articles.php',$donnees); 

        //mise à jour de pagination.php
        $viewPagination=$this->view->renderFile('src/templates/pagination.php',[
            'nArticles'=>$nArticles,
            'classe'=>'paginationadmin'
         ]);

         echo (json_encode(array('tableau'=>$viewTableau,'pagination'=>$viewPagination,'totalPages'=>$totalPages)));
    }

    //suppression commentaire 
    public function deleteCommentaire(){

        //on recupère l'id du commentaire, et le numéro de la page
         $nPage=intval($_POST['nPage']);
         //--------------------------------------------------------------
        //suppression du commentaire
        $this->managerCommentaires->deleteCommentaire($_POST['aArticle']);

        $nCommentaires=$this->managerCommentaires->getAllNbreCommentaires();

        //on transmet à ajax le nbre maj de commentaires enregistrés
        //on verifie si après suppression du commentaire, le numéro de page est toujours valide, cad s'il a lieu d'exister encore
        //on calcule le nombre de page 
        $totalPages=ceil(intval($nCommentaires['nbre'])/10); 

        //calcul de l'intervalle :
        if($totalPages<$nPage){ //cas de suppression d'un dernier article dans une derniere page
            $nPage=$totalPages;
        }
        $this->aCommentaire=($nPage-1)*10;
             
        //mise à jour de tableau-articles.php : code de pagination() :
        //les articles et le manager de commentaires :
        $donnees=[];
        $commentaires=$this->managerCommentaires->getAllCommentaires($this->aCommentaire,$this->nCommentaire);
        $donnees["commentaires"]=$commentaires;
       
        //maj des commentaires dans le template
        $viewTableau=$this->view->renderFile('src/templates/edition/tableau-commentaires.php',$donnees); 
        //affichage récupéré en ajax dans variable 'data' (cf js.js)
        //mise à jour de pagination.php
         $viewPagination=$this->view->renderFile('src/templates/pagination.php',[
            'nCommentaires'=>$nCommentaires,
            'classe'=>'paginationcommentaires'
         ]);

         echo (json_encode(array('tableau'=>$viewTableau,'pagination'=>$viewPagination,'totalPages'=>$totalPages)));

    }

    //-- gestionnaire des commentaires
    public function editComments(){

        session_start();

        if(isset($_SESSION['user'])){
            
            $commentaires=$this->managerCommentaires->getAllCommentaires($this->aCommentaire,$this->nCommentaire);         
            $nCommentaires=$this->managerCommentaires->getAllNbreCommentaires();

            $this->view->render('edition/commentaires', [ 
                    'commentaires' => $commentaires,
                    'nCommentaires'=>$nCommentaires, 
                    'classe'=>'paginationcommentaires'
            ]);
        }
        else{
             header('Location: accueil'); 
        }
 
    }

    public function editComment(){ 

        session_start();

         if(isset($_SESSION['user'])){

            //récupération du commentaire
            $commentaire=$this->managerCommentaires->getCommentaire($_GET['id']);
            if($commentaire){
                $this->view->render('edition/commentaire', [ 
                    'commentaire'=>$commentaire
                ]); 
            }
            else{
                 $this->view->render('public/error', [
                    'error' => 'Commentaire inconnu au bataillon'
                ]);               
            }  
        }
        else{
             header('Location: accueil'); 
        }
    
    }


    public function paginationComments(){
      
        $this->aCommentaire=$_POST['aArticle'];        
        //les billets et le manager de commentaires :
        $donnees=[];
        $commentaires=$this->managerCommentaires->getAllCommentaires($this->aCommentaire,$this->nCommentaire);       
        //maj des billets dans le template
        $viewTableau=$this->view->renderFile('src/templates/edition/tableau-commentaires.php',[ 
            'commentaires'=>$commentaires
        ]);
        //affichage récupéré en ajax dans variable 'data' (cf js.js)
        echo (json_encode(array('vueArticles'=>$viewTableau)));       
    }

    public function updateComment(){

        $this->managerCommentaires->updateCommentaire($_POST);
    }

    public function profil(){

        session_start();

        if(isset($_SESSION['user'])){

            $user=$this->managerUser->getData();
            $viewTableau=$this->view->render('edition/profil',[
                'user'=>$user
            ]);
        }
        else{
             header('Location: accueil'); 
        }
    }

    public function saveProfil(){

        session_start();

        $_SESSION['auteur']=$_POST['nom'];
        $_SESSION['user'] = $_POST['login'];
        $user=$this->managerUser->saveData($_POST);
        //recup ajax :
        echo (json_encode(array('login'=>$_POST['login'])));
    }

    public function saveMtp(){

        $checkLg=0;
        foreach ($_POST as $key) {
            if(strlen($key)>0){
                $checkLg++;
            }
        }

        $message="Veuillez saisir correctement tous les champs";

        if($checkLg==3){ //on modifie si tous les champs sont complétés
            $user=$this->managerUser->getData();
            $mtp_hash=$user->getPassword();

            //vérification du mot de passe actuel
            $mtp = $_POST["mtp"];

            $isPasswordCorrect = password_verify($mtp,$mtp_hash);
            if($isPasswordCorrect){ //on verifie si l'administrateur a mis son mot de passe

                //on verifie ensuite leur équivalence
                $mtpnew = $_POST["mtpnew"];
                $mtpnew2 = $_POST["mtpnew2"];  

                if($mtpnew== $mtpnew2){ //si oui, on hash et on met à jour le mot de passe
                    //hash du nouveau mtp
                    $new_mtp_hash=$pass_hache = password_hash($mtpnew, PASSWORD_DEFAULT);
                    //maj dans bdd du mtp
                    $this->managerUser->savePassword($new_mtp_hash);
                    $message="Le nouveau mot de passe a bien été enregistré";
                }
            }
        }
        //recup ajax :
        echo (json_encode(array('message'=>$message)));
    }


    public function banner(){

            session_start();

            if(isset($_SESSION['user'])){

                $accueil=$this->managerAccueil->getData();

                $titre="";
                $mention="";
                $extrait="";
                $promo="";
                $image="";
                $urlImage="";
                $description="";
                if(isset($accueil)){

                  $titre=$accueil->getTitre();
                  $mention=$accueil->getMention();
                  $extrait=$accueil->getExtrait();
                  $promo=$accueil->getPromo();
                  $image=$accueil->getImage();
                  $description=$accueil->getDescription();
                  if(!empty($image)){
                    $urlImage='web/images/'.$image;
                  }                                  
                }              

                 $this->view->render('edition/accueil', [ 

                    'titre'=>$titre,
                    'mention'=>$mention,
                    'extrait'=>$extrait,
                    'promo'=>$promo,
                    'image'=>$image,
                    'urlImage'=>$urlImage,
                    'description'=>$description                   
                 ]);    
             }    
             else{
                header('Location: accueil'); 
             }
    }

    public function saveBanner(){

            $illustration=$_FILES['imageBanner']['name'];  

            if(empty($illustration)){ //si pas d'ajout de nouvelle image, on récupère la ref de l'image éventuellement déjà enregistrée
                $illustration=$_POST['memoBanner'];
            }     
          
            if(strlen($illustration)>0){  // on ne crée une image banner que s'il y a une nouvelle image
                $imagor=new Imagor($_FILES['imageBanner']);
                $imagor->copie();            
                $imagor->createBanner($illustration);
            }
            
            $this->managerAccueil->saveData($_POST,$illustration);
            //recup ajax :
            echo (json_encode(array('banner'=>$illustration)));          
    }  

    public function editAbout(){

            session_start();

            if(isset($_SESSION['user'])){

                $about=$this->managerAbout->getData();
                //--
                $description="";
                $avatar="";
                $email="";
                $contenu="";
                $urlAvatar="";
                if(isset($about)){

                    $description=$about->getDescription();
                    $avatar=$about->getAvatar();
                    $email=$about->getEmail();
                    $contenu=$about->getContenu();
                    if(!empty($avatar)){
                        $urlAvatar='web/images/'.$avatar;
                    }                 
                }     
             
                $this->view->render('edition/about', [ 
                    'description'=>$description,
                    'avatar'=>$avatar,
                    'email'=>$email,
                    'contenu'=>$contenu,
                    'urlAvatar'=>$urlAvatar
                ]);    
            }
            else{
                header('Location: accueil'); 
            }
    }  


    public function saveAbout(){

         $avatar=$_FILES['avatar']['name'];
         
         if(empty($avatar)){ //si pas d'ajout de nouvelle image, on récupère la ref de l'image éventuellement déjà enregistrée
                $avatar=$_POST['memoAvatar'];
         } 
         
         if(strlen($avatar)>0){  // on ne crée un avatar que s'il y a une nouvelle image
            $imagor=new Imagor($_FILES['avatar']);
            $imagor->copie();            
        }
        
        $this->managerAbout->saveData($_POST,$avatar);
    }

    //--édition du logo et du favicon
    public function logo(){

             session_start();

             if(isset($_SESSION['user'])){
                $logos=$this->managerLogos->getLogos();

                $this->view->render('edition/logos', [ 
                    "logos"=>$logos
                 ]); 
            }
            else{
                header('Location: accueil'); 
            }
    }
    

    public function saveLogo(){

        $imagor=new Imagor($_FILES['logo']);
        $imagor->copie(); 
        $imagor=new Imagor($_FILES['favicon']);
        $imagor->copie(); 

         $logo=$_FILES['logo']['name'];
         if(empty($logo) && $_POST['actionLogo']!="retirer"){ //si pas d'ajout de nouvelle image, on récupère la ref de l'image éventuellement déjà enregistrée
            $logo=$_POST['memoLogo'];
        }  

        $favicon=$_FILES['favicon']['name'];
         if(empty($favicon) && $_POST['actionFavicon']!="retirer"){ //si pas d'ajout de nouvelle image, on récupère la ref de l'image éventuellement déjà enregistrée
            $favicon=$_POST['memoFavicon'];
        } 

        $this->managerLogos->saveData($logo,$favicon);
        //recup ajax :
        echo (json_encode(array('logo'=>$logo,'favicon'=>$favicon)));
    }

    public function footer(){

              session_start();

             if(isset($_SESSION['user'])){

                $footer=$this->managerFooter->getData();
                $contenu="";
                if(isset($footer)){
                    $contenu=$footer->getContenu();
                }
                
                $this->view->render('edition/footer', [ 
                    'contenu'=>$contenu
                 ]); 
            }
            else{
                header('Location: accueil');
            }
    }

    public function saveFooter(){

        $this->managerFooter->saveData($_POST['contenu']);
       //recup ajax :
        echo (json_encode(array('contenu'=>$_POST['contenu'])));
    }
    //--------------
}