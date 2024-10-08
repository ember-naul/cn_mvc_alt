<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Casa & Negócios</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
            href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Jost:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">
    <link href="/assets/img/favicon.png" rel="icon">
    <link href="/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/vendor/aos/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets/css/flaticon.css">
    <link rel="stylesheet" href="/assets/css/modal.css">
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="/assets/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/assets/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="/assets/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.css"/>
    <script src="https://unpkg.com/leaflet-routing-machine@3.2.12/dist/leaflet-routing-machine.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>

    <style>
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            width: 300px;
        }

        .logocn {
            width: 70px;
            height: 70px;
        }

        @media (max-width: 768px) {
            .logocn {
                width: 60px;
                height: 60px
            }
        }
    </style>
</head>

<?php if (isset($_SESSION['sucesso'])) { ?>
    <div class="toast bg-success text-white" role="alert" data-aos="fade-up" data-aos-delay="100" aria-live="assertive"
         aria-atomic="true">
        <div class="toast-header">
            <img src="/assets/img/logo2.png" width="30px" height="30px" class="rounded mr-2" alt="...">
            <strong class="mr-auto">Sucesso!</strong>
            <small class="text-muted"></small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            <?= $_SESSION['sucesso'] ?>
        </div>
    </div>
    <?php
    unset($_SESSION['sucesso']);
}
if (isset($_SESSION['erro'])) {
    ?>
    <div class="toast bg-danger text-white" role="alert" aria-live="assertive" aria-atomic="true">

        <div class="toast-header">
            <img src="/assets/img/logo2.png" width="30px" height="30px" class="rounded mr-2" alt="...">
            <strong class="mr-auto">Erro!</strong>
            <small class="text-muted"></small>
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="toast-body">
            <?= $_SESSION['erro'] ?>
        </div>
    </div>
    <?php
    unset($_SESSION['erro']);
}

if ($_SESSION['logado'] == true): ?>

<body class="starter-page-page">
<header id="header" class="header d-flex align-items-center sticky-top">
    <?php require_once __DIR__ . '/../../../App/Views/template/navbar.php'; ?>

<?php endif; ?>