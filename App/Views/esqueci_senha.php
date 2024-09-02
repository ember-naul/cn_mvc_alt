<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="/login" class="h1"><b>Admin</b>LTE</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>
      <form action="/novasenha" method="post">
        <div class="input-group mb-3">
          <input type="email" class="form-control" name="email" placeholder="Email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Request new password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <p class="mt-3 mb-1">
        <a href="/login">Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>

<?php 

// use App\Models\Usuario;

// // Recupera todos os usuários do banco de dados
// $usuarios = Usuario::all();

// // Itera sobre cada usuário e imprime suas informações
// foreach ($usuarios as $usuario) {
//     // Supondo que você queira imprimir todos os campos
//     // Você pode acessar os campos do usuário como propriedades do objeto
//     echo "ID: " . $usuario->id . "<br>";
//     echo "Nome: " . $usuario->nome . "<br>";
//     echo "Email: " . $usuario->email . "<br>";
//     // Adicione outras propriedades conforme necessário
//     echo "<hr>";
// }

?>