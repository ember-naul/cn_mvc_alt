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
<main class="main">
    <section id="hero" class="hero section dark-background">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
                    <h1>Encontre profissionais e contrate serviços para tudo o que você precisar</h1>
                    <p>Diversos tipos de serviços em um só lugar!</p>
                    <div class="d-flex">
                        <a href="#about" class="btn-get-started">Comece agora</a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="200">
                    <img src="assets/img/hero-img.png" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Sobre nós</h2>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-6 content" data-aos="fade-up" data-aos-delay="100">
                    <p>
                        Nós somos uma empresa focada em...
                    </p>
                    <ul>
                        <li><i class="bi bi-check2-circle"></i> <span>Item 1.</span></li>
                        <li><i class="bi bi-check2-circle"></i> <span>Item 2.</span></li>
                        <li><i class="bi bi-check2-circle"></i> <span>Item 3.</span></li>
                    </ul>
                </div>

                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                    <p>Resumo sobre nossas coisas e ferramentas/serviços </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Us Section -->
    <section id="why-us" class="section why-us light-background" data-builder="section">

        <div class="container-fluid">

            <div class="row gy-4">

                <div class="col-lg-7 d-flex flex-column justify-content-center order-2 order-lg-1">

                    <div class="content px-xl-5" data-aos="fade-up" data-aos-delay="100">
                        <h3><span>Por que escolher o nosso aplicativo? </span><strong>Casa & Negócios?</strong></h3>
                        <p>
                            Descrição do por que a pessoa deve escolher nosso aplicativo
                        </p>
                    </div>

                    <div class="faq-container px-xl-5" data-aos="fade-up" data-aos-delay="200">

                        <div class="faq-item faq-active">

                            <h3><span>01</span> Perguna 1?</h3>
                            <div class="faq-content">
                                <p>Resposta 1.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3><span>02</span> Pergunta 2?
                            </h3>
                            <div class="faq-content">
                                <p>Resposta 2.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div><!-- End Faq item-->

                        <div class="faq-item">
                            <h3><span>03</span> Pergunta 3?</h3>
                            <div class="faq-content">
                                <p>Resposta 3.
                                </p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>
                    </div>

                </div>

                <div class="col-lg-5 order-1 order-lg-2 why-us-img">
                    <img src="assets/img/why-us.png" class="img-fluid" alt="" data-aos="zoom-in" data-aos-delay="100">
                </div>
            </div>

        </div>

    </section>

    <section id="services" class="services section">

        <!-- Section Title -->
        <div class="container section-title aos-init aos-animate" data-aos="fade-up">
            <h2>Nossos serviços</h2>
            <p>Quais serviços você pode contratar ou prestar em nossa plataforma</p>
        </div><!-- End Section Title -->

        <div class="container">

            <div class="row gy-4">

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item position-relative">
                        <div class="card-img">
                            <img src="assets/img/service-1.jpg" alt="" class="img-fluid">
                        </div>
                        <h3><a href="#" class="stretched-link">Jardinagem</a></h3>
                        <p>Cumque eos in qui numquam. Aut aspernatur perferendis sed atque quia voluptas quisquam
                            repellendus temporibus itaqueofficiis odit</p>
                    </div>
                </div><!-- End Card Item -->

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item position-relative">
                        <div class="card-img">
                            <img src="assets/img/service-2.jpg" alt="" class="img-fluid">
                        </div>
                        <h3><a href="#" class="stretched-link">Diarista</a></h3>
                        <p>Asperiores provident dolor accusamus pariatur dolore nam id audantium ut et iure incidunt
                            molestiae dolor ipsam ducimus occaecati nisi</p>
                    </div>
                </div><!-- End Card Item -->

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item position-relative">
                        <div class="card-img">
                            <img src="assets/img/service-3.jpg" alt="" class="img-fluid">
                        </div>
                        <h3><a href="#" class="stretched-link">Babá</a></h3>
                        <p>Dicta quam similique quia architecto eos nisi aut ratione aut ipsum reiciendis sit doloremque
                            oluptatem aut et molestiae ut et nihil</p>
                    </div>
                </div><!-- End Card Item -->

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-item position-relative">
                        <div class="card-img">
                            <img src="assets/img/service-4.jpg" alt="" class="img-fluid">
                        </div>
                        <h3><a href="#" class="stretched-link">Cozinheira(o)</a></h3>
                        <p>Dicta quam similique quia architecto eos nisi aut ratione aut ipsum reiciendis sit doloremque
                            oluptatem aut et molestiae ut et nihil</p>
                    </div>
                </div><!-- End Card Item -->

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-item position-relative">
                        <div class="card-img">
                            <img src="assets/img/service-5.jpg" alt="" class="img-fluid">
                        </div>
                        <h3><a href="#" class="stretched-link">Eletricista</a></h3>
                        <p>Illo consequuntur quisquam delectus praesentium modi dignissimos facere vel cum onsequuntur
                            maiores beatae consequatur magni voluptates</p>
                    </div>
                </div><!-- End Card Item -->

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="600">
                    <div class="service-item position-relative">
                        <div class="card-img">
                            <img src="assets/img/service-6.jpg" alt="" class="img-fluid">
                        </div>
                        <h3><a href="#" class="stretched-link">Lavador(a)</a></h3>
                        <p>Quas assumenda non occaecati molestiae. In aut earum sed natus eatae in vero. Ab modi
                            quisquam aut nostrum unde et qui est non quo nulla</p>
                    </div>
                </div><!-- End Card Item -->

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="700">
                    <div class="service-item position-relative">
                        <div class="card-img">
                            <img src="assets/img/service-6.jpg" alt="" class="img-fluid">
                        </div>
                        <h3><a href="#" class="stretched-link">Churrasqueiro(a)</a></h3>
                        <p>Quas assumenda non occaecati molestiae. In aut earum sed natus eatae in vero. Ab modi
                            quisquam aut nostrum unde et qui est non quo nulla</p>
                    </div>
                </div><!-- End Card Item -->

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="800">
                    <div class="service-item position-relative">
                        <div class="card-img">
                            <img src="assets/img/service-6.jpg" alt="" class="img-fluid">
                        </div>
                        <h3><a href="#" class="stretched-link">Copeiro(a)</a></h3>
                        <p>Quas assumenda non occaecati molestiae. In aut earum sed natus eatae in vero. Ab modi
                            quisquam aut nostrum unde et qui est non quo nulla</p>
                    </div>
                </div><!-- End Card Item -->
            </div>
            <div class="container section-title" data-aos="fade-up" data-aos-delay="200" style="padding-top:6%">
                <h5>Entre outros serviços...</h5>
            </div>
        </div>

    </section>

    <!-- <section id="services" class="services section light-background">
            <div class="container section-title" data-aos="fade-up">
                <h2>Serviços</h2>
                <p>Quais serviços você pode contratar ou prestar em nossa plataforma</p>
            </div>

            <div class="container">

                <div class="row gy-4">

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-activity icon"></i></div>
                            <h4><a href="" class="stretched-link">Lorem Ipsum</a></h4>
                            <p>Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-bounding-box-circles icon"></i></div>
                            <h4><a href="" class="stretched-link">Sed ut perspici</a></h4>
                            <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore</p>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-calendar4-week icon"></i></div>
                            <h4><a href="" class="stretched-link">Magni Dolores</a></h4>
                            <p>Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia</p>
                        </div>
                    </div>

                    <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-item position-relative">
                            <div class="icon"><i class="bi bi-broadcast icon"></i></div>
                            <h4><a href="" class="stretched-link">Nemo Enim</a></h4>
                            <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis</p>
                        </div>
                    </div>

                </div>

            </div>

        </section> -->

    <!-- Call To Action Section -->
    <section id="call-to-action" class="call-to-action section dark-background">

        <img src="assets/img/cta-bg.jpg" alt="">

        <div class="container">

            <div class="row" data-aos="zoom-in" data-aos-delay="100">
                <div class="col-xl-9 text-center text-xl-start">
                    <h3>Call To Action</h3>
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
                        pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                        mollit anim id est laborum.</p>
                </div>
                <div class="col-xl-3 cta-btn-container text-center">
                    <a class="cta-btn align-middle" href="#">Call To Action</a>
                </div>
            </div>

        </div>

    </section><!-- /Call To Action Section -->

    <!-- <section id="team" class="team section">

            <div class="container section-title" data-aos="fade-up">
                <h2>Nosso time</h2>
                <p>Confira os integrantes da nossa equipe</p>
            </div>

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="assets/img/team/team-1.jpg" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Luan Henrique</h4>
                                <span>Líder / Programador</span>
                                <p>Explicabo voluptatem mollitia et repellat qui dolorum quasi</p>
                                <div class="social">
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""> <i class="bi bi-linkedin"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="assets/img/team/team-2.jpg" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Brayan Araujo</h4>
                                <span> Programador </span></span>
                                <p>Aut maiores voluptates amet et quis praesentium qui senda para</p>
                                <div class="social">
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""> <i class="bi bi-linkedin"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="assets/img/team/team-3.jpg" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Higor Nakamoto</h4>
                                <span>Copywriter</span>
                                <p>Quisquam facilis cum velit laborum corrupti fuga rerum quia</p>
                                <div class="social">
                                    <a href=""><i class="bi bi-facebook"></i></a>
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""> <i class="bi bi-linkedin"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="team-member d-flex align-items-start">
                            <div class="pic"><img src="assets/img/team/team-4.jpg" class="img-fluid" alt=""></div>
                            <div class="member-info">
                                <h4>Maria Clara</h4>
                                <span>Copywriter</span>
                                <p>Dolorum tempora officiis odit laborum officiis et et accusamus</p>
                                <div class="social">
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""> <i class="bi bi-linkedin"></i> </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section> -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Contact</h2>
            <p>Necessitatibus eius consequatur ex aliquid fuga eum quidem sint consectetur velit</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row gy-4">

                <div class="col-lg-5">

                    <div class="info-wrap">
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Endereço</h3>
                                <p>Rua Vereador Sérgio Leopoldino Alves, 500 - Distrito Industrial I, Santa Bárbara
                                    d'Oeste - SP</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Call Us</h3>
                                <p>+55 (19) 12345-6789</p>
                            </div>
                        </div><!-- End Info Item -->

                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Email Us</h3>
                                <p>casanegocios@contato.com</p>
                            </div>
                        </div><!-- End Info Item -->

                        <img src="assets/img/login-image.webp" width="100%"></img>
                    </div>
                </div>

                <div class="col-lg-7">
                    <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up"
                        data-aos-delay="200">
                        <div class="row gy-4">

                            <div class="col-md-6">
                                <label for="name-field" class="pb-2">Seu nome</label>
                                <input type="text" name="name" id="name-field" class="form-control" required="">
                            </div>

                            <div class="col-md-6">
                                <label for="email-field" class="pb-2">Seu email</label>
                                <input type="email" class="form-control" name="email" id="email-field" required="">
                            </div>

                            <div class="col-md-12">
                                <label for="subject-field" class="pb-2">Assunto</label>
                                <input type="text" class="form-control" name="subject" id="subject-field" required="">
                            </div>

                            <div class="col-md-12">
                                <label for="message-field" class="pb-2">Messagem</label>
                                <textarea class="form-control" name="message" rows="10" id="message-field"
                                    required=""></textarea>
                            </div>

                            <div class="col-md-12 text-center">
                                <div class="loading">Loading</div>
                                <div class="error-message"></div>
                                <div class="sent-message">Your message has been sent. Thank you!</div>

                                <button type="submit">Send Message</button>
                            </div>

                        </div>
                    </form>
                </div><!-- End Contact Form -->

            </div>

        </div>

    </section><!-- /Contact Section -->
    <!-- <h1> Diversos tipos de serviços </h1>
                <span class="second-line">em um só lugar!</span>
            <div class="flex-container home">
                <img src="assets/img/jardineiro.png" class="jardineiro img-fluid" alt="Jardineiro">
                <p class="testep mb-3">Encontre profissionais e contrate <br>serviços para tudo o que você precisar</p>
            </div>
        </div> -->
    <!-- <section id="servicos" class="gray">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6 col-lg-4 p-3 d-flex">
                        <section class="teste-2 align-items-center">
                            <p class="testep mb-1">Você deseja se tornar um <b>cliente</b> para contratar um profissional para você?</p>
                            <p class="testep mb-3">Clique aqui para saber mais!</p>
                            <button class="btn btn-dark" data-toggle="modal" data-target="#modal_cadastro_cliente">Cadastre-se</button>
                        </section>
                    </div>
                    <div class="col-md-6 col-lg-4 p-3 d-flex">
                        <section class="teste-2 align-items-center">
                            <p class="testep mb-2">Você deseja se cadastrar como um <b>profissional</b> para divulgar seus serviços<br> em nosso web site?</p>
                            <p class="testep mb-3">Clique aqui para saber mais!</p>
                            <button class="btn btn-dark" data-toggle="modal" data-target="#modal_cadastro_profissional">Cadastre-se</button>
                        </section>
                    </div>
                </div>
            </div>
        </section> -->

    <!-- <section id="sobrenos" class="container l-5 about-section mt-5 mb-5">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-left">
                    <h2 class="inter-h1">Sobre Nós</h2>
                    <p class="about-text mt-4">Nosso compromisso é fornecer um ambiente seguro e confiável para que você possa encontrar o que precisa de maneira rápida.<br> Agradecemos por escolher nossa plataforma e estamos sempre aqui para ajudar com qualquer dúvida ou necessidade.</p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="assets/img/logo2.png" class="img-fluid" alt="Logo">
                </div>
                <div class="col-md-6 text-center">
                    <img src="assets/img/contato.png" class="img-fluid" alt="Logo">
                </div>
                <div class="col-md-6 text-center text-md-left">
                <h2 class="inter-h1 mt-5">Contato</h2>
                    <p class="about-text mt-4">Celular  : (19) 99332-6023<br>
                                               Email    : casanegocios@sac.com<br>
                                               Instagram: @casanegocios<br>
                                               Facebook  : casanegocios<br>
                                               </p>
                </div>
            </div>
        </section> -->
    </div>
    </div>
    </section>
</main>
</body>

</html>