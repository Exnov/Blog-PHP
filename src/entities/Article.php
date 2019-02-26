<?php

namespace App\src\entities;

use DateTime;

class Article {

    private $id;
    private $titre;   
    private $contenu;   
    private $auteur;  
    private $date_creation;
    private $date_modification;
    private $date_publication;   
    private $illustration;
    private $statut_publication;
    private $extrait;
    private $medium;

    //getters
    public function getId(){
        return $this->id;
    }

    public function getTitre(){
        return $this->titre;
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

    public function getDate_modification(){
        $date = new DateTime($this->date_modification);
        return $date->format('d/m/Y à H:i:s'); 
    }

    public function getDate_publication(){
        $date = new DateTime($this->date_publication);
        return $date->format('d/m/Y à H:i:s'); 
    }    

    public function getIllustration(){
        return $this->illustration;
    }

    public function getStatut_Publication(){
        switch ($this->statut_publication) {
            case 0:
                $statut='non publié';
                break;
            case 1:
                $statut='publié';
                break;
            case 2:
                $statut='retiré';
                break;                            
            default:
                # code...
                break;
        }
        return $statut;
    }

    public function getExtrait(){
        return $this->extrait;
    }

    public function getMedium(){
        return $this->medium;
    }
  
    //setters
    public function setId($id){
        $this->id = $id;
    }

    public function setTitre($titre){
        $this->titre = $titre;
    }

    public function setContenu($contenu){
        $this->contenu = $contenu;
        //--création de l'extrait pour le tableau de gestion des commentaires
        $this->setExtrait($contenu);        
    }

     public function setAuteur($auteur){
        $this->auteur = $auteur;
    }
       
     public function setDate_creation($date_creation){
        $this->date_creation = $date_creation;
    }
       
    public function setDate_modification($date_modification){
        $this->date_modification = $date_modification;
    } 

    public function setDate_publication($date_publication){
        $this->date_publication = $date_publication;
    }

    public function setIllustration($illustration){
        $this->illustration = $illustration;
    } 

    public function setStatut_publication($statut_publication){
        $this->statut_publication = $statut_publication;
    }

    public function setExtrait($contenu){ //appelé dans setContenu()
        $this->extrait = $contenu;

        $tab = explode(" ",$contenu);
        $nMots=count($tab);

        if($nMots>10){
            $decoupe=array_splice($tab,0,60);
            $this->extrait=implode(" ",$decoupe) . " ..."; 
        }
        //on verifie si pas d'image au début de l'article
        //si image au début de l'article, on ne garde que le texte qui précède l'image
        $findme   = 'img';
        $pos = strpos($this->extrait, $findme);

        if($pos>0){
             $this->extrait=substr($this->extrait, 0, $pos-4);
        }
    }  

    public function setMedium($medium){
        $this->medium = $medium;
    }   
    //-------------  
}