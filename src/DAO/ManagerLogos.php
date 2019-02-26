<?php

namespace App\src\DAO;

use PDO;
use App\src\entities\Logos;


class ManagerLogos extends Manager{

   	public function getLogos(){

        $req=$this->bdd->query("SELECT * FROM logos");
   		  $logos=new Logos();

     		while($row=$req->fetch()){
       			//logo
       			if($row['type']=='logo'){ 
       				  $logos->setLogo($row['image']);
       			}
       			//favicon
       			else{ 
       				  $logos->setFavicon($row['image']);
       			}
     		}

   		  $req->closeCursor();
   		  return $logos;
   	}

   	public function saveData($logo,$favicon){

   		  //on verifie si les 2 entrées existent, sinon on les crée :
        $req=$this->bdd->query("SELECT COUNT(*) AS nbre FROM logos");
        $verif=$req->fetch();
        $n=intval($verif['nbre']);
        $req->closeCursor();

        if(intval($n)==0){
   	  	    //2requêtes :
  	 		    //logo
  	        $this->createImg($logo,'logo');
  	        //favicon
  	        $this->createImg($favicon,'favicon');                     
        }
        else{
  	  	    //2requêtes :
  	 		    //logo
  	        $this->updateImg($logo,'logo'); 
  	        //favicon
  	        $this->updateImg($favicon, 'favicon');
        }
   	}

   	public function updateImg($image,$type){

      	$req=$this->bdd->prepare("UPDATE logos SET image= :a WHERE type = :b");
      	$req->bindValue("a",$image);
      	$req->bindValue("b",$type);
        $req->execute();
        $req->closeCursor();		
   	}

   	public function createImg($image,$type){
      
        $req=$this->bdd->prepare("INSERT INTO logos(type, image) VALUES (:a, :b)");
        $req->execute(array("a"=>$type,"b"=>$image));
        $req->closeCursor();  
   	}
 
}