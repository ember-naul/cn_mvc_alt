<style>

    .form-group {
        margin-bottom: 20px;
    }

    .form-control {
        padding: 15px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn {
        padding: 12px;
        font-size: 1rem;
        border-radius: 4px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .text-danger {
        color: #dc3545;
        margin-top: 5px;
    }

    #searchError {
        display: block;
    }

    #submitBtn {
        margin-top: 20px;
        width: 100%;
    }

    /* Botão ocupará a largura to

</style>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBV2RbCH4G9_X8i1sxWKAtdwiCkYFg44ig&libraries=places"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
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
                            <form action='/novocliente' id="form-cadastro-cliente" method='post'>
                                <div class="form-group">
                                    <label for="nome">Seu nome</label>
                                    <input type="text" class="form-control" id="nome" name="nome" readonly
                                           value='<?php echo($_SESSION['nome']); ?>'>
                                </div>
                                <div class="form-group">
                                    <label for="celular">Seu celular</label>
                                    <input type="text" class="form-control" id="celular" name="celular" readonly
                                           value='<?php echo($_SESSION['celular']); ?>'>
                                </div>
                                <div class="form-group">
                                    <label for="rg">Seu RG</label>
                                    <input type="text" class="form-control" id="rg" name="rg" readonly
                                           value='<?php echo($_SESSION['rg']); ?>'>
                                </div>

                                <label for="enderecoCompleto">Pesquisar Endereço:</label>
                                <input type="text" id="enderecoCompleto" name="enderecoCompleto" class="form-control">
                                <small class="text-danger" id="searchError" style="display:none;">Endereço
                                    inválido.</small>
                                <input type="hidden" id="rua" name="rua">
                                <input type="hidden" id="cep" name="cep">

                                <button type="submit" class="btn btn-primary btn-block" id="submitBtn">
                                    Cadastrar Endereço
                                </button>
                                <div id="resposta"></div>
                            </form>
                        </div>
                    </div>
            </section>
        </div>
    </div>
</main>

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

                // Faz uma chamada para a API de Geocoding
                fetch(`https://maps.googleapis.com/maps/api/geocode/json?address=${encodeURIComponent(address)}&key=AIzaSyBV2RbCH4G9_X8i1sxWKAtdwiCkYFg44ig`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "OK") {
                            const components = data.results[0].address_components;
                            const cep = components.find(comp => comp.types.includes("postal_code"))?.long_name;

                            if (cep) {
                                $('#cep').val(cep);
                                document.getElementById("resposta").innerHTML = "Seu cep é:" + cep;
                            } else {
                                $('#cep').val('');
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
                alert('Por favor, complete o endereço corretamente, incluindo o número.');
            } else {
                this.submit();
            }
        });
    });
</script>


