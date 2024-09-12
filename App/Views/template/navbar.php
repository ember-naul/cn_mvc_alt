<?php 
use App\Models\Usuario;
$usuario = Usuario::where('id', '=', $_SESSION['id_usuario'])->first(); ?>
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="/home" class="navbar-brand">
        <img src="/assets/img/logo2.png" alt="Logo da nossa empresa" width="35px" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-light">Casa & Negócios</span>
      </a>

      <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse order-3" id="navbarCollapse">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="#" class="nav-link">Contato</a>
          </li>
          <li class="nav-item">
            <a href="/mapa" class="nav-link">Mapa</a>
          </li>         
          <?php if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] == 'cliente'): ?>
            
          <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" class="nav-link dropdown-toggle">Serviços</a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
              <li><a href="/servicos" class="dropdown-item">Jardineiro </a></li>
              <li><a href="/servicos" class="dropdown-item">Pedreiro</a></li>

              <li class="dropdown-divider"></li>
              <!-- Level two dropdown-->
              <li class="dropdown-submenu dropdown-hover">
                <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
                <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                  <li>
                    <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                  </li>

                  <!-- Level three dropdown-->
                  <li class="dropdown-submenu">
                    <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                      <li><a href="#" class="dropdown-item">3rd level</a></li>
                      <li><a href="#" class="dropdown-item">3rd level</a></li>
                    </ul>
                  </li>
                  <!-- End Level three -->

                  <li><a href="#" class="dropdown-item">level 2</a></li>
                  <li><a href="#" class="dropdown-item">level 2</a></li>
                </ul>
              </li>
              <!-- End Level two -->
            </ul>
          </li>
          <?php endif; ?>
        </ul>
      <!-- Right navbar links -->
      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item">
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-lg">
        <img src="/assets/img/perfilicon.png" width="35px">
        </button>
        </li>
      </ul>
    </div>
  </nav>
  <!-- /.navbar -->


<!-- Modal -->
<div class="modal fade" id="modal-lg" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content rounded-lg"> <!-- Borda mais arredondada -->
      <div class="modal-header justify-content-center"> <!-- Centraliza o texto "Ajustes" -->
        <h4 class="modal-title" id="modalLabel">Ajustes</h4>
        <button type="button" class="close position-absolute" style="right: 15px;" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- Profile Picture and Information -->
        <div class="row mb-3">
          <div class="col-4 text-center"> <!-- Imagem à esquerda -->
            <img src="/assets/img/perfilicon.png" class="rounded-circle" alt="Perfil" width="120" height="120">
          </div>
          <div class="col-8 text-left">
          <?php if ($usuario): ?>
          <h5><?= $usuario->nome ?></h5>
          <p>CPF: <?= $usuario->cpf ?></p>
          <p>Celular: <?= $usuario->celular ?></p>
          <?php endif; ?>
          </div>
        </div>

        <!-- Buttons Section -->
        <div class="row text-center">
          <div class="col-6 mb-2"> <!-- Diminui o espaçamento vertical -->
            <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center" style="width: 85%; margin-left: auto;">
              <img src="/assets/img/servicos.png" alt="Histórico de Serviços" width="24" class="mr-2"> Histórico de Serviços
            </button>
          </div>
          <div class="col-6 mb-2">
            <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center" style="width: 85%; margin-left: auto;">
              <img src="/assets/img/endereco.png" alt="Endereços" width="24" class="mr-2"> Endereços
            </button>
          </div>
          <div class="col-6 mb-2">
            <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center" style="width: 85%; margin-left: auto;">
              <img src="/assets/img/pagamento.png" alt="Pagamento" width="24" class="mr-2"> Pagamento
            </button>
          </div>
          <div class="col-6 mb-2">
            <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center" style="width: 85%; margin-left: auto;">
              <img src="/assets/img/suporte.png" alt="Suporte" width="24" class="mr-2"> Suporte
            </button>
          </div>
          <div class="col-6 mb-2">
            <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center" style="width: 85%; margin-left: auto;">
              <img src="/assets/img/sobre.png" alt="Sobre" width="24" class="mr-2"> Sobre
            </button>
          </div>
          <div class="col-6 mb-2">
            <a href="/deslogar" class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center" style="width: 85%; margin-left: auto;">
              <img src="/assets/img/sair.png" alt="Sair" width="24" class="mr-2"> Sair
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap CSS & JS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom CSS -->
<style>
  .modal-header {
    background-color: #f7f7f7;
    border-bottom: none;
  }

  .modal-content {
    border-radius: 15px; /* Borda arredondada */
  }

  .modal-body h5 {
    font-size: 18px;
    font-weight: bold;
  }

  .modal-body p {
    margin-bottom: 0.5rem;
  }

  .btn-outline-custom {
    border-color: #007bff; /* Cor da borda dos botões */
    color: #007bff;
    border-radius: 8px; /* Borda arredondada dos botões */
    display: flex;
    align-items: center;
    justify-content: flex-start; /* Alinhar ícone e texto à esquerda */
  }

  .btn-outline-custom img {
    margin-right: 8px; /* Espaço entre o ícone e o texto */
  }

  /* Remover o efeito azul ao passar o mouse */
  .btn-outline-custom:hover {
    background-color: #f7f7f7; /* Cor ao passar o mouse sem o azul */
    color: #007bff;
    border-color: #6c757d;
  }

  /* Ajustes de responsividade */
  @media (max-width: 768px) {
    .modal-dialog {
      width: 100%;
      margin: 0 auto;
    }

    .modal-body .col-6 {
      width: 100%;
      margin-bottom: 1rem;
    }
  }
</style>






  