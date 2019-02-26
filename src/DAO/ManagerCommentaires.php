<?php

namespace App\src\DAO;
use PDO;

use App\src\entities\Commentaire;

class ManagerCommentaires extends Manager{

 	public function getCommentaires($article_id){ //publication uniquement des billets non retirés par l'administrateur

		$req=$this->bdd->prepare("SELECT * FROM commentaires WHERE id_article= :a AND statut_publication = 1 ORDER BY id DESC");
 		$req->bindValue("a",$article_id,PDO::PARAM_INT);
 		$req->execute();

 		$commentaires = [];
 		while($row=$req->fetch()){
 			 $commentaireId = $row['id'];
 			 $commentaires[$commentaireId] = $this->hydrate(new Commentaire(),$row);
 		}
 		return $commentaires;		
 	}

 	 public function getCommentaire($id){
    
        $req=$this->bdd->prepare('SELECT c.*, b.titre titre_article, b.id id_article_trouve FROM commentaires c LEFT JOIN articles b ON c.id_article = b.id WHERE c.id= :a');
        
 		$req->execute(array("a"=>$id));
        $row = $req->fetch();
        if($row) {
            return $this->hydrate(new Commentaire(),$row);
        } 
 	}

    //pour gestionnaires de commentaires, on récupère via une jointure externe tous les commentaires avec les titres et les id de leur billet, même ceux disparus (titre du billet vaudra null), rangé par ordre décroissant du signalement.
    public function getAllCommentaires($aCommentaire, $nCommentaire){

        $req=$this->bdd->prepare('SELECT c.*, b.titre titre_article, b.id id_article_trouve FROM commentaires c LEFT JOIN articles b ON c.id_article = b.id ORDER BY signalement DESC LIMIT :a,:b');

        $req->bindValue("a",$aCommentaire,PDO::PARAM_INT);
        $req->bindValue("b",$nCommentaire,PDO::PARAM_INT);
        $req->execute();

        $commentaires=[];
        while($row=$req->fetch()){
             $commentId = $row['id'];
             $commentaires[$commentId] = $this->hydrate(new Commentaire(),$row);
        }
        return $commentaires;
    }

    public function getAllNbreCommentaires(){

        $req=$this->bdd->query("SELECT COUNT(*) AS nbre FROM commentaires");
        $total=$req->fetch();
        return $total;
    }

    public function getNbreCommentaires($idArticle){

        $req=$this->bdd->prepare("SELECT COUNT(*) AS nbre FROM commentaires WHERE id_article= :a");
        $req->execute(array("a"=>$idArticle));
        $total=$req->fetch();
        return $total['nbre'];
    }

 	public function addCommentaires($commentaire){
        //permet de récupérer les variables $title, $content et $author
        extract($commentaire);

        $req=$this->bdd->prepare("INSERT INTO commentaires(id_article, auteur,contenu,email,signalement, date_creation, statut_publication) 
        	VALUES (:a,:b,:c, :d, 0, NOW(),1)");
        $req->execute(array("a"=>$idArticle,"b"=>$auteur,"c"=>$contenu,"d"=>$email)); 
        $req->closeCursor();
    } 	

    public function signalCommentaire($commentaire){

    	$signalement=$commentaire->getSignalement();
    	$id=$commentaire->getId();

        $req=$this->bdd->prepare("UPDATE commentaires SET signalement= :a  WHERE id= :b");
        $req->execute(array("a"=>$signalement,"b"=>$id));
        $req->closeCursor(); 
    }

    //gestionnaire de commentaires :
    public function updateCommentaire($data){

        extract($data);

        if($action=='enregistrer'){
            $req=$this->bdd->prepare("UPDATE commentaires SET auteur= :a, contenu= :b, email= :c  WHERE id= :d");           
        }
        else{
            $statut=1; //publié, par défaut
            if($action=="retirer"){
                $statut=0; 
            }
            $req=$this->bdd->prepare("UPDATE commentaires SET auteur= :a, contenu= :b, email= :c, statut_publication= :e  WHERE id= :d");
            $req->bindValue("e",$statut,PDO::PARAM_INT);
        }

        $req->bindValue("a",$auteur);
        $req->bindValue("b",$contenu);
        $req->bindValue("c",$email);
        $req->bindValue("d",$idComment,PDO::PARAM_INT);
        $req->execute();
        $req->closeCursor(); 
    }

    public function deleteCommentaire($id){

        $req=$this->bdd->prepare('DELETE FROM commentaires WHERE id= :a');
        $req->execute(array("a"=>$id));
        $req->closeCursor();
    }

}