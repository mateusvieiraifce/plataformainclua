@extends('layouts.app', ['page' => __('Perfil'), 'pageSlug' => 'profile','class'=>'profile'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Anúncio') }}</h5>
                </div>
                <form method="post" action="{{route('advertisement.preco')}}" autocomplete="off" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$obj->id}}">

                    <div class="card-body">
                        <div class="form-group{{ $errors->has('titulo') ? ' has-danger' : '' }}">
                            <label id="nomecompleto">{{ __('Título') }}</label>
                            <input type="text" name="titulo" class="form-control{{ $errors->has('titulo') ? ' is-invalid' : '' }}" placeholder="{{ __('Título') }}" value="{{ old('titulo', $obj->titulo) }}" required >
                            @include('alerts.feedback', ['field' => 'titulo'])
                        </div>
                        <div class="form-group{{ $errors->has('descricao') ? ' has-danger' : '' }}">
                            <label id="nomecompleto">{{ __('Descrição') }}</label>
                            <input type="text" name="descricao" class="form-control{{ $errors->has('descricao') ? ' is-invalid' : '' }}" placeholder="{{ __('Descrição') }}" value="{{ old('descricao', $obj->descricao) }}" required >
                            @include('alerts.feedback', ['field' => 'descricao'])
                        </div>

                        <div class="form-group{{ $errors->has('descricaod') ? ' has-danger' : '' }}">
                            <label id="nomecompleto">{{ __('Descrição Detalhada') }}</label>
                            <textarea  name="descricaod" class="form-control{{ $errors->has('descricaod') ? ' is-invalid' : '' }}" placeholder="{{ __('Descrição Detalhada') }}" required cols="50" rows="4">{{ old('descricaod', $obj->descricaod  ) }}
                            </textarea>
                            @include('alerts.feedback', ['field' => 'descricao'])
                        </div>

                        <div class="form-group{{ $errors->has('material') ? ' has-danger' : '' }}">
                            <label id="hashtagl">{{ __('Material') }}</label>
                            <input  type="text" name="material" class="form-control{{ $errors->has('material') ? ' is-invalid' : '' }}" placeholder="{{ __('Material') }}" value="{{ old('material', $obj->material) }}" required >
                            @include('alerts.feedback', ['field' => 'hashtag'])
                        </div>





                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Próximo') }}</button>
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
