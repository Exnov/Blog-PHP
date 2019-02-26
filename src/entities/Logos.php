<?php

namespace App\src\entities;

class Logos{

    private $logo;
    private $favicon;   

    //getters
    public function getLogo(){
    	return $this->logo;
    }
    public function getFavicon(){
    	return $this->favicon;
    } 

    //setters
      public function setLogo($logo){
    	$this->logo=$logo;
    }
    public function setFavicon($favicon){
    	$this->favicon=$favicon;
    }  

}