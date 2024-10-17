<?php

use App\Models\Habilidade;
use App\Models\Profissional;
use App\Models\Cliente;
use App\Models\Usuario;
use App\Models\ProfissionalHabilidade;

$usuario = Usuario::where('id', $_SESSION['id_usuario'])->first();
$cliente = Cliente::where('id_usuario', $usuario->id)->first();
$profissional = Profissional::where('id_usuario', $usuario->id)->first();

$habilidades = [];

if ($profissional) {
    $habilidades = ProfissionalHabilidade::with('habilidade')
        ->where('id_profissional', $profissional->id)
        ->get();
}
?>
<style>

    .btn-outline-custom img {
        transition: filter 0.3s; /* Transição suave para o filtro */
    }

    .btn-outline-custom:hover img {
        filter: invert(1); /* Inverte as cores da imagem */
    }
    .btn-outline-custom {
        border: 2px solid #3e4c69; /* Borda personalizada */
        color: #3e4c69; /* Cor do texto */
        background-color: transparent; /* Fundo transparente */
        transition: background-color 0.3s, color 0.3s; /* Transição suave */
    }

    .btn-outline-custom:hover {
        background-color: #3e4c69; /* Cor de fundo ao passar o mouse */
        color: white; /* Cor do texto ao passar o mouse */
    }

    .edit-button {
        background-color: #3e4c69; /* Cor do botão */
        color: #fff; /* Cor do texto */
        border: none; /* Remove a borda */
        border-radius: 5px; /* Bordas arredondadas */
        padding: 5px 10px; /* Padding interno */
        margin-left: 10px; /* Espaço à esquerda */
        cursor: pointer; /* Cursor pointer para indicar que é clicável */
        transition: background-color 0.3s ease; /* Transição suave */
    }

    .edit-button:hover {
        background-color: #2c3e50; /* Cor ao passar o mouse */
    }

    .profile-user-img {
        position: relative; /* Para que o botão de editar possa ser posicionado em relação à imagem */
    }

    .edit-button[data-field="foto"] {
        position: absolute; /* Posiciona o botão em relação à imagem */
        bottom: 10px; /* Distância do fundo da imagem */
        left: 50%; /* Centraliza horizontalmente */
        transform: translateX(-50%); /* Ajusta para centralizar corretamente */
        font-size: 12px; /* Tamanho da fonte */
    }

    .badge-custom {
        background-color: #3e4c69; /* Cor de fundo */
        color: white; /* Cor do texto */
    }

    .badge-custom:hover {
        background-color: #2c3e50; /* Cor ao passar o mouse */
    }
     .perfil-imagem {
         position: relative;
         width: 25%;
         border-radius:100%;
         margin: auto;
     }

    .image {
        opacity: 1;
        transition: .5s ease;
        backface-visibility: hidden;
    }

    .middle {
        transition: .5s ease;
        opacity: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        text-align: center;
    }

    .perfil-imagem:hover .image {
        opacity: 0.65;
    }

    .perfil-imagem:hover .middle {
        opacity: 1;
    }

    .text {
        background-color: #3d4d6a;
        color: white;
        font-size: 13px;
        padding: 8px 16px;
    }
</style>

<div class="container-fluid container-xl position-relative d-flex align-items-center">
    <a href="/home" class="d-flex align-items-center me-auto">
        <img src="/assets/img/logo.png" class='logocn' alt="">
    </a>
    <hr>
    <nav id="navmenu" class="navmenu">
        <ul>
            <li><a href="/home">Home</a></li>

            <?php if ($_SESSION['logado'] == false): ?>
                <li><a href="/home#about">Sobre nós</a></li>
                <li><a href="/home#services">Serviços</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['profissional']) && $_SESSION['profissional'] == true): ?>
                <li><a href="/profissional/habilidades">Habilidades</a></li>
            <?php endif; ?>
            <li><a href="#" data-toggle="modal" data-target="#modal-lg">Perfil</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
    </nav>
    <?php if (!isset($_SESSION['profissional']) && !isset($_SESSION['cliente'])): ?>
        <a class="btn-getstarted" data-toggle="modal" data-target="#exampleModalCenter">Comece agora</a>
    <?php endif; ?>


</div>
</header>
<?php

function censurarCPF($cpf)
{
    $cpf = preg_replace('/\D/', '', $cpf);
    return (strlen($cpf) !== 11) ? 'CPF inválido' :
        substr($cpf, 0, 3) . '.***.***-' . substr($cpf, -2);
}

function censurarRG($rg)
{
    $rg = preg_replace(
        '/\D/',
        '',
        $rg
    );
    return (strlen($rg) < 8 || strlen($rg) > 12) ? 'RG inválido' : substr($rg, 0, 2) . '.***.***-' . substr(
            $rg,
            -2
        );
}
function formatarCelular($celular) {
    // Remove todos os caracteres que não são dígitos
    $celular = preg_replace('/\D/', '', $celular);

    // Verifica se o número de dígitos é 11 (para o formato (XX) XXXXX-XXXX)
    if (strlen($celular) !== 11) {
        return 'Número de celular inválido';
    }

    // Formata o celular
    return '(' . substr($celular, 0, 2) . ') ' . substr($celular, 2, 5) . '-' . substr($celular, 7);
}
?>

<div class="modal fade" id="modal-lg" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-lg">
            <div class="modal-header justify-content-center">
                <h4 class="modal-title" id="modalLabel">Ajustes</h4>
                <button type="button" class="close position-absolute" style="right: 15px;" data-dismiss="modal"
                        aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="container-fluid">
                <div class="row mb-3">

                    <div class="card-body box-profile text-center">
                       <div>
                           <div class="perfil-imagem">
                               <img src="<?= $usuario->imagem ? "https://storage.googleapis.com/profilepics-cn/{$usuario->imagem}" : '/assets/img/perfilicon.png' ?>" alt="Avatar" class="profile-user-img img-fluid img-circle image" style="margin-bottom:5%; border-radius:100%;">
                               <div class="middle">
                                   <a href="/enviar_imagem"><div class="text">Editar</div></a>
                               </div>
                           </div>
                       </div>


                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <b>Nome</b>
                                <h4 class="profile-username"><?= $usuario->nome ?></h4>
                                <button class="edit-button" data-field="nome" data-toggle="modal"
                                        data-target="#editModal"><i class="fa fa-edit"></i>
                                </button>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <b>Celular</b>
                                <span class="float-right"><?= formatarCelular($usuario->celular) ?></span>
                                <button class="edit-button" data-field="celular" data-toggle="modal"
                                        data-target="#editModal"><i class="fa fa-edit"></i>
                                </button>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <b>Email</b>
                                <span class="editable" data-field="email"><?= $usuario->email ?></span>
                                <span style="opacity:0;"><i class="fa fa-edit"></i>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <b>RG</b>
                                <span class="float-right"><?= censurarRG($usuario->rg) ?></span>
                                <span style="opacity:0;"><i class="fa fa-edit"></i>
                                </span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <b>CPF</b>
                                <span class="float-right"><?= censurarCPF($usuario->cpf); ?></span>
                                <span style="opacity:0;"><i class="fa fa-edit"></i>
                                </span>
                            </li>
                        </ul>
                        <?php if (!$_SESSION['cliente'] && $_SESSION['profissional']) : ?>
                        <div class="form-group">
                            <h5>Habilidades:</h5>
                            <div id="skills-container" class="d-flex flex-wrap justify-content-center">
                                <?php foreach ($habilidades as $profissionalHabilidade): ?>
                                    <span class="badge badge-info badge-custom m-1"><?= $profissionalHabilidade->habilidade->nome ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


            <div class="row text-center ml-5 mr-5">
                <div class="col-6 mb-2">
                    <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center">
                        <img src="/assets/img/servicos.png" alt="Histórico de Serviços" width="24" class="mr-2">
                        Histórico de Serviços
                    </button>
                </div>
                <div class="col-6 mb-2">
                    <a href="/enderecos">
                        <button class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center">
                            <img src="/assets/img/endereco.png" alt="Endereços" width="24" class="mr-2"> Endereços
                        </button>
                    </a>
                </div>
                <div class="col-6 mb-2">
                    <button
                            class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center">
                        <img src="/assets/img/pagamento.png" alt="Pagamento" width="24" class="mr-2"> Pagamento
                    </button>
                </div>
                <?php if (!$cliente || !$profissional || !$cliente && !$profissional): ?>
                    <div class="col-6 mb-2">
                        <button data-toggle="modal" data-target="#exampleModalCenter"
                                class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center">
                            <img src="/assets/img/suporte.png" alt="Suporte" width="24" class="mr-2"> Cadastrar em
                            outro perfil
                        </button>
                    </div>
                <?php endif; ?>

                <div class="col-6 mb-2">
                    <a href="/home#about"
                       class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center">
                        <img src="/assets/img/sobre.png" alt="Sobre" width="24" class="mr-2"> Sobre
                    </a>
                </div>
                <div class="col-6 mb-2">
                    <a href="/deslogar"
                       class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center">
                        <img src="/assets/img/sair.png" alt="Sair" width="24" class="mr-2"> Sair
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="editModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Informação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/update-usuario" method="POST">
                    <input type="hidden" name="field" id="field">
                    <div class="form-group">
                        <label for="value">Novo Valor</label>
                        <input type="text" class="form-control" id="value" name="value" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function () {
            const field = this.getAttribute('data-field');
            document.getElementById('field').value = field;
            document.getElementById('value').value = document.querySelector(`span.editable[data-field="${field}"]`).innerText;
        });
    });

</script>