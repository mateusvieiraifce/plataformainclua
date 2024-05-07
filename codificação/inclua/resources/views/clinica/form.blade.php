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
                  <div class="col-md-3 px-8">
                    <div class="form-group">
                      <label id="labelFormulario">Nome fantasia</label>
                      <input style="border-color: #C0C0C0" type="text" class="form-control" name="nome" required value="{{$entidade->nome}}" maxlength="150">
                    </div>
                  </div>
                  <div class="col-md-3 px-8">
                    <div class="form-group">
                        <label id="labelFormulario">Razão social</label>
                        <input style="border-color: #C0C0C0" type="text" class="form-control" name="razaosocial" required value="{{$entidade->razaosocial}}" maxlength="150">
                    </div>
                  </div>
                <div class="col-md-3 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">CNPJ</label>
                    <input style="border-color: #C0C0C0" type="text" class="form-control" name="cnpj" required value="{{$entidade->cnpj}}" maxlength="150">
                  </div>
                </div>
                <div class="col-md-3 px-8">
              <div class="form-group">
                <label id="labelFormulario">Telefone</label>
                <input style="border-color: #C0C0C0" type="text" class="form-control" name="telefone" required value="{{$entidade->telefone}}" maxlength="150">
            </div>
          </div>
         
          

                  <div class="col-md-2 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Cep</label>
                    <input style="border-color: #C0C0C0" type="text" class="form-control" name="cep" required value="{{$entidade->cep}}" maxlength="150">
                </div>
              </div>
              <div class="col-md-3 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Cidade</label>
                    <input style="border-color: #C0C0C0" type="text" class="form-control" name="cidade" required value="{{$entidade->cidade}}" maxlength="150">
                </div>
              </div>
                <div class="col-md-3 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Bairro</label>
                  <input style="border-color: #C0C0C0" type="text" class="form-control" name="bairro" required value="{{$entidade->bairro}}" maxlength="150">
              </div>
            </div>
            <div class="col-md-4 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Rua</label>
                  <input style="border-color: #C0C0C0" type="text" class="form-control" name="rua" required value="{{$entidade->rua}}" maxlength="150">
              </div>
            </div>
              <div class="col-md-2 px-8">
              <div class="form-group">
                <label id="labelFormulario">Número</label>
                <input style="border-color: #C0C0C0" type="text" class="form-control" name="numero" required value="{{$entidade->numero}}" maxlength="150">
            </div>
          </div>
          
              <div class="col-md-2 px-8">
              <div class="form-group">
                <label id="labelFormulario">Longitude</label>
                <input style="border-color: #C0C0C0" type="text" class="form-control" name="longitude" required value="{{$entidade->longitude}}" maxlength="150">
            </div>
          </div>
              <div class="col-md-2 px-8">
              <div class="form-group">
                <label id="labelFormulario">Latitude</label>
                <input style="border-color: #C0C0C0" type="text" class="form-control" name="latitude" required value="{{$entidade->latitude}}" maxlength="150">
            </div>
          </div>
          
            <div class="col-md-4 px-8">
            <div class="form-group">
              <label id="labelFormulario">Nº de atendimentos sociais mensais</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="numero_atendimento_social_mensal" required value="{{$entidade->numero_atendimento_social_mensal}}" maxlength="150">
          </div>
        </div>
      


      
          
    <input type="hidden" name ="id" value="{{$entidade->id}}">
    </div>
    <button class="btn btn-success" onclick="$('#send').click(); "><i class="fa fa-save"></i><span> Salvar</span></button>
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
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="logotipo" required value="{{$entidade->logotipo}}" maxlength="150">
              </div>
            </div>
        <div class="col-md-4 px-8">
            <div class="form-group">
              <label id="labelFormulario">E-mail para login</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="logotipo" required value="{{$entidade->logotipo}}" maxlength="150">
          </div>
        </div>
        <div class="col-md-4 px-8">
            <div class="form-group">
              <label id="labelFormulario">Senha</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="logotipo" required value="{{$entidade->logotipo}}" maxlength="150">
          </div>
        </div>
        </div>
    <input type="hidden" name ="id" value="{{$entidade->id}}">       
    <button class="btn btn-success" onclick="$('#send').click(); "><i class="fa fa-save"></i><span> Salvar</span></button>
    </div>
    </div>
    <a href="{{route('clinica.list')}}" class="btn btn-primary"><i class="fa fa-reply"></i><span> Voltar</span></a>
  
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
 

@endsection
