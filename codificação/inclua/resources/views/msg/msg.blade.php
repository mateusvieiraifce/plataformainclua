@extends('layouts.app', ['class' => 'login-page', 'page' => __(''), 'contentClass' => 'login-page'])
@section('title', 'Plataforma Inclua')


@section('content')
    <!-- breadcrumb -->
    <div class="container" style="height: 50%; width: 70%;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    ">
        <section class="u-clearfix u-image u-section-1" id="sec-25ad" data-image-width="1920" data-image-height="1200">
      <div class="data-layout-selected u-clearfix u-layout-wrap u-layout-wrap-1">
        <div class="u-layout">
          <div class="u-layout-row">
            <div class="u-container-align-left-lg u-container-align-left-md u-container-align-left-sm u-container-align-left-xl u-container-style u-layout-cell u-size-28-xl u-size-29-lg u-size-60-md u-size-60-sm u-size-60-xs u-layout-cell-1">
              <div class="u-container-layout u-valign-middle-lg u-valign-middle-md u-valign-middle-sm u-valign-middle-xl u-container-layout-1">
                <h1 class="u-align-left u-text  u-text-1">Obrigado pelo retorno!</h1>
                <div class="u-expanded-width-xs u-list u-list-1">
                  <div class="u-repeater u-repeater-1">
                    <!-- Antigo painéis de fotos -->
                    <p class="informativo" style="font-size: 155%; width: 425px;">Em breve nossos consultores entrarão em contato com você.</p>
                     <img src="images/Imagens-sitePrancheta-2.png" alt="Icones-Autismo" style="height: 17%; width: 17%;">
                     <div class="container mt-5" style="padding: 0;">
                        <button class="btn btn-primary" onclick="history.back()">Voltar</button>
                    </div>
                  </div>
                </div>
                <img src="../assets/img/logo-01.png" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); width: 37%; height: auto;">
              </div>
            </div>
            <div class="u-container-style u-image u-layout-cell u-size-31-lg u-size-32-xl u-size-60-md u-size-60-sm u-size-60-xs u-image-1">
              <div class="u-container-layout u-container-layout-6"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
    </div>

@endsection
