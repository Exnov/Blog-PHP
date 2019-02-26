<?php


namespace App\src\DAO;

use App\src\entities\User;

class ManagerUser extends Manager{

 	public function getData(){
 		
 		$req=$this->bdd->query("SELECT * FROM user");
		$row=$req->fetch();
		$donnees = [];
		$donnees = $this->hydrate(new User(),$row);
		return $donnees;
 	}

 	public function saveData($data){

 		extract($data);

 		$req=$this->bdd->prepare("UPDATE user SET nom= :a, login= :b, email = :c WHERE id= 1");
 		$req->execute(array("a"=>$nom,"b"=>$login,"c"=>$email));
 		$req->closeCursor();
 	}

 	public function savePassword($password){

 		$req=$this->bdd->prepare("UPDATE user SET password= :a WHERE id= 1");
 		$req->execute(array("a"=>$password));
 		$req->closeCursor();
 	}

}