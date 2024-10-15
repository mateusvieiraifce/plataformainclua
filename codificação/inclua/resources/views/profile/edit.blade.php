@extends('layouts.app', ['page' => __('Perfil'), 'pageSlug' => 'profile', 'exibirPesquisa' => false, 'class' => 'profile'])
@section('title', 'Editar Perfil')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">Dados da conta</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('user.update')}}" autocomplete="off">
                        @csrf
                        @include('alerts.success')

                        <div class="form-group">
                            <label for="nome">
                                Nome
                            </label>
                            <div class="input-group{{ $errors->has('nome') ? ' has-danger' : '' }}">
                                <input type="text" id="nome" class="form-control {{ $errors->has('nome') ? 'is-invalid' : '' }}"
                                    name="nome" placeholder="Nome" value="{{ old('nome') ?? auth()->user()->nome_completo }}">
                                @include('alerts.feedback', ['field' => 'nome'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">
                                E-mail
                            </label>
                            <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <input type="text" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    name="email" placeholder="E-mail" value="{{ old('email') ?? auth()->user()->email }}">
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-fill btn-primary">Salvar</button>
                        </div>
                        <input type="hidden" name="usuario_id" value="{{auth()->user()->id}}">
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="title">Dados Pessoais</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('user.update.dados')}}" autocomplete="off">
                        @csrf
                        @method('put')

                        @include('alerts.success', ['key' => 'password_status'])
                        <div class="form-group">
                            <label for="tipo_pessoa">
                                Tipo Pessoa
                            </label>
                            <div class="input-group{{ $errors->has('tipo_pessoa') ? ' has-danger' : '' }}">
                                <select id="tipo_pessoa" name="tipo_pessoa" class="form-control{{ $errors->has('tipo_pessoa') ? 'is-invalid' : '' }}" onchange="escondeSexo()">
                                    <option value=""></option>
                                    <option value="F" @if ((auth()->user()->tipo_pessoa == 'F') || old('tipo_pessoa') == 'F') selected @endif>FÍSICA</option>
                                    <option value="J" @if ((auth()->user()->tipo_pessoa == 'J') || old('tipo_pessoa') == 'J') selected @endif>JURÍDICA</option>
                                </select>
                                @include('alerts.feedback', ['field' => 'tipo_pessoa'])
                            </div>
                        </div>
                        <div class="form-group" id="sexo_div">
                            <label for="sexo">
                                Sexo
                            </label>
                            <div class="input-group{{ $errors->has('sexo') ? ' has-danger' : '' }}">
                                <select id="sexo" name="sexo" class="form-control{{ $errors->has('sexo') ? 'is-invalid' : '' }}">
                                    <option value=""></option>
                                    <option value="F" @if ((auth()->user()->sexo == 'F') || old('sexo') == 'F') selected @endif>Feminino</option>
                                    <option value="M" @if ((auth()->user()->sexo == 'M') || old('sexo') == 'M') selected @endif>Masculino</option>
                                    <option value="O" @if ((auth()->user()->sexo == 'O') || old('sexo') == 'O') selected @endif>Outro</option>
                                    <option value="N" @if ((auth()->user()->sexo == 'N') || old('sexo') == 'N') selected @endif>Prefiro não informar</option>
                                </select>
                                @include('alerts.feedback', ['field' => 'sexo'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="documento">
                                CPF/CNPJ
                            </label>
                            <div class="input-group{{ $errors->has('documento') ? ' has-danger' : '' }}">
                                <input type="text" id="documento" class="form-control {{ $errors->has('documento') ? 'is-invalid' : '' }}"
                                    name="documento" placeholder="CPF/CNPJ" value="{{ old('documento') ?? auth()->user()->documento }}">
                                @include('alerts.feedback', ['field' => 'documento'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telefone">
                                Telefone
                            </label>
                            <div class="input-group{{ $errors->has('telefone') ? ' has-danger' : '' }}">
                                <input type="text" id="telefone" class="form-control {{ $errors->has('telefone') ? 'is-invalid' : '' }}" pattern="\([0-9]{2}\) [0-9]{4,6}-[0-9]{3,4}$"
                                    name="telefone" placeholder="(**) ****-****" value="{{ old('telefone') ?? auth()->user()->telefone }}">
                                @include('alerts.feedback', ['field' => 'telefone'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="celular">
                                Celular
                            </label>
                            <div class="input-group{{ $errors->has('celular') ? ' has-danger' : '' }}">
                                <input type="text" id="celular" class="form-control {{ $errors->has('celular') ? 'is-invalid' : '' }}" oninput="mascaraCelular(this)"
                                    pattern="\([0-9]{2}\) [0-9]{4,6}-[0-9]{3,4}$" name="celular" placeholder="(**) 9****-****" value="{{ old('celular') ?? auth()->user()->celular }}">
                                @include('alerts.feedback', ['field' => 'celular'])
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-fill btn-primary">Atualizar Dados</button>
                        </div>
                        <input type="hidden" name="usuario_id" value="{{auth()->user()->id}}">
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header ">
                    <h5 class="title">Endereços</h5>
                    <div class="dropdown">
                        <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                            <i class="tim-icons icon-settings-gear-63"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('user.endereco.create') }}">Adicionar</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-full-width table-responsive">
                        <table class="table">
                            <tbody>
                                @php
                                    $enderecos = auth()->user()->Enderecos()->get();
                                @endphp
                                @foreach($enderecos as $endereco)
                                    <tr>
                                        <td>
                                            <div class="form-check text-left">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" name="efetuado" disabled @if($endereco->principal) checked @endif>
                                                    <span class="form-check-sign"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            <label>{{ $endereco->recebedor }}</label>
                                            <label>{{ $endereco->rua }}, {{ $endereco->bairro }}, {{ $endereco->numero }}, {{ $endereco->cidade }}-{{ $endereco->estado }}</label>
                                        </td>
                                        <td class="td-actions text-right">
                                            <a href="{{route('user.endereco.edit', $endereco->id)}}">
                                                <button type="button" rel="tooltip" title="" class="btn btn-link">
                                                    <i class="tim-icons icon-pencil"></i>
                                                </button>
                                            </a>
                                        </td>
                                        <td class="td-actions text-right">
                                            <a onclick="return confirm('Deseja realmente excluir?') " href="{{route('user.endereco.delete', $endereco->id)}}">
                                                <button type="button" rel="tooltip" title="" class="btn btn-link">
                                                    <i class="tim-icons icon-simple-remove"></i>
                                                </button>
                                            </a>
                                        </td>
                                        <td class="td-actions text-right">
                                            @if (!$endereco->principal)
                                                <a href="{{route('user.endereco.principal',$endereco->id)}}">
                                                    <button type="button" rel="tooltip" title="Tornar principal" class="btn btn-link">
                                                        <i class="tim-icons icon-heart-2"></i>
                                                    </button>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-user">
                <div class="card-body">
                    <p class="card-text">
                        <div class="author">
                            <div class="block block-one"></div>
                            <div class="block block-two"></div>
                            <div class="block block-three"></div>
                            <div class="block block-four"></div>
                            <a href="#">
                                <img class="avatar" src="{{ auth()->user()->avatar }}" alt="">
                                <h5 class="title">{{ auth()->user()->name }}</h5>
                            </a>
                        </div>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var documento = $("#documento");
            var tipo_pessoa = document.getElementById('tipo_pessoa').value;
            if (tipo_pessoa == "F") {
                documento.mask("000.000.000-00");
            } else{
                documento.mask("00.000.000/0000-00");
            }
            
            $("#telefone").mask("(00) 0000-0000");
            $("#celular").mask("(00) 00000-0000");
        });

        function escondeSexo() {
            var documento = $("#documento");
            var tipo_pessoa = document.getElementById('tipo_pessoa').value;
            var cpf = document.getElementById('documento');
            var nome = document.getElementById('nome');
            var divSexo = document.getElementById('sexo_div');
            if (tipo_pessoa == "J") {
                divSexo.style.display = "none"
                documento.mask("00.000.000/0000-00");
                cpf.innerText="CNPJ";
                nome.innerText = "Fantasia";
            } else {
                divSexo.style.display = "block"
                documento.mask("000.000.000-00");
                cpf.innerText="CPF";
                nome.innerText = "Nome Completo";
            }
        }
    </script>
@endsection