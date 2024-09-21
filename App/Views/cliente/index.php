<?php
use App\Models\Cliente;
use App\Models\Usuario;
/** 
 * @see App\Controllers\HomeController::index()
 * @see App\Controllers\ClienteController::novoCliente()
 * @see App\Controllers\ProfissionalController::novoProfissional()
 */
$usuario = Usuario::find($_SESSION['id_usuario']);
$cliente = Cliente::where('id_usuario', $usuario->id)->first();
$_SESSION['id_cliente'] = $cliente->id;
?>
<main class="main">

<div class="container" data-aos="fade-up">
<h1><?php var_dump($_SESSION['id_cliente']) ?></h1>
<h1><?php var_dump($_SESSION['cliente']) ?></h1>
<h1><?php var_dump($_SESSION['profissional']) ?></h1>
</div>

</section>

</main>
    