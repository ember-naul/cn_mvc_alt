<?php

use App\Widgets\BaseWidget;

$breadcumb = [
    [
        'title' => 'Dashboard',
        'url'   => '/home',
    ],
];

BaseWidget::breadcumb('Home', $breadcumb);

?>

<style>
    .flex-container {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .inter-h1 {
        font-family: 'Inter', sans-serif;
        font-weight: bold;
    }
    .second-line {
        display: block;
        color: #6c757d; /* Ajuste a cor conforme necessário */
    }
    .jardineiro {
        max-width: 100%;
        height: auto;
    }
    .inter-a {
        text-decoration: none;
        color: #007bff;
    }
    .inter-a:hover {
        text-decoration: underline;
    }
    .titleh1 {
        font-size: 4rem;
    }
    .testep {
        font-size: 2.25rem;

    }
    .teste-2 {
        background-color: #d1d1d1;
        padding: 4rem;
        border-radius: .25rem;
        box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
        height:39rem;
    }


</style>
</head>


<body>

    <div class="container mt-5">
        <div class="text-center mb-0">
            <h1 class="titleh1 inter-h1 m-1">
                Diversos tipos de serviços<br>
                <span class="second-line">em um só lugar!</span>
            </h1>
            <div class="flex-container" style= "margin-right:100px">
            <!-- STYLE NAO RESPONSIVO!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
                <img src="assets/img/jardineiro.png" class="jardineiro img-fluid" alt="Jardineiro">
                <p class="testep mb-3">Encontre profissionais e contrate <br>serviços para tudo o que você precisar</p>
            </div>
        </div>

        <section id="servicos" class="bg-white p-4">
        <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center m-5 vh-75 full-width">
      <div class="col-md-3  p-3 text-left m-5" style='margin:50px;'>
      <!-- STYLE NAO RESPONSIVO!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
        <section class="teste-2" >
          <p class="testep mb-1">Você deseja se tornar um <b>cliente</b> para contratar um profissional para você?</p>
          <p class="testep mb-3">Clique aqui para saber mais!</p>
          <button class="btn btn-dark" data-toggle="modal" data-target="#modal_cadastro_cliente" style='margin-left:82px; margin-top:100px;'>Cadastre-se</button></a>
          <!-- STYLE NAO RESPONSIVO!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
        </section>
      </div>

      <div class="col-md-3 p-3 text-left m-5">
        <section class="teste-2">
          <p class="testep mb-2">Você deseja se cadastrar como um <b>profissional</b> para realizar uma<br> tarefa em nosso web site?</p>
          <p class="testep mb-3">Clique aqui para saber mais!</p>
          <a href = "/servicos">
          <button class="btn btn-dark" style='margin-left:95px; margin-top:45px;'>Serviços</button></a>
          <!-- STYLE NAO RESPONSIVO!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! -->
        </section>
        </div>
        </div>
    </div>
    </section>
    <?php include('cadastro_clientes.php'); ?>
</div>

    <!-- Adicione o link para o Bootstrap JS e dependências (jQuery e Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
