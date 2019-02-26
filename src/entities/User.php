<?php

namespace App\src\entities;

class User{
    
    private $id;
    private $nom;   
    private $email;   
    private $login;  
    private $password;

    //getters
    public function getId(){
        return $this->id;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getLogin(){
        return $this->login;
    }

    public function getPassword(){
        return $this->password;
    }

    //setters
    public function setId($id){
        $this->id=$id;
    }

    public function setNom($nom){
        $this->nom=$nom;
    }

    public function setEmail($email){
        $this->email=$email;
    }

    public function setLogin($login){
        $this->login=$login;
    }

    public function setPassword($password){
        $this->password=$password;
    }    
    
}