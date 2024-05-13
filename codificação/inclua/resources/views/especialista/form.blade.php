@extends('layouts.app',['page' => __('especialista'),'rotaPesquisa' => 'especialista.search', 'pageSlug' => 'especialista','class'=>'especialista'])
@section('content')
<section class="bg0 p-t-104 p-b-116">
   <div class="container">
  <div class="row">

     <div class="col-md-12">
         <div class="card">
            <div class="card-header">
                <h5 class="title">Editar</h5>
            </div>
            <div class="card-body">
<form  method="post" action="{{route('especialista.save')}}" >
  @csrf

          <div class="col-md-5 px-8">
            <div class="form-group">
               <label id="labelFormulario">Nome</label>
               <input style="border-color: #C0C0C0" type="text" class="form-control" name="nome" required value="{{$entidade->nome}}" maxlength="150">

            </div>
          </div>
          <div class="col-md-5 px-8">
            <div class="form-group">
               <label id="labelFormulario">Telefone</label>
               <input style="border-color: #C0C0C0" type="text" class="form-control" name="telefone" required value="{{$entidade->telefone}}" maxlength="150">

            </div>
          </div>
   
     <input type="hidden" name ="id" value="{{$entidade->id}}">
     <input type="hidden" name ="usuario_id" value="{{$entidade->usuario_id}}">
    <a href="{{route('especialista.list')}}" class="btn btn-primary"><i class="fa fa-reply"></i><span> Voltar</span></a>
    <button class="btn btn-success" onclick="$('#send').click(); "><i class="fa fa-save"></i><span> Salvar</span></button>
  </div>
</form>
           </div>
            </div>
     </div>
@endsection
