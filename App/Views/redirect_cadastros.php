<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,600,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/ionicons.min.css">
    <link rel="stylesheet" href="/assets/css/flaticon.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .modal-body {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            gap: 2rem;
        }
        .btn-square {
            width: 250px; /* Ajuste o tamanho conforme necessário */
            height: 225px; /* Ajuste o tamanho conforme necessário */
            font-size: 1.5rem; /* Aumenta o tamanho do texto */
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            
        } 
    </style>
</head>

<body>
    <div class="modal fade ajuste" id="exampleModalCenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg d-flex">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Escolha seu perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <a href="/cliente/cadastro" class="btn btn-primary btn-square">
                        <i class="fa fa-user"></i><br>Cadastre-se como cliente
                    </a>
                    <a href="/profissional/cadastro" class="btn btn-primary btn-square">
                        <i class="fa fa-briefcase"></i><br>Cadastre-se como profissional
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/jquery.min.js"></script>
    <script src="/assets/js/popper.js"></script>
    <script src="/assets/js/bootstrap.min.js"></script>
</body>

</html>
