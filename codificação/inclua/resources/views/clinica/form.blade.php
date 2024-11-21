@extends('layouts.app', ['page' => __('clinica'), 'rotaPesquisa' => 'clinica.search', 'pageSlug' => 'clinica', 'class' => 'clinica'])
@section('content')
@section('title', 'Clínica')
    <form method="post" action="{{ route('clinica.save') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Dados da clínica</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="cnpj">
                                CNPJ
                            </label>
                            <div class="input-group{{ $errors->has('cnpj') ? ' has-danger' : '' }}">
                                <input type="text" id="cnpj" class="form-control {{ $errors->has('cnpj') ? 'is-invalid' : '' }}"
                                    name="cnpj" placeholder="CNPJ" oninput="mascaraCnpj(this)" onblur="consultarCNPJ(this)"
                                        value="{{ old('cnpj') ?? (isset($clinica) ? $clinica->cnpj : null) }}">
                                @include('alerts.feedback', ['field' => 'cnpj'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="nome_fantasia">
                                Nome fantasia
                            </label>
                            <div class="input-group{{ $errors->has('nome_fantasia') ? ' has-danger' : '' }}">
                                <input type="text" id="nome_fantasia" class="form-control {{ $errors->has('nome_fantasia') ? 'is-invalid' : '' }}"
                                    name="nome_fantasia" placeholder="Nome" value="{{ old('nome_fantasia') ?? (isset($clinica) ? $clinica->nome : null) }}">
                                @include('alerts.feedback', ['field' => 'nome_fantasia'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="razao_social">
                                Razão social
                            </label>
                            <div class="input-group{{ $errors->has('razao_social') ? ' has-danger' : '' }}">
                                <input type="text" id="razao_social" class="form-control {{ $errors->has('razao_social') ? 'is-invalid' : '' }}"
                                    name="razao_social" placeholder="Razão social" value="{{ old('razao_social') ?? (isset($clinica) ? $clinica->razaosocial : null) }}">
                                @include('alerts.feedback', ['field' => 'razao_social'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="telefone">
                                Telefone
                            </label>
                            <div class="input-group{{ $errors->has('telefone') ? ' has-danger' : '' }}">
                                <input type="text" id="telefone" class="form-control {{ $errors->has('telefone') ? 'is-invalid' : '' }}"
                                    name="telefone" maxlength="14" placeholder="(**) ****-****" oninput="mascaraTelefone(this)"
                                    value="{{  old('telefone') ?? (isset($clinica) ? $clinica->getTelefone($clinica->usuario_id) : null) }}">
                                @include('alerts.feedback', ['field' => 'telefone'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="celular">
                                Celular
                            </label>
                            <div class="input-group{{ $errors->has('celular') ? ' has-danger' : '' }}">
                                <input type="text" id="celular" class="form-control {{ $errors->has('celular') ? 'is-invalid' : '' }}"
                                    name="celular" maxlength="15" placeholder="(**) 9****-****" oninput="mascaraCelular(this)"
                                    value="{{ old('celular') ?? (isset($clinica) ? $clinica->getCelular($clinica->usuario_id) : null) }}">
                                @include('alerts.feedback', ['field' => 'celular'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="numero_atendimento_social_mensal">
                                Nº de atendimentos sociais mensais
                            </label>
                            <div class="input-group{{ $errors->has('numero_atendimento_social_mensal') ? ' has-danger' : '' }}">
                                <input type="number" id="numero_atendimento_social_mensal" class="form-control {{ $errors->has('numero_atendimento_social_mensal') ? 'is-invalid' : '' }}"
                                    name="numero_atendimento_social_mensal" placeholder="Nº de atendimentos sociais mensais" value="{{ old('numero_atendimento_social_mensal') ?? (isset($clinica) ? $clinica->numero_atendimento_social_mensal : null) }}">
                                @include('alerts.feedback', ['field' => 'numero_atendimento_social_mensal'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="anamnese_obrigatoria">
                                A Anamnese será obrigatória?
                            </label>
                            <div class="input-group{{ $errors->has('anamnese_obrigatoria') ? ' has-danger' : '' }}">
                                <select name="anamnese_obrigatoria" class="form-control {{ $errors->has('anamnese_obrigatoria') ? 'is-invalid' : '' }}">
                                    <option value="N" @if (isset($clinica) && $clinica->anamnese_obrigatoria ==  "N" || old('anamnese_obrigatoria') == "N") selected @endif selected>
                                        Não
                                    </option>
                                    <option value="S" @if (isset($clinica) && $clinica->anamnese_obrigatoria ==  "S" || old('anamnese_obrigatoria') == "S") selected @endif>
                                        Sim
                                    </option>
                                </select>
                                @include('alerts.feedback', ['field' => 'anamnese_obrigatoria'])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="title"> Endereço</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="cep">
                                CEP
                            </label>
                            <div class="input-group{{ $errors->has('cep') ? ' has-danger' : '' }}">
                                <input type="text" id="cep" class="form-control {{ $errors->has('cep') ? 'is-invalid' : '' }}"
                                    name="cep" placeholder="CEP" oninput="mascaraCep(this)" onblur="validarCep(this)" maxlength="9"
                                    value="{{ old('cep') ?? (isset($endereco) ? $endereco->cep : null) }}">
                                @include('alerts.feedback', ['field' => 'cep'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="cidade">
                                Cidade
                            </label>
                            <div class="input-group{{ $errors->has('cidade') ? ' has-danger' : '' }}">
                                <input type="text" id="cidade" class="form-control {{ $errors->has('cidade') ? 'is-invalid' : '' }}"
                                    name="cidade" placeholder="Cidade" value="{{ old('cidade') ?? (isset($endereco) ? $endereco->cidade : null) }}">
                                @include('alerts.feedback', ['field' => 'cidade'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="estado">
                                Estado
                            </label>
                            <div class="input-group{{ $errors->has('estado') ? ' has-danger' : '' }}">
                                <input id="estado" list="estados" name="estado" class="form-control {{ $errors->has('estado') ? 'is-invalid' : '' }}"
                                    placeholder="Selecione o estado" value="{{ (isset($endereco) ? $endereco->estado : null) ?? old('estado') }}">
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
                                Endereço
                            </label>
                            <div class="input-group{{ $errors->has('endereco') ? ' has-danger' : '' }}">
                                <input type="text" id="endereco" class="form-control {{ $errors->has('endereco') ? 'is-invalid' : '' }}"
                                    name="endereco" placeholder="Endereço" value="{{ old('endereco') ?? (isset($endereco) ? $endereco->rua : null) }}">
                                @include('alerts.feedback', ['field' => 'endereco'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="numero">
                                Número
                            </label>
                            <div class="input-group{{ $errors->has('numero') ? ' has-danger' : '' }}">
                                <input type="number" id="numero" class="form-control {{ $errors->has('numero') ? 'is-invalid' : '' }}"
                                    name="numero" placeholder="Número" value="{{ old('numero') ?? (isset($endereco) ? $endereco->numero : null) }}">
                                @include('alerts.feedback', ['field' => 'numero'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bairro">
                                Bairro
                            </label>
                            <div class="input-group{{ $errors->has('bairro') ? ' has-danger' : '' }}">
                                <input type="text" id="bairro" class="form-control {{ $errors->has('bairro') ? 'is-invalid' : '' }}"
                                    name="bairro" placeholder="Bairro" value="{{ old('bairro') ?? (isset($endereco) ? $endereco->bairro : null) }}">
                                @include('alerts.feedback', ['field' => 'bairro'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label >
                                Localização
                            </label>
                            <div class="mapa" id="map"></div>
                        </div>                        
                        <div class="form-group">
                            <label for="longitude">
                                Longitude
                            </label>
                            <div class="input-group {{ $errors->has('longitude') ? ' has-danger' : '' }}">
                                <input type="text" id="longitude" class="form-control only-numbers {{ $errors->has('longitude') ? ' is-invalid' : '' }}"
                                    name="longitude" placeholder="longitude" value="{{ (isset($endereco) ? $endereco->longitude : null) ?? old('longitude') }}">
                                @include('alerts.feedback', ['field' => 'longitude'])
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label for="latitude">
                                Latitude
                            </label>
                            <div class="input-group {{ $errors->has('latitude') ? ' has-danger' : '' }}">
                                <input type="text" id="latitude" class="form-control only-numbers {{ $errors->has('latitude') ? ' is-invalid' : '' }}"
                                    name="latitude" placeholder="latitude" value="{{ (isset($endereco) ? $endereco->latitude : null) ?? old('latitude') }}">
                                @include('alerts.feedback', ['field' => 'latitude'])
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="title">Dados do usuário</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nome_completo">
                                Nome
                            </label>
                            <div class="input-group{{ $errors->has('nome_completo') ? ' has-danger' : '' }}">
                                <input type="text" id="nome_completo" class="form-control {{ $errors->has('nome_completo') ? 'is-invalid' : '' }}"
                                    name="nome_completo" placeholder="Nome" value="{{ old('nome_completo') ?? (isset($usuario) ? $usuario->nome_completo : null) }}">
                                @include('alerts.feedback', ['field' => 'nome_completo'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email">
                                E-mail para login
                            </label>
                            <div class="input-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                                <input type="email" id="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    name="email" placeholder="E-mail" value="{{ old('email') ?? (isset($usuario) ? $usuario->email : null) }}">
                                @include('alerts.feedback', ['field' => 'email'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password">
                                Senha
                            </label>
                            <div class="input-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <input type="password" id="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                    name="password" placeholder="Senha" @if(!isset($clinica)) required @endif 
                                    value="" minlength="8" maxlength="15">
                                @include('alerts.feedback', ['field' => 'password'])
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">
                                Confirmar senha
                            </label>
                            <div class="input-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }}">
                                <input type="password" id="password_confirmation" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                    name="password_confirmation" placeholder="Confirmar senha" @if(!isset($clinica)) required @endif 
                                    value="" minlength="8" maxlength="15">
                                @include('alerts.feedback', ['field' => 'password_confirmation'])
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="{{route('clinica.list')}}" class="btn btn-primary"><i class="fa fa-reply"></i> Voltar</a>
                            <button class="btn btn-primary" onclick="$('#send').click();"><i class="fa fa-save"></i> Salvar</button>
                        </div>
                    </div>
                    
                    <input type="hidden" name="clinica_id" value="{{ isset($clinica) ? $clinica->id : null}}">
                    <input type="hidden" name="endereco_id" value="{{ isset($endereco) ? $endereco->id : null}}">
                    <input type="hidden" name="usuario_id" value="{{ isset($usuario) ? $usuario->id : null}}">
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
                                <h3 class="title">Logo da clínica</h3>
                                {{-- verificando se existe imagem  --}}
                                @if (isset($clinica->logotipo)) 
                                    <img id="preview" src={{ asset($clinica->logotipo)}} alt="IMG-LOGO"
                                        style="max-width: 200px; max-height: 200px;">
                                @else
                                    <img id="preview" src={{ "/assets/img/logo-01.png" }} alt="IMG-LOGO"
                                        style="max-width: 200px; max-height: 200px;">
                                @endif
                            </div>
                        </p>
                        <div class="custom-file justify-content-center">
                            <input class="custom-file-input hidden" type="file" id="image" name="image" onchange="visualizarImagem(event)" accept="image/jpeg,image/jpg,image/png">
                            <label class="btn custom-file-label {{ $errors->has('image') ? 'is-invalid' : '' }}" for="image">Escolha um arquivo</label>
                        </div>
                        @include('alerts.feedback', ['field' => 'image'])
                    </div>
                </div>
            </div>
        </div>
    </form>
    
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
        
        function visualizarImagem(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function(){
                var preview = document.getElementById('preview');
                preview.src = reader.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
@endsection