

<main class="main">
  <div class="page-title" data-aos="fade">
    <div class="container">
    <section id="starter-section" class="starter-section section">
    <div class="container" data-aos="fade-up">
      <div class="section-title" data-aos="fade-up">
        <h2>Cadastro</h2>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <form action='/novoprofissional' id="form-cadastro-cliente" method='post'>
            <div class="form-group">
              <label for="nome">Seu nome</label>
              <input type="text" class="form-control" id="nome" name="nome" disabled
                value='<?php echo ($_SESSION['nome']); ?>' required>
            </div>
            <div class="form-group">
              <label for="celular">Seu celular</label>
              <input type="text" class="form-control" id="celular" name="celular" disabled
                value='<?php echo ($_SESSION['celular']); ?>' required>
            </div>
            <div class="form-group">
              <label for="rg">Seu RG</label>
              <input type="text" class="form-control" id="rg" name="rg" disabled
                value='<?php echo ($_SESSION['rg']); ?>' required>
            </div>
            <div class="form-group">
              <label for="cep">Seu CNPJ (Se possuir)</label>
              <input type="text" class="form-control" maxlength="14" id="cnpj" name="cnpj" required>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
    </div>
  </div>
  
</main>