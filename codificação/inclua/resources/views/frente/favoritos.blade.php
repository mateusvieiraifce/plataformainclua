@extends('frente.layout')

@section('slide')
@endsection

@section('detail')
    <div style="height: 60px"> </div>
    <div class="bg0 p-t-23 p-b-140">
        <div class="container">
            <div class="p-b-10">
                <h3 class="ltext-103 cl5">
                    Produtos Favoritos
                </h3>
            </div>

            <div class="flex-w flex-sb-m p-b-52">
                <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                    <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1" data-filter="*">
                        Todos os Produtos
                    </button>


                    <?php
                    $allTypes = \App\Models\TipoAnuncio::all();
                    ?>
                    @foreach($allTypes as $type)
                        <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter="{{".".$type->id}}">
                            {{$type->descricao}}
                        </button>
                    @endforeach

                </div>


            </div>

            <div class="row isotope-grid">

                @foreach($anuncios as $anuncio)
                    <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item {{$anuncio->type_id}}">
                        <!-- Block2 -->
                        <div class="block2">
                            <div class="block2-pic hov-img0" style="width: auto; height: 380px;">
                                <?php $pathImage = \App\Models\FileAnuncio::where('anuncio_id','=',$anuncio->id)->where("path","!=","")->first(); ?>
                                <img src={{"/storage/products/".$pathImage->path}} alt="IMG-PRODUCT" width="auto" height="380px">

                                <a href="{{route('advertisement.detail',$anuncio->id)}}" class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                    Ver Detalhes
                                </a>
                            </div>

                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l ">
                                    <a href="{{route('advertisement.detail',$anuncio->id)}}" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                        {{$anuncio->titulo}}
                                    </a>

                                    <span class="stext-105 cl3" style="text-align: right; width: 100%">
									@money($anuncio->preco)
								</span>
                                </div>

                                <div class="block2-txt-child2 flex-r p-t-3">
                                    <form action="{{route('advertisement.remfavorito',$anuncio->id)}}">
                                    <button  class="btn-addwish-b2 dis-block pos-relative" onclick="addFavarito({{$anuncio->id}});">
                                        <img class="icon-heart1 dis-block trans-04" src="/images/icons/icon-close2.png" alt="ICON">
                                        <img class="icon-heart2 dis-block trans-04 ab-t-l" src="/images/icons/icon-close2.png" alt="ICON">
                                    </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="wrap-modal1 js-modal{{$anuncio->id}} p-t-60 p-b-20">
                        <div class="overlay-modal1 js-hide-modal1"></div>

                        <div class="container">
                            <div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
                                <button class="how-pos3 hov3 trans-04 js-hide-modal1">
                                    <img src="images/icons/icon-close.png" alt="CLOSE">
                                </button>

                                <div class="row">
                                    <div class="col-md-6 col-lg-7 p-b-30">
                                        <div class="p-l-25 p-r-30 p-lr-0-lg">
                                            <div class="wrap-slick3 flex-sb flex-w">
                                                <div class="wrap-slick3-dots"></div>
                                                <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                                                <div class="slick3 gallery-lb">
                                                    <div class="item-slick3" data-thumb="/images/produtos/img_17.png">
                                                        <div class="wrap-pic-w pos-relative">
                                                            <img src="/images/produtos/img_17.png" alt="IMG-PRODUCT">

                                                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="/images/produtos/img_17.png">
                                                                <i class="fa fa-expand"></i>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="item-slick3" data-thumb="/images/produtos/img_17.png">
                                                        <div class="wrap-pic-w pos-relative">
                                                            <img src="/images/produtos/img_17.png" alt="IMG-PRODUCT">

                                                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="/images/produtos/img_17.png">
                                                                <i class="fa fa-expand"></i>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <div class="item-slick3" data-thumb="/images/produtos/img_17.png">
                                                        <div class="wrap-pic-w pos-relative">
                                                            <img src="/images/produtos/img_17.png" alt="IMG-PRODUCT">

                                                            <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="/images/produtos/img_17.png">
                                                                <i class="fa fa-expand"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-lg-5 p-b-30">
                                        <div class="p-r-50 p-t-5 p-lr-0-lg">
                                            <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                                                {{$anuncio->titulo}}
                                            </h4>

                                            <span class="mtext-106 cl2">
								R$ 58.79
							</span>

                                            <p class="stext-102 cl3 p-t-23">
                                                {{$anuncio->descricao}}
                                            </p>

                                            <!--  -->
                                            <div class="p-t-33">

                                                <div class="flex-w flex-r-m p-b-10">

                                                    <div class="size-204 respon6-next">
                                                    </div>
                                                </div>

                                                <div class="flex-w flex-r-m p-b-10">
                                                    <div class="size-204 flex-w flex-m respon6-next">
                                                        <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                                            <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                                            </div>

                                                            <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1">

                                                            <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                                            </div>
                                                        </div>

                                                        <button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                                            Adicionar ao carrinho
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--  -->
                                            <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                                                <div class="flex-m bor9 p-r-10 m-r-11">
                                                    <a href="{{route("home")}}" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Add to Wishlist">
                                                        <i class="zmdi zmdi-favorite"></i>
                                                    </a>
                                                </div>

                                                <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Facebook">
                                                    <i class="fa fa-facebook"></i>
                                                </a>

                                                <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Twitter">
                                                    <i class="fa fa-twitter"></i>
                                                </a>

                                                <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100" data-tooltip="Google Plus">
                                                    <i class="fa fa-google-plus"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                @endforeach

            </div>

        </div>
    </div>
@endsection
