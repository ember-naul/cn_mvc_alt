<main class="main d-flex align-items-center justify-content-center vh-100">
    <div class="hold-transition login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="/login" class="h1"><b>Casa &</b>Negócios</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Você esqueceu sua senha? Aqui você pode facilmente redefini-la.</p>
                    <form action="/esqueci_senha" method="post">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" name="email" placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Redefinir minha Senha</button>
                            </div>
                        </div>
                    </form>
                    <p class="mt-3 mb-1">
                        <a href="/login">Login</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>
