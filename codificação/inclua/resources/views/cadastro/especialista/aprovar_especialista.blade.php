@extends('layouts.app', ['class' => 'register-page', 'contentClass' => 'register-page', 'pageSlug' => 'registre'])
@section('title', 'Aprovar Especialista')
@section('content')
    <div class="row">
        <div class="col-md-7 mr-auto">
            <div class="card card-register card-white">
                <div class="card-img">
                    <img class="img-card" src="{{ asset('assets/img/logo-01.png') }}" alt="Card image" >
                </div>
                <div class="card-header">
                    <h2 class="title">Dados pessoais</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="image">
                            Imagem de perfil
                        </label>
                        <br>
                        <img class="img-avatar" src="{{ isset($user) ? asset($user->avatar) : asset('assets/img/default-avatar.png') }}" id="preview" alt="Avatar">
                    </div>

                    <div class="form-group">
                        <label for="nome">
                            Nome
                        </label>
                        <div class="input-group {{ $errors->has('nome') ? ' has-danger' : '' }} input-medium">
                            <input type="text" id="nome" class="form-control border-full disabled {{ $errors->has('nome') ? ' is-invalid' : '' }}"
                                name="nome" placeholder="Nome Completo" value="{{ (isset($user) && $user->nome_completo ? $user->nome_completo : null) ?? old('nome') }}" disabled>
                            @include('alerts.feedback', ['field' => 'nome'])
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="documento">
                            CPF
                        </label>
                        <div class="input-group input-medium{{ $errors->has('documento') ? ' has-danger' : '' }}">
                            <input type="text" id="documento" class="form-control border-full disabled {{ $errors->has('documento') ? 'is-invalid' : '' }}"
                                name="documento" maxlength="14" placeholder="000.000.000-00" oninput="mascaraCpf(this)" onblur="validarCPF(this)"
                                value="{{ (isset($user) && $user->documento ? $user->documento : null) ?? old('documento') }}" disabled>
                            @include('alerts.feedback', ['field' => 'documento'])
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="celular">
                            Celular
                        </label>
                        <div class="input-group input-medium{{ $errors->has('celular') ? ' has-danger' : '' }}">
                            <input type="text" id="celular" class="form-control border-full disabled {{ $errors->has('celular') ? 'is-invalid' : '' }}"
                                name="celular" maxlength="15" placeholder="(**) 9****-****"  oninput="mascaraCelular(this)"
                                value="{{ (isset($user) && $user->celular ? $user->celular : null) ?? old('celular') }}" disabled>
                            @include('alerts.feedback', ['field' => 'celular'])
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="especialidade">
                            Especialidade
                        </label>
                        <div class="input-group input-medium{{ $errors->has('celular') ? ' has-danger' : '' }}">
                            <input type="text" id="especialidade" class="form-control border-full disabled {{ $errors->has('celular') ? 'is-invalid' : '' }}"
                                name="especialidade" maxlength="15" placeholder="(**) 9****-****"  oninput="mascaraCelular(this)"
                                value="{{ $user->getEspecialidadeEspecialista() }}" disabled>
                            @include('alerts.feedback', ['field' => 'celular'])
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="arquivo">
                            Certificado de Graduação/Especialização
                        </label>
                        <div class="input-group input-medium column-gap-10{{ $errors->has('arquivo') ? ' has-danger' : '' }}">
                            <input class="form-control border-full disabled {{ $errors->has('arquivo') ? 'is-invalid' : '' }}" type="text" name="fileName" id="fileName" value="{{ isset($user) ? explode('/', $user->getCertificadoEspecialista())[2] : null }}" disabled required>
                            @if (isset($user) && $user->getCertificadoEspecialista())
                                <a href="{{ asset($user->getCertificadoEspecialista()) }}" title="Baixar arquivo" download>
                                    <i class="zmdi zmdi-download zmdi-hc-3x"></i>
                                </a>
                            @endif
                            @include('alerts.feedback', ['field' => 'arquivo'])
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <h2 class="title">Local de atendimento</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="cep">
                            CEP <span class="required">*</span>
                        </label>
                        <div class="input-group {{ $errors->has('cep') ? ' has-danger' : '' }} input-medium">
                            <input type="text" id="cep" class="form-control border-full disabled {{ $errors->has('cep') ? ' is-invalid' : '' }}"
                                name="cep" maxlength="9" placeholder="CEP" value="{{ $endereco->cep }}" disabled>
                            @include('alerts.feedback', ['field' => 'cep'])
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="clinica">
                            Clínicas <span class="required">*</span>
                        </label>
                        <div class="input-group {{ $errors->has('clinica') ? ' has-danger' : '' }} input-medium">
                            <input type="text" id="clinica" class="form-control border-full disabled {{ $errors->has('clinica') ? ' is-invalid' : '' }}"
                                name="clinica" maxlength="9" placeholder="clinica" value="{{ $especialista->getClinica() }}" disabled>
                            @include('alerts.feedback', ['field' => 'clinica'])
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="documento">
                            CNPJ/CPF <span class="required">*</span>
                        </label>
                        <div class="input-group input-medium{{ $errors->has('documento') ? ' has-danger' : '' }}">
                            <input type="text" id="documento" class="form-control border-full disabled {{ $errors->has('documento') ? 'is-invalid' : '' }}"
                                name="documento" maxlength="18" placeholder="00.000.000/0000-00" value="{{ $clinica->cnpj }}" disabled>
                            @include('alerts.feedback', ['field' => 'documento'])
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nome_fantasia">
                            Nome Fantasia <span class="required">*</span>
                        </label>
                        <div class="input-group input-medium{{ $errors->has('nome_fantasia') ? ' has-danger' : '' }}">
                            <input type="text" id="nome_fantasia" class="form-control border-full disabled {{ $errors->has('nome_fantasia') ? 'is-invalid' : '' }}"
                                name="nome_fantasia" placeholder="Nome Fantasia" value="{{ $clinica->nome }}" disabled>
                            @include('alerts.feedback', ['field' => 'nome_fantasia'])
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="razao_social">
                            Razão Social <span class="required">*</span>
                        </label>
                        <div class="input-group input-medium{{ $errors->has('razao_social') ? ' has-danger' : '' }}">
                            <input type="text" id="razao_social" class="form-control border-full disabled {{ $errors->has('razao_social') ? 'is-invalid' : '' }}"
                                name="razao_social" placeholder="Razão Social" value="{{ $clinica->razaosocial }}" disabled>
                            @include('alerts.feedback', ['field' => 'razao_social'])
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="telefone">
                            Telefone Fixo
                        </label>
                        <div class="input-group input-medium{{ $errors->has('telefone') ? ' has-danger' : '' }}">
                            <input type="text" id="telefone" class="form-control border-full disabled {{ $errors->has('telefone') ? 'is-invalid' : '' }}"
                                name="telefone" maxlength="14" placeholder="(**) ****-****" value="{{ $user->telefone }}" disabled>
                            @include('alerts.feedback', ['field' => 'telefone'])
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="celular">
                            Celular <span class="required">*</span>
                        </label>
                        <div class="input-group input-medium{{ $errors->has('celular') ? ' has-danger' : '' }}">
                            <input type="text" id="celular" class="form-control border-full disabled {{ $errors->has('celular') ? 'is-invalid' : '' }}"
                                name="celular" maxlength="15" placeholder="(**) 9****-****" value="{{ $user->celular }}" disabled>
                            @include('alerts.feedback', ['field' => 'celular'])
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="numero_atendimento_social_mensal">
                            N° de atendimentos sociais mensais <span class="required">*</span>
                        </label>
                        <div class="input-group input-medium{{ $errors->has('numero_atendimento_social_mensal') ? ' has-danger' : '' }}">
                            <input type="number" id="numero_atendimento_social_mensal" class="form-control border-full disabled {{ $errors->has('numero_atendimento_social_mensal') ? 'is-invalid' : '' }}"
                                name="numero_atendimento_social_mensal" maxlength="15" placeholder="N° de atendimentos sociais mensais" value="{{ $clinica->numero_atendimento_social_mensal }}" disabled>
                            @include('alerts.feedback', ['field' => 'numero_atendimento_social_mensal'])
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="anamnese_obrigatoria">
                            A Anamnese será obrigatória? <span class="required">*</span>
                        </label>
                        <div class="input-group input-medium{{ $errors->has('anamnese_obrigatoria') ? ' has-danger' : '' }}">
                            <input type="text" id="anamnese_obrigatoria" class="form-control border-full disabled {{ $errors->has('anamnese_obrigatoria') ? 'is-invalid' : '' }}"
                                name="anamnese_obrigatoria" placeholder="Razão Social" value="{{ $clinica->anamnese_obrigatoria == "S" ? "Sim" : "Não" }}" disabled>
                            @include('alerts.feedback', ['field' => 'anamnese_obrigatoria'])
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="cidade">
                            Cidade <span class="required">*</span>
                        </label>
                        <div class="input-group {{ $errors->has('cidade') ? ' has-danger' : '' }} input-medium">
                            <input type="text" id="cidade" class="form-control border-full {{ $errors->has('cidade') ? ' is-invalid' : '' }}"
                                name="cidade" placeholder="Cidade" value="{{ $endereco->cidade }}" disabled>
                            @include('alerts.feedback', ['field' => 'cidade'])
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="estado">
                            Estado <span class="required">*</span>
                        </label>
                        <div class="input-group input-medium{{ $errors->has('estado') ? ' has-danger' : '' }}">
                            <input id="estado" type="text" name="estado" class="form-control border-full disabled {{ $errors->has('estado') ? 'is-invalid' : '' }}"
                                placeholder="Selecione o estado" value="{{ $endereco->estado }}" disabled>
                            @include('alerts.feedback', ['field' => 'estado'])
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="endereco">
                            Endereço <span class="required">*</span>
                        </label>
                        <div class="input-group {{ $errors->has('endereco') ? ' has-danger' : '' }} input-medium">
                            <input type="text" id="endereco" class="form-control border-full disabled {{ $errors->has('endereco') ? ' is-invalid' : '' }}"
                                name="endereco" placeholder="Endereço" value="{{ $endereco->rua }}" disabled>
                            @include('alerts.feedback', ['field' => 'endereco'])
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="numero">
                            Número <span class="required">*</span>
                        </label>
                        <div class="input-group {{ $errors->has('numero') ? ' has-danger' : '' }} input-medium">
                            <input type="text" id="numero" class="form-control border-full only-numbers disabled {{ $errors->has('numero') ? ' is-invalid' : '' }}"
                                name="numero" placeholder="Número" value="{{ $endereco->numero }}" disabled>
                            @include('alerts.feedback', ['field' => 'numero'])
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="bairro">
                            Bairro <span class="required">*</span>
                        </label>
                        <div class="input-group {{ $errors->has('bairro') ? ' has-danger' : '' }} input-medium">
                            <input type="text" id="bairro" class="form-control border-full disabled {{ $errors->has('bairro') ? ' is-invalid' : '' }}"
                                name="bairro" placeholder="Bairro" value="{{ $endereco->bairro }}" disabled>
                            @include('alerts.feedback', ['field' => 'bairro'])
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="complemento">
                            Complemento
                        </label>
                        <div class="input-group {{ $errors->has('complemento') ? ' has-danger' : '' }} input-medium">
                            <input type="text" id="complemento" class="form-control border-full disabled {{ $errors->has('complemento') ? ' is-invalid' : '' }}"
                                name="complemento" placeholder="Complemento" value="{{ $endereco->complemento }}" disabled>
                            @include('alerts.feedback', ['field' => 'complemento'])
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="longitude">
                            Longitude <span class="required">*</span>
                        </label>
                        <div class="input-group {{ $errors->has('longitude') ? ' has-danger' : '' }} input-medium">
                            <input type="text" id="longitude" class="form-control border-full only-numbers disabled {{ $errors->has('longitude') ? ' is-invalid' : '' }}"
                                name="longitude" placeholder="longitude" value="{{ $endereco->longitude }}" disabled>
                            @include('alerts.feedback', ['field' => 'longitude'])
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="latitude">
                            Latitude <span class="required">*</span>
                        </label>
                        <div class="input-group {{ $errors->has('latitude') ? ' has-danger' : '' }} input-medium">
                            <input type="text" id="latitude" class="form-control border-full only-numbers disabled {{ $errors->has('latitude') ? ' is-invalid' : '' }}"
                                name="latitude" placeholder="latitude" value="{{ $endereco->latitude }}" disabled>
                            @include('alerts.feedback', ['field' => 'latitude'])
                        </div>
                    </div>
                </div>
                <div class="card-header">
                    <h2 class="title">Dados Bancários</h2>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="conta_bancaria">
                            Conta Bancária <span class="required">*</span>
                        </label>
                        <div class="input-group {{ $errors->has('conta_bancaria') ? ' has-danger' : '' }} input-medium">
                            <input type="text" id="conta_bancaria" class="form-control border-full disabled {{ $errors->has('conta_bancaria') ? ' is-invalid' : '' }}"
                                name="conta_bancaria" placeholder="Número da conta bancária" value="{{ (isset($especialista) && $especialista->conta_bancaria ? $especialista->conta_bancaria : null) ?? old('conta_bancaria') }}" disabled>
                            @include('alerts.feedback', ['field' => 'conta_bancaria'])
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="agencia">
                            Agência <span class="required">*</span>
                        </label>
                        <div class="input-group {{ $errors->has('agencia') ? ' has-danger' : '' }} input-medium">
                            <input type="text" id="agencia" class="form-control border-full disabled {{ $errors->has('agencia') ? ' is-invalid' : '' }}"
                                name="agencia" placeholder="Agência" value="{{ (isset($especialista) && $especialista->agencia ? $especialista->agencia : null) ?? old('agencia') }}" disabled>
                            @include('alerts.feedback', ['field' => 'agencia'])
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="banco">
                            Banco <span class="required">*</span>
                        </label>
                        <div class="input-group input-medium{{ $errors->has('banco') ? ' has-danger' : '' }}">
                            <input type="text" id="banco" class="form-control border-full disabled {{ $errors->has('banco') ? 'is-invalid' : '' }}"
                                name="banco" placeholder="Nome do banco" value="{{ (isset($especialista) && $especialista->banco ? $especialista->banco : null) ?? old('banco') }}" disabled>
                            @include('alerts.feedback', ['field' => 'banco'])
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="chave_pix">
                            Pix <span class="required">*</span>
                        </label>
                        <div class="input-group input-medium{{ $errors->has('chave_pix') ? ' has-danger' : '' }}">
                            <input type="text" id="chave_pix" class="form-control border-full disabled {{ $errors->has('chave_pix') ? 'is-invalid' : '' }}"
                                name="chave_pix" maxlength="15" placeholder="Chave pix" value="{{ (isset($especialista) && $especialista->chave_pix ? $especialista->chave_pix : null) ?? old('chave_pix') }}" disabled>
                            @include('alerts.feedback', ['field' => 'chave_pix'])
                        </div>
                    </div>

                    <div class="input-group input-medium justify-content-between">
                        <form class="form" method="post" action="{{ route('aprovar.especialista.store') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-round btn-lg">{{ __('Negar') }}</button>
                            <input type="hidden" name="usuario_id" value="{{ $user->id }}">
                            <input type="hidden" name="especialista_id" value="{{ isset($user) ? $user->getIdEspecialista($user->id) : '' }}">
                            <input class="hidden" type="text" name="aprovado" value="false">
                        </form>
                        <form class="form" method="post" action="{{ route('aprovar.especialista.store') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Aprovar') }}</button>
                            <input type="hidden" name="usuario_id" value="{{ $user->id }}">
                            <input type="hidden" name="especialista_id" value="{{ isset($user) ? $user->getIdEspecialista($user->id) : '' }}">
                            <input class="hidden" type="text" name="aprovado" value="true">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
