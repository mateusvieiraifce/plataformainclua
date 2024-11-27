@extends('layouts.app', ['page' => __('Pacientes'), 'exibirPesquisa' => false, 'pageSlug' => 'pacientes', 'class' => 'pacientes'])
@section('title', 'Cadastro de paciente')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title">Cadastro de paciente</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('paciente.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="nome">
                                        Nome <span class="required">*</span>
                                    </label>
                                    <div class="input-group {{ $errors->has('nome') ? 'has-danger' : '' }}">
                                        <input type="text" id="nome" class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }}" name="nome"
                                            placeholder="Nome completo..." value="{{ old('nome') }}" required>
                                        @include('alerts.feedback', ['field' => 'nome'])
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="documento">
                                        CPF <span class="required">*</span>
                                    </label>
                                    <div class="input-group {{ $errors->has('documento') ? 'has-danger' : '' }}">
                                        <input type="text" 
                                           id="documento" 
                                           class="form-control {{ $errors->has('documento') ? 'is-invalid' : '' }}" 
                                           name="documento" 
                                           maxlength="14" 
                                           placeholder="000.000.000-00" 
                                           oninput="mascaraCpf(this)" 
                                           onblur="validarCPF(this)" 
                                           value="{{ old('documento') ? \App\Helper::mascaraCPF(old('documento')) : '' }}" 
                                           required>

                                        @include('alerts.feedback', ['field' => 'documento'])
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="data_nascimento">
                                        Data de nascimento <span class="required">*</span>
                                    </label>    
                                    <div class="input-group {{ $errors->has('data_nascimento') ? 'has-danger' : '' }}">
                                        <input type="date" 
                                           id="data_nascimento" 
                                           class="form-control {{ $errors->has('data_nascimento') ? 'is-invalid' : '' }}"
                                           name="data_nascimento" 
                                           value="{{ old('data_nascimento') }}" 
                                           max="{{ date('Y-m-d') }}" 
                                           required>

                                        @include('alerts.feedback', ['field' => 'data_nascimento'])
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="sexo">
                                        Gênero <span class="required">*</span>
                                    </label>
                                    <div class="input-group {{ $errors->has('sexo') ? 'has-danger' : '' }}">
                                        <select name="sexo" class="form-control {{ $errors->has('sexo') ? 'is-invalid' : '' }}" required>
                                            <option value=""></option>
                                            <option value="F" @if (old('sexo') == 'F') selected @endif>Feminino</option>
                                            <option value="M" @if (old('sexo') == 'M') selected @endif>Masculino</option>
                                            <option value="O" @if (old('sexo') == 'O') selected @endif>Outro</option>
                                            <option value="N" @if (old('sexo') == 'N') selected @endif>Prefiro não informar</option>
                                        </select>
                                        @include('alerts.feedback', ['field' => 'sexo'])
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ url()->previous() }}" class="btn btn-primary">
                                    <i class="fa fa-reply"></i> Voltar
                                </a>
                                <button class="btn btn-primary" onclick="$('#send').click();">
                                    Cadastrar <i class="fa fa-save"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" name="id" value=" ">
                        <input type="hidden" name="especialista_id" value="">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
