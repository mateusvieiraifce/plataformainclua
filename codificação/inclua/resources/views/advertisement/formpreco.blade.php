@extends('layouts.app', ['page' => __('Perfil'), 'pageSlug' => 'profile','class'=>'profile'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Anúncio') }}</h5>

                    <form method="post" action="{{route('advertisement.fotos')}}" autocomplete="off" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group{{ $errors->has('tipo') ? ' has-danger' : '' }}">
                        <label id="nomecompleto">{{ __('Tipo') }}</label>
                        <select name="tipo" class="form-control{{ $errors->has('tipo') ? ' is-invalid' : '' }}">
                            @if(isset($tipos))
                                @foreach($tipos as $tipo)
                                    <option style="background-color: #1e1e2f" value="{{$tipo->id}}"
                                            @if(old('tipo', $obj->type_id)==$tipo->id)
                                                selected
                                        @endif
                                    >{{$tipo->descricao}}</option>
                                @endforeach
                            @endif
                        </select>
                        @include('alerts.feedback', ['field' => 'tipo'])
                    </div>

                    <div class="form-group{{ $errors->has('cor') ? ' has-danger' : '' }}">
                        <label id="corl">{{ __('Cor') }}</label>
                        <select name="cor" class="form-control{{ $errors->has('cor') ? ' is-invalid' : '' }}">
                            @if(isset($cores))
                                @foreach($cores as $cor)
                                    <option style="background-color: #1e1e2f" value="{{$cor->id}}"
                                            @if(old('cor', $obj->color_id)==$cor->id)
                                                selected
                                        @endif
                                    >{{$cor->descricao}}</option>
                                @endforeach
                            @endif
                        </select>
                        @include('alerts.feedback', ['field' => 'cor'])
                    </div>


                     <input type="hidden" name="id" value="{{$obj->id}}">
                    <div class="row">
                        <div class="form-group{{ $errors->has('preco') ? ' has-danger' : '' }} col-md-4"   >
                            <label >{{ __('Preço de venda') }}</label>
                            <input  style="text-align: right" id="preco" type="text" name="preco" class="form-control{{ $errors->has('preco') ? ' is-invalid' : '' }}" placeholder="{{ __('Preço') }}" value="{{ old('preco', $obj->preco) }}"  onkeyup="calculaPrecos()" required >
                            @include('alerts.feedback', ['field' => 'preco'])
                        </div>
                        <div class="form-group{{ $errors->has('preco') ? ' has-danger' : '' }} col-md-4"  >
                            <label >{{ __('Recebo Anúncio Normal  ') }}</label>
                            <input style="text-align: right" id="recebonormal" type="text" name="ancl"  class="form-control" placeholder="{{ __('Preço') }}"  value="{{  $obj->normal}}" readonly >
                            @include('alerts.feedback', ['field' => 'preco'])
                        </div>

                        <div class="form-group{{ $errors->has('preco') ? ' has-danger' : '' }} col-md-4"  >
                            <label >{{ __('Recebo Anúncio Destaque  ') }}</label>
                            <input style="text-align: right" id="recebodestaque" type="text" name="ancl"  class="form-control" placeholder="{{ __('Preço') }}"  value="{{ $obj->destaque }}" readonly >
                            @include('alerts.feedback', ['field' => 'preco'])
                        </div>


                    </div>


                    <div class="row">
                        <div class="form-group{{ $errors->has('qtd') ? ' has-danger' : '' }}  col-md-3 ">
                            <label >{{ __('Quantidade') }}</label>
                            <input style="text-align: right" id="qtd" type="text" name="qtd" class="form-control{{ $errors->has('qtd') ? ' is-invalid' : '' }}" placeholder="{{ __('Qtd') }}" value="{{ old('qtd', $obj->quantidade) }}" required >
                            @include('alerts.feedback', ['field' => 'qtd'])
                        </div>


                        <div class="form-group{{ $errors->has('altura') ? ' has-danger' : '' }} col-md-3"  >
                            <label >{{ __('Altura(cm)') }}</label>
                            <input style="text-align: right" id="altura" type="text" name="altura" class="form-control{{ $errors->has('altura') ? ' is-invalid' : '' }}" placeholder="{{ __('Altura') }}" value="{{ old('altura', $obj->altura) }}" required >
                            @include('alerts.feedback', ['field' => 'altura'])
                        </div>

                        <div class="form-group{{ $errors->has('largura') ? ' has-danger' : '' }}  col-md-3 ">
                            <label >{{ __('Lagura(cm)') }}</label>
                            <input style="text-align: right" id="largura" type="text" name="largura" class="form-control{{ $errors->has('largura') ? ' is-invalid' : '' }}" placeholder="{{ __('largura') }}" value="{{ old('largura', $obj->largura) }}" required >
                            @include('alerts.feedback', ['field' => 'largura'])
                        </div>

                        <div class="form-group{{ $errors->has('peso') ? ' has-danger' : '' }}  col-md-3 ">
                            <label >{{ __('Peso Unitário(g)') }}</label>
                            <input style="text-align: right" id="peso" type="text" name="peso" class="form-control{{ $errors->has('peso') ? ' is-invalid' : '' }}" placeholder="{{ __('peso') }}" value="{{ old('peso', $obj->peso) }}" required >
                            @include('alerts.feedback', ['field' => 'peso'])
                        </div>

                        <div class="form-group{{ $errors->has('hashtag') ? ' has-danger' : '' }}  col-md-12 ">
                            <label >{{ __('Hashtag') }}</label>
                            <input id="hashtag" type="text" name="hashtag" class="form-control{{ $errors->has('hashtag') ? ' is-invalid' : '' }}" placeholder="{{ __('hashtag') }}" value="{{ old('hashtag', $obj->hashtag) }}" required >
                            @include('alerts.feedback', ['field' => 'hashtag'])
                        </div>

                    </div>

                        <div class="card-footer">
                            <a href="{{route('advertisement.back', $obj->id)}}" class="btn btn-fill btn-primary">{{ __('Voltar') }}</a>
                            <button type="submit" class="btn btn-fill btn-primary">{{ __('Próximo') }}</button>

                        </div>

                    </form>


                </div>
            </div>
        </div>
    </div>

    <script src="/assets/js/functions.js">

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <script>
        function calculaPrecos(){
            var preco = $("#preco").val();
            preco =  preco.toString().replace('.','');
            var prec = preco.toString().replace(',','.');
            var comnoval = {{env('COMISSAO_NORMAL')}};
            var destaque= {{env('COMISSAO_DESTAQUE')}}
            var valorN = parseFloat(prec) * parseFloat(comnoval);
            var valorD = parseFloat(prec) * parseFloat(destaque);
            document.getElementById('recebonormal').value = valorN.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            document.getElementById('recebodestaque').value = valorD.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

        }
        $(document).ready(function($){
            $("#preco").mask("#.##0,00", {reverse: true});
            $("#qtd").mask("#.##0,00", {reverse: true});
            $("#altura").mask("#.##0,00", {reverse: true});
            $("#largura").mask("#.##0,00", {reverse: true});
            $("#peso").mask("#.##0,00", {reverse: true});
        });

        function showname(id, ret) {
            var name = document.getElementById(id);
            document.getElementById(ret).value =  name.files.item(0).name;
            //alert('Selected file: ' + name.files.item(0).name);
            /*alert('Selected file: ' + name.files.item(0).size);
            alert('Selected file: ' + name.files.item(0).type);*/

        }
    </script>
@endsection
