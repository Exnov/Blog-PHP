<?php

namespace App\src\DAO;

use PDO;
use App\src\entities\Footer;


class ManagerFooter extends Manager{

    public function getData(){ 
    
        $req=$this->bdd->query("SELECT * FROM footer");
        $row=$req->fetch();

        if($row){
            $data=$this->hydrate(new Footer(),$row);
            return $data;           
        }      
    }

    public function saveData($contenu){

        $req=$this->bdd->query("SELECT COUNT(*) AS nbre FROM footer");
        $verif=$req->fetch();
        $n=intval($verif['nbre']);
        $req->closeCursor();

        if(intval($n)==0){
            $req=$this->bdd->prepare("INSERT INTO footer(contenu) VALUES (:a)");
            $req->execute(array("a"=>$contenu));
            $req->closeCursor();                    
        }
        else{
             $req=$this->bdd->prepare("UPDATE footer SET contenu= :a");
             $req->execute(array("a"=>$contenu));
             $req->closeCursor();          
        }
    }
    
}
