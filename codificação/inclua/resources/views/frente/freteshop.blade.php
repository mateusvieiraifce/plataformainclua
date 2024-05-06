
@extends('frente.layout')
<link href="/assets/css/black-dashboard.css" rel="stylesheet" />
@section('detail')

    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="{{route('home')}}" class="stext-109 cl8 hov-cl1 trans-04">
                Home
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>


        </div>
    </div>
    <div>
    <form method="post" action="{{route('vendas.adr.save')}}" autocomplete="off">
        @csrf
        <input type="hidden" name="id" value="{{auth()->user()->id}}">
        <input type="hidden" name="id_add" value="{{$obj->id}}">
        <input type="hidden" name="principal" value="{{$obj->princial}}">
        <br />
        <br />
        <br />
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <style type="text/css">

            .mateus{
                    left: 200px; width: 600px;
            }
            @media (min-width:320px)  {
                .mateus{left: 40px; width: 400px; color: black;}
                label{ color: #0c2646}
            }
            @media (min-width:481px)  {
                .mateus{left: 200px; width: 600px; }
                label{ color: #0c2646}

            }


        </style>
        <div class="card mateus" >
            <div class="card-body">

            <div class="form-group{{ $errors->has('nome_completo') ? ' has-danger' : '' }}">
                <label id="nomecompleto" style="color: black">{{ __('Contato') }}</label>
                <input type="text" name="recebedor" class="form-control{{ $errors->has('recebedor') ? ' is-invalid' : '' }}" placeholder="{{ __('Nome Completo') }}" value="{{ old('recebedor', $obj->recebedor) }}" required >
                @include('alerts.feedback', ['field' => 'recebedor'])

            </div>

            <div class="form-group{{ $errors->has('cep') ? ' has-danger' : '' }}">
                <label id="cep" style="color: black">{{ __('CEP') }}</label>
                <input id="cep_input" type="text" name="cep" class="form-control{{ $errors->has('cep') ? ' is-invalid' : '' }}" placeholder="{{ __('CEP') }}" value="{{ old('cep', $obj->cep) }}" required onblur="pesquisacep(this.value);" >
                @include('alerts.feedback', ['field' => 'cep'])
            </div>



            <div class="form-group{{ $errors->has('rua') ? ' has-danger' : '' }}">
                <label style="color: black">{{ __('Endereço') }}</label>
                <input id="rua" type="text" name="rua" class="form-control{{ $errors->has('Rua') ? ' is-invalid' : '' }}" placeholder="{{ __('Rua') }}" value="{{ old('rua', $obj->rua) }}" required >
                @include('alerts.feedback', ['field' => 'Rua'])
            </div>


            <div class="form-group{{ $errors->has('bairro') ? ' has-danger' : '' }}">
                <label style="color: black">{{ __('Bairro') }}</label>
                <input id="bairro" type="text" name="bairro" class="form-control{{ $errors->has('bairro') ? ' is-invalid' : '' }}" placeholder="{{ __('Bairro') }}" value="{{ old('bairro', $obj->cidade) }}" required >
                @include('alerts.feedback', ['field' => 'bairro'])

            </div>

            <div class="form-group{{ $errors->has('cidade') ? ' has-danger' : '' }}">
                <label style="color: black">{{ __('Cidade') }}</label>
                <input id="cidade" type="text" name="cidade" class="form-control{{ $errors->has('cidade') ? ' is-invalid' : '' }}" placeholder="{{ __('Cidade') }}" value="{{ old('cidade', $obj->cidade) }}" required >
                @include('alerts.feedback', ['field' => 'cidade'])
            </div>

            <div class="form-group{{ $errors->has('estado') ? ' has-danger' : '' }}">
                <label style="color: black">{{ __('Estado') }}</label>
                <input id="uf" type="text" name="estado" class="form-control{{ $errors->has('estado') ? ' is-invalid' : '' }}" placeholder="{{ __('Estado') }}" value="{{ old('estado', $obj->estado) }}" required >
                @include('alerts.feedback', ['field' => 'estado'])
            </div>



            <div class="form-group{{ $errors->has('numero') ? ' has-danger' : '' }}">
                <label style="color: black">{{ __('Número') }}</label>
                <input type="text" name="numero" class="form-control{{ $errors->has('numero') ? ' is-invalid' : '' }}" placeholder="{{ __('Número') }}" value="{{ old('numero', $obj->numero) }}" required >
                @include('alerts.feedback', ['field' => 'numero'])
            </div>


            <div class="form-group{{ $errors->has('complemento') ? ' has-danger' : '' }}">
                <label style="color: black">{{ __('Complemento') }}</label>
                <input type="text" name="complemento" class="form-control{{ $errors->has('complemento') ? ' is-invalid' : '' }}" placeholder="{{ __('Complemento') }}" value="{{ old('complemento', $obj->complemento) }}"  >
                @include('alerts.feedback', ['field' => 'complemento'])
            </div>


            <div class="form-group{{ $errors->has('informacoes') ? ' has-danger' : '' }}">
                <label style="color: black">{{ __('Informações') }}</label>
                <input type="text" name="informacoes" class="form-control{{ $errors->has('informacoes') ? ' is-invalid' : '' }}" placeholder="{{ __('Informações') }}" value="{{ old('informacoes', $obj->informacoes) }}"  >
                @include('alerts.feedback', ['field' => 'informacoes'])
            </div>

                <button type="submit" class="btn btn-fill btn-primary">{{ __('Salvar') }}</button>

        </div>
        </div>
        <div class="card-footer">

        </div>
    </form>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <script>
        $(document).ready(function($){
            $("#cep_input").mask("00000-000");
        });
        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                //Atualiza os campos com os valores.
                // document.getElementById('endereco').value = (conteudo.logradouro);
                // document.getElementById('bairro').value = (conteudo.bairro);
                localidade = (conteudo.localidade);
                document.getElementById('cidade').value = localidade;
                document.getElementById('rua').value = conteudo.logradouro;
                document.getElementById('bairro').value = conteudo.bairro;
                document.getElementById('uf').value = conteudo.uf;

                readOnly = true;
                if(!conteudo.logradouro){
                    readOnly = false;
                    document.getElementById('rua').readOnly =false;
                    document.getElementById('bairro').readOnly = false;
                } else{

                    document.getElementById('rua').setAttribute('readonly',true);
                    document.getElementById('bairro').setAttribute('readonly',true);
                }

                document.getElementById('cidade').setAttribute('readonly',true);
                document.getElementById('uf').setAttribute('readonly',true);

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
