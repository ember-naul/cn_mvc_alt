<div class="modal fade" id="modal_cadastro_cliente" tabindex="-1" role="dialog"
  aria-labelledby="modalCadastroClienteLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="modalCadastroClienteLabel">Cadastro de Cliente</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action='/novocliente' id="form-cadastro-cliente" method='post'>
          <input type="hidden" name='id_usuario' value=<?= $_SESSION['id_usuario']; ?>>
          <div class="form-group">
            <label for="usuarioId">Seu nome</label>
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
            <input type="text" class="form-control" id="rg" name="rg" disabled value='<?php echo ($_SESSION['rg']); ?>'
              required>
          </div>
          <div class="form-group">
            <label for="cep">Seu CEP</label>
            <input type="text" class="form-control" id="cep" name="cep" required>
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
          <div class="form-group">
            <input type="hidden" class="form-control" id="id_usuario" name="id_usuario"
              placeholder="Digite o ID do usuário" required>
          </div>
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button type="submit" class="btn btn-primary" id="btn-salvar">Salvar</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script src="assets/plugins/jquery/jquery.min.js"></script>

<script>
  document.getElementById('cep').addEventListener('input', function () {
    let value = this.value.replace(/\D/g, '');
    this.value = value;

    if (value.length === 8) {
      const cep = value.replace('-', '');
      fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => {
          if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
          }
          return response.json();
        })
        .then(data => {
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
          console.error('Erro ao buscar CEP:', error.message);
          alert('Erro ao buscar CEP.');
          document.getElementById('cep').value = '';
        });
    }
  });


</script>