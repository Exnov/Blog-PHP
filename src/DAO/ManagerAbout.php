<?php

namespace App\src\DAO;

use PDO;
use App\src\entities\About;

class ManagerAbout extends Manager{

 	public function getData(){ 
    
		$req=$this->bdd->query("SELECT * FROM about");
		$row=$req->fetch();

		if($row){
			$data=$this->hydrate(new About(),$row);
			return $data;	
		}	
 	}

 	public function saveData($data,$avatar){

 		extract($data);

        $req=$this->bdd->query("SELECT COUNT(*) AS nbre FROM about");
        $verif=$req->fetch();
        $n=intval($verif['nbre']);
        $req->closeCursor();

        if(intval($n)==0){
            $req=$this->bdd->prepare("INSERT INTO about(contenu, email, avatar, description) VALUES (:a, :b, :c, :d)");
            $req->execute(array("a"=>$contenu,"b"=>$email,"c"=>$avatar, "d"=>$description));
            $req->closeCursor();                    
        }
        else{
	 		 $req=$this->bdd->prepare("UPDATE about SET contenu= :a, email= :b, avatar= :c, description= :d");
	         $req->execute(array("a"=>$contenu,"b"=>$email,"c"=>$avatar, "d"=>$description));
	         $req->closeCursor();        
        }
 	}

}