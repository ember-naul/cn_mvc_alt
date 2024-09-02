<?php require_once __DIR__ . '../../cadastro_clientes.php'; ?>
<?php if($_SESSION['logado'] == true): ?>
  </div>
  <!-- Footer -->
  <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            Olá <?php echo $_SESSION['nome']; ?>.
        </div>
        <strong>&copy; 2024 <a href="/home">Casa & Negócios</a>.</strong> Todos os direitos reservados.
    </footer>
</div>
<?php endif; ?>
</body>
<!-- 

nao entendi o pq de ter funcionado quando eu comentei, mas enfim
"se funciona não questiona." araujo, brayan 02/09/2024 
-->
<script src="assets/plugins/jquery/jquery.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.js"></script>
<script src="assets/js/adminlte.js?v=3.2.0"></script>
<script src="assets/plugins/sweetalert2/sweetalert2.js"></script>
<script src="assets/plugins/toastr/toastr.js"></script> 
</html>
