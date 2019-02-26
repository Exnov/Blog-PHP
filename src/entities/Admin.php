<?php


namespace App\src\entities;

use App\src\DAO\ManagerArticlesBack;
use App\src\DAO\ManagerCommentaires;


class Admin {

    //construction des données à afficher dans la page d'administration :
    public function buildData(ManagerArticlesBack $managerArticles, ManagerCommentaires $managerCommentaires,$debut,$fin){ //pour le BackController
        $donnees=[];                   
        //récupération des articles
        $articles=$managerArticles->getArticles($debut,$fin);
        $donnees["articles"]=$articles; 
        //récupération du nombre de articles : pour la pagination 
        $nArticles=$managerArticles->getNbreArticles();
        $donnees["nArticles"]=$nArticles; 
        $donnees["classe"]='paginationadmin'; //pour template pagination.php et requête ajax (chemin au router)
        //transmission d'un objet managerCommentaires :
        $donnees["managerCommentaires"]=$managerCommentaires;

        return $donnees;
    }

}