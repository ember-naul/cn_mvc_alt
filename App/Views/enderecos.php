<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Endereço</title>
    <style>
        .form-group {
            margin-bottom: 15px;
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBV2RbCH4G9_X8i1sxWKAtdwiCkYFg44ig&libraries=places"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBV2RbCH4G9_X8i1sxWKAtdwiCkYFg44ig&libraries=places"></script>
<div class="container mt-5">
    <h1 class="text-center">Cadastrar Endereço</h1>
    <div id="why-us" class="section why-us" data-builder="section">
        <div class="container-fluid">
            <div class="row gy-4">
                <div class="faq-container px-xl-12">
                    <div class="faq-item faq-active">
                        <h3 class="text-center m-auto">Atenção!</h3>
                        <div class="faq-content">
                            <p>Ao digitar seu endereço, aperte na <span class="text-danger">opção que será sugerida para preencher automaticamente
                                    o seu endereço.</span></p> <br>
                            <p class="font-weight-bold text-danger">
                                É necessário que contenha o número do seu endereço.
                            </p>
                        </div>
                        <i class="faq-toggle bi bi-chevron-right"></i>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="/novoEndereco" class="mt-4" id="enderecoForm">
            <div class="form-group">
                <label for="enderecoCompleto">Pesquisar Endereço:</label>
                <input type="text" id="enderecoCompleto" name="enderecoCompleto" class="form-control">
                <small class="text-danger" id="searchError" style="display:none;">Endereço inválido.</small>
            </div>
            <input type="hidden" id="rua" name="rua">
            <input type="hidden" id="cep" name="cep">

            <button type="submit" class="btn btn-primary btn-block" id="submitBtn">Cadastrar Endereço</button>
        </form>
    </div>

    <script>
        $(document).ready(function () {
            const enderecoCompleto = document.getElementById('enderecoCompleto');
            const autocomplete = new google.maps.places.Autocomplete(enderecoCompleto);

            google.maps.event.addListener(autocomplete, 'place_changed', function () {
                const place = autocomplete.getPlace();
                if (place) {

                    const rua = place.address_components.find(comp => comp.types.includes("route"))?.long_name;
                    $('#rua').val(rua);

                    const address = place.formatted_address;

                    fetch(`https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(address)}&key=AIzaSyBV2RbCH4G9_X8i1sxWKAtdwiCkYFg44ig`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === "OK") {
                                const components = data.results[0].address_components;
                                const cep = components.find(comp => comp.types.includes("postal_code"))?.long_name;
                                if (cep) {
                                    $('#cep').val(cep);
                                } else {
                                    $('#cep').val(''); // Limpa o CEP se não for encontrado
                                    $('#searchError').show();
                                }
                            } else {
                                alert('Endereço não encontrado.');
                            }
                        })
                        .catch(error => {
                            console.error('Erro ao buscar CEP:', error);
                            alert('Erro ao buscar CEP.');
                        });
                }
            });

            // Validação no envio do formulário
            $('#enderecoForm').on('submit', function (e) {
                e.preventDefault();

                const cep = $('#cep').val();
                if (!cep) {
                    alert('Por favor, complete o endereço corretamente.');
                } else {
                    this.submit();
                }
            });
        });
    </script>

</body>
</html>
