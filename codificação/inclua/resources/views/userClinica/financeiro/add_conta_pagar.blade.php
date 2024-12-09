@extends('layouts.app', ['exibirPesquisa' => false, 'pageSlug' => 'financeiro', 'class' => 'financeiro',  'contentClass' => 'register-page'])
@section('title', 'Cadastro de dados da conta para pagar')
@section('content')
    <div class="row">
        <div class="col-md-7 mr-auto">
            <div class="card card-register card-white">
                <div class="card-img">
                    <img class="img-card" src="{{ asset('assets/img/logo-01.png') }}" alt="Card image" >
                </div>
                <div class="card-header">
                    <h2 class="title">Dados da conta para pagar</h2>
                </div>
                <div class="card-body">                    
                    <form class="form" method="post" action="{{ route('clinica.financeiro.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="descricao">
                                Descrição<span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('descricao') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="descricao" class="form-control border-full {{ $errors->has('descricao') ? ' is-invalid' : '' }}"
                                    name="descricao" placeholder="Descrição" value="{{ old('descricao') }}" required>
                                @include('alerts.feedback', ['field' => 'descricao'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="valor">
                                Valor<span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('valor') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="valor" class="form-control border-full {{ $errors->has('valor') ? ' is-invalid' : '' }}"
                                    name="valor" placeholder="R$0,00" value="{{ old('valor') }}" required>
                                @include('alerts.feedback', ['field' => 'valor'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="vencimento">
                                Vencimento<span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('vencimento') ? ' has-danger' : '' }} input-medium">
                                <input type="date" id="vencimento" class="form-control border-full {{ $errors->has('vencimento') ? ' is-invalid' : '' }}"
                                    name="vencimento" value="{{ old('vencimento') }}" required>
                                @include('alerts.feedback', ['field' => 'vencimento'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="situacao">
                                Situação<span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('status') ? ' has-danger' : '' }} input-medium">
                                <select name="status" id="status" class="form-control border-full {{ $errors->has('status') ? ' is-invalid' : '' }}" required>
                                       <option value="Pago" {{ old('status') == 'Pago' ? 'selected' : '' }}>Pago</option>
                                       <option value="Pendente" {{ old('status') == 'Pendente' ? 'selected' : 'selected' }}>Pendente</option>
                                </select>
                                @include('alerts.feedback', ['field' => 'status'])
                            </div>
                        </div>

                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-round btn-lg">
                                @auth
                                    {{ __('Salvar') }}
                                @else
                                    {{ __('Finalizar') }}
                                @endauth
                            </button>
                        </div>
                        <input type="hidden" name="user_id" id="user_id" value="{{ $user_id }}">
                    </form>
                </div>                    
            </div>
        </div>
    </div>
    @include("layouts.modal_aviso")
    <script>
        $(document).ready(function () {
            $('#valor').mask('#,##0,000.00', {reverse: true});
        });
    </script>
@endsection