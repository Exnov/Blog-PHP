<?php

namespace App\src\DAO;

use App\config\Blank;
use PDO;


abstract class Manager{

	protected $blank;
	protected $host;
	protected $dbname;
	protected $user;
	protected $mtp;
	protected $bdd="";
	
 	public function __construct(){

 		$this->blank=new Blank();
 		$this->host=$this->blank->getDbHost();
 		$this->dbname=$this->blank->getDbName();
 		$this->user=$this->blank->getDbUser();
 		$this->mtp=$this->blank->getDbMtp();
 		$this->bdd=$this->connexion();
 	}

	public function connexion(){

		try{
			$bdd=new PDO("mysql:host=".$this->host.";dbname=".$this->dbname.";charset=utf8",$this->user,$this->mtp,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			return $bdd;
		}
		catch(Exception $e){
			die("Erreur : ".$e->getMessage());
		}
	}

	//méthode d'hydratation 
    public function hydrate(object $objet, array $donnees){
        foreach ($donnees as $key => $value){
            // On récupère le nom du setter correspondant à l'attribut.
            $method = 'set'.ucfirst($key);
            // Si le setter correspondant existe.
            if (method_exists($objet, $method)){
                 // On appelle le setter.
                 $objet->$method($value);
            }
        }
        return $objet;
    }

}