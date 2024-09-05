<?php
namespace App\Services;
use Exception;

class DefaultServices {
    public bool $logado;
    public string $nome;
    public string $email;
    public string $id_usuario;
    
    public function __construct(){
        $this->logado = $_SESSION['logado'];
        $this->nome = $_SESSION['nome'];
        $this->email = $_SESSION['email'];
        $this->id_usuario = $_SESSION['id_usuario'];
    }

    static function deslogar()
    {
        try{
            
            $_SESSION['logado'] = false;
            $_SESSION['email']  = null;
            $_SESSION['nome']   = null;
            $_SESSION['id_usuario'] = null;

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