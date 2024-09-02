<?php

use App\Services\RedirectServices;

function redirect($url){
    return new RedirectServices($url);
}