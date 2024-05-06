@extends('layouts.app', ['page' => __('Perfil'), 'pageSlug' => 'profile','class'=>'profile'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Dados p/ Envio') }}</h5>
                </div>
                <form method="post" action="{{route('sales.send.do',$id)}}" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$id}}">

                    <div class="card-body">
                        <div class="form-group">
                            <label id="nomecompleto">{{ __('Cliente') }}</label>
                            <label type="text" name="titulo" class="form-control" placeholder="{{ __('Cliente') }}" value="{{ old('titulo', $obj->name) }}"  >{{$obj->name}}</label>

                        </div>
                        <div class="form-group{{ $errors->has('descricao') ? ' has-danger' : '' }}">
                            <label id="nomecompleto">{{ __('Descrição') }}</label>
                            <label type="text" name="descricao" class="form-control" placeholder="{{ __('Descrição') }}" value="{{ old('descricao', ) }}"  > {{$obj->titulo.', Qtd: '.$obj->quantidade.', Tamanho: '.$obj->descricao}}</label>

                        </div>

                        <div class="form-group{{ $errors->has('descricaod') ? ' has-danger' : '' }}">
                            <label id="nomecompleto">{{ __('Endereço de Envio') }}</label>
                            <label  name="descricaod" class="form-control" placeholder="{{ __('Endereço de Envio') }}" required cols="50" rows="4" >{{ old('descricaod',
                            $obj->rua .', '. $obj->bairro.', '.$obj->cidade.' - ' .$obj->estado. ' CEP:'.$obj->cep ) }}
                            </label>

                        </div>

                        <div class="form-group{{ $errors->has('rastreio') ? ' has-danger' : '' }}">
                            <label id="hashtagl">{{ __('Código de Rastreio') }}</label>
                            <input  type="text" name="rastreio" class="form-control{{ $errors->has('rastreio') ? ' is-invalid' : '' }}" placeholder="{{ __('Código de Rastreio') }}" value="{{ old('material', $obj->material) }}" required >
                            @include('alerts.feedback', ['field' => 'hashtag'])
                        </div>





                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Enviar') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="/assets/js/functions.js">

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

    <script>
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
