<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cadastro</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Karla:400,700&display=swap" rel="stylesheet">
    <style>
        .main {
            background-color: #f8f9fa;
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <main class="main d-flex align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow">
                        <div class="card-body">
                            <h3 class="card-title text-center">Cadastro</h3>
                            <form id="multiStepForm" method='post' action='/novousuario'>
                                <!-- Etapa 1 -->
                                <div id="step1">
                                    <div class="form-group">
                                        <label for="nome">Nome Completo</label>
                                        <input name="nome" type="text" required class="form-control" id="nome"
                                            placeholder="Digite seu nome de usuário" maxlength="100">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input name="email" type="email" required class="form-control" id="email"
                                            placeholder="Digite seu email" maxlength="100">
                                    </div>
                                    <button type="button" class="btn btn-primary btn-block mt-4"
                                        onclick="nextStep(1)">Próximo</button>
                                    <p class="text-center mt-4">Já possui uma conta? <a href="/login"
                                            class="text-primary">Entre aqui</a></p>
                                </div>

                                <!-- Etapa 2 -->
                                <div id="step2" class="d-none">
                                    <div class="form-group">
                                        <label for="celular">Celular</label>
                                        <input name="celular" type="text" required class="form-control" id="celular"
                                            placeholder="Digite o número do seu celular" maxlength="15">
                                    </div>
                                    <div class="form-group">
                                        <label for="rg">RG</label>
                                        <input name="rg" type="text" required class="form-control" id="rg"
                                            placeholder="Digite o seu RG" maxlength="12">
                                    </div>
                                    <div class="form-group">
                                        <label for="cpf">CPF</label>
                                        <input name="cpf" type="text" required class="form-control" id="cpf"
                                            placeholder="Digite o seu CPF" maxlength="14">
                                    </div>
                                    <button type="button" class="btn btn-secondary btn-block mt-4"
                                        onclick="nextStep(0)">Anterior</button>
                                    <button type="button" class="btn btn-primary btn-block mt-4"
                                        onclick="nextStep(2)">Próximo</button>
                                </div>

                                <!-- Etapa 3 -->
                                <div id="step3" class="d-none">
                                    <div class="form-group">
                                        <label for="senha">Senha</label>
                                        <input name="senha" type="password" required class="form-control" id="senha"
                                            placeholder="Digite sua senha" maxlength="20">
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmar_senha">Confirmar Senha</label>
                                        <input name="confirmar_senha" type="password" required class="form-control"
                                            id="confirmar_senha" placeholder="Digite novamente a sua senha"
                                            maxlength="20">
                                    </div>
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="agreeTerms" name="terms" required value="agree">
                                        <label for="agreeTerms">
                                            Concordo com os <a href="#" data-toggle="modal" data-target="#termosModal">termos de uso</a>
                                        </label>
                                    </div>
                                    <button type="button" class="btn btn-secondary btn-block mt-4"
                                        onclick="nextStep(1)">Anterior</button>
                                    <button type="submit" class="btn btn-primary btn-block mt-4">Cadastrar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-block">
                    <img src="assets/img/login-img.png" class="img-fluid" alt="Imagem de Cadastro">
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>


    <script>
        let currentStep = 1;

        function showStep(step) {
            document.querySelector(`#step${currentStep}`).classList.add('d-none');
            document.querySelector(`#step${step}`).classList.remove('d-none');
            currentStep = step;
        }

        function nextStep(step) {
            showStep(step + 1);
        }

        $(document).ready(function () {
            $('#celular').inputmask({
                mask: "(99) 99999-9999",
                placeholder: "(__) _____-____",
                clearMaskOnLostFocus: true
            });

            $('#rg').inputmask({
                mask: "99.999.999-9",
                placeholder: "__.___.___-_",
                clearMaskOnLostFocus: true
            });

            $('#cpf').inputmask({
                mask: "999.999.999-99",
                placeholder: "___.___.___-__",
                clearMaskOnLostFocus: true
            });

            // Remove masking before form submission
            $('#multiStepForm').on('submit', function () {
                // Remove input masks
                $('#celular').inputmask('remove');
                $('#rg').inputmask('remove');
                $('#cpf').inputmask('remove');

                // Clean up the input values to remove formatting
                $('#celular').val($('#celular').val().replace(/\D/g, ''));
                $('#rg').val($('#rg').val().replace(/\D/g, ''));
                $('#cpf').val($('#cpf').val().replace(/\D/g, ''));
            });
        });
    </script>
<?php require_once __DIR__ . '/termos_uso.php'; ?>