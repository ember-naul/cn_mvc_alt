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
<?php function censurarCPF($cpf)
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
                        <img width="150px" height="150px" class="profile-user-img img-fluid img-circle"
                             src="/assets/img/perfilicon.png" alt="User profile picture">
                        <h3 class="profile-username"><?= $usuario->nome ?></h3>

                        <div class="form-group">
                            <h5>Habilidades:</h5>
                            <div id="skills-container" class="d-flex flex-wrap justify-content-center">
                                <?php foreach ($habilidades as $profissionalHabilidade): ?>
                                    <span
                                            class="badge badge-info m-1"><?= $profissionalHabilidade->habilidade->nome ?></span>
                                <?php endforeach; ?>
                            </div>

                        </div>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item d-flex justify-content-between">
                                <b>Celular</b> <span class="float-right"><?= $usuario->celular ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <b>RG</b> <span class="float-right"><?= censurarRG($usuario->rg) ?></span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <b>CPF</b> <span class="float-right"><?= censurarCPF($usuario->cpf); ?></span>
                            </li>
                        </ul>

                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-6 mb-2">
                        <button
                                class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center">
                            <img src="/assets/img/servicos.png" alt="Histórico de Serviços" width="24" class="mr-2">
                            Histórico de Serviços
                        </button>
                    </div>
                    <div class="col-6 mb-2">
                        <a href="/enderecos">
                            <button
                                    class="btn btn-outline-custom btn-block d-flex justify-content-start align-items-center">
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
</div>
<!-- Modal for editing user info -->
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
    // Preenche o campo 'field' do formulário com o valor do campo que está sendo editado
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function () {
            const field = this.getAttribute('data-field');
            document.getElementById('field').value = field;
            document.getElementById('value').value = document.querySelector(`span.editable[data-field="${field}"]`).innerText;
        });
    });
</script>