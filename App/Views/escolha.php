<div class="container mt-5">
    <h1 class="text-center">Escolha de Opção</h1>
    <p class="text-center">Por favor, escolha como deseja continuar navegando em nosso site:</p>

    <div class="d-flex justify-content-around mt-4">
        <form method="post" action="/redirect">
            <input type="hidden" name="area" value="cliente">
            <button type="submit" class="btn btn-primary btn-lg">Área do Cliente</button>
        </form>
        <form method="post" action="/redirect">
            <input type="hidden" name="area" value="profissional">
            <button type="submit" class="btn btn-success btn-lg">Área do Profissional</button>
        </form>
    </div>
</div>