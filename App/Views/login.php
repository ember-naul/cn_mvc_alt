<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
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
                            <h3 class="card-title text-center">Entre na sua conta</h3>
                            <p class="text-center text-muted">Entre para aproveitar</p>
                            <form action='/iniciarsessao' method='post'>
                                <div class="form-group">
                                    <label for="email">Seu email</label>
                                    <input name="email" type="email" required class="form-control" id="email_login" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="senha">Senha</label>
                                    <input name="senha" type="password" required class="form-control" id="senha_login" placeholder="Senha">
                                </div>
                                <div class="d-flex justify-content-between">
                                    <a href="/recuperarsenha" class="text-primary">Esqueceu sua senha?</a>
                                </div>
                                <button type="submit" class="btn btn-primary btn-block mt-4">Entrar</button>
                                <p class="text-center mt-4">Não possui um cadastro? <a href="/cadastro" class="text-primary">Cadastre-se aqui</a></p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 d-none d-md-block">
                    <img src="assets/img/login-image.webp" class="img-fluid" alt="Imagem de Login">
                </div>
            </div>
        </div>
    </main>