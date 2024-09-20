<main class="main">
  <div class="page-title" data-aos="fade">
    <div class="container">
      <h1>Starter Page</h1>
    </div>
  </div>
  <section id="starter-section" class="starter-section section">
    <div class="container" data-aos="fade-up">
      <div class="section-title" data-aos="fade-up">
        <h2>Cadastro</h2>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <form action='/novocliente' id="form-cadastro-cliente" method='post'>
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
              <label for="cep">Seu CEP</label>
              <input type="text" class="form-control" maxlength="8" id="cep" name="cep" required>
            </div>
            <div class="form-group">
              <label for="endereco">Endereço</label>
              <input type="text" class="form-control" id="endereco" name="endereco" required>
            </div>
            <div class="form-group">
              <label for="bairro">Bairro</label>
              <input type="text" class="form-control" id="bairro" name="bairro" required>
            </div>
            <div class="form-group">
              <label for="cidade">Cidade</label>
              <input type="text" class="form-control" id="cidade" name="cidade" required>
            </div>
            <div class="form-group">
              <label for="numero">Número</label>
              <input type="text" class="form-control" id="numero" name="numero" required>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  <div class="col-md-12 text-center">
    <div class="loading">Loading</div>
    <div class="error-message"></div>
  </div>
</main>

<script>
  document.getElementById('cep').addEventListener('input', function () {
    let value = this.value.replace(/\D/g, '');
    this.value = value;

    if (value.length === 8) {
      const cep = value.replace('-', '');
      const loading = document.querySelector('.loading');
      loading.style.display = 'block'; // Mostrar o loading

      fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
          loading.style.display = 'none';
          if (data.logradouro && data.bairro && data.localidade && data.uf) {
            document.getElementById('endereco').value = data.logradouro || '';
            document.getElementById('bairro').value = data.bairro || '';
            document.getElementById('cidade').value = data.localidade || '';
          } else {
            alert('CEP não encontrado ou inválido.');
            document.getElementById('cep').value = '';
          }
        })
        .catch(error => {
          loading.style.display = 'none';
          console.error('Erro ao buscar CEP:', error.message);
          alert('Erro ao buscar CEP.');
          document.getElementById('cep').value = '';
        });
    }
  });
</script>