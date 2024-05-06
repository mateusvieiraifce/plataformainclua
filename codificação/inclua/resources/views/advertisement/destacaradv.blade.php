@extends('layouts.app', ['page' => __('Perfil'), 'pageSlug' => 'profile','class'=>'profile'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Anúncio') }}</h5>
                    <form autocomplete="off" enctype="multipart/form-data" method="post" action="{{route('advertisement.destacar.do', $obj->id)}}" >
                        <input type="hidden" name="id" value="{{$obj->id}}">
                        @csrf

                        <div class="card-body">
                        <div class="form-group{{ $errors->has('destaque') ? ' has-danger' : '' }}">
                            <label >{{ __('Destaque') }}</label>
                            <input id='foto4' type="text" name="destaque" class="form-control{{ $errors->has('destaque') ? ' is-invalid' : '' }}" placeholder="{{ __('Destaque') }}" value="{{ old('destaque', $obj->destaque) }}"  readonly >
                            @include('alerts.feedback', ['field' => 'complemento'])

                            <input type="file" style="display:none" class="form-control" name="fotoum"  size="25" id="foto4i" maxlength="20" accept=".jpg,.png" onchange="showname('foto4i','foto4');"
                            >
                            <div style="margin-top: 10px; margin-bottom: -25px">
                                <input type="button" id="loadFileXml" value="Anexar" onclick="document.getElementById('foto4i').click();" />
                            </div>
                            <br>

                        </div>

                            <div class="form-group{{ $errors->has('titulo_destaque') ? ' has-danger' : '' }}">
                                <label id="nomecompleto">{{ __('Título') }}</label>
                                <input type="text" name="titulo" class="form-control{{ $errors->has('titulo') ? ' is-invalid' : '' }}" placeholder="{{ __('Título') }}" value="{{ old('titulo', $obj->titulo_destaque) }}" required maxlength="15">
                                @include('alerts.feedback', ['field' => 'titulo'])
                            </div>
                            <div class="form-group{{ $errors->has('subtitulo') ? ' has-danger' : '' }}">
                                <label id="nomecompleto">{{ __('Subtítulo') }}</label>
                                <input type="text" name="subtitulo" class="form-control{{ $errors->has('subtitulo') ? ' is-invalid' : '' }}" placeholder="{{ __('Subtítulo') }}" value="{{ old('subtitulo', $obj->subtitulo) }}" required maxlength="15">
                                @include('alerts.feedback', ['field' => 'descricao'])
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-fill btn-primary">{{ __('Finalizar') }}</button>


                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

        function showname(id, ret) {
            var name = document.getElementById(id);
            document.getElementById(ret).value =  name.files.item(0).name;
            //alert('Selected file: ' + name.files.item(0).name);
            /*alert('Selected file: ' + name.files.item(0).size);
            alert('Selected file: ' + name.files.item(0).type);*/

        }
    </script>
    <script src="/assets/js/functions.js">

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>


@endsection
