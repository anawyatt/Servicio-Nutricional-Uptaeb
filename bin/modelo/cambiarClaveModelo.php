<?php

namespace modelo;

use config\connect\connectDB as connectDB;
use helpers\encryption as encryption;
use helpers\JwtHelpers;
use helpers\ConteoLoginHelpers; 

 
class cambiarClaveModelo extends connectDB
{
    private $correo;
    private $encryption;    


    public function __construct()
    {
        parent::__construct();
        $this->encryption = new encryption();
    }







}

    