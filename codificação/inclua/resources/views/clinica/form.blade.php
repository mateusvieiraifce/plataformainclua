@extends('layouts.app', ['page' => __('clinica'), 'rotaPesquisa' => 'clinica.search', 'pageSlug' => 'clinica', 'class' => 'clinica'])
@section('content')
@section('title', 'Clínica')

<form method="post" action="{{route('clinica.save')}}" enctype="multipart/form-data">
  @csrf
  <div class="row">
    <div class="col-md-9">

      <div class="card">
        <div class="card-header">
          <h5 class="title">Editar</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 px-8">
              <div class="form-group">
                <label id="labelFormulario">Nome fantasia</label>
                <input style="border-color: #C0C0C0" type="text" class="form-control" name="nome" required
                  value="{{ old('nome', $entidade->nome)}}" maxlength="150">
              </div>
            </div>
            <div class="col-md-12 px-8">
              <div class="form-group">
                <label id="labelFormulario">Razão social</label>
                <input style="border-color: #C0C0C0" type="text" class="form-control" name="razaosocial" required
                  value="{{old('razaosocial', $entidade->razaosocial)}}" maxlength="150">
              </div>
            </div>
            <div class="col-md-12 px-8">
              <div class="form-group">
                <label id="labelFormulario">CNPJ</label>
                <input style="border-color: #C0C0C0" type="text" class="form-control" name="cnpj" required
                  value="{{old('cnpj', $entidade->cnpj)}}" maxlength="150">
                @error('cnpj')
          O campo CNPJ não é um CNPJ válido ou já foi usado.
        @enderror
              </div>
            </div>


            <div class="col-md-12 px-8">
              <div class="form-group">
                <label id="labelFormulario">Telefone</label>
                <input style="border-color: #C0C0C0" type="tel" value="{{old('telefone', $entidade->telefone)}}"
                  name="telefone" id="telefone" class="form-control" maxlength="150" required>
              </div>
            </div>
            <div class="col-md-12 px-8">
              <div class="form-group">
                <label id="labelFormulario">Nº de atendimentos sociais mensais</label>
                <input style="border-color: #C0C0C0" type="number" class="form-control"
                  name="numero_atendimento_social_mensal" required
                  value="{{old('numero_atendimento_social_mensal', $entidade->numero_atendimento_social_mensal)}}"
                  maxlength="150">
              </div>
            </div>

          </div>

        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h5 class="title"> Endereço</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 px-8">
              <div class="form-group{{ $errors->has('cep') ? ' has-danger' : '' }}">
                <label id="cep">{{ __('CEP') }}</label>
                <input style="border-color: #C0C0C0" id="cep_input" type="text" name="cep"
                  class="form-control{{ $errors->has('cep') ? ' is-invalid' : '' }}"
                  value="{{ old('cep', $entidade->cep) }}" onblur="pesquisacep(this.value);" maxlength="150">
              </div>
            </div>
            <div class="col-md-12 px-8">
              <div class="form-group">
                <label id="labelFormulario">Estado</label>
                <input id="estado" style="border-color: #C0C0C0" type="text" class="form-control" name="estado"
                  value="{{ old('estado', $entidade->estado)}}" maxlength="150">
              </div>
            </div>
            <div class="col-md-12 px-8">
              <div class="form-group">
                <label id="labelFormulario">Cidade</label>
                <input id="cidade" style="border-color: #C0C0C0" type="text" class="form-control" name="cidade" required
                  value="{{old('cidade', $entidade->cidade)}}" maxlength="150">
              </div>
            </div>
            <div class="col-md-12 px-8">
              <div class="form-group">
                <label id="labelFormulario">Bairro</label>
                <input id="bairro" style="border-color: #C0C0C0" type="text" class="form-control" name="bairro" required
                  value="{{old('bairro', $entidade->bairro)}}" maxlength="150">
              </div>
            </div>
            <div class="col-md-12 px-8">
              <div class="form-group">
                <label id="labelFormulario">Rua</label>
                <input id="rua" style="border-color: #C0C0C0" type="text" class="form-control" name="rua" required
                  value="{{old('rua', $entidade->rua)}}" maxlength="150">
              </div>
            </div>
            <div class="col-md-12 px-8">
              <div class="form-group">
                <label id="labelFormulario">Número</label>
                <input id="numero" style="border-color: #C0C0C0" type="text" class="form-control" name="numero" required
                  value="{{old('numero', $entidade->numero)}}" maxlength="150">
              </div>
            </div>

            <div class="col-md-12 px-8">
              <div class="form-group">
                <label id="labelFormulario">Longitude</label>
                <input style="border-color: #C0C0C0" type="number" step="0.000000000000001" class="form-control"
                  name="longitude"   id="longitude"  required value="{{old('longitude', $entidade->longitude)}}" maxlength="150">
              </div>
            </div>
            <div class="col-md-12 px-8">
              <div class="form-group">
                <label id="labelFormulario">Latitude</label>
                <input style="border-color: #C0C0C0" type="number" step="0.000000000000001" class="form-control"
                  name="latitude"   id="latitude"  required value="{{old('latitude', $entidade->latitude)}}" maxlength="150">
              </div>
            </div>


            <input type="hidden" name="id" value="{{$entidade->id}}">
          </div>
        </div>
      </div>



      <div class="card">
        <div class="card-header">
          <h5 class="title"> Dados do usuário</h5>
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-md-12 px-8">
              <div class="form-group">
                <label id="labelFormulario">Nome</label>
                <input style="border-color: #C0C0C0" type="text" class="form-control" name="nome_login" required
                  value="{{old('nome_login', $usuario->nome_completo)}}" maxlength="150">
              </div>
            </div>
            <div class="col-md-12 px-8">
              <div class="form-group">
                <label id="labelFormulario">E-mail para login</label>
                <input style="border-color: #C0C0C0" type="email" class="form-control" name="email" required
                  value="{{old('email', $usuario->email)}}" maxlength="150">
                @error('email')
          O e-mail já foi usado.
        @enderror
              </div>
            </div>
            <div class="col-md-12 px-8">
              <div class="form-group">
                <label id="labelFormulario">Senha</label>
                <input type="password" style="border-color: #C0C0C0" class="form-control" name="password"
                  @if(!$entidade->usuario_id) 
                      required  minlength="8"
                  @else
                      minlength="8"
                  @endif 
                  value="" maxlength="15"></div>
                 </div>
            <div class="col-md-12 px-8">
            <div class="form-group">
              <label id="labelFormulario">Confirmar senha</label>
              <input type="password" style="border-color: #C0C0C0" class="form-control" name="password_confirmation"
                @if(!$entidade->usuario_id) required @endif value="" maxlength="15">
                @error('password')
                Por favor, verifique se a senha corresponde ao campo de confirmação da senha.
                @enderror
            </div>
              </div>
          </div>
          <input type="hidden" name="id" value="{{$entidade->id}}">
          <input type="hidden" name="usuario_id" value="{{$entidade->usuario_id}}">
        </div>
      </div>

      <a href="{{route('clinica.list')}}" class="btn btn-primary"><i class="fa fa-reply"></i> Voltar</a>

      <button class="btn btn-success" onclick="$('#send').click(); "><i class="fa fa-save"></i> Salvar</button>

    </div>

    <div class="col-md-3">
      <div class="card card-user">
        <div class="card-body">
          <p class="card-text">
          <div class="author">
            <div class="block block-one"></div>
            <div class="block block-two"></div>
            <div class="block block-three"></div>
            <h3 class="title">Logo da clínica</h3>

            <?php 
                                //verificando se existe imagem 
            if (isset($entidade->logotipo)) {
                                ?>
            <img id="preview" src={{"/images/logosclinicas/" . $entidade->logotipo}} alt="IMG-LOGO"
              style="max-width: 200px; max-height: 200px;">
            <?php } else { ?>
            <img id="preview" src={{"/assets/img/logo-01.png"}} alt="IMG-LOGO"
              style="max-width: 200px; max-height: 200px;">
            <?php } ?>

            </br>
            </br>

            <div class="custom-file">


              <input class="custom-file-input" type="file" style="max-width: 200px; max-height: 200px;" id="image"
                name="image" onchange="visualizarImagem(event)">
              <label class="btn custom-file-label" for="image">Escolha um arquivo</label>
            </div>
            <style>
              .custom-file-input {
                display: none;
              }

              .custom-file-label {
                cursor: pointer;
                padding-right: 80px;
                left: 0;
                right: 0;
                top: 0;
                bottom: 0;
                z-index: 1;
              }
            </style>

            <script>
              document.getElementById('image').addEventListener('change', function () {
                var fileName = $(this).val().split('\\').pop();
                //  $(this).next('.custom-file-label').html(fileName);                                  
              });

            </script>
            <script>
              function visualizarImagem(event) {
                var input = event.target;
                var reader = new FileReader();
                reader.onload = function () {
                  var preview = document.getElementById('preview');
                  preview.src = reader.result;
                  preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
              }
            </script>
          </div>
          </p>
        </div>
      </div>
   
     
      <div class="card card-user">
        <div class="card-body">         
            <h5 class="title">Geolocalização</h5>            
            <div id="map"></div>   
                       
          </div>
          
          <style>
               /* Estilo básico para o mapa */
                #map {
                    height: 15em;
                    width: 15em;
                }
            </style>
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
      </div>
   
   
   
    </div>

   

    </div>
  </div>

</form>












<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<script>
  $(document).ready(function ($) {
    $("#cep_input").mask("00000-000");
    $('#telefone').mask("(00) 0 0000-0000");
  });

  function meu_callback(conteudo) {
    if (!("erro" in conteudo)) {
      document.getElementById('rua').value = (conteudo.logradouro);
      document.getElementById('bairro').value = (conteudo.bairro);
      localidade = (conteudo.localidade);
      document.getElementById('cidade').value = localidade;
      document.getElementById('estado').value = (conteudo.uf);
    } else {
      alert("CEP não encontrado.");
    }
  }

  function pesquisacep(valor) {

    //Nova variável "cep" somente com dígitos.
    var cep = valor.replace(/\D/g, '');

    //Verifica se campo cep possui valor informado.
    if (cep != "") {

      //Expressão regular para validar o CEP.
      var validacep = /^[0-9]{8}$/;

      //Valida o formato do CEP.
      if (validacep.test(cep)) {
        //Preenche os campos com "..." enquanto consulta webservice.
        document.getElementById('rua').value = "...";
        document.getElementById('bairro').value = "...";
        document.getElementById('cidade').value = "...";
        document.getElementById('estado').value = "...";

        //Cria um elemento javascript.
        var script = document.createElement('script');

        //Sincroniza com o callback.

        ///     script.src = 'busca_cep.php?cep=00000001';

        script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

        //Insere script no documento e carrega o conteúdo.
        document.body.appendChild(script);

      } //end if.
      else {
        alert("Formato de CEP inválido.");
      }
    } //end if.
    else {

    }
  };

</script>


@endsection