@extends('layouts.app', ['page' => __('Perfil'), 'pageSlug' => 'profile','class'=>'profile'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Anúncio') }}</h5>
                    <form autocomplete="off" enctype="multipart/form-data" method="post" action="{{route('advertisement.finalizar', $obj->id)}}" >
                        <input type="hidden" name="id" value="{{$obj->id}}">
                        @csrf
                    <div class="form-group{{ $errors->has('fotoum') ? ' has-danger' : '' }}">
                        <label >{{ __('Foto 1') }}</label>
                        <input id="foto1" type="text" name="foto1" class="form-control{{ $errors->has('foto1') ? ' is-invalid' : '' }}" placeholder="{{ __('Foto1') }}" value="{{ old('foto1', $obj->foto1)}}" required readonly>
                        @include('alerts.feedback', ['field' => 'fotoum'])

                        <input type="file" style="display:none" class="form-control" name="fotoum"  size="25" id="arquivo" maxlength="20" accept="image/*" onchange="showname('arquivo','foto1');" >
                        <div style="margin-top: 10px; margin-bottom: -25px">
                            <input type="button" id="loadFileXml" value="Anexar" onclick="document.getElementById('arquivo').click();" />
                        </div>
                        <br>

                    </div>

                    <div class="form-group{{ $errors->has('ft2') ? ' has-danger' : '' }}">
                        <label >{{ __('Foto 2') }}</label>
                        <input id="foto2" type="text" name="foto2" class="form-control{{ $errors->has('foto2') ? ' is-invalid' : '' }}" placeholder="{{ __('Foto2') }}" value="{{ old('foto2', $obj->foto2) }}" required readonly>
                        @include('alerts.feedback', ['field' => 'ft2'])
                        <input type="file" style="display:none" class="form-control" name="ft2"  size="25" id="foto2i" maxlength="20" accept="image/*" onchange="showname('foto2i','foto2');"
                        >
                        <div style="margin-top: 10px; margin-bottom: -25px">
                            <input type="button" id="loadFileXml" value="Anexar" onclick="document.getElementById('foto2i').click();" />
                        </div>
                        <br>
                    </div>

                    <div class="form-group{{ $errors->has('ft3') ? ' has-danger' : '' }}">
                        <label >{{ __('Foto 3') }}</label>
                        <input id="foto3" type="text" name="foto3" class="form-control{{ $errors->has('foto3') ? ' is-invalid' : '' }}" placeholder="{{ __('Foto 3') }}" value="{{ old('foto3', $obj->foto3) }}" required readonly>
                        @include('alerts.feedback', ['field' => 'ft3'])

                        <input type="file" style="display:none" class="form-control" name="ft3"  size="25" id="foto3i" maxlength="20" accept="image/*" onchange="showname('foto3i','foto3');"
                        >
                        <div style="margin-top: 10px; margin-bottom: -25px">
                            <input type="button" id="loadFileXml" value="Anexar" onclick="document.getElementById('foto3i').click();" />
                        </div>
                        <br>

                    </div>



                        <div class="card-footer">
                            <a href="{{route('advertisement.back.fotos', $obj->id)}}" class="btn btn-fill btn-primary">{{ __('Voltar') }}</a>
                            <button type="submit" class="btn btn-fill btn-primary">@if($obj->type_id == 4) {{ __('Próximo') }} @else {{ __('Finalizar') }} @endif </button>

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
