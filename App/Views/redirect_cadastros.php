<?php

use App\Models\Usuario;
use App\Models\Cliente;
use App\Models\Profissional;
if ($_SESSION['logado']){
    $usuario = Usuario::where('id', $_SESSION['id_usuario'])->first();
    $cliente = Cliente::where('id_usuario', $usuario->id)->first();
    $profissional = Profissional::where('id_usuario', $usuario->id)->first();
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700&display=swap" rel="stylesheet">

    <style>
        .modal-body {
            display: flex;
            justify-content: center;
            padding: 2rem;
            gap: 0.5rem;
            height: 300px;
            width: 500px;
        }

        .btn-square {
            width: 70%;
            height: 100%;
            font-size: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;

        }
    </style>
</head>

<body>
<div class="modal fade ajuste" id="exampleModalCenter" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-lg">
            <div class="modal-header justify-content-center">
                <h5 class="modal-title">Escolha seu perfil</h5>
                <button type="button" class="close position-absolute" style="right: 15px;" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="row mb-3">
                <div class="modal-body">
                    <?php if (!$cliente): ?>
                        <a href="/cliente/cadastro" class="btn btn-primary btn-square">
                            <i class="fa fa-user"></i> Cadastre-se como cliente
                        </a>
                    <?php else: ?>
                        <a class="btn btn-secondary btn-square">
                            <i class="fa fa-user"></i> Cadastre-se como cliente
                        </a>
                    <?php endif; ?>
                    <?php if (!$profissional): ?>
                        <a href="/profissional/cadastro" class="btn btn-primary btn-square">
                            <i class="fa fa-briefcase"></i>Cadastre-se como profissional
                        </a>
                    <?php else: ?>
                        <a class="btn btn-secondary btn-square">
                            <i class="fa fa-briefcase"></i>Cadastre-se como profissional
                        </a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade ajuste" id="modalescolha" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg d-flex">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Escolha seu perfil</h5>
                <p class="text-center">Por favor, escolha como deseja continuar navegando em nosso site:</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-around mt-4">
                    <form method="post" action="/redirect">
                        <input type="hidden" name="area" value="cliente">
                        <button type="submit" class="btn btn-primary btn-lg">Área do Cliente</button>
                    </form>
                    <form method="post" action="/redirect">
                        <input type="hidden" name="area" value="profissional">
                        <button type="submit" class="btn btn-success btn-lg">Área do Profissional</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>

</html>