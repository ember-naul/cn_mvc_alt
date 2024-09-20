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
                        <?php if (isset($_SESSION['escolha'])):?>
                        <button data-toggle="modal" data-target="#modalescolha" class="btn-get-started">Comece
                            agora</button>
                        <?php endif;;?>
                        <?php if (!isset($_SESSION['escolha'])):?>
                        <button data-toggle="modal" data-target="#exampleModalCenter" class="btn-get-started">Teste
                        agora</button>
                        <?php endif;;?>
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
            <h2>Sobre nós</h2>
        </div>>

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
                        </div>

                        <div class="faq-item">
                            <h3><span>02</span> Pergunta 2?
                            </h3>
                            <div class="faq-content">
                                <p>Resposta 2.</p>
                            </div>
                            <i class="faq-toggle bi bi-chevron-right"></i>
                        </div>

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

        <div class="container section-title aos-init aos-animate" data-aos="fade-up">
            <h2>Nossos serviços</h2>
            <p>Quais serviços você pode contratar ou prestar em nossa plataforma</p>
        </div>

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
                </div>

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item position-relative">
                        <div class="card-img">
                            <img src="assets/img/service-2.jpg" alt="" class="img-fluid">
                        </div>
                        <h3><a href="#" class="stretched-link">Diarista</a></h3>
                        <p>Asperiores provident dolor accusamus pariatur dolore nam id audantium ut et iure incidunt
                            molestiae dolor ipsam ducimus occaecati nisi</p>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item position-relative">
                        <div class="card-img">
                            <img src="assets/img/service-3.jpg" alt="" class="img-fluid">
                        </div>
                        <h3><a href="#" class="stretched-link">Babá</a></h3>
                        <p>Dicta quam similique quia architecto eos nisi aut ratione aut ipsum reiciendis sit doloremque
                            oluptatem aut et molestiae ut et nihil</p>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-item position-relative">
                        <div class="card-img">
                            <img src="assets/img/service-4.jpg" alt="" class="img-fluid">
                        </div>
                        <h3><a href="#" class="stretched-link">Cozinheira(o)</a></h3>
                        <p>Dicta quam similique quia architecto eos nisi aut ratione aut ipsum reiciendis sit doloremque
                            oluptatem aut et molestiae ut et nihil</p>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-item position-relative">
                        <div class="card-img">
                            <img src="assets/img/service-5.jpg" alt="" class="img-fluid">
                        </div>
                        <h3><a href="#" class="stretched-link">Eletricista</a></h3>
                        <p>Illo consequuntur quisquam delectus praesentium modi dignissimos facere vel cum onsequuntur
                            maiores beatae consequatur magni voluptates</p>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="600">
                    <div class="service-item position-relative">
                        <div class="card-img">
                            <img src="assets/img/service-6.jpg" alt="" class="img-fluid">
                        </div>
                        <h3><a href="#" class="stretched-link">Lavador(a)</a></h3>
                        <p>Quas assumenda non occaecati molestiae. In aut earum sed natus eatae in vero. Ab modi
                            quisquam aut nostrum unde et qui est non quo nulla</p>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="700">
                    <div class="service-item position-relative">
                        <div class="card-img">
                            <img src="assets/img/service-6.jpg" alt="" class="img-fluid">
                        </div>
                        <h3><a href="#" class="stretched-link">Churrasqueiro(a)</a></h3>
                        <p>Quas assumenda non occaecati molestiae. In aut earum sed natus eatae in vero. Ab modi
                            quisquam aut nostrum unde et qui est non quo nulla</p>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="800">
                    <div class="service-item position-relative">
                        <div class="card-img">
                            <img src="assets/img/service-6.jpg" alt="" class="img-fluid">
                        </div>
                        <h3><a href="#" class="stretched-link">Copeiro(a)</a></h3>
                        <p>Quas assumenda non occaecati molestiae. In aut earum sed natus eatae in vero. Ab modi
                            quisquam aut nostrum unde et qui est non quo nulla</p>
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

    </section>
    </div>
    </div>
    </section>
</main>
</body>

</html>