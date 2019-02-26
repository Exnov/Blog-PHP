<?php

namespace App\src\entities;

class Footer{

    private $id;
    private $contenu;   

	//getters
    public function getId(){
    	return $this->id;
    }

    public function getContenu(){
    	return $this->contenu;
    }

    //setters
    public function setId($id){
    	$this->id=$id;
    }

    public function setContenu($contenu){
    	$this->contenu=$contenu;
    }

}