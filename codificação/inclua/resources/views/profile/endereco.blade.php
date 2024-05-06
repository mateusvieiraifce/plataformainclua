@extends('layouts.app', ['page' => __('Perfil'), 'pageSlug' => 'profile','class'=>'profile'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Endereço') }}</h5>
                </div>
                <form method="post" action="{{route('user.update.add.do')}}" autocomplete="off">
                    @csrf
                    <input type="hidden" name="id" value="{{auth()->user()->id}}">
                    <input type="hidden" name="id_add" value="{{$obj->id}}">
                    <input type="hidden" name="principal" value="{{$obj->princial}}">
                    <div class="card-body">
                        <div class="form-group{{ $errors->has('nome_completo') ? ' has-danger' : '' }}">
                            <label id="nomecompleto">{{ __('Contato') }}</label>
                            <input type="text" name="recebedor" class="form-control{{ $errors->has('recebedor') ? ' is-invalid' : '' }}" placeholder="{{ __('Nome Completo') }}" value="{{ old('recebedor', $obj->recebedor) }}" required >
                            @include('alerts.feedback', ['field' => 'recebedor'])
                        </div>

                        <div class="form-group{{ $errors->has('cep') ? ' has-danger' : '' }}">
                            <label id="cep">{{ __('CEP') }}</label>
                            <input id="cep_input" type="text" name="cep" class="form-control{{ $errors->has('cep') ? ' is-invalid' : '' }}" placeholder="{{ __('CEP') }}" value="{{ old('cep', $obj->cep) }}" required onblur="pesquisacep(this.value);" >
                            @include('alerts.feedback', ['field' => 'cep'])
                        </div>

                        <div class="form-group{{ $errors->has('rua') ? ' has-danger' : '' }}">
                            <label >{{ __('Endereço') }}</label>
                            <input id="rua" type="text" name="rua" class="form-control{{ $errors->has('Rua') ? ' is-invalid' : '' }}" placeholder="{{ __('Rua') }}" value="{{ old('rua', $obj->rua) }}" required >
                            @include('alerts.feedback', ['field' => 'Rua'])
                        </div>

                        <div class="form-group{{ $errors->has('bairro') ? ' has-danger' : '' }}">
                            <label >{{ __('Bairro') }}</label>
                            <input id="bairro" type="text" name="bairro" class="form-control{{ $errors->has('bairro') ? ' is-invalid' : '' }}" placeholder="{{ __('Bairro') }}" value="{{ old('bairro', $obj->cidade) }}" required >
                            @include('alerts.feedback', ['field' => 'bairro'])
                        </div>

                        <div class="form-group{{ $errors->has('cidade') ? ' has-danger' : '' }}">
                            <label >{{ __('Cidade') }}</label>
                            <input id="cidade" type="text" name="cidade" class="form-control{{ $errors->has('cidade') ? ' is-invalid' : '' }}" placeholder="{{ __('Cidade') }}" value="{{ old('cidade', $obj->cidade) }}" required >
                            @include('alerts.feedback', ['field' => 'cidade'])
                        </div>

                        <div class="form-group{{ $errors->has('estado') ? ' has-danger' : '' }}">
                            <label >{{ __('Estado') }}</label>
                            <input id="uf" type="text" name="estado" class="form-control{{ $errors->has('estado') ? ' is-invalid' : '' }}" placeholder="{{ __('Estado') }}" value="{{ old('estado', $obj->estado) }}" required >
                            @include('alerts.feedback', ['field' => 'estado'])
                        </div>

                        <div class="form-group{{ $errors->has('numero') ? ' has-danger' : '' }}">
                            <label >{{ __('Número') }}</label>
                            <input type="text" name="numero" class="form-control{{ $errors->has('numero') ? ' is-invalid' : '' }}" placeholder="{{ __('Número') }}" value="{{ old('numero', $obj->numero) }}" required >
                            @include('alerts.feedback', ['field' => 'numero'])
                        </div>

                        <div class="form-group{{ $errors->has('complemento') ? ' has-danger' : '' }}">
                            <label >{{ __('Complemento') }}</label>
                            <input type="text" name="complemento" class="form-control{{ $errors->has('complemento') ? ' is-invalid' : '' }}" placeholder="{{ __('Complemento') }}" value="{{ old('complemento', $obj->complemento) }}"  >
                            @include('alerts.feedback', ['field' => 'complemento'])
                        </div>

                        <div class="form-group{{ $errors->has('informacoes') ? ' has-danger' : '' }}">
                            <label >{{ __('Informações') }}</label>
                            <input type="text" name="informacoes" class="form-control{{ $errors->has('informacoes') ? ' is-invalid' : '' }}" placeholder="{{ __('Informações') }}" value="{{ old('informacoes', $obj->informacoes) }}"  >
                            @include('alerts.feedback', ['field' => 'informacoes'])
                        </div>


                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Salvar') }}</button>
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
            $("#cep_input").mask("00000-000");
        });
    </script>
@endsection
