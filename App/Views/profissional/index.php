<?php
use App\Models\Profissional;
use App\Models\Usuario;
/** 
 * @see App\Controllers\HomeController::index()
 * @see App\Controllers\ClienteController::novoCliente()
 * @see App\Controllers\ProfissionalController::novoProfissional()
 */
$usuario = Usuario::find($_SESSION['id_usuario']);
$profissional = Profissional::where('id_usuario', $usuario->id)->first();
$_SESSION['profissional_id'] = $profissional->id;
?>
<main class="main">
   
<section id="starter-section" class="starter-section section">

<div class="container" data-aos="fade-up">
<h1><?php var_dump($_SESSION['cliente']) ?></h1>
<h1><?php var_dump($_SESSION['profissional']) ?></h1>

</div>

</section>

</main>
    