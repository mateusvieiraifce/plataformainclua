@extends('layouts.app', ['class' => 'register-page', 'contentClass' => 'register-page', 'pageSlug' => 'registre'])
@section('title', 'Cadastro de Endereço')
@section('content')
    <div class="row">
        <div class="col-md-7 mr-auto">
            <div class="card card-register card-white">
                <div class="card-img">
                    <img class="img-card" src="{{ asset('assets/img/logo-01.png') }}" alt="Card image" >
                </div>
                <div class="card-header">
                    <h2 class="title">Cadastro de endereço</h2>
                </div>
                <div class="card-body">                    
                    <form class="form" method="post" action="{{ route('clinica.store.endereco') }}">
                        @csrf
                        <div class="form-group">
                            <label for="cep">
                                CEP <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('cep') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="cep" class="form-control border-full {{ $errors->has('cep') ? ' is-invalid' : '' }}" oninput="mascaraCep(this)"
                                    name="cep" maxlength="9" placeholder="CEP" onblur="validarCep(this)" value="{{ (isset($clinica) ? $clinica->cep : null) ?? old('cep') }}" required>
                                @include('alerts.feedback', ['field' => 'cep'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="cidade">
                                Cidade <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('cidade') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="cidade" class="form-control border-full {{ $errors->has('cidade') ? ' is-invalid' : '' }}"
                                    name="cidade" placeholder="Cidade" value="{{ (isset($clinica) ? $clinica->cidade : null) ?? old('cidade') }}" required>
                                @include('alerts.feedback', ['field' => 'cidade'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="estado">
                                Estado <span class="required">*</span>
                            </label>
                            <div class="input-group input-medium{{ $errors->has('estado') ? ' has-danger' : '' }}">
                                <input id="estado" list="estados" name="estado" class="form-control border-full {{ $errors->has('estado') ? 'is-invalid' : '' }}"
                                    placeholder="Selecione o estado" value="{{ (isset($clinica) ? $clinica->estado : null) ?? old('estado') }}" required>
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
                                    name="endereco" placeholder="Endereço" value="{{ (isset($clinica) ? $clinica->rua : null) ?? old('endereco') }}" required>
                                @include('alerts.feedback', ['field' => 'endereco'])
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="numero">
                                Número <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('numero') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="numero" class="form-control border-full only-numbers {{ $errors->has('numero') ? ' is-invalid' : '' }}"
                                    name="numero" placeholder="Número" value="{{ (isset($clinica) ? $clinica->numero : null) ?? old('numero') }}" required>
                                @include('alerts.feedback', ['field' => 'numero'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="bairro">
                                Bairro <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('bairro') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="bairro" class="form-control border-full {{ $errors->has('bairro') ? ' is-invalid' : '' }}"
                                    name="bairro" placeholder="Bairro" value="{{ (isset($clinica) ? $clinica->bairro : null) ?? old('bairro') }}" required>
                                @include('alerts.feedback', ['field' => 'bairro'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="complemento">
                                Complemento
                            </label>
                            <div class="input-group {{ $errors->has('complemento') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="complemento" class="form-control border-full {{ $errors->has('complemento') ? ' is-invalid' : '' }}"
                                    name="complemento" placeholder="Complemento" value="{{ (isset($clinica) ? $clinica->complemento : null) ?? old('complemento') }}">
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
                                    name="longitude" placeholder="longitude" value="{{ (isset($clinica) ? $clinica->longitude : null) ?? old('longitude') }}" required>
                                @include('alerts.feedback', ['field' => 'longitude'])
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="latitude">
                                Latitude <span class="required">*</span>
                            </label>
                            <div class="input-group {{ $errors->has('latitude') ? ' has-danger' : '' }} input-medium">
                                <input type="text" id="latitude" class="form-control border-full only-numbers {{ $errors->has('latitude') ? ' is-invalid' : '' }}"
                                    name="latitude" placeholder="latitude" value="{{ (isset($clinica) ? $clinica->latitude : null) ?? old('latitude') }}" required>
                                @include('alerts.feedback', ['field' => 'latitude'])
                            </div>
                        </div>

                        <div class="input-group">
                            <button type="submit" class="btn btn-primary btn-round btn-lg">{{ __('Finalizar') }}</button>
                        </div>
                        <input type="hidden" name="usuario_id" value="{{ $clinica->usuario_id }}">
                        <input type="hidden" name="clinica_id" value="{{ $clinica->id }}">
                    </form>
                </div>                    
            </div>
        </div>
    </div>
    
    <script src="{{env('MAP_APP_URL_KEY')}}" async defer></script>
    <script>
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
