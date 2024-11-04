<?php
// use App\Widgets\BaseWidget;
// $breadcumb = [
//     [
//         'title' => 'Dashboard',
//         'url'   => '/home',
//     ],
// ];
// BaseWidget::breadcumb('Home', $breadcumb);

/**
 * @see App\Controllers\HomeController::index()
 * @see App\Controllers\ClienteController::novoCliente()
 * @see App\Controllers\ProfissionalController::novoProfissional()
 */
?>
<?php if ($_SESSION['logado'] == false): ?>

<body class="index-page">

<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">


        <a href="/home" class="logo d-flex align-items-center me-auto">
            <img src="/assets/img/logo.png" alt="">
            <h1 style="text-decoration:none;" class="sitename">Casa & Negócios</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="/home">Home</a></li>
                <li><a href="/home#about">Sobre nós</a></li>
                <li><a href="/home#services">Serviços</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>
        <a class="btn-getstarted" href="/login">Login</a>

    </div>
</header>
<?php endif; ?>

<main class="main">
    <section id="hero" class="hero section dark-background">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center"
                     data-aos="zoom-out">
                    <h1>Encontre profissionais e contrate serviços para tudo o que você precisar</h1>
                    <p>Diversos tipos de serviços em um só lugar!</p>
                    <div class="d-flex">
                        <?php if ($_SESSION['logado'] == true): ?>
                            <?php if (isset($_SESSION['escolha'])): ?>
                                <button data-toggle="modal" data-target="#modalescolha" class="btn btn-get-started">Comece
                                    agora
                                </button>
                            <?php endif;
                        ; ?>
                            <?php if (!isset($_SESSION['escolha'])): ?>
                                <button data-toggle="modal" data-target="#exampleModalCenter"
                                        class="btn btn-get-started">Escolha seu perfil!
                                </button>
                            <?php endif;; ?>
                        <?php endif;; ?>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="200">
                    <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

    </section>

    <section id="about" class="about section">
        <div class="container section-title" data-aos="fade-up">
            <h2>Sobre Nós</h2>
        </div>
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                    <p>
                        Somos uma agência dedicada a conectar você com os melhores profissionais para serviços
                        domésticos. Nosso compromisso é garantir segurança, confiança e alta qualidade em cada
                        serviço
                        oferecido.
                    </p>
                    <ul>
                        <li><i class="bi bi-check2-circle"></i> <span>Profissionais treinados e qualificados.</span>
                        </li>
                        <li><i class="bi bi-check2-circle"></i> <span>Segurança e confiabilidade garantidas.</span>
                        </li>
                        <li><i class="bi bi-check2-circle"></i> <span>Atendimento personalizado para suas
                                    necessidades.</span></li>
                    </ul>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <p>Com uma ampla gama de serviços, estamos aqui para simplificar sua vida, oferecendo soluções
                        sob
                        medida para sua casa ou empresa. Desde limpeza até serviços especializados, garantimos sua
                        tranquilidade e satisfação.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="why-us" class="section why-us light-background" data-builder="section">
        <div class="container-fluid">
            <div class="row gy-4">
                <div class="col-lg-7 d-flex flex-column justify-content-center order-2 order-lg-1">
                    <div class="content px-xl-5" data-aos="fade-up" data-aos-delay="100">
                        <h3><span>Por que escolher a </span><strong>Casa & Negócios?</strong></h3>
                        <p>
                            Nossa missão é proporcionar serviços de excelência com praticidade e confiança.
                            Selecionamos
                            cuidadosamente cada profissional para garantir que você receba o melhor atendimento,
                            sempre
                            com foco em segurança e qualidade.
                        </p>
                    </div>

                    <div class="faq-container px-xl-5" data-aos="fade-up" data-aos-delay="200">
                        <div class="faq-item faq-active">
                            <h3><span>01</span> Como selecionar os profissionais?</h3>
                            <div class="faq-content">
                                <p>Todos os nossos profissionais passam por um rigoroso processo de seleção,
                                    incluindo
                                    entrevistas, verificação de antecedentes e treinamentos específicos.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <div class="faq-item">
                            <h3><span>02</span> Posso confiar nos profissionais da agência?</h3>
                            <div class="faq-content">
                                <p>Sim! Nossa agência realiza uma verificação completa de todos os profissionais
                                    para
                                    garantir a segurança e a qualidade dos serviços prestados.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

                        <div class="faq-item">
                            <h3><span>03</span> Quais tipos de serviços vocês oferecem?</h3>
                            <div class="faq-content">
                                <p>Oferecemos uma ampla gama de serviços, incluindo limpeza, jardinagem, babás,
                                    cozinheiros(as), eletricistas, entre outros.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5 order-1 order-lg-2 why-us-img">
                    <img src="assets/img/why-us.png" class="img-fluid" alt="Por que escolher nossa agência"
                         data-aos="zoom-in" data-aos-delay="100">
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="services section">

        <div class="container section-title aos-init aos-animate" data-aos="fade-up">
            <h2>Nossos serviços</h2>
            <p>Quais serviços você pode contratar ou prestar em nossa plataforma</p>
        </div>

        <div class="container">

            <div class="row gy-4">

            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                <div class="service-item position-relative">
                    <div class="card-img">
                        <img src="" alt="" class="img-fluid">
                    </div>
                    <h3><a href="#" class="stretched-link">Jardinagem</a></h3>
                    <p>Cuida de jardins e plantas, garantindo seu crescimento saudável e embelezando espaços.</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                <div class="service-item position-relative">
                    <div class="card-img">
                        <img src="" alt="" class="img-fluid">
                    </div>
                    <h3><a href="#" class="stretched-link">Limpeza Pós-Obra</a></h3>
                    <p>Realiza a limpeza de espaços após reformas, removendo sujeira e resíduos da construção.</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                <div class="service-item position-relative">
                    <div class="card-img">
                        <img src="" alt="" class="img-fluid">
                    </div>
                    <h3><a href="#" class="stretched-link">Assistente</a></h3>
                    <p>Auxilia em diversas tarefas do dia a dia, ajudando na organização e execução de atividades.</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
                <div class="service-item position-relative">
                    <div class="card-img">
                        <img src="" alt="" class="img-fluid">
                    </div>
                    <h3><a href="#" class="stretched-link">Cozinheira(o)</a></h3>
                    <p>Prepara refeições, criando cardápios e garantindo a qualidade dos pratos servidos.</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="500">
                <div class="service-item position-relative">
                    <div class="card-img">
                        <img src="" alt="" class="img-fluid">
                    </div>
                    <h3><a href="#" class="stretched-link">Eletricista</a></h3>
                    <p>Instala e mantém sistemas elétricos, garantindo segurança e funcionamento adequado.</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="600">
                <div class="service-item position-relative">
                    <div class="card-img">
                        <img src="" alt="" class="img-fluid">
                    </div>
                    <h3><a href="#" class="stretched-link">Lavador(a)</a></h3>
                    <p>Realiza a lavagem e limpeza de roupas, garantindo cuidado e conservação dos tecidos.</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="700">
                <div class="service-item position-relative">
                    <div class="card-img">
                        <img src="" alt="" class="img-fluid">
                    </div>
                    <h3><a href="#" class="stretched-link">Babysitter (babá)</a></h3>
                    <p>Cuida de crianças, garantindo segurança e entretenimento enquanto os pais estão ausentes.</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="800">
                <div class="service-item position-relative">
                    <div class="card-img">
                        <img src="" alt="" class="img-fluid">
                    </div>
                    <h3><a href="#" class="stretched-link">Cuidador(a) de Animais</a></h3>
                    <p>Oferece cuidados para animais de estimação, incluindo alimentação, passeios e atenção.</p>
                </div>
            </div>

            </div>
            <div class="container section-title" data-aos="fade-up" data-aos-delay="200" style="padding-top:6%">
                <h5>Entre outros serviços...</h5>
            </div>
        </div>

    </section>
    <section id="call-to-action" class="call-to-action section dark-background">
        <img src="assets/img/cta-bg.png" alt="">
        <div class="container">
            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-xl-9 text-center text-xl-start">
                    <h3>Pronto para contratar um profissional?</h3>
                    <p>Faça sua solicitação e encontre o profissional ideal para suas necessidades com total
                        segurança e
                        praticidade.</p>
                </div>
                <div class="col-xl-3 cta-btn-container text-center">
                    <a class="cta-btn align-middle" href="#hero">Contrate Agora!</a>
                </div>
            </div>

        </div>

    </section>
    </div>
    </div>
    </section>
</main>
<?php if ($_SESSION['logado'] == false): ?>
    </div>
    <footer id="footer" class="footer">
        <div id="preloader"></div>
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="#hero" class="d-flex align-items-center">
                        <span class="sitename">Casa & Negócios</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Rua Vereador Sérgio Leopoldino Alves, 500</p>
                        <p>Distrito Industrial I, Santa Bárbara d'Oeste, SP</p>
                        <p class="mt-3"><strong>Celular:</strong> <span>+55 (19) 12345-6789</span></p>
                        <p><strong>Email:</strong> <span>casanegocios@contao.com</span></p>
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

</html>