<?php
namespace App\Services;

class DefaultServices {

    static function deslogar()
    {
        try{
            
            $_SESSION['logado'] = false;
            $_SESSION['email']  = null;
            $_SESSION['nome']   = null;

            session_destroy();
            
            header('Location: /login');
            exit();
        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }

    static function verificarLogin(){
        try{

            if($_SESSION['logado'] == false){
                header('Location: /login');
                exit();
            }

        }catch(Exception $e){
            throw new Exception($e->getMessage());
        }
    }


}