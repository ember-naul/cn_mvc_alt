<?php

namespace App\Services;

class RedirectServices {

    protected $url;

    public function __construct($url){
        $this->url = $url;
    }

    public function send()
    {
        header('Location: '.$this->url);
        exit();
    }

    public function sucesso($mensagem){
        $_SESSION['sucesso'] = $mensagem;
        $this->send();
    }

    public function erro($mensagem){
        $_SESSION['erro'] = $mensagem;
        $this->send();
    }
}