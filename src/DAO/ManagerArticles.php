<?php

namespace App\src\DAO;

use App\src\entities\Article;
use PDO;


class ManagerArticles extends Manager{

    protected $indexes; //pour pagination dans article
    protected $index_article; //pour pagination dans article

 	public function getArticles($aArticle,$nArticle){ 

        $req=$this->bdd->prepare("SELECT * FROM articles WHERE statut_publication=1 ORDER BY date_publication DESC LIMIT :a,:b");
        $req->bindValue("a",$aArticle,PDO::PARAM_INT);
        $req->bindValue("b",$nArticle,PDO::PARAM_INT);
        $req->execute();

 		$articles = [];
 		while($row=$req->fetch()){
 			 $articleId = $row['id'];
 			 $articles[$articleId] = $this->hydrate(new Article(),$row);
 		}
 		return $articles;
 	}

    public function getNbreArticles(){ 

        $req=$this->bdd->query("SELECT COUNT(*) AS nbre FROM articles WHERE statut_publication=1");
        $total=$req->fetch();
        return $total;
    }

 	public function getArticle($article_id){ 

 		$req=$this->bdd->prepare("SELECT * FROM articles WHERE id= :a AND statut_publication=1");
 		$req->execute(array("a"=>$article_id));

        $row = $req->fetch();
        if($row) {
            return $this->hydrate(new Article(),$row);
        } 
 	}
 
    public function getTotalArticles($article_id){ //pour pagination dans article

        $req=$this->bdd->query('SELECT id, titre, date_publication, statut_publication from articles WHERE statut_publication=1 ORDER by date_publication DESC');
        $articles = [];
        while($row=$req->fetch()){
             $articleId = $row['id'];
             $articles[$articleId] = $this->hydrate(new Article(),$row);
        }

        $this->indexes=[];
        foreach ($articles as $key => $value) {
            $this->indexes[]=$key;
        }
    
        $this->index_article = array_search($article_id, $this->indexes);
        $this->index_article=intval($this->index_article);

        $articles=[];
        $articles['previous']=$this->getArticlePeripherique(1);
        $articles['next']=$this->getArticlePeripherique(-1);

        return $articles;  
    }

    public function getArticlePeripherique($n){ //+1 ou -1 pour $n, pour pagination dans article
    
            $article='';
            $index=$this->index_article+$n;

            if($index>=0 && $index<count($this->indexes)){
                $article=$this->getArticle($this->indexes[$index]);
            }
    
            return $article;
    }
	
}
