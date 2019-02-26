<?php

namespace App\src\controllers;

use App\src\entities\View;

class ErrorController{

	private $view;

	public function __construct(){
		$this->view = new View();
	}
	
    public function unknown()
    {
        $this->view->render('public/unknown', [ 
            'unknown' => 'page demandée non identifiée'
        ]);
    }

    public function error()
    {
        $this->view->render('public/error', [ 
            'error' => 'erreur erreur erreur ...'
        ]);
    }
}