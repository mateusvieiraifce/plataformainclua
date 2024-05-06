@extends('frente.layout')
@section('slide')
@endsection

@section('detail')
    <div style="height: 60px"> </div>

    <div class="bg0 p-t-23 p-b-140">
        <div class="container">
    <!-- Product Detail -->
    <section class="sec-product-detail bg0 p-t-65 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">
                            <div class="wrap-slick3-dots"></div>
                            <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>


                            <div class="slick3 gallery-lb">
                                <div class="item-slick3" data-thumb="{{"/storage/products/".$obj->foto1}}">
                                    <div class="wrap-pic-w pos-relative">
                                        <img src="{{"/storage/products/".$obj->foto1}}" alt="IMG-PRODUCT">

                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{"/storage/products/".$obj->foto1}}">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="item-slick3" data-thumb="{{"/storage/products/".$obj->foto2}}">
                                    <div class="wrap-pic-w pos-relative">
                                        <img src="{{"/storage/products/".$obj->foto2}}" alt="IMG-PRODUCT">

                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{"/storage/products/".$obj->foto2}}">
                                            <i class="fa fa-expand"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="item-slick3" data-thumb="{{"/storage/products/".$obj->foto3}}">
                                    <div class="wrap-pic-w pos-relative">
                                        <img src="{{"/storage/products/".$obj->foto3}}" alt="IMG-PRODUCT">

                                        <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04" href="{{"/storage/products/".$obj->foto3}}">
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
                            {{$obj->titulo}}
                        </h4>

                        <span class="mtext-106 cl2">
							@money($obj->preco)
						</span>

                        <p class="stext-102 cl3 p-t-23">
                            {{$obj->descricao}}
                        </p>

                        <p class="stext-102 cl3 p-t-23">
                            Vendido Por: {{$obj->name}}
                        </p>
                        <br>
                        <p>

                            <label> Tamanho </label>
                            <select name="tamanho" style="width: 100px;" id="tamanho">
                                @foreach($tamanhos as $size)
                                    <option value="{{$size->id}}">{{$size->descricao}}</option>
                                @endforeach
                            </select>
                            <br/>

                        </p>
                        <!--  -->
                        <div class="p-t-33">


                            <div class="flex-w flex-r-m p-b-10">



                            </div>

                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-204 flex-w flex-m respon6-next">
                                    <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                        <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-minus"></i>
                                        </div>

                                        <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product" value="1" id="num-product">

                                        <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                            <i class="fs-16 zmdi zmdi-plus"></i>
                                        </div>


                                    </div>
                                    <br />

                                    <button class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail" onclick="addSesscao();">
                                        Adicionar ao Carrinho
                                    </button>


                                </div>
                            </div>
                        </div>

                        <!--  -->
                        <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                                <a href="{{route('advertisement.addfavorito',$obj->id)}}" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100" data-tooltip="Adicionar a lista de desejos">
                                    <i class="zmdi zmdi-favorite"></i>
                                </a>

                        </div>
                    </div>
                </div>
            </div>

            <div class="bor10 m-t-50 p-t-43 p-b-40">
                <!-- Tab01 -->
                <div class="tab01">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item p-b-10">
                            <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Descrição Completa</a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#information" role="tab">Informações Adicionais</a>
                        </li>

                        <li class="nav-item p-b-10">
                            <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Revisões</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-t-43">
                        <!-- - -->
                        <div class="tab-pane fade show active" id="description" role="tabpanel">
                            <div class="how-pos2 p-lr-15-md">
                                <p class="stext-102 cl6">
                                    {{$obj->descricaod}}
                                </p>
                            </div>
                        </div>

                        <!-- - -->
                        <div class="tab-pane fade" id="information" role="tabpanel">
                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                    <ul class="p-lr-28 p-lr-15-sm">
                                        <li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Peso
											</span>

                                            <span class="stext-102 cl6 size-206">
												{{($obj->peso)/1000}} Kg
											</span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Dimensões da Embalagem
											</span>

                                            <span class="stext-102 cl6 size-206">
												{{$obj->altura}} cm x {{$obj->largura}} cm
											</span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Materiais
											</span>

                                            <span class="stext-102 cl6 size-206">
												{{$obj->material}}
											</span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Color
											</span>

                                            <span class="stext-102 cl6 size-206">
												{{$obj->cor}}
											</span>
                                        </li>

                                        <li class="flex-w flex-t p-b-7">
											<span class="stext-102 cl3 size-205">
												Tamanho
											</span>

                                            <span class="stext-102 cl6 size-206">
												{{$obj->tamanhos}}
											</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- - -->
                        <div class="tab-pane fade" id="reviews" role="tabpanel">
                            <!-- Add review -->

                            <div class="row">
                                <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                    <div class="p-b-30 m-lr-15-sm">
                                        <form class="w-full" action="{{route('advertisement.comentario.add')}}" method="post">
                                            <input type="hidden" name="anuncio_id" value="{{$obj->id}}" required>
                                            @csrf
                                            <h5 class="mtext-108 cl2 p-b-7">
                                                Adicionar Comentários
                                            </h5>

                                            <p class="stext-102 cl6">
                                                Seu email não será publicado, Os campos marcados com * são obrigatório
                                            </p>

                                            <div class="flex-w flex-m p-t-50 p-b-23">
												<span class="stext-102 cl3 m-r-16">
													Sua Avaliação
												</span>

                                                <span class="wrap-rating fs-18 cl11 pointer">

													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<i class="item-rating pointer zmdi zmdi-star-outline"></i>
													<input class="dis-none" type="number" name="rating" required>
												</span>
                                            </div>

                                            <div class="row p-b-25">
                                                <div class="col-12 p-b-5">
                                                    <label class="stext-102 cl3" for="review">Sua revisão</label>
                                                    <textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10" id="review" name="review" required></textarea>
                                                </div>

                                                <div class="col-sm-6 p-b-5">
                                                    <label class="stext-102 cl3" for="name">Nome</label>
                                                    <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="name" type="text" name="name" required>
                                                </div>

                                                <div class="col-sm-6 p-b-5">
                                                    <label class="stext-102 cl3" for="email">Email</label>
                                                    <input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email" type="email" name="email" required>
                                                </div>
                                            </div>

                                            <button class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
                                                Enviar
                                            </button>
                                        </form>
                                        <!-- Review -->
                                        <div class="flex-w flex-t p-b-68">
                                            <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">

                                            </div>

                                            <div class="size-207">
                                                @if(isset($comentarios))
                                                    @foreach($comentarios as $comentario)
                                                <div class="flex-w flex-sb-m p-b-17">
													<span class="mtext-107 cl2 p-r-20">
														{{$comentario->nome}} em @dataformatada($comentario->created_at)
													</span>

                                                    @php
                                                    $estrelas = $comentario->pontos;

                                                    @endphp

                                                    <span class="fs-18 cl11">
                                                    @if($estrelas>0)
													@foreach(range(1,$estrelas) as $i)
														<i class="zmdi zmdi-star"></i>
                                                    @endforeach
                                                        @else
                                                            <i class="zmdi zmdi-star"></i>
                                                        @endif

													</span>
                                                </div>

                                                <p class="stext-102 cl6">
                                                    {{$comentario->descricao}}
                                                </p>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
			<span class="stext-107 cl6 p-lr-25">
				Vendido por: {{$obj->name}}
			</span>

            <span class="stext-107 cl6 p-lr-25">
				Categoria: {{$obj->categoria}}
			</span>
        </div>
    </section>


    <!-- Related Products -->
    <section class="sec-relate-product bg0 p-t-45 p-b-105">
    </section>
        </div>
    </div>
<script type="application/javascript">
    function addSesscao(){
        var qtd = document.getElementById('num-product').value;
        var tm = document.getElementById('tamanho').value;
        console.log(tm);
        var title = "<?php print $obj->id; ?>";

        $.get("/cart/add?produto="+title+"&qtd="+qtd+"&t="+tm, function(resultado){
            console.log(resultado);
        });



      /*

        var newOrder = new Object();
        newOrder.produto = title;
        newOrder.qtd = qtd;
        if (sessionStorage.produtos){
            produtos= JSON.parse(sessionStorage.getItem('produtos'));
        }else{
            produtos = [];
        }
        produtos.push(newOrder);
        aux = JSON.stringify(produtos);
        sessionStorage.setItem('produtos', JSON.stringify(produtos));




        /*
        var retrievedObject = sessionStorage.getItem('produtos');
        console.log('retrievedObject: ', JSON.parse(retrievedObject));

        var b = {'produto': title, 'qtd': qtd};

        b = JSON.stringify(b);
        sessionStorage.setItem('carrinho', b);
        var c = JSON.parse(sessionStorage.getItem('carrinho'));
        console.info(c);

        alert("adicionou a seção"+title);*/
    }
</script>
@endsection

