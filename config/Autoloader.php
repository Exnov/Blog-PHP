<?php

namespace App\config;

class Autoloader
{
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function autoload($class)
    {
        $class = str_replace('App', '', $class);
        $class = str_replace('\\', '/', $class);
        $class = substr($class, 1);   
        require ($class.'.php');
    }
}