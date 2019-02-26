<?php

namespace App\src\DAO;

use PDO;
use App\src\entities\Accueil;

class ManagerAccueil extends Manager{

 	public function getData(){ //publication uniquement des articles non retirés par l'administrateur
 	
		$req=$this->bdd->query("SELECT * FROM accueil");
		$row=$req->fetch();

		if($row){
			$data=$this->hydrate(new Accueil(),$row);
			return $data;			
		}		
 	}

 	public function saveData($data,$illustration){

 		extract($data);

 		$req=$this->bdd->query("SELECT COUNT(*) AS nbre FROM accueil");
 		$verif=$req->fetch();
 		$n=intval($verif['nbre']);
 		$req->closeCursor();

 		if(intval($n)==0){
        	$req=$this->bdd->prepare("INSERT INTO accueil(titre, mention, extrait, promo, image, description) VALUES (:a, :b, :c, :d, :e, :f)");
	        $req->execute(array("a"=>$titre,"b"=>$mention,"c"=>$extrait,"d"=>$promo,"e"=>$illustration, "f"=>$description));
	        $req->closeCursor(); 					
 		}
 		else{
	 		 $req=$this->bdd->prepare("UPDATE accueil SET titre= :a, mention= :b, extrait= :c, promo= :d, image= :e, 
	 		 	description= :f");
	         $req->execute(array("a"=>$titre,"b"=>$mention,"c"=>$extrait,"d"=>$promo,"e"=>$illustration, "f"=>$description));
	         $req->closeCursor(); 			
 		}
 	}

}