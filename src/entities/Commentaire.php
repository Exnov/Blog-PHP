<?php

namespace App\src\entities;

use DateTime;

class Commentaire{

    private $id;
    private $id_billet;   
    private $contenu;   
    private $auteur;  
    private $email;
    private $date_creation;
    private $signalement;
    private $statut_publication;
    private $extrait;
    //pour la partie gestion des commentaires
    private $titre_article;
    private $id_article_trouve;

    //getters
    public function getId(){
        return $this->id;
    }

    public function getId_billet(){
        return $this->id_billet;
    }

    public function getContenu(){
        return $this->contenu;
    }

    public function getAuteur(){
        return $this->auteur;
    }

    public function getDate_creation(){
        $date = new DateTime($this->date_creation);
        return $date->format('d/m/Y à H:i:s'); 
    }

    public function getSignalement(){
        return $this->signalement;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getStatut_Publication(){
        switch ($this->statut_publication) {
            case 0:
                $statut='retiré';
                break;
            case 1:
                $statut='publié';
                break;                           
        }
        return $statut;
    }

    public function getExtrait(){
        return $this->extrait;
    }

    //setters 
    public function setId($id){
        $this->id = $id;
    }

    public function setId_billet($id_billet){
        $this->id_billet = $id_billet;
    }

    public function setContenu($contenu){
        $this->contenu = strip_tags($contenu);
        //création de l'extrait pour le tableau de gestion des commentaires
        $this->setExtrait(strip_tags($contenu));
    }

    public function setAuteur($auteur){
        $this->auteur = $auteur;
    }

    public function setDate_creation($date_creation){
        $this->date_creation = $date_creation;
    }

    public function setSignalement($signalement){
        $this->signalement=intval($this->signalement)+$signalement;
    }  

    public function setEmail($email){
        $this->email = $email;
    }  

    public function setStatut_publication($statut_publication){
        $this->statut_publication = $statut_publication;
    }

    public function setExtrait($contenu){ //appelé dans setContenu()
        $this->extrait = $contenu;

        $tab = explode(" ",$contenu);
        $nMots=count($tab);

        if($nMots>10){
            $decoupe=array_splice($tab,0,10);
            $this->extrait=implode(" ",$decoupe) . " ..."; 
        }
    } 

    //partie gestion des commentaires
    //getters
    public function getTitre_article(){ 
        return $this->titre_article;
    }

    public function getId_article_trouve(){
        return $this->id_article_trouve;
    }

    //setters
    public function setTitre_article($titre_article){
        $this->titre_article = $titre_article;
    } 
       
    public function setId_article_trouve($id_article_trouve){
        $this->id_article_trouve = $id_article_trouve;
    } 
    //-------------    
    
}