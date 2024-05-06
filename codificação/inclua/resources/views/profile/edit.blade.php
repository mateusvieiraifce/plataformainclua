@extends('layouts.app', ['page' => __('Perfil'), 'pageSlug' => 'profile','class'=>'profile'])

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Dados da Conta') }}</h5>
                </div>
                <form method="post" action="{{route('user.update')}}" autocomplete="off">
                    <div class="card-body">
                            @csrf
                            @include('alerts.success')

                            <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                <label>{{ __('Name') }}</label>
                                <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" placeholder="{{ __('Name') }}" value="{{ old('name', auth()->user()->name) }}">
                                @include('alerts.feedback', ['field' => 'name'])
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <label>{{ __('Email address') }}</label>
                                <input type="email" name="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email address') }}" value="{{ old('email', auth()->user()->email) }}">
                                @include('alerts.feedback', ['field' => 'email'])
                                <input type="hidden" name="id" value="{{auth()->user()->id}}">
                            </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Dados Pessoais') }}</h5>
                </div>
                <form method="post" action="{{route('user.update.comp')}}" autocomplete="off">
                    <input type="hidden" name="id" value="{{auth()->user()->id}}">
                    <div class="card-body">
                        @csrf
                        @method('put')

                        @include('alerts.success', ['key' => 'password_status'])

                        <div class="form-group{{ $errors->has('nome_completo') ? ' has-danger' : '' }}">
                            <label id="nomecompleto">{{ __('Nome Completo') }}</label>
                            <input type="text" name="nome_completo" class="form-control{{ $errors->has('nome_completo') ? ' is-invalid' : '' }}" placeholder="{{ __('Nome Completo') }}" value="{{ old('nome_completo', auth()->user()->nomecompleto) }}" required >
                            @include('alerts.feedback', ['field' => 'nome_completo'])
                        </div>

                        <div class="form-group{{ $errors->has('tipopessoa') ? ' has-danger' : '' }}">
                            <label>{{ __('Tipo Pessoa') }}</label>
                            @php
                            $tipo= old('tipopessoa', auth()->user()->tipopessoa);
                            @endphp
                        <select name="tipopessoa" id="tipopessoa"  class="form-control{{ $errors->has('tipopessoa') ? ' is-invalid' : '' }}" onchange="escondeSexo()">
                            <option value="F"  style="background-color: #1e1e2f" <?=$tipo === 'F' ? 'selected' : ''; ?> >FÍSICA</option>
                            <option value="J" style="background-color: #1e1e2f" <?= $tipo === 'J' ? 'selected' : ''; ?> >JURÍDICA</option>
                        </select>
                        </div>

                        <div class="form-group{{ $errors->has('sexo') ? ' has-danger' : '' }}" id="sexo_div">
                            <label>{{ __('Sexo') }}</label>
                            <select name="sexo" id="sexo"  class="form-control{{ $errors->has('sexo') ? ' is-invalid' : '' }}">

                                <option value="M"  style="background-color: #1e1e2f" <?= auth()->user()->sexo === 'M' ? 'selected' : ''; ?> >Masculino</option>
                                <option value="F" style="background-color: #1e1e2f" <?= auth()->user()->sexo === 'F' ? 'selected' : ''; ?> >Feminino</option>
                                <option value="N" style="background-color: #1e1e2f" <?= auth()->user()->sexo === 'N' ? 'selected' : ''; ?> >Não Informar</option>
                            </select>
                        </div>


                        <div class="form-group{{ $errors->has('documento') ? ' has-danger' : '' }}">
                            <label id="documento">{{ __('CPF') }}</label>
                            <input id="docmateus" type="text" name="documento"  class="form-control{{ $errors->has('documento') ? ' is-invalid' : '' }}" placeholder="{{ __('Cpf/CNPJ') }}" value="{{ old('documento', auth()->user()->documento) }}" required>
                            @include('alerts.feedback', ['field' => 'documento'])
                        </div>
                        <div class="form-group">
                            <label>{{ __('Nacionalidade') }}</label>
                            <input type="text" name="nacionalidade" class="form-control" placeholder="{{ __('Nacionalidade') }}" value="{{ old('nacionalidade', auth()->user()->nacionalidade) }}" required>
                        </div>
                        <div class="form-group">
                            <label>{{ __('Telefone') }}</label>
                            <input type="tel" name="telefone" class="form-control" placeholder="{{ __('Telefone') }}" value="{{ old('telefone', auth()->user()->telefone) }}" required pattern="\([0-9]{2}\) [0-9]{4,6}-[0-9]{3,4}$" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Celular') }}</label>
                            <input type="text" name="celular" class="form-control" placeholder="{{ __('Celular') }}" value="{{ old('celular', auth()->user()->celular) }}" required pattern="\([0-9]{2}\) [0-9]{4,6}-[0-9]{3,4}$" onkeypress="mask(this, mphone);" onblur="mask(this, mphone);">
                        </div>

                        <div class="form-group">
                            <label>{{ __('E-mail alternativo') }}</label>
                            <input type="email" name="email_alternativo" required class="form-control" placeholder="{{ __('E-mail Alternativo') }}" value="{{ old('email_alternativo', auth()->user()->email_alternativo) }}">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Instagram') }}</label>
                            <input type="text" name="instagram" class="form-control" placeholder="{{ __('Instagram') }}" value="{{ old('instagram', auth()->user()->instagram) }}">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Facebook') }}</label>
                            <input type="text" name="facebook" class="form-control" placeholder="{{ __('Facebook') }}" value="{{ old('facebook', auth()->user()->facebook) }}">
                        </div>
                        <div class="form-group">
                            <label>{{ __('Twitter') }}</label>
                            <input type="text" name="twitter" class="form-control" placeholder="{{ __('Twitter') }}" value="{{ old('twitter', auth()->user()->twitter) }}">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">{{ __('Atualizar Dados') }}</button>
                    </div>
                </form>
            </div>

            <div class="card">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="card card-tasks">
                            <div class="card-header ">
                                <h6 class="title d-inline">Endereços</h6>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                                        <i class="tim-icons icon-settings-gear-63"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item" href="{{route('user.update.add')}}">Adicionar</a>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body ">
                                <div class="table-full-width table-responsive">
                                    <table class="table">
                                        <tbody>
                                        @php
                                        $enderecos = auth()->user()->Enderecos()->get();
                                        @endphp
                                        @foreach($enderecos as $ende)
                                            <tr>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input" type="checkbox" disabled
                                                            @if($ende->princial)
                                                                checked
                                                                @endif
                                                            >
                                                            <span class="form-check-sign">
                                                    <span class="check"></span>
                                                </span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="title">{{$ende->recebedor}}</p>
                                                    <p class="text-muted">{{$ende->rua}}, {{$ende->bairro}},{{$ende->numero}}, {{$ende->cidade}}-{{$ende->estado}}</p>
                                                </td>

                                                <td class="td-actions text-right">
                                                    <a href="{{route('user.add.update',$ende->id)}}">
                                                    <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                                        <i class="tim-icons icon-pencil"></i>
                                                    </button>
                                                    </a>
                                                </td>
                                                <td class="td-actions text-right">
                                                    <a onclick="return confirm('Deseja realmente excluir?') " href="{{route('user.update.del.do',$ende->id)}}">
                                                    <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                                        <i class="tim-icons icon-simple-remove"></i>
                                                    </button>
                                                    </a>
                                                </td>

                                                <td class="td-actions text-right">
                                                    <a href="{{route('user.update.end.pri',$ende->id)}}">
                                                    <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                                        <i class="tim-icons icon-heart-2"></i>
                                                    </button>
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
                <div class="card-footer">
                    <div class="button-container">
                        <a href="{{ auth()->user()->instagram }}">
                        <button class="btn btn-icon btn-round btn-instagram">
                            <i class="fab fa-instagram"></i>
                        </button>
                        </a>
                        <a href="{{ auth()->user()->facebook }}">
                        <button class="btn btn-icon btn-round btn-google">
                            <i class="fab fa-facebook"></i>
                        </button>
                        </a>
                        <a href="{{ auth()->user()->twitter }}">
                        <button class="btn btn-icon btn-round btn-twitter">
                            <i class="fab fa-twitter"></i>
                        </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/assets/js/functions.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
    <script>
        var obj = $("#docmateus");
        $('#docmateus').focus( "load", function() {
            var tipo_pessoa = document.getElementById('tipopessoa').value;
            if (tipo_pessoa=="F"){
                obj.mask("000.000.000-00");
            }else{
                obj.mask("00.000.000/0000-00");
            }
            console.log( tipo_pessoa );
        });
    </script>

    <script type="application/javascript">
      var obj = $("#docmateus");
      function escondeSexo(){
          var tipo_pessoa = document.getElementById('tipopessoa').value;
          var cpf = document.getElementById('documento');
          var nomecompeto = document.getElementById('nomecompleto');
            var divSexo = document.getElementById('sexo_div');
            if (tipo_pessoa=="J"){
                divSexo.style.display = "none"
                obj.mask("00.000.000/0000-00");
                cpf.innerText="CNPJ";
                nomecompeto.innerText ="Fantasia";
            } else{
                divSexo.style.display = "block"
                obj.mask("000.000.000-00");
                cpf.innerText="CPF";
                nomecompeto.innerText ="Nome Completo";
            }
        }
        function aplicaMascaraPorTipoPessoa() {
            if (document.querySelectorAll('select[id="tipopessoa"]').length) {
                var tipo_pessoa = document.getElementById('tipopessoa').value;
                if (tipo_pessoa === 'F')
                {
                    jQuery(document).ready(function($){
                        jQuery("#docmateus").mask("000.000.000-00");
                    });
                }

            }
        }

    </script>


@endsection
