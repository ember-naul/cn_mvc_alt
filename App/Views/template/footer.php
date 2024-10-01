<?php require_once __DIR__ . '../../redirect_cadastros.php'; ?>
<?php //require_once __DIR__ . '../../cadastro_profissionais.php'; ?>
<?php if ($_SESSION['logado'] == true): ?>
    <footer id="footer" class="footer">
        <div id="preloader"></div>
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="d-flex align-items-center">
                        <span class="sitename">Casa & Negócios</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Rua Vereador Sérgio Leopoldino Alves, 500</p>
                        <p>Distrito Industrial I, Santa Bárbara d'Oeste, SP</p>
                        <p class="mt-3"><strong>Celular:</strong> <span>+55 (19) 12345-6789</span></p>
                        <p><strong>Email:</strong> <span>casanegocios@contato.com</span></p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 footer-links">
                </div>

                <div class="col-lg-2 col-md-3 footer-links">
                    <h4>Links úteis</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="/home">Home</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="/home#about">Sobre nós</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="/home#services">Serviços</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#">Termos de serviço</a></li>
                    </ul>
                </div>


                <div class="col-lg-4 col-md-12">
                    <h4>Nos siga</h4>
                    <p>Nas nossas redes sociais</p>
                    <div class="social-links d-flex">
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <strong>&copy; 2024 <a href="/home">Casa & Negócios</a>.</strong> Todos os direitos reservados.
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Elementos e design utilizados do site <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>

    </footer>
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    </div>
<?php endif; ?>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- <script src="/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="/assets/js/main.js"></script>
<script src="/assets/vendor/glightbox/js/glightbox.min.js"></script>
<script src="/assets/plugins/sweetalert2/sweetalert2.js"></script>
<script src="/assets/plugins/select2/js/select2.full.min.js"></script>
<script src="/assets/vendor/aos/aos.js"></script>

<script>
    $(document).ready(function () {
        // Exibir o toast com temporizador
        $('.toast').toast({ delay: 3000 }); // O toast desaparecerá automaticamente após 3 segundos
        $('.toast').toast('show'); // Mostra o toast

        // Permitir fechar o toast com o botão "X"
        $('.toast .close').on('click', function () {
            $(this).closest('.toast').toast('hide');
        });
    });

</script>

</html>