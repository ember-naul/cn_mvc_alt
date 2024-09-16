<?php
namespace App\Views;

use App\Models\Habilidade;

// Recupera todas as habilidades do banco de dados
$habilidades = Habilidade::all();
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mamando galos negros</title>
    <link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <style>
        .main-card {
            width: 80%;
            margin: auto;
        }
        
        .form-control {
            width: 100%; 
            padding: 0.375rem 0.75rem; 
            border-radius: 0.25rem; 
            border: 1px solid #ced4da; 
        }

        /* Custom styles for Select2 */
        .select2-container {
            width: 100% !important; 
        }
        
        .select2-container--default .select2-selection--single {
            height: calc(2.25rem + 2px);
            line-height: 1.5;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
        }
    </style>
</head>
<body>
    <div class="main-card card w-25 p-1 h-100">
        <div class="card-body">
            <form action="/profissional/habilidades/inserir" method="post">
                <div class="row">
                    <div class="col-md-6">
                        <select id="dynamic-select" class="form-control js-example-tags" name="habilidades[]" multiple="multiple">
                            <?php foreach ($habilidades as $habilidade): ?>
                            <option value="<?= htmlspecialchars($habilidade['id']) ?>">
                            <?= htmlspecialchars($habilidade['nome']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <button class="mt-2 btn btn-primary" type="submit">Cadastrar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="/assets/plugins/jquery/jquery.min.js"></script>
    <script src="/assets/plugins/select2/js/select2.full.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $(".js-example-tags").select2({
                tags: true,
                placeholder: "Selecione suas habilidades",
                allowClear: true
            });
        });
    </script>
</body>
</html>
