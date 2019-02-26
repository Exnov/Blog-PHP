<?php

namespace App\src\entities;

class About{


    private $id;
    private $avatar;   
    private $contenu;   
    private $email;  
    private $description; //meta description

    //getters
    public function getId(){
    	return $this->id;
    }

    public function getAvatar(){
    	return $this->avatar;
    }

    public function getContenu(){
    	return $this->contenu;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getDescription(){
        return $this->description;
    }                   

    //setters
    public function setId($id){
    	$this->id=$id;
    }

    public function setAvatar($avatar){
    	$this->avatar=$avatar;
    }

    public function setContenu($contenu){
    	$this->contenu=$contenu;
    }

    public function setEmail($email){
        $this->email=$email;
    }    

    public function setDescription($description){
        $this->description=$description;
    }

}