@extends('frente.layout')
@section('detail')



    <!-- breadcrumb -->
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{route('home')}}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>


        </div>
    </div>


    <!-- Shoping Cart -->
    <form class="bg0 p-t-75 p-b-85"  method="post" action="{{route('vendas.create')}}">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                    <div class="m-l-25 m-r--38 m-lr-0-xl">
                        <div class="wrap-table-shopping-cart">
                            <table class="table-shopping-cart">
                                <tr class="table_head">
                                    <th class="column-1">Produto</th>
                                    <th class="column-2"></th>
                                    <th class="column-3">Preço</th>
                                    <th class="column-4">Quantidade</th>
                                    <th class="column-5">Total</th>
                                </tr>

                                @php
                                    $nocarrinho = 0 ;
                                    if(session()->has('produtos')){
                                        $produtos =  session('produtos');
                                        $nocarrinho = sizeof($produtos);
                                    }
                                    $total = 0;
                                @endphp
                                @if(isset($produtos))
                                @foreach($produtos as $produto)
                                    @php
                                        $an = \App\Models\Anuncio::find($produto['id']);
                                        $files = \App\Models\FileAnuncio::where('anuncio_id','=',$an->id)->first();
                                        $tam = \App\Models\Tamanho::find($produto['tamanho']);
                                    @endphp

                                    <tr class="table_row">
                                    <td class="column-1">
                                        <div class="how-itemcart1">
                                            <img src="{{"/storage/products/".$files->path}}" alt="IMG">
                                        </div>
                                    </td>

                                    <td class="column-2">{{$an->titulo}} - Tamanho - {{$tam->descricao}} </td>
                                    <td class="column-3">@money($an->preco)</td>
                                        @php
                                        $total = $total + $an->preco * $produto['qtd'];
                                        @endphp
                                    <td class="column-4">
                                        <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                            <div class=" cl8 hov-btn3 trans-04 flex-c-m" style=" width: 45px; height: 100%;">
                                                <a href="{{route('cart.remqtd',$an->id)}}" class="fs-16 zmdi zmdi-minus"></a>
                                            </div>

                                            <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product1" value="{{$produto['qtd']}}">

                                            <div class="cl8 hov-btn3 trans-04 flex-c-m" style=" width: 45px; height: 100%;">
                                                <a href="{{route('cart.addqtd',$an->id)}}" class="fs-16 zmdi zmdi-plus"></a>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-5">@money($an->preco * $produto['qtd'])</td>
                                </tr>
                                @endforeach

                                <input type="hidden" id="total" name="total" value="{{$total}}">
                                @endif

                            </table>
                        </div>


                    </div>
                </div>

                <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                        <h4 class="mtext-109 cl2 p-b-30">
                            Total do Carrinho
                        </h4>

                        <div class="flex-w flex-t bor12 p-b-13">
                            <div class="size-208">
								<span class="stext-110 cl2">
									Subtotal:
								</span>
                            </div>

                            <div class="size-209">
								<span class="mtext-110 cl2">
									@money($total)
								</span>
                            </div>
                        </div>

                        <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                            <div class="size-208 w-full-ssm">
								<span class="stext-110 cl2">
									Envio:
								</span>

                            </div>

                            <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                                <p class="stext-111 cl6 p-t-2"> Por conta do comprador</p>
                                <div class="p-t-15">
                                    <span class="stext-112 cl8">
										Local de Entrega:
									</span>
                                    <a href="{{route('vendas.adr.create')}}"> Novo </a>
                                    @guest

                                    @else
                                        @php
                                        $usuario =\Illuminate\Support\Facades\Auth::user();
                                        $ende = \App\Models\Endereco::where('user_id','=',$usuario->id)->get();


                                        @endphp
                                       @if(sizeof($ende)==0)
                                            <a href="{{route('vendas.adr.create')}}" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                                                Adicionar Endereço
                                            </a>
                                        @else
                                        <br/>
                                        <select name="enderecos"  onchange="selecionaAdd();" id="endereco_mateus">
                                        @foreach($ende as $end)
                                            <option value="{{$end->id}}">{{$end->recebedor}}</option>
                                        @endforeach
                                        </select>
                                        @endif
                                    @endguest


                                    @auth
                                    @if(sizeof($ende)>0)
                                    <div class="bor8 bg0 m-b-22">
                                        <input @if(  !empty($ende) ) value="{{$ende[0]->cep}}" @endif class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="postcode" placeholder="CEP" onblur="pesquisacep(this.value);" disabled id="cep" >
                                    </div>

                                    <div class="bor8 bg0 m-b-22">
                                        <input @if(!empty($ende)) value="{{$ende[0]->rua}}" @endif class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="cidade" placeholder="Rua" id="rua" disabled>
                                    </div>

                                    <div class="bor8 bg0 m-b-22">
                                        <input @if(!empty($ende)) value="{{$ende[0]->bairro}}" @endif class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="cidade" placeholder="Bairro" id="bairro" disabled>
                                    </div>


                                    <div class="bor8 bg0 m-b-22">
                                        <input @if(!empty($ende)) value="{{$ende[0]->cidade}}" @endif class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="cidade" placeholder="Cidade" id="cidade" disabled>
                                    </div>
                                            <div class="bor8 bg0 m-b-22">
                                                <input @if(!empty($ende)) value="{{$ende[0]->estado}}" @endif class="stext-111 cl8 plh3 size-111 p-lr-15" type="text" name="estado" placeholder="UF" id="uf" disabled>
                                            </div>

                                            @php
                                                $frete = 10;
                                            @endphp


                                    <div class="flex-w">
                                        <div class="flex-c-m stext-101 cl2 size-115 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer">
                                            <?php
                                            $fretes =  session('fretes');
                                            ?>
                                            <label id="frete">Total Frete: @if(!empty($ende)) @if($ende[0]->cidade=="Sobral") @money($fretes*10) @else  Indisponível @php $frete = 200;@endphp@endif  @endif</label>
                                        <input type="hidden" name="frete" value="{{$fretes*10}}">
                                        </div>
                                    </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>


                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208">
								<span class="mtext-101 cl2">
									Total:
								</span>
                            </div>

                            <div class="size-209 p-t-1">
								<span class="mtext-110 cl2">
                                    @if(isset($frete))
                                        @if($frete==10)
                                        <label id="final"> @money($total+($frete*$fretes))</label>
                                        @else
                                            <label id="final"> Indisponível</label>
                                        @endif
                                    @else
                                        <label id="final"> Crie e defina um endereço como principal</label>

                                    @endif
								</span>
                            </div>
                        </div>

                        @guest
                            <a class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                                Entrar
                            </a>
                        @else
                            @if(isset($frete))
                        <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer" id="finalizar">
                            Finalize o Processo
                        </button>
                            @endif
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </form>
<script>

    function selecionaAdd(){

        var id =$('#endereco_mateus').val();


        var script = document.createElement('script');

        //Sincroniza com o callback.

        ///     script.src = 'busca_cep.php?cep=00000001';

        path = "{{route('vendas.endereco')}}"+"/"+id;
        qtd = "{{session('fretes')}}";

        fetch(path)
            .then(data => {
                return data.json();
            })
            .then(get => {
                if (get.cidade=='Sobral') {
                    document.getElementById('cep').setAttribute('value', get.cep);
                    document.getElementById('rua').setAttribute('value', get.rua);
                    document.getElementById('bairro').setAttribute('value', get.bairro);
                    document.getElementById('cidade').setAttribute('value', get.cidade);
                    document.getElementById('uf').setAttribute('value', get.estado);
                    document.getElementById('finalizar').disabled = false;
                } else{
                    alert('Indisponível para essa região!');
                    document.getElementById('cep').setAttribute('value', '');
                    document.getElementById('rua').setAttribute('value', '');
                    document.getElementById('bairro').setAttribute('value', '');
                    document.getElementById('cidade').setAttribute('value', '');
                    document.getElementById('uf').setAttribute('value', '');
                    document.getElementById('finalizar').disabled = true;

                }
               /* $('#cep').value = get.cep;*/
                /*console.log(get.cep);*/
            });

    }
    function formatMoney(number) {
        return number.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
    }
    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
           // document.getElementById('endereco').value = (conteudo.logradouro);
           // document.getElementById('bairro').value = (conteudo.bairro);
            localidade = (conteudo.localidade);
            document.getElementById('cidade').value = localidade;
            frete = 10;
            if (localidade == "Sobral"){
                document.getElementById('frete').textContent  = "TOTAL FRETE: R$ 10,00";

            }else{
                document.getElementById('frete').textContent  = "TOTAL FRETE: R$ 200,00";
                frete = 200;
            }
            total = {{$total}} + frete;
            document.getElementById('final').textContent  = formatMoney(total);
            //document.getElementById('uf').value = (conteudo.uf);
        } //end if.
        else {
            //CEP não Encontrado.
            //limpa_formulário_cep();
            alert("CEP não encontrado.");
            ///script.src = 'busca_cep.php?cep=00000001';

        }
    }

    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if (validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
              //  document.getElementById('endereco').value = "...";
               // document.getElementById('bairro').value = "...";
                document.getElementById('cidade').value = "...";
                //document.getElementById('uf').value = "...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.

                ///     script.src = 'busca_cep.php?cep=00000001';

                script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } //end if.
            else {
                //cep é inválido.
              //  limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        } //end if.
        else {
            //cep sem valor, limpa formulário.
            //limpa_formulário_cep();

        }
    };
</script>

@endsection
