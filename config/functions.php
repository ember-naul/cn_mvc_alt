<?php

use App\Services\DefaultServices;
use App\Services\RedirectServices;

function user(){
    return new DefaultServices();
}

function redirect($url){
    return new RedirectServices($url);
}
