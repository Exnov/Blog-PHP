<?php

namespace App\src\DAO;

use App\src\entities\Article;
use PDO;


class ManagerArticlesBack extends Manager{

 	public function getArticles($aArticle,$nArticle){ 

        $req=$this->bdd->prepare("SELECT * FROM articles ORDER BY date_creation DESC LIMIT :a,:b");
        $req->bindValue("a",$aArticle,PDO::PARAM_INT);
        $req->bindValue("b",$nArticle,PDO::PARAM_INT);
        $req->execute();
 		//--
 		$articles = [];
 		while($row=$req->fetch()){
 			 $articleId = $row['id'];
 			 $articles[$articleId] = $this->hydrate(new Article(),$row);
 		}
 		return $articles;
 	}

    public function getNbreArticles(){ 

        $req=$this->bdd->query("SELECT COUNT(*) AS nbre FROM articles");
        $total=$req->fetch();
        return $total;
    }
	
 	public function getArticle($article_id){ 

 		$req=$this->bdd->prepare("SELECT * FROM articles WHERE id= :a");
 		$req->execute(array("a"=>$article_id));
 		//--
        $row = $req->fetch();
        if($row) {
            return $this->hydrate(new Article(),$row);
        } 
 	}

    public function getLastId(){ //renvoie l'id du dernier billet enregistré dans le bdd

        $req=$this->bdd->query("SELECT MAX(id) AS idArticle FROM articles"); 
        $id=$req->fetch();
        return $id['idArticle']; 
    }

 	public function addArticle($article,$illustration,$medium){ 
        //Permet de récupérer les variables $title, $content et $author
        extract($article);

        $req=$this->bdd->prepare("INSERT INTO articles(titre,auteur,contenu,illustration,date_creation,statut_publication,medium) VALUES (:a,:b,:c,:d, NOW(),0,:z)");
        $req->execute(array("a"=>$titre,"b"=>$auteur,"c"=>$contenu,"d"=>$illustration,"z"=>$medium));
        $req->closeCursor();

    }

    public function editArticle($article,$illustration,$medium){ 
        //Permet de récupérer les variables $title, $content et $author
        extract($article);

        if(isset($statut_publication)){
            $req=$this->bdd->prepare("UPDATE articles SET titre= :a, auteur= :b, contenu = :c, illustration = :d, medium = :z, date_modification= NOW(), statut_publication = :e, date_publication= NOW() WHERE id= :f");
             $req->execute(array("a"=>$titre,"b"=>$auteur,"c"=>$contenu, "d"=>$illustration, "e"=>$statut_publication,"f"=>$idArticle,
            "z"=>$medium));
        }
        else{
             $req=$this->bdd->prepare("UPDATE articles SET titre= :a, auteur= :b, contenu = :c, illustration = :d, 
                medium = :z, date_modification= NOW() WHERE id= :f");
             $req->execute(array("a"=>$titre,"b"=>$auteur,"c"=>$contenu, "d"=>$illustration,"f"=>$idArticle,
            "z"=>$medium));           
        }
        $req->closeCursor();        
    }

    public function deleteArticle($id){ 

        $req=$this->bdd->prepare('DELETE FROM articles WHERE id= :a');
        $req->execute(array("a"=>$id));
        $req->closeCursor();
    }

}
