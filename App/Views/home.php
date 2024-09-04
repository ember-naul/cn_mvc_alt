<?php

// use App\Widgets\BaseWidget;

// $breadcumb = [
//     [
//         'title' => 'Dashboard',
//         'url'   => '/home',
//     ],
// ];

// BaseWidget::breadcumb('Home', $breadcumb);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <style>
        .content-wrapper{
            padding: 0;
        }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .flex-container {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
        }

        .inter-h1 {
            font-family: 'Inter', sans-serif;
            font-weight: bold;
        }

        .second-line {
            display: block;
            color: #6c757d;
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
            font-size: 2rem;
        }

        .testep {
            font-size: 1.25rem;
        }

        .teste-2 {
            background-color: #d1d1d1;
            padding: 2rem;
            border-radius: .25rem;
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%; /* Faz com que a altura da seção ocupe 100% da altura do contêiner pai */
        }

        .btn-dark {
            width: 100%; /* Faz o botão ocupar toda a largura do contêiner pai */
            max-width: 300px; /* Define uma largura máxima para os botões */
            margin-top: 1rem; /* Adiciona espaço superior ao botão */
        }

        /* Ajustes para telas médias (tablets) e maiores */
        @media (min-width: 768px) {
            .titleh1 {
                font-size: 2.5rem;
            }

            .testep {
                font-size: 1.5rem;
            }

            .teste-2 {
                padding: 3rem;
            }
        }

        @media (min-width: 992px) {
            .titleh1 {
                font-size: 3rem;
            }

            .testep {
                font-size: 1.75rem;
            }

            .teste-2 {
                min-height: 300px; /* Define uma altura mínima para as seções */
                padding: 3rem;
            }
        }

        @media (min-width: 1200px) {
            .titleh1 {
                font-size: 4rem;
            }

            .testep {
                font-size: 2rem;
            }

            .teste-2 {
                max-width: 90%; 
                margin: 1rem auto;
            }
        }

        #servicos {
            width: 99.58vw;
            margin-left: calc(-50vw + 50%); 
            margin-right: calc(-50vw + 50%); 
            padding: 0; 
            min-height: 500px; 
        }

        #servicos .container {
            padding: 0;
            max-width: 100%;
        }

        #servicos .row {
            margin: 0;
        }

        #sobrenos{
            width: 99.58vw;
            padding: 0;
            height 
            min-height: 500px; 
        }
    </style>
</head>
<body>
    <div class="wrapper mt-5">
        <div class="text-center mb-0">
            <h1 class="titleh1 inter-h1 m-1">
                Diversos tipos de serviços<br>
                <span class="second-line">em um só lugar!</span>
            </h1>
            <div class="flex-container home">
                <img src="assets/img/jardineiro.png" class="jardineiro img-fluid" alt="Jardineiro">
                <p class="testep mb-3">Encontre profissionais e contrate <br>serviços para tudo o que você precisar</p>
            </div>
        </div>
        <section id="servicos" class="bg-white">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6 col-lg-4 p-3 d-flex">
                        <section class="teste-2 align-items-center">
                            <p class="testep mb-1">Você deseja se tornar um <b>cliente</b> para contratar um profissional para você?</p>
                            <p class="testep mb-3">Clique aqui para saber mais!</p>
                            <button class="btn btn-dark" data-toggle="modal" data-target="#modal_cadastro_cliente">Cadastre-se</button>
                        </section>
                    </div>
                    <div class="col-md-6 col-lg-4 p-3 d-flex">
                        <section class="teste-2 align-items-center">
                            <p class="testep mb-2">Você deseja se cadastrar como um <b>profissional</b> para divulgar seus serviços<br> em nosso web site?</p>
                            <p class="testep mb-3">Clique aqui para saber mais!</p>
                            <button class="btn btn-dark" data-toggle="modal" data-target="#modal_cadastro_profissional">Cadastre-se</button>
                        </section>
                    </div>
                </div>
            </div>
        </section>
        <section id="sobrenos" class="container l-5 about-section mt-5 mb-5">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-left">
                    <h2 class="inter-h1">Sobre Nós</h2>
                    <p class="about-text mt-4">Nosso compromisso é fornecer um ambiente seguro e confiável para que você possa encontrar o que precisa de maneira rápida.<br> Agradecemos por escolher nossa plataforma e estamos sempre aqui para ajudar com qualquer dúvida ou necessidade.</p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="assets/img/logo2.png" class="img-fluid" alt="Logo">
                </div>
            </div>
        </section>
    </div>
</body>
</html>
