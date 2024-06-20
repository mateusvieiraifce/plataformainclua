<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>
        Conecta-agropec
    </title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assetsl/css/bootstrap.min.css" >
    <!-- Icon -->
    <link rel="stylesheet" href="assetsl/fonts/line-icons.css">
    <!-- Slicknav -->
    <link rel="stylesheet" href="assetsl/css/slicknav.css">
    <!-- Owl carousel -->
    <link rel="stylesheet" href="assetsl/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assetsl/css/owl.theme.css">

    <link rel="stylesheet" href="assetsl/css/magnific-popup.css">
    <link rel="stylesheet" href="assetsl/css/nivo-lightbox.css">
    <!-- Animate -->
    <link rel="stylesheet" href="assetsl/css/animate.css">
    <!-- Main Style -->
    <link rel="stylesheet" href="assetsl/css/main.css">
    <!-- Responsive Style -->
    <link rel="stylesheet" href="assetsl/css/responsive.css">

</head>
<body>

<!-- Header Area wrapper Starts -->
<header id="header-wrap">
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-md bg-inverse fixed-top scrolling-navbar">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <a href="index.html" class="navbar-brand"><img src="assetsl/img/logo.png" alt=""></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <i class="lni-menu"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto w-100 justify-content-end clearfix">
                    <li class="nav-item active">
                        <a class="nav-link" href="#hero-area">
                            @lang('mensage.home')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#feature">
                            @lang('mensage.func')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">
                            @lang('mensage.serv')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#team">
                            @lang('mensage.equipe')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#counter">
                            @lang('mensage.num')
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">
                            @lang('mensage.precos')
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#portfolios">
                            @lang('mensage.parceiros')
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#contact">
                            @lang('mensage.contato')
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{route('login')}}">
                            Entrar
                        </a>
                    </li>


                    <li class="nav-item">

                        <a class="nav-link" href="/" width="32" height="32">
                            <img src="/assetsl/img/brasil.png">
                        </a>

                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="/en">

                            <img src="/assetsl/img/eua.png" width="32" height="32">
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/esp">
                            <img src="/assetsl/img/espanha.png" width="32" height="32">
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Hero Area Start -->
    <div id="hero-area" class="hero-area-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="contents text-center">
                        <h2 class="head-title wow fadeInUp">@lang('mensage.mensagem_inicial')</h2>
                        <div class="header-button wow fadeInUp" data-wow-delay="0.3s">
                            <a href="#services" class="btn btn-common">@lang('mensage.explore')</a>
                        </div>
                    </div>
                    <div class="img-thumb text-center wow fadeInUp" data-wow-delay="0.6s">
                        <img class="img-fluid" src="assetsl/img/hero-1.png" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero Area End -->

</header>
<!-- Header Area wrapper End -->

<!-- Feature Section Start -->
<div id="feature">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <div class="text-wrapper">
                    <div>
                        <h2 class="title-hl wow fadeInLeft" data-wow-delay="0.3s">@lang('mensage.ajudamos')</h2>
                        <p class="mb-4">@lang('mensage.ajudamos2') </p>
                        <a href="#" class="btn btn-common">@lang('mensage.nos')</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12 col-sm-12 padding-none feature-bg">
                <div class="feature-thumb">
                    <div class="feature-item wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="300ms">
                        <div class="icon">
                            <i class="lni-microphone"></i>
                        </div>
                        <div class="feature-content">
                            <h3>@lang('mensage.fazemos')?</h3>
                            <p> @lang('mensage.fornecemos')  </p>

                            </p>
                        </div>
                    </div>
                    <div class="feature-item wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="500ms">
                        <div class="icon">
                            <i class="lni-users"></i>
                        </div>
                        <div class="feature-content">

                            <p> @lang('mensage.fornecemos2')
                        </div>
                    </div>
                    <div class="feature-item wow fadeInDown" data-wow-duration="1000ms" data-wow-delay="700ms">
                        <div class="icon">
                            <i class="lni-medall-alt"></i>
                        </div>
                        <div class="feature-content">
                            <p>@lang('mensage.aprendizado')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Feature Section End -->

<!-- Services Section Start -->
<section id="services" class="section-padding bg-gray">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">@lang('mensage.nossoserv')</h2>
            <p>@lang('mensage.plataforma')</p>
        </div>
        <div class="row">
            <!-- Services item -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="0.3s">
                    <div class="icon">
                        <i class="lni-pencil"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">@lang('mensage.gestao')</a></h3>
                        <p>@lang('mensage.plataforma2')</p>
                    </div>
                </div>
            </div>
            <!-- Services item -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="0.6s">
                    <div class="icon">
                        <i class="lni-briefcase"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">@lang('mensage.winzard')</a></h3>
                        <p>@lang('mensage.processo')</p>
                    </div>
                </div>
            </div>
            <!-- Services item -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="0.9s">
                    <div class="icon">
                        <i class="lni-cog"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">@lang('mensage.interface')</a></h3>
                        <p>@lang('mensage.final')</p>
                    </div>
                </div>
            </div>
            <!-- Services item -->
            <div class="col-md-6 col-lg-4 col-xs-12" >
                <div class="services-item wow fadeInRight" data-wow-delay="1.2s" >
                    <div class="icon">
                        <i class="lni-mobile"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">@lang('mensage.integracao')</a></h3>
                        <p>@lang('mensage.criar')</p>
                    </div>
                </div>
            </div>
            <!-- Services item -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="1.5s">
                    <div class="icon">
                        <i class="lni-layers"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">@lang('mensage.intuitivo')</a></h3>
                        <p>@lang('mensage.dashbord') </p>
                    </div>
                </div>
            </div>
            <!-- Services item -->
            <div class="col-md-6 col-lg-4 col-xs-12">
                <div class="services-item wow fadeInRight" data-wow-delay="1.8s">
                    <div class="icon">
                        <i class="lni-rocket"></i>
                    </div>
                    <div class="services-content">
                        <h3><a href="#">@lang('mensage.completos')</a></h3>
                        <p>@lang('mensage.plataforma3')</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->

<!-- Start Video promo Section -->
<section class="video-promo section-padding text-center">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <iframe width="420" height="345" src="https://www.youtube.com/embed/WVL3AiWWi6U?si=i25Nst0pSe4oQVcj">
                </iframe>
            </div>
        </div>
    </div>
</section>
<!-- End Video Promo Section -->

<!-- Team Section Start -->
<section id="team" class="section-padding text-center">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">@lang('mensage.time')</h2>
            <p>@lang('mensage.equipe2')</p>
        </div>
        <div class="row" >
            <div class="col-sm-6 col-md-6 col-lg-3" style="margin-left: 15%;">
                <!-- Team Item Starts -->
                <div class="team-item text-center wow fadeInRight" data-wow-delay="0.3s">
                    <div class="team-img">
                        <img class="img-fluid" src="assetsl/img/team/brad1.jpg" alt="" style="height: 350px;">
                        <div class="team-overlay">
                            <div class="overlay-social-icon text-center">
                                <ul class="social-icons">

                                    <li><a href="https://br.linkedin.com/in/ilso-da-silva-72559969"><i class="lni-linkedin-filled" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="info-text">
                        <h3><a href="#">Ilso S. Silva</a></h3>
                        <p>Chief Executive Officer-CEO</p>
                    </div>
                </div>
                <!-- Team Item Ends -->
            </div>

            <div class="col-sm-6 col-md-6 col-lg-3">
                <!-- Team Item Starts -->
                <div class="team-item text-center wow fadeInRight" data-wow-delay="0.6s">
                    <div class="team-img">
                        <img class="img-fluid" src="assetsl/img/team/leo1.jpg" alt="" style="height: 350px; ">
                        <div class="team-overlay">
                            <div class="overlay-social-icon text-center">
                                <ul class="social-icons">

                                    <li><a href="https://linkedin.com/in/antonio-josé-fernandes-andrade-532927241"><i class="lni-linkedin-filled" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="info-text">
                        <h3><a href="#">Neide Gomes</a></h3>
                        <p>Chief Executive Officer-CEO</p>
                    </div>
                </div>
                <!-- Team Item Ends -->
            </div>

            <div class="col-sm-6 col-md-6 col-lg-3">
                <!-- Team Item Starts -->
                <div class="team-item text-center wow fadeInRight" data-wow-delay="0.9s">
                    <div class="team-img">
                        <img class="img-fluid" src="assetsl/img/team/angelina.jpg" alt="" style="height: 350px;">
                        <div class="team-overlay">
                            <div class="overlay-social-icon text-center">
                                <ul class="social-icons">
                                    <li><a href="https://github.com/mritamoreira"><i class="lni-github" aria-hidden="true"></i></a></li>
                                    <li><a href="https://www.linkedin.com/in/maria-rita-moreira-fernandes-7709061b2/"><i class="lni-linkedin-filled" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="info-text">
                        <h3><a href="#">Heitor Rodrigues</a></h3>
                        <p>Chief Executive Officer-CEO</p>
                    </div>
                </div>
                <!-- Team Item Ends -->
            </div>

        </div>
    </div>
</section>
<!-- Team Section End -->

<!-- Counter Section Start -->
<section id="counter" class="section-padding">
    <div class="overlay"></div>
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-lg-12 col-md-12 col-xs-12">
                <div class="row">
                    <!-- Start counter -->
                    <div class="col-lg-3 col-md-6 col-xs-12">
                        <div class="counter-box wow fadeInUp" data-wow-delay="0.2s">
                            <div class="icon-o"><i class="lni-users"></i></div>
                            <div class="fact-count">
                                <h3><span class="counter">23576</span></h3>
                                <p>Users</p>
                            </div>
                        </div>
                    </div>
                    <!-- End counter -->
                    <!-- Start counter -->
                    <div class="col-lg-3 col-md-6 col-xs-12">
                        <div class="counter-box wow fadeInUp" data-wow-delay="0.4s">
                            <div class="icon-o"><i class="lni-emoji-smile"></i></div>
                            <div class="fact-count">
                                <h3><span class="counter">2124</span></h3>
                                <p>Positive Reviews</p>
                            </div>
                        </div>
                    </div>
                    <!-- End counter -->
                    <!-- Start counter -->
                    <div class="col-lg-3 col-md-6 col-xs-12">
                        <div class="counter-box wow fadeInUp" data-wow-delay="0.6s">
                            <div class="icon-o"><i class="lni-download"></i></div>
                            <div class="fact-count">
                                <h3><span class="counter">54598</span></h3>
                                <p>Downloads</p>
                            </div>
                        </div>
                    </div>
                    <!-- End counter -->
                    <!-- Start counter -->
                    <div class="col-lg-3 col-md-6 col-xs-12">
                        <div class="counter-box wow fadeInUp" data-wow-delay="0.8s">
                            <div class="icon-o"><i class="lni-thumbs-up"></i></div>
                            <div class="fact-count">
                                <h3><span class="counter">3212</span></h3>
                                <p>Followers</p>
                            </div>
                        </div>
                    </div>
                    <!-- End counter -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Counter Section End -->

<!-- Pricing section Start -->
<section id="pricing" class="section-padding bg-gray">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">@lang('mensage.melhores')</h2>
            <p>@lang('mensage.versao')</p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="table wow fadeInCenter" data-wow-delay="1.2s">
                    <div class="title">
                        <h3>Basic</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value">R$ 60.00<span>/ @lang('mensage.mes')</span></p>
                    </div>
                    <ul class="description">
                        <li>@lang('mensage.gratuitos')</li>
                        <li>@lang('mensage.usuario')</li>
                        <li>@lang('mensage.propaganda') </li>
                        <li>@lang('mensage.estimativa')</li>

                    </ul>
                    <button class="btn btn-common">@lang('mensage.breve')</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12 active">
                <div class="table wow fadeInUp" id="active-tb" data-wow-delay="1.2s">
                    <div class="title">
                        <h3>@lang('mensage.profissional')</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value">R$98.00<span>/ @lang('mensage.mes2')</span></p>
                    </div>
                    <ul class="description">
                        <li>@lang('mensage.ilimitados')</li>
                        <li>@lang('mensage.usuario2')</li>
                        <li>@lang('mensage.propaganda2')</li>
                        <li>@lang('mensage.limitados2') </li>


                    </ul>
                    <button class="btn btn-common">@lang('mensage.breve2')</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="table wow fadeInRight" data-wow-delay="1.2s">
                    <div class="title">
                        <h3>Consultas Avulsas</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value">a partir de R$ 80.00<span>/ @lang('mensage.mes3')</span></p>
                    </div>
                    <ul class="description">
                        <li>@lang('mensage.projetos')</li>
                        <li>@lang('mensage.usuario3')</li>
                        <li>@lang('mensage.propaganda3')</li>
                        <li>@lang('mensage.estimativa2')</li>

                    </ul>
                    <button class="btn btn-common">@lang('mensage.breve3')</button>
                </div>
            </div>
        </div>
    </div>

</section>
<section id="pricing" class="section-padding bg-gray">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">@lang('mensage.nome_pec')</h2>
            <p>@lang('mensage.versao')</p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="table wow fadeInCenter" data-wow-delay="1.2s">
                    <div class="title">
                        <h3>Basic</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value">R$ A partir de 60.00<span>/ @lang('mensage.mes')</span></p>
                    </div>
                    <ul class="description">
                        <li>@lang('mensage.plano1')</li>
                        <li>@lang('mensage.preco1')</li>
                        <li>@lang('mensage.preco2') </li>
                        <li>@lang('mensage.preco3')</li>

                    </ul>
                    <button class="btn btn-common">@lang('mensage.breve')</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12 active">
                <div class="table wow fadeInUp" id="active-tb" data-wow-delay="1.2s">
                    <div class="title">
                        <h3>@lang('Profissional por rebanho')</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value">A partir de R$80.00<span>/ @lang('mensage.mes2')</span></p>
                    </div>
                    <ul class="description">
                        <li>@lang('mensage.especialista1')</li>
                        <li>@lang('mensage.especialista2')</li>
                        <li>@lang('mensage.especialista3')</li>
                        <li>@lang('mensage.especialista4') </li>



                    </ul>
                    <button class="btn btn-common">@lang('mensage.breve2')</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="table wow fadeInRight" data-wow-delay="1.2s">
                    <div class="title">
                        <h3>Consultas Avulsas</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value">a partir de R$ 80.00<span>/ @lang('mensage.mes3')</span></p>
                    </div>
                    <ul class="description">
                        <li>@lang('mensage.especialista5') </li>
                        <li>@lang('mensage.especialista6')</li>
                        <li>@lang('mensage.especialista7')</li>
                        <li>@lang('mensage.especialista8')</li>

                    </ul>
                    <button class="btn btn-common">@lang('mensage.breve3')</button>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- Pricing Table Section End -->
<section id="pricing" class="section-padding bg-gray">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">@lang('mensage.nome_agro')</h2>
            <p>@lang('mensage.versao')</p>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="table wow fadeInCenter" data-wow-delay="1.2s">
                    <div class="title">
                        <h3>Basic</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value">R$ A partir de 60.00<span>/ @lang('mensage.mes')</span></p>
                    </div>
                    <ul class="description">
                        <li>@lang('mensage.basic1')</li>
                        <li>@lang('mensage.basic2')</li>
                        <li>@lang('mensage.basic3') </li>
                        <li>@lang('mensage.basic4')</li>

                    </ul>
                    <button class="btn btn-common">@lang('mensage.breve')</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12 active">
                <div class="table wow fadeInUp" id="active-tb" data-wow-delay="1.2s">
                    <div class="title">
                        <h3>@lang('Profissional por cultura')</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value">A partir de R$80.00<span>/ @lang('mensage.mes2')</span></p>
                    </div>
                    <ul class="description">
                        <li>@lang('mensage.agrocultura')</li>
                        <li>@lang('mensage.especialista2')</li>
                        <li>@lang('mensage.especialista3')</li>
                        <li>@lang('mensage.especialista4') </li>



                    </ul>
                    <button class="btn btn-common">@lang('mensage.breve2')</button>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-xs-12">
                <div class="table wow fadeInRight" data-wow-delay="1.2s">
                    <div class="title">
                        <h3>Consultas Avulsas</h3>
                    </div>
                    <div class="pricing-header">
                        <p class="price-value">a partir de R$ 80.00<span>/ @lang('mensage.mes3')</span></p>
                    </div>
                    <ul class="description">
                        <li>@lang('mensage.agro2') </li>
                        <li>@lang('mensage.agro3')</li>
                        <li>@lang('mensage.agro4')</li>
                        <li>@lang('mensage.especialista8')</li>

                    </ul>
                    <button class="btn btn-common">@lang('mensage.breve3')</button>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- Start Video promo Section -->
<section id="portfolios" class="video-promo section-padding text-center">
    <div class="overlay"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12">

            </div>
        </div>
    </div>
</section>
<!-- End Video Promo Section -->

<!-- Testimonial Section Start
<section id="testimonial" class="testimonial section-padding">
  <div class="overlay"></div>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12">
        <div id="testimonials" class="owl-carousel wow fadeInUp" data-wow-delay="1.2s">
          <div class="item">
            <div class="testimonial-item">
              <div class="img-thumb">
                <img src="assets/img/testimonial/img1.jpg" alt="">
              </div>
              <div class="info">
                <h2><a href="#">Grenchen Pearce</a></h2>
                <h3><a href="#">Boston Brothers co.</a></h3>
              </div>
              <div class="content">
                <p class="description">Holisticly empower leveraged ROI whereas effective web-readiness. Completely enable emerging meta-services with cross-platform web services. Quickly initiate inexpensive total linkage rather than extensible scenarios. Holisticly empower leveraged ROI whereas effective web-readiness. </p>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="testimonial-item">
              <div class="img-thumb">
                <img src="assets/img/testimonial/img2.jpg" alt="">
              </div>
              <div class="info">
                <h2><a href="#">Domeni GEsson</a></h2>
                <h3><a href="#">Awesome Technology co.</a></h3>
              </div>
              <div class="content">
                <p class="description">Holisticly empower leveraged ROI whereas effective web-readiness. Completely enable emerging meta-services with cross-platform web services. Quickly initiate inexpensive total linkage rather than extensible scenarios. Holisticly empower leveraged ROI whereas effective web-readiness. </p>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="testimonial-item">
              <div class="img-thumb">
                <img src="assets/img/testimonial/img3.jpg" alt="">
              </div>
              <div class="info">
                <h2><a href="#">Dommini Albert</a></h2>
                <h3><a href="#">Nesnal Design co.</a></h3>
              </div>
              <div class="content">
                <p class="description">Holisticly empower leveraged ROI whereas effective web-readiness. Completely enable emerging meta-services with cross-platform web services. Quickly initiate inexpensive total linkage rather than extensible scenarios. Holisticly empower leveraged ROI whereas effective web-readiness. </p>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="testimonial-item">
              <div class="img-thumb">
                <img src="assets/img/testimonial/img4.png" alt="">
              </div>
              <div class="info">
                <h2><a href="#">Fernanda Anaya</a></h2>
                <h3><a href="#">Developer</a></h3>
              </div>
              <div class="content">
                <p class="description">Holisticly empower leveraged ROI whereas effective web-readiness. Completely enable emerging meta-services with cross-platform web services. Quickly initiate inexpensive total linkage rather than extensible scenarios. Holisticly empower leveraged ROI whereas effective web-readiness. </p>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="testimonial-item">
              <div class="img-thumb">
                <img src="assets/img/testimonial/img5.png" alt="">
              </div>
              <div class="info">
                <h2><a href="#">Jason A.</a></h2>
                <h3><a href="#">Designer</a></h3>
              </div>
              <div class="content">
                <p class="description">Holisticly empower leveraged ROI whereas effective web-readiness. Completely enable emerging meta-services with cross-platform web services. Quickly initiate inexpensive total linkage rather than extensible scenarios. Holisticly empower leveraged ROI whereas effective web-readiness. </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
Testimonial Section End -->


<!-- Clients Section Start -->
<div id="clients" class="section-padding bg-gray">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title wow fadeInDown" data-wow-delay="0.3s">@lang('mensage.parceiros2')</h2>
            <p> @lang('mensage.guiado')</p>
        </div>
        <div class="row text-align-">
            <div class="col-lg-3 col-md-3 col-xs-12 wow fadeInUp" data-wow-delay="0.3s">
                <div class="client-item-wrapper">
                    <img class="img-fluid" src="assetsl/img/clients/img1.png" alt="">
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 wow fadeInUp" data-wow-delay="0.6s">
                <div class="client-item-wrapper">
                    <img class="img-fluid" src="assetsl/img/clients/img2.png" alt="">
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 wow fadeInUp" data-wow-delay="0.9s">
                <div class="client-item-wrapper">
                    <img class="img-fluid" src="assetsl/img/clients/img3.png" alt="">
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-12 wow fadeInUp" data-wow-delay="1.2s">
                <div class="client-item-wrapper">
                    <img class="img-fluid"  src="assetsl/img/clients/images.jfif" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Clients Section End -->

<!-- Contact Section Start -->
<section id="contact" class="section-padding">
    <div class="container">
        <div class="row contact-form-area wow fadeInUp" data-wow-delay="0.4s">
            <div class="col-md-6 col-lg-6 col-sm-12">
                <div class="contact-block">
                    <form id="contactForm" action="{{route('home.email')}}" method="post">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name" name="name" placeholder="@lang('mensage.nome')" required data-error="Please enter your name">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" placeholder="@lang('mensage.email2')" id="email" class="form-control" name="mail" required data-error="Please enter your email">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input name="assunto" type="text" placeholder="@lang('mensage.assunto')" id="msg_subject" class="form-control" required data-error="Please enter your subject">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <textarea class="form-control" name="message" id="message" placeholder="@lang('mensage.mensagem')" rows="5" data-error="Write your message" required></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="submit-button">
                                    <button class="btn btn-common" id="form-submit" type="submit">@lang('mensage.enviar')</button>
                                    <div id="msgSubmit" class="h3 text-center hidden"></div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @if(isset($msg))
                            @if($msg)
                            <script>alert('Email Enviado Com sucesso!!');
                            </script>
                            </p>
                            @else
                                <p>
                                    <script>alert('Falha ao enviar o email');
                                    </script>
                                </p>
                           @endif
                        @endif
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-sm-12">
                <div class="contact-right-area wow fadeIn">
                    <div class="contact-title">
                        <h1>@lang('mensage.visitar')</h1>
                        <p>@lang('mensage.criamos')</p>
                    </div>
                    <h2>@lang('mensage.contate')</h2>
                    <div class="contact-right">
                        <div class="single-contact">
                            <div class="contact-icon">
                                <i class="lni-map-marker"></i>
                            </div>
                            <p>@lang('mensage.endereco') Rua Ezio Lima Verde,108, Sobral, CE</p>
                        </div>
                        <div class="single-contact">
                            <div class="contact-icon">
                                <i class="lni-envelope"></i>
                            </div>
                            <p><a href="#">@lang('mensage.email')  raianedarlavieira@gmail.com</a></p>
                        </div>
                        <div class="single-contact">
                            <div class="contact-icon">
                                <i class="lni-phone-handset"></i>
                            </div>
                            <p><a href="#">@lang('mensage.telefone')  +55 88 9 9981-5173</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

<!-- Copyright Section Start -->
<div class="copyright">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-3 col-xs-12">
                <div class="footer-logo">
                    <img src="assetsl/img/logo.png" alt="">
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-xs-12">
                <div class="social-icon text-center">
                    <a class="Github" href="https://github.com/RaianeDarla/stakehol"><i class="lni-github"></i></a>
                    <a class="instagram" href="https://instagram.com/stakehol"><i class="lni-instagram-filled"></i></a>
                    <a class="linkedin" href="https://www.linkedin.com/company/stakehol/?viewAsMember=true"><i class="lni-linkedin-filled"></i></a>
                </div>
            </div>
            <div class="col-lg-4 col-md-5 col-xs-12">
            </div>
        </div>
    </div>
</div>
<!-- Copyright Section End -->

<!-- Go to Top Link -->
<a href="#" class="back-to-top">
    <i class="lni-arrow-up"></i>
</a>

<!-- Preloader -->
<div id="preloader">
    <div class="loader" id="loader-1"></div>
</div>
<!-- End Preloader -->

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="assetsl/js/jquery-min.js"></script>
<script src="assetsl/js/popper.min.js"></script>
<script src="assetsl/js/bootstrap.min.js"></script>
<script src="assetsl/js/owl.carousel.min.js"></script>
<script src="assetsl/js/wow.js"></script>
<script src="assetsl/js/jquery.nav.js"></script>
<script src="assetsl/js/scrolling-nav.js"></script>
<script src="assetsl/js/jquery.easing.min.js"></script>
<script src="assetsl/js/jquery.counterup.min.js"></script>
<script src="assetsl/js/waypoints.min.js"></script>
<script src="assetsl/js/jquery.slicknav.js"></script>
<script src="assetsl/js/main.js"></script>


</body>
</html>
