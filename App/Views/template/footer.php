<?php require_once __DIR__ . '../../cadastro_clientes.php'; ?>
<?php require_once __DIR__ . '../../cadastro_profissionais.php'; ?>
<?php if($_SESSION['logado'] == true): ?>
  </div>
  <!-- Footer -->
  <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            Olá <?php echo $_SESSION['nome'] . " " . $_SESSION['id_usuario']; ?>.
        </div>
        <strong>&copy; 2024 <a href="/home">Casa & Negócios</a>.</strong> Todos os direitos reservados.
    </footer>
</div>
<?php endif; ?>
</body>
<script src="/assets/plugins/jquery/jquery.js"></>
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.js"></script>
<script src="/assets/js/adminlte.js?v=3.2.0"></script>
<script src="/assets/plugins/sweetalert2/sweetalert2.js"></script>
<script src="/assets/plugins/toastr/toastr.min.js"></script> 
<script src="/assets/plugins/select2/js/select2.full.min.js"></script>
<script src="/assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<script src="/assets/plugins/moment/moment.min.js"></script>
<script src="/assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<script src="/assets/plugins/daterangepicker/daterangepicker.js"></script>
<script src="/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<script src="/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<script src="/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script src="/assets/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<script src="/assets/plugins/dropzone/min/dropzone.min.js"></script>
</html>
