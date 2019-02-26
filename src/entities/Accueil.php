<?php

namespace App\src\entities;

class Accueil{


    private $id;
    private $titre;   
    private $mention;   
    private $extrait;  
    private $promo;
    private $image;
    private $description; //meta description


    //getters
    public function getId(){
    	return $this->id;
    }

    public function getTitre(){
    	return $this->titre;
    }

    public function getMention(){
    	return $this->mention;
    }

    public function getExtrait(){
    	return $this->extrait;
    }

    public function getPromo(){
    	return $this->promo;
    }

    public function getImage(){
    	return $this->image;
    }

    public function getDescription(){
        return $this->description;
    }
                    
    //setters
    public function setId($id){
    	$this->id=$id;
    }

    public function setTitre($titre){
    	$this->titre=$titre;
    }

    public function setMention($mention){
    	$this->mention=$mention;
    }

    public function setExtrait($extrait){
    	$this->extrait=$extrait;
    }

    public function setPromo($promo){
    	$this->promo=$promo;
    }

    public function setImage($image){
    	$this->image=$image;
    }
      
    public function setDescription($description){
        $this->description=$description;
    }

}