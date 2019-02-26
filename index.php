<?php

require ('config/Autoloader.php');
\App\config\Autoloader::register();


require ('config/Router.php');
$router = new \App\config\Router();
$router->run();


