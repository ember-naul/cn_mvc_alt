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
                                    <label for="tipo_profissional">Tipo de pessoa</label>
                                    <select class="form-control" id="tipo_profissional" name="tipo_profissional" required>
                                        <option value="fisica">Pessoa física</option>
                                        <option value="jurídica">Pessoa jurídica</option>
                                    </select>
                                </div>
                                <div class="form-group" id="cnpjOpt" style="display:none;">
                                    <label for="cnpj">Seu CNPJ</label>
                                    <input type="text" class="form-control" maxlength="18" id="cnpj" name="cnpj">
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
<script>
    $(document).ready(function () {
        // Inicialização do evento de mudança
        $('#tipo_profissional').on('change', function() {
            var cnpjOpt = $('#cnpjOpt');
            var cnpjInp = $('#cnpj'); // Adicionado a definição correta aqui

            if (this.value === 'jurídica') {
                cnpjOpt.show();
                cnpjInp.prop('required', true);
                cnpjInp.inputmask({
                    mask: "99.999.999/9999-99",
                    placeholder: "__.___.___/____-__",
                    clearMaskOnLostFocus: true
                });
            } else {
                cnpjOpt.hide();
                cnpjInp.prop('required', false).val(''); // Limpa o campo
                cnpjInp.inputmask('remove'); // Remove a máscara se não for necessário
            }
        });
        $('#form-cadastro-cliente').on('submit', function () {
            $('#cnpj').inputmask('remove');
            $('#cnpj').val($('#cnpj').val().replace(/\D/g, ''));
        });
    });
</script>
