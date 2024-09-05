<form action='/testeteste' id="form-cadastro-cliente" method='post'>
          <div class="form-group">
              <label for="usuarioId">Seu nome</label>
              <input type="text" class="form-control" id="id_usuario" name="nome" disabled value='<?php echo ($_SESSION['nome']); ?>' required>
            </div>

            <div class="form-group">
              <label for="celular">Seu celular</label>
              <input type="text" class="form-control" id="celular" name="celular" disabled value='<?php echo ($_SESSION['celular']); ?>'  required>
            </div>

            <div class="form-group">
              <label for="rg">Seu RG</label>
              <input type="text" class="form-control" id="rg" name="rg" disabled value='<?php echo ($_SESSION['rg']); ?>' required>
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
              <input type="hidden" class="form-control" id="id_usuario" name="id_usuario" placeholder="Digite o ID do usuário" required>
            </div>
            <p id='datat'></p>
          
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <button type="submit" class="btn btn-primary" id="btn-salvar">Salvar</button>
          </form>

          <script>
  document.getElementById('cep').addEventListener('input', function() {
    let value = this.value.replace(/\D/g, ''); // Remove caracteres não numéricos
    this.value = value; // Atualiza o valor do campo

    // Faz a busca do CEP somente se o comprimento for 8
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
                console.log('Dados recebidos:', data); // Adicione esta linha para verificar a resposta
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