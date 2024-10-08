<?php
namespace App\Views\habilidades;

use App\Models\Habilidade;
use App\Models\Profissional;
use App\Models\ProfissionalHabilidade;
use App\Models\Usuario;

$habilidades = Habilidade::all();
$usuario = Usuario::find($_SESSION['id_usuario']);
$profissional = Profissional::where('id_usuario', $usuario->id)->first();
$habilidades_do_profissional = ProfissionalHabilidade::where('id_profissional',"=", $profissional->id)
    ->distinct()
    ->pluck('id_habilidade')
    ->toArray();

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habilidades</title>
    <link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <style>
        .btn-custom {
            background-color: #3e4c69;
            color: white;
            border: none; /* Remove borda se necessário */
            padding: 10px 20px; /* Ajuste o padding conforme desejado */
            cursor: pointer; /* Muda o cursor para indicar que é clicável */
            transition: background-color 0.3s; /* Efeito suave na transição */
        }

        .btn-custom:hover {
            background-color: #2c3e50; /* Cor ao passar o mouse */
        }

        .btn-submit {
            display: block;
            width: 100%;
            margin-top: 1rem;
            background-color: #3e4c69;
            border:none;
        }

        .img-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .text-center-top {
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 1rem;
        }
    </style>

<body>
<div class="container-fluid d-flex justify-content-center align-items-center mt-5">
    <div class="row w-75">
        <div class="col-md-6">
            <div class="text-center-top mb-3">
                <h1>Mostre o que você pode fazer!</h1>
            </div>

            <div class="card h-75">
                <div class="card-body d-flex flex-column">
                    <p>Habilidades:</p>
                    <form action="/profissional/habilidades/inserir" method="post" class="d-flex flex-column">
                        <div class="form-group">
                            <select id="dynamic-select" class="form-control js-example-tags" name="habilidades[]" multiple="multiple">
                                <?php foreach ($habilidades as $habilidade): ?>
                                    <option value="<?= htmlspecialchars($habilidade['id']) ?>" <?= in_array($habilidade['id'], $habilidades_do_profissional) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($habilidade['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button class="btn btn-primary btn-submit btn-custom" type="submit">Prosseguir</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="img-container">
                <img src="/assets/img/habilidades.png" class="img-fluid" alt="Habilidades">
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="/assets/plugins/select2/js/select2.full.js"></script>
<script>
    $(document).ready(function() {
        $(".js-example-tags").select2({
            tags: true,
            placeholder: "Selecione suas habilidades",
            allowClear: true
        });

        $('#dynamic-select').on('change', function() {
            var selectedOptions = $(this).find('option:selected').map(function() {
                return $(this).text();
            }).get().join(', ');

            $('.selected-skills').html('<p><strong>Habilidades Selecionadas:</strong> ' + selectedOptions + '</p>');
        });
    });
</script>
</body>
</html>
