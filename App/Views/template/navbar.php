<?php
use App\Models\Usuario;
$usuario = Usuario::where('id', '=', $_SESSION['id_usuario'])->first(); ?>
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
  <div class="container">
    <a href="/home" class="navbar-brand">
      <img src="/assets/img/logo2.png" alt="Logo da nossa empresa" width="35px" class="brand-image" style="opacity: .8">
      <span class="brand-text font-weight-light">Casa & Negócios</span>
    </a>

    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
      aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse order-3" id="navbarCollapse">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a href="#" class="nav-link">Contato</a>
        </li>

        <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'cliente'): ?>
          <li class="nav-item">
            <a href="/mapa" class="nav-link">Mapa</a>
          </li>
        <?php endif; ?>
        <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'profissional'): ?>
          <li class="nav-item">
            <a href="/profissional/habilidades" class="nav-link">Serviços</a>
          </li>
        <?php endif; ?>
        
      </ul>
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item">
          <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg">
            <img src="/assets/img/perfilicon.png" width="35px">
          </button>
        </li>
      </ul>
    </div>
</nav>

<div class="modal fade" id="modal-lg" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-lg">
      <div class="modal-header justify-content-center">
        <h4 class="modal-title" id="modalLabel">Ajustes</h4>
        <button type="button" class="close position-absolute" style="right: 15px;" data-dismiss="modal"
          aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="row mb-3">
          <div class="col-4 text-center"> <!-- Imagem à esquerda -->
            <img src="/assets/img/perfilicon.png" class="rounded-circle" alt="Perfil" width="120" height="120">
          </div>
          <div class="col-8 text-left">
            <?php if ($usuario): ?>
              <h5><?= $usuario->nome ?></h5>
              <p>CPF: <?= censurarCPF($usuario->cpf); ?></p>
              <p>Celular: <?= $usuario->celular ?></p>
            <?php endif; ?>
          </div>
        </div>

        <!-- Buttons Section -->
        <div class="row text-center">
          <div class="col-6 mb-2"> <!-- Diminui o espaçamento vertical -->
            <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center"
              style="width: 85%; margin-left: auto;">
              <img src="/assets/img/servicos.png" alt="Histórico de Serviços" width="24" class="mr-2"> Histórico de
              Serviços
            </button>
          </div>
          <div class="col-6 mb-2">
            <a href="/enderecos">
            <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center"
              style="width: 85%; margin-left: auto;">
              <img src="/assets/img/endereco.png" alt="Endereços" width="24" class="mr-2"> Endereços
            </button>
            </a>
          </div>
          <div class="col-6 mb-2">
            <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center"
              style="width: 85%; margin-left: auto;">
              <img src="/assets/img/pagamento.png" alt="Pagamento" width="24" class="mr-2"> Pagamento
            </button>
          </div>
          <div class="col-6 mb-2">
            <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center"
              style="width: 85%; margin-left: auto;">
              <img src="/assets/img/suporte.png" alt="Suporte" width="24" class="mr-2"> Suporte
            </button>
          </div>
          <div class="col-6 mb-2">
            <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center"
              style="width: 85%; margin-left: auto;">
              <img src="/assets/img/sobre.png" alt="Sobre" width="24" class="mr-2"> Sobre
            </button>
          </div>
          <div class="col-6 mb-2">
            <a href="/deslogar" class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center"
              style="width: 85%; margin-left: auto;">
              <img src="/assets/img/sair.png" alt="Sair" width="24" class="mr-2"> Sair
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php 
function censurarCPF($cpf) {
  $cpf = preg_replace('/\D/', '', $cpf);

  if (strlen($cpf) !== 11) {
      return 'CPF inválido';
  }

  $censurado = substr($cpf, 0, 3) . '.***.***-' . substr($cpf, -2);

  return $censurado;
}


?>