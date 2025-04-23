@extends('layouts.app', ['class' => 'register-page', 'contentClass' => 'register-page', 'pageSlug' => 'registre'])
@section('title', 'Cadastro de Local de Atendimento')
@section('content')
    <div class="row">
        <div class="col-md-7 mr-auto">
            <div class="card card-register card-white">
                <div class="card-img">
                    <img class="img-card" src="{{ asset('assets/img/logo-01.png') }}" alt="Card image" >
                </div>
                <div class="card-header">
                    <h2 class="title">Cadastro de local de atendimento</h2>
                </div>
                <div class="card-body">
                    <form class="form" method="post" action="{{ route('especialista.local-atendimento.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="cep">
                                CEP <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('cep') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="cep" class="form-control border-full {{ $errors->has('cep') ? ' is-invalid' : '' }}" oninput="mascaraCep(this)"
                                    name="cep" maxlength="9" placeholder="CEP" onblur="validarCep(this)" value="{{ (isset($user) ? $user->cep : null) ?? old('cep') }}">
                                @include('alerts.feedback', ['field' => 'cep'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="clinicas">
                                Clínicas <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('clinicas') ? ' has-danger' : '' }}">
                                <select id="clinicas" name="clinica" class="form-control border-full {{ $errors->has('clinica') ? 'is-invalid' : '' }}" disabled required></select>
                                @include('alerts.feedback', ['field' => 'clinica'])
                            </div>
                        </div>
                        
                        <div id="endereco-especialista" class="hidden">
                            <div class="form-group">
                                <label for="documento">
                                    CNPJ/CPF <span class="required">*</span>
                                </label>
                                <div class="input-group input-medium{{ $errors->has('documento') ? ' has-danger' : '' }}">
                                    <input type="text" id="documento" class="form-control border-full {{ $errors->has('documento') ? 'is-invalid' : '' }}"
                                        name="documento" maxlength="18" placeholder="00.000.000/0000-00" onblur="mascaraDocumento(this)"
                                        value="{{ (isset($user) && $user->documento ? $user->documento : null) ?? old('documento') }}">
                                    @include('alerts.feedback', ['field' => 'documento'])
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nome_fantasia">
                                    Nome Fantasia <span class="required">*</span>
                                </label>
                                <div class="input-group input-medium{{ $errors->has('nome_fantasia') ? ' has-danger' : '' }}">
                                    <input type="text" id="nome_fantasia" class="form-control border-full {{ $errors->has('nome_fantasia') ? 'is-invalid' : '' }}"
                                        name="nome_fantasia" placeholder="Nome Fantasia" value="{{ (isset($user) && $user->nome_completo ? "$user->nome_completo - {$user->getEspecialidadeEspecialista()}" : null) ?? old('nome_fantasia') }}">
                                    @include('alerts.feedback', ['field' => 'nome_fantasia'])
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="razao_social">
                                    Razão Social <span class="required">*</span>
                                </label>
                                <div class="input-group input-medium{{ $errors->has('razao_social') ? ' has-danger' : '' }}">
                                    <input type="text" id="razao_social" class="form-control border-full {{ $errors->has('razao_social') ? 'is-invalid' : '' }}"
                                        name="razao_social" placeholder="Razão Social" value="{{ (isset($user) && $user->nome_completo ? "$user->nome_completo - {$user->getEspecialidadeEspecialista()}" : null) ?? old('razao_social') }}">
                                    @include('alerts.feedback', ['field' => 'razao_social'])
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="telefone">
                                    Telefone Fixo
                                </label>
                                <div class="input-group input-medium{{ $errors->has('telefone') ? ' has-danger' : '' }}">
                                    <input type="text" id="telefone" class="form-control border-full {{ $errors->has('telefone') ? 'is-invalid' : '' }}"
                                        name="telefone" maxlength="14" placeholder="(**) ****-****" oninput="mascaraTelefone(this)"
                                        value="{{ (isset($user) ? $user->telefone : null) ?? old('telefone') }}">
                                    @include('alerts.feedback', ['field' => 'telefone'])
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="celular">
                                    Celular <span class="required">*</span>
                                </label>
                                <div class="input-group input-medium{{ $errors->has('celular') ? ' has-danger' : '' }}">
                                    <input type="text" id="celular" class="form-control border-full {{ $errors->has('celular') ? 'is-invalid' : '' }}"
                                        name="celular" maxlength="15" placeholder="(**) 9****-****" oninput="mascaraCelular(this)"
                                        value="{{ (isset($user) ? $user->celular : null) ?? old('celular') }}">
                                    @include('alerts.feedback', ['field' => 'celular'])
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="numero_atendimento_social_mensal">
                                    N° de atendimentos sociais mensais <span class="required">*</span>
                                </label>
                                <div class="input-group input-medium{{ $errors->has('numero_atendimento_social_mensal') ? ' has-danger' : '' }}">
                                    <input type="number" id="numero_atendimento_social_mensal" class="form-control border-full {{ $errors->has('numero_atendimento_social_mensal') ? 'is-invalid' : '' }}"
                                        name="numero_atendimento_social_mensal" maxlength="15" placeholder="N° de atendimentos sociais mensais" value="{{ old('numero_atendimento_social_mensal') }}" min="0">
                                    @include('alerts.feedback', ['field' => 'numero_atendimento_social_mensal'])
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="anamnese_obrigatoria">
                                    A Anamnese será obrigatória? <span class="required">*</span>
                                </label>
                                <div class="input-group input-medium{{ $errors->has('anamnese_obrigatoria') ? ' has-danger' : '' }}">
                                    <select id="anamnese_obrigatoria" name="anamnese_obrigatoria" class="form-control border-full {{ $errors->has('anamnese_obrigatoria') ? 'is-invalid' : '' }}">
                                        <option value="N" @if (old('anamnese_obrigatoria') == "N") selected @endif selected>
                                            Não
                                        </option>
                                        <option value="S" @if (old('anamnese_obrigatoria') == "S") selected @endif>
                                            Sim
                                        </option>
                                    </select>
                                    @include('alerts.feedback', ['field' => 'anamnese_obrigatoria'])
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="cidade">
                                    Cidade <span class="required">*</span>
                                </label>
                                <div class="input-group {{ $errors->has('cidade') ? ' has-danger' : '' }} input-medium">
                                    <input type="text" id="cidade" class="form-control border-full {{ $errors->has('cidade') ? ' is-invalid' : '' }}"
                                        name="cidade" placeholder="Cidade" value="{{ old('cidade') }}">
                                    @include('alerts.feedback', ['field' => 'cidade'])
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="estado">
                                    Estado <span class="required">*</span>
                                </label>
                                <div class="input-group input-medium{{ $errors->has('estado') ? ' has-danger' : '' }}">
                                    <input id="estado" list="estados" name="estado" class="form-control border-full {{ $errors->has('estado') ? 'is-invalid' : '' }}"
                                        placeholder="Selecione o estado" value="{{ old('estado') }}">
                                    <datalist id="estados" name="estado">
                                        <option value="AC">Acre</option>
                                        <option value="AL">Alagoas</option>
                                        <option value="AP">Amapá</option>
                                        <option value="AM">Amazonas</option>
                                        <option value="BA">Bahia</option>
                                        <option value="CE">Ceará</option>
                                        <option value="DF">Distrito Federal</option>
                                        <option value="ES">Espírito Santo</option>
                                        <option value="GO">Goiás</option>
                                        <option value="MA">Maranhão</option>
                                        <option value="MT">Mato Grosso</option>
                                        <option value="MS">Mato Grosso do Sul</option>
                                        <option value="MG">Minas Gerais</option>
                                        <option value="PA">Pará</option>
                                        <option value="PB">Paraíba</option>
                                        <option value="PR">Paraná</option>
                                        <option value="PE">Pernambuco</option>
                                        <option value="PI">Piauí</option>
                                        <option value="RJ">Rio de Janeiro</option>
                                        <option value="RN">Rio Grande do Norte</option>
                                        <option value="RS">Rio Grande do Sul</option>
                                        <option value="RO">Rondônia</option>
                                        <option value="RR">Roraima</option>
                                        <option value="SC">Santa Catarina</option>
                                        <option value="SP">São Paulo</option>
                                        <option value="SE">Sergipe</option>
                                        <option value="TO">Tocantins</option>
                                    </datalist>
                                    @include('alerts.feedback', ['field' => 'estado'])
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="endereco">
                                    Endereço <span class="required">*</span>
                                </label>
                                <div class="input-group {{ $errors->has('endereco') ? ' has-danger' : '' }} input-medium">
                                    <input type="text" id="endereco" class="form-control border-full {{ $errors->has('endereco') ? ' is-invalid' : '' }}"
                                        name="endereco" placeholder="Endereço" value="{{ old('endereco') }}">
                                    @include('alerts.feedback', ['field' => 'endereco'])
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="numero">
                                    Número <span class="required">*</span>
                                </label>
                                <div class="input-group {{ $errors->has('numero') ? ' has-danger' : '' }} input-medium">
                                    <input type="text" id="numero" class="form-control border-full only-numbers {{ $errors->has('numero') ? ' is-invalid' : '' }}"
                                        name="numero" placeholder="Número" value="{{ old('numero') }}">
                                    @include('alerts.feedback', ['field' => 'numero'])
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="bairro">
                                    Bairro <span class="required">*</span>
                                </label>
                                <div class="input-group {{ $errors->has('bairro') ? ' has-danger' : '' }} input-medium">
                                    <input type="text" id="bairro" class="form-control border-full {{ $errors->has('bairro') ? ' is-invalid' : '' }}"
                                        name="bairro" placeholder="Bairro" value="{{ old('bairro') }}">
                                    @include('alerts.feedback', ['field' => 'bairro'])
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="complemento">
                                    Complemento
                                </label>
                                <div class="input-group {{ $errors->has('complemento') ? ' has-danger' : '' }} input-medium">
                                    <input type="text" id="complemento" class="form-control border-full {{ $errors->has('complemento') ? ' is-invalid' : '' }}"
                                        name="complemento" placeholder="Complemento" value="{{ old('complemento') }}">
                                    @include('alerts.feedback', ['field' => 'complemento'])
                                </div>
                            </div>

                            <div class="form-group">
                                <label >
                                    Localização <span class="required">*</span>
                                </label>
                                <div class="mapa" id="map"></div>
                            </div>
                            
                            <div class="form-group">
                                <label for="longitude">
                                    Longitude <span class="required">*</span>
                                </label>
                                <div class="input-group {{ $errors->has('longitude') ? ' has-danger' : '' }} input-medium">
                                    <input type="text" id="longitude" class="form-control border-full only-numbers {{ $errors->has('longitude') ? ' is-invalid' : '' }}"
                                        name="longitude" placeholder="longitude" value="{{ old('longitude') }}">
                                    @include('alerts.feedback', ['field' => 'longitude'])
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="latitude">
                                    Latitude <span class="required">*</span>
                                </label>
                                <div class="input-group {{ $errors->has('latitude') ? ' has-danger' : '' }} input-medium">
                                    <input type="text" id="latitude" class="form-control border-full only-numbers {{ $errors->has('latitude') ? ' is-invalid' : '' }}"
                                        name="latitude" placeholder="latitude" value="{{ old('latitude') }}">
                                    @include('alerts.feedback', ['field' => 'latitude'])
                                </div>
                            </div>
                        </div>

                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Próximo') }}</button>
                        </div>
                        <input type="hidden" name="usuario_id" value="{{ $user->id }}">
                        <input type="hidden" name="especialista_id" value="{{ isset($user) ? $user->getIdEspecialista($user->id) : '' }}">
                    </form>
                </div>                    
            </div>
        </div>
    </div>

    <script src="{{env('MAP_APP_URL_KEY')}}" async defer></script>
    <script>
        $('#cep').on('input', function() {
            let cep = this.value
            $('#endereco-especialista').hide();
            $('#clinicas').prop('disabled', true);

            if (cep.length >= 8) {
                $('#clinicas').empty();
                
                // Adiciona option padrão
                $('#clinicas').append('<option value="">Carregando...</option>');
                $('#clinicas').prop('disabled', false);
                $.ajax({
                    url: '{{ route("clinicas.get-all")}}',
                    method: 'POST',
                    dataType: 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        'cep': cep.replace(/\D/g, '')
                    },
                    success: function(response) {
                        $('#clinicas').empty();
                    
                        $('#clinicas').append(
                            $('<option></option>').attr('value', null).text(null)
                        );

                        $.each(response.data, function(key, clinica) {
                            $('#clinicas').append(
                                $('<option></option>').attr('value', clinica.id).text(clinica.nome)
                            );
                        });
                        
                        $('#clinicas').append('<option value="">Novo local de atendimento</option>');
                    },
                    error: function(error) {
                        nowuiDashboard.showNotification('top', 'right', 'Ocorreu um problema ao consultar as clínicas cadastradas com o CEP informado, por favor tente novamente', 'danger');
                    }
                });
            }
        })
        
        $("#clinicas").change(function () {
            $(this).find(":selected").each(function () {
                //EXIBIR FORM COM MUDANÇAS
                if ($(this).val() == "") {
                    $('#endereco-especialista').show();
                    $('#documento').prop('required', true);
                    $('#nome_fantasia').prop('required', true);
                    $('#razao_social').prop('required', true);
                    $('#celular').prop('required', true);
                    $('#numero_atendimento_social_mensal').prop('required', true);
                    $('#anamnese_obrigatoria').prop('required', true);
                    $('#cidade').prop('required', true);
                    $('#estado').prop('required', true);
                    $('#endereco').prop('required', true);
                    $('#numero').prop('required', true);
                    $('#bairro').prop('required', true);
                    $('#longitude').prop('required', true);
                    $('#latitude').prop('required', true);
                } else {
                    $('#endereco-especialista').hide();
                    $('#documento').prop('required', false);
                    $('#nome_fantasia').prop('required', false);
                    $('#razao_social').prop('required', false);
                    $('#celular').prop('required', false);
                    $('#numero_atendimento_social_mensal').prop('required', false);
                    $('#anamnese_obrigatoria').prop('required', false);
                    $('#cidade').prop('required', false);
                    $('#estado').prop('required', false);
                    $('#endereco').prop('required', false);
                    $('#numero').prop('required', false);
                    $('#bairro').prop('required', false);
                    $('#longitude').prop('required', false);
                    $('#latitude').prop('required', false);
                }
            });            
        });

        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -3.68274, lng: -40.3512}, // Posição inicial do mapa
                zoom: 12 // Zoom inicial do mapa
            });

            @if(isset($entidade->latitude))
                var latitude = {{ $entidade->latitude }};                
                var longitude = {{ $entidade->longitude }};                       
                var myLatLng = {lat: latitude, lng: longitude};
                placeMarker(myLatLng, map);
            @endif

            // Adicionar um event listener para capturar o clique no mapa
            google.maps.event.addListener(map, 'click', function(event) {
                // Obter latitude e longitude do evento de clique              
                var latitude = event.latLng.lat();
                var longitude = event.latLng.lng();           

                // Atualizar os campos de entrada com a latitude e a longitude
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;  
                placeMarker(event.latLng, map);             
            });
        }

        // Função para colocar o marcador no local clicado
        function placeMarker(location, map) {
            // Remover marcador anterior, se houver
            if (window.marker) {
                window.marker.setMap(null);
            }
            // Criar um novo marcador
            window.marker = new google.maps.Marker({
                position: location,
                map: map
            });                    
        }        
    </script>
@endsection
