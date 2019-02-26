<?php


namespace App\config;

use App\src\controllers\FrontController;
use App\src\controllers\BackController;
use App\src\controllers\ErrorController;

class Router{

	private $frontController;
	private $backController;
	private $errorController;

	public function __construct(){
		$this->frontController=new FrontController();
		$this->backController=new BackController();
		$this->errorController=new ErrorController();
	}

    public function run(){
		try{
		    if(isset($_GET['route']))
		    {
                //frontController
		        if($_GET['route'] === 'article'){ 
		            $id = $_GET['id'];
               		$this->frontController->article($id); 
		        }

                else if($_GET['route'] === 'pagination') {
                    $this->frontController->pagination();
                } 

                else if($_GET['route'] === 'about') {
                    $this->frontController->about();
                }   

                //backController
                else if($_GET['route'] === 'apercu'){
                    $id = $_GET['id'];
                    $this->backController->apercu($id);
                }

                else if($_GET['route'] === 'editabout') {
                    $this->backController->editAbout();
                } 

                else if($_GET['route'] === 'saveabout') {
                    $this->backController->saveAbout();
                } 

                else if($_GET['route'] === 'paginationadmin') {
                    $this->backController->pagination();
                }

                else if($_GET['route'] === 'paginationcommentaires') {
                    $this->backController->paginationComments();
                }     

                else if($_GET['route'] === 'login') {
                 	$this->backController->login($_POST);
                 }

                else if($_GET['route'] === 'admin') {

                	$this->backController->check($_POST);
                }

                else if($_GET['route'] === 'logout') {
                	$this->backController->logout($_POST);
                }

                else if($_GET['route'] === 'edit') {
                    $this->backController->edit();
                }

                 else if($_GET['route'] === 'save') {
                    $this->backController->save();
                }
                 else if($_GET['route'] === 'savecomment') {
                    $this->backController->saveComment();
                }

                 else if($_GET['route'] === 'editcomments') {
                    $this->backController->editComments();
                }

                else if($_GET['route'] === 'editcomment') { 
                    $this->backController->editComment();
                }

                else if($_GET['route'] === 'updatecomment') { 
                    $this->backController->updateComment();
                }

                else if($_GET['route'] === 'signalement') {
                    $this->backController->signalement();
                }

                else if($_GET['route'] === 'add') {
                    $this->backController->add();
                } 

                else if($_GET['route'] === 'delete') {
                    if($_POST['elt']=='article'){ 
                        $this->backController->deleteArticle();
                    }
                    else if($_POST['elt']=='commentaire'){
                        $this->backController->deleteCommentaire();
                    }                   
                } 

                else if($_GET['route'] === 'profil') {
                    $this->backController->profil();
                }

                else if($_GET['route'] === 'saveprofil') {
                    $this->backController->saveProfil();
                }

                else if($_GET['route'] === 'savemtp') {
                    $this->backController->saveMtp();
                }

                else if($_GET['route'] === 'banner') {
                    $this->backController->banner();
                }

                else if($_GET['route'] === 'savebanner') {
                    $this->backController->saveBanner();
                }

                else if($_GET['route'] === 'logo') {
                    $this->backController->logo();
                }

                else if($_GET['route'] === 'savelogo') {
                    $this->backController->saveLogo();
                }

                else if($_GET['route'] === 'footer') {
                    $this->backController->footer();
                }

                else if($_GET['route'] === 'savefooter') {
                    $this->backController->saveFooter();
                }

                //errorController
		        else{
		             $this->errorController->unknown();
		        }
		    }
		    else{ //page d'accueil
                $this->frontController->home();
		    }
		}
		catch (Exception $e)
		{
		    $this->errorController->error();
		}
    	
    }

}
