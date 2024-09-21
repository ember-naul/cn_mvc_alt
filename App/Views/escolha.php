<!-- Seção de Escolha de Perfil -->
<section id="escolha-perfil" class="d-flex align-items-center justify-content-center vh-100">
    <div class="container text-center">
        <h2>Escolha seu perfil</h2>
        <p>Por favor, escolha como deseja continuar navegando em nosso site:</p>

        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <form method="post" action="/redirect">
                    <input type="hidden" name="area" value="cliente">
                    <button type="submit" class="btn btn-primary btn-lg w-100">Área do Cliente</button>
                </form>
            </div>
            <div class="col-md-4">
                <form method="post" action="/redirect">
                    <input type="hidden" name="area" value="profissional">
                    <button type="submit" class="btn btn-success btn-lg w-100">Área do Profissional</button>
                </form>
            </div>
        </div>
    </div>
</section>
