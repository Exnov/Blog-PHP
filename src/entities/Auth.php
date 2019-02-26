<?php


namespace App\src\entities;

use App\src\DAO\ManagerUser;

class Auth {

	private $managerUser;
    private $user; 
    private $login;
    private $password;

    public function __construct(){
        $this->hydrate();
    }

    public function hydrate(){
    	$this->managerUser=new ManagerUser();
    	$this->user=$this->managerUser->getData();
    	$this->login=$this->user->getLogin();
    	$this->password=$this->user->getPassword();
    }

    public function check($loginVisitor,$passwordVisitor){
		$isPasswordCorrect = password_verify($passwordVisitor,$this->password);
		if($this->login==$loginVisitor && $isPasswordCorrect){
			return $this->user;
		}
    }

}