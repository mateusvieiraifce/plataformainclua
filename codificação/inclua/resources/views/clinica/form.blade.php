@extends('layouts.app', ['page' => __('clinica'), 'rotaPesquisa' => 'clinica.search', 'pageSlug' => 'clinica', 'class' => 'clinica'])
@section('content')

   <div class="row">
      <div class="col-md-9"> 
      <form  method="post" action="{{route('clinica.save')}}" >
            @csrf     
         <div class="card">
            <div class="card-header">
                <h5 class="title">Editar</h5>
            </div>
            <div class="card-body">
            <form  method="post" action="{{route('clinica.save')}}" >
            @csrf
                <div class="row">
                  <div class="col-md-6 px-8">
                    <div class="form-group">
                      <label id="labelFormulario">Nome fantasia</label>
                      <input style="border-color: #C0C0C0" type="text" class="form-control" name="nome" required value="{{$entidade->nome}}" maxlength="150">
                    </div>
                  </div>
                  <div class="col-md-6 px-8">
                    <div class="form-group">
                        <label id="labelFormulario">Razão social</label>
                        <input style="border-color: #C0C0C0" type="text" class="form-control" name="razaosocial" required value="{{$entidade->razaosocial}}" maxlength="150">
                    </div>
                  </div>
                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">CNPJ</label>
                    <input style="border-color: #C0C0C0" type="text" class="form-control" name="cnpj" required value="{{$entidade->cnpj}}" maxlength="150">
                  </div>
                </div>


                <div class="col-md-4 px-8">
                    <div class="form-group">
                        <label id="labelFormulario">Telefone</label>
                        <input style="border-color: #C0C0C0" type="tel"
                                value="{{$entidade->telefone}}"
                                name="telefone" id="telefone" class="form-control"
                                maxlength="150"
                                required>
                    </div>
                </div>
                <div class="col-md-4 px-8">
            <div class="form-group">
              <label id="labelFormulario">Nº de atendimentos sociais mensais</label>
              <input style="border-color: #C0C0C0" type="number" class="form-control" name="numero_atendimento_social_mensal" required value="{{$entidade->numero_atendimento_social_mensal}}" maxlength="150">
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
                <div class="col-md-3 px-8">
                    <div class="form-group{{ $errors->has('cep') ? ' has-danger' : '' }}">
                        <label id="cep">{{ __('CEP') }}</label>
                        <input style="border-color: #C0C0C0" id="cep_input" type="text" name="cep"
                                class="form-control{{ $errors->has('cep') ? ' is-invalid' : '' }}"
                                value="{{ old('cep', $entidade->cep) }}"
                                onblur="pesquisacep(this.value);"
                                maxlength="150">
                    </div>
                </div>
                <div class="col-md-3 px-8">
                      <div class="form-group">
                          <label id="labelFormulario">Estado</label>
                          <input id="estado" style="border-color: #C0C0C0" type="text"
                                  class="form-control" name="estado"
                                  value="{{$entidade->estado}}" maxlength="150">
                      </div>
                  </div>
              <div class="col-md-3 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Cidade</label>
                    <input id="cidade" style="border-color: #C0C0C0" type="text" class="form-control" name="cidade" required value="{{$entidade->cidade}}" maxlength="150">
                </div>
              </div>
                <div class="col-md-3 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Bairro</label>
                  <input id="bairro" style="border-color: #C0C0C0" type="text" class="form-control" name="bairro" required value="{{$entidade->bairro}}" maxlength="150">
              </div>
            </div>
            <div class="col-md-4 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Rua</label>
                  <input  id="rua" style="border-color: #C0C0C0" type="text" class="form-control" name="rua" required value="{{$entidade->rua}}" maxlength="150">
              </div>
            </div>
              <div class="col-md-2 px-8">
              <div class="form-group">
                <label id="labelFormulario">Número</label>
                <input id="numero" style="border-color: #C0C0C0" type="text" class="form-control" name="numero" required value="{{$entidade->numero}}" maxlength="150">
            </div>
          </div>
          
              <div class="col-md-3 px-8">
              <div class="form-group">
                <label id="labelFormulario">Longitude</label>
                <input style="border-color: #C0C0C0" type="number" class="form-control" name="longitude" required value="{{$entidade->longitude}}" maxlength="150">
            </div>
          </div>
              <div class="col-md-3 px-8">
              <div class="form-group">
                <label id="labelFormulario">Latitude</label>
                <input style="border-color: #C0C0C0" type="number" class="form-control" name="latitude" required value="{{$entidade->latitude}}" maxlength="150">
            </div>
          </div>
            
          
    <input type="hidden" name ="id" value="{{$entidade->id}}">
    </div>
            </div>
        </div>



           <div class="card">
            <div class="card-header">
                <h5 class="title"> Dados do usuário</h5>
            </div>
            <div class="card-body">
                <div class="row">
            <div class="col-md-4 px-8">
            <div class="form-group">
              <label id="labelFormulario">Nome</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="nome_login" required value="{{$usuario->name}}" maxlength="150">
              </div>
            </div>
        <div class="col-md-4 px-8">
            <div class="form-group">
              <label id="labelFormulario">E-mail para login</label>
              <input style="border-color: #C0C0C0" type="email" class="form-control" name="email" required value="{{$usuario->email}}" maxlength="150">
              @error('email')
                O e-mail já foi usado.
                @enderror
            </div>
        </div>
        <div class="col-md-4 px-8">
          <div class="form-group">
                <label id="labelFormulario">Senha</label>
                <input type="password" style="border-color: #C0C0C0" class="form-control"
                        name="password" required
                        value="" maxlength="15">
             
            </div>
          </div>
        </div>
    <input type="hidden" name ="id" value="{{$entidade->id}}">  
    <input type="hidden" name ="usuario_id" value="{{$entidade->usuario_id}}">       
     </div>
    </div>
    
    <a href="{{route('clinica.list')}}" class="btn btn-primary"><i class="fa fa-reply"></i><span> Voltar</span></a>
  
    <button class="btn btn-success" onclick="$('#send').click(); "><i class="fa fa-save"></i><span> Salvar</span></button>
  
    </div>
  </form>
          
      <div class="col-md-3">
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
                          <h5 class="title">Logo da clínica</h5>
                      </a>

                  </div>
              </p>

          </div>
         
      </div>
      </div>     
   </div>
 


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
