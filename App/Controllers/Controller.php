<?php

namespace App\Controllers;

use App\Services\DefaultServices;

class Controller {

    public $validarLogin = true;

    public function __construct(){

        if($this->validarLogin){
            DefaultServices::verificarLogin();
        }

    }

}