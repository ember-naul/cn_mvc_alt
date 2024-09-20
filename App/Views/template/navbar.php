<?php
use App\Models\Usuario;
$usuario = Usuario::where('id', '=', $_SESSION['id_usuario'])->first(); ?>

<div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="/home" class="logo d-flex align-items-center me-auto">
       <img src="/assets/img/logo.png" alt="">
        <h1 style="text-decoration:none;" class="sitename">Casa & Negócios</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="/home">Home</a></li>
          <li><a href="/home#about">Sobre nós</a></li>
          <li><a href="/home#services">Serviços</a></li>
          <?php if (isset($_SESSION['profissional']) && $_SESSION['profissional'] == true): ?>
          <li><a href="/profissional/habilidades">Habilidades</a></li>
        <?php endif; ?>
          <li><a href="#" data-toggle="modal" data-target="#modal-lg">Perfil</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      <?php if (!isset($_SESSION['profissional']) && !isset($_SESSION['cliente'])): ?>
        <a class="btn-getstarted" data-toggle="modal" data-target="#exampleModalCenter">Comece agora</a>
        <?php endif; ?>
      

    </div>
</header>



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
          <div class="col-4 text-center"> 
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

        <div class="row text-center">
          <div class="col-6 mb-2">
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



