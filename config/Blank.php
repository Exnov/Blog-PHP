<?php

namespace App\config;

class Blank
{
    //db
    private $dbHost='XXXXXXXXXXXXXXXXXXXXXXXXXXX';
    private $dbName='XXXXXXXXXXXXXXXXXXXXXXXXXXX';
    private $dbUser='XXXXXXXXXXXXXXXXXXXXXXXXXXX';
    private $dbMtp='XXXXXXXXXXXXXXXXXXXXXXXXXXX';

    //getters
    public function getDbHost(){
        return $this->dbHost;
    }
    public function getDbName(){
        return $this->dbName;
    }
    public function getDbUser(){
        return $this->dbUser;
    }
    public function getDbMtp(){
        return $this->dbMtp;
    }

}



