@extends('layouts.app', ['page' => __('Layout'), 'pageSlug' => 'layout', 'exibirPesquisa' => false, 'class' => 'layout'])
@section('title', 'Layout')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">Cores do layout</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('configuracao.layout.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="color_primary">
                                Cor principal
                            </label>
                            <div class="input-group{{ $errors->has('color_primary') ? ' has-danger' : '' }}">
                                <input type="color" id="color_primary" class="form-control {{ $errors->has('color_primary') ? 'is-invalid' : '' }}"
                                    name="color_primary" value="{{ isset($configuracao) ? $configuracao->color_primary : old('color_primary') }}">
                                @include('alerts.feedback', ['field' => 'color_primary'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="color_gradiente">
                                Cor gradiente
                            </label>
                            <div class="input-group{{ $errors->has('color_gradiente') ? ' has-danger' : '' }}">
                                <input type="color" id="color_gradiente" class="form-control {{ $errors->has('color_gradiente') ? 'is-invalid' : '' }}"
                                    name="color_gradiente" value="{{ isset($configuracao) ? $configuracao->color_gradiente : old('color_gradiente') }}">
                                @include('alerts.feedback', ['field' => 'color_gradiente'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="image_logo">
                                Logo para login
                            </label>
                            <br>
                            <img src="{{ isset($configuracao) && !empty($configuracao->logo) ? asset($configuracao->logo) : asset('assets/img/logo-01.png') }}" id="preview-logo" alt="Avatar">
                            <div class="custom-file">
                                <input class="custom-file-input hidden" type="file" id="image_logo" name="image_logo" onchange="visualizarImagem(event, 'preview-logo')" accept="image/jpeg,image/jpg,image/png">
                                <label class="btn custom-file-label without-line-vertical input-small {{ $errors->has('image_logo') ? 'is-invalid' : '' }}" for="image_logo"></label>
                            </div>
                            @include('alerts.feedback', ['field' => 'image_logo'])
                        </div>
                        
                        <div class="form-group">
                            <label for="image_icon">
                                Icone dashboard
                            </label>
                            <br>
                            <img class="img-avatar" src="{{ isset($configuracao) && !empty($configuracao->icon) ? asset($configuracao->icon) : asset('assets/img/Icone2t.png') }}" id="preview-icon" alt="Avatar">
                            <div class="custom-file">
                                <input class="custom-file-input hidden" type="file" id="image_icon" name="image_icon" onchange="visualizarImagem(event, 'preview-icon')" accept="image/jpeg,image/jpg,image/png">
                                <label class="btn custom-file-label without-line-vertical input-small {{ $errors->has('image_icon') ? 'is-invalid' : '' }}" for="image_icon"></label>
                            </div>
                            @include('alerts.feedback', ['field' => 'image_icon'])
                        </div>
                        
                        <div class="form-group">
                            <label for="image_favicon">
                                Favicon
                            </label>
                            <br>
                            <img class="img-avatar" src="{{ isset($configuracao) && !empty($configuracao->favicon) ? asset($configuracao->favicon) : asset('assets/img/Icone2t.png') }}" id="preview-favicon" alt="Avatar">
                            <div class="custom-file">
                                <input class="custom-file-input hidden" type="file" id="image_favicon" name="image_favicon" onchange="visualizarImagem(event, 'preview-favicon')" accept="image/jpeg,image/jpg,image/png">
                                <label class="btn custom-file-label without-line-vertical input-small {{ $errors->has('image_favicon') ? 'is-invalid' : '' }}" for="image_favicon"></label>
                            </div>
                            @include('alerts.feedback', ['field' => 'image_favicon'])
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-fill btn-primary">Salvar</button>
                        </div>
                        <input type="hidden" name="configuracao_id" value="{{ isset($configuracao) ? $configuracao->id : null }}">
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <button id="button-example" type="button" class="btn btn-fill btn-primary">Exemplo</button>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="sidebar-reflection">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            const htmlEl = document.querySelector('html');
            document.getElementById('color_primary').addEventListener('input', function() {
                htmlEl.style.setProperty('--primary-reflection', $('#color_primary').val());
            });

            document.getElementById('color_gradiente').addEventListener('input', function() {
                const htmlEl = document.querySelector('html');
                htmlEl.style.setProperty('--color-gradient-reflection', $('#color_gradiente').val());
            });
        });

        function visualizarImagem(event, exibir) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function(){
                var preview = document.getElementById(exibir);
                preview.src = reader.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection