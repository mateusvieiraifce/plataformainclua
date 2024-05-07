@extends('layouts.app',['page' => __('especialidade'),'rotaPesquisa' => 'especialidade.search', 'pageSlug' => 'especialidade','class'=>'especialidade'])
@section('content')
<section class="bg0 p-t-104 p-b-116">
   <div class="container">
  <div class="row">

     <div class="col-md-10">
         <div class="card">
            <div class="card-header">
                <h5 class="title">Editar</h5>
            </div>
            <div class="card-body">
<form  method="post" action="{{route('especialidade.save')}}" >
  @csrf

    <div class="col-md-5 px-8">
     <div class="form-group">
       <label id="labelFormulario">Descricao</label>
       <input style="border-color: #C0C0C0" type="text" class="form-control" name="descricao" required value="{{$entidade->descricao}}" maxlength="150">

  </div>
 </div>
    <div class="col-md-5 px-8">
     <div class="form-group">
       <label id="labelFormulario">Valorpadrao</label>
       <input style="border-color: #C0C0C0" type="text" class="form-control" name="valorpadrao" required value="{{$entidade->valorpadrao}}" maxlength="150">

  </div>
 </div>
    <input type="hidden" name ="id" value="{{$entidade->id}}">
    <a href="{{route('especialidade.list')}}" class="btn btn-primary"><i class="fa fa-reply"></i><span> Voltar</span></a>
    <button class="btn btn-success" onclick="$('#send').click(); "><i class="fa fa-save"></i><span> Salvar</span></button>
  </div>
</form>
           </div>
            </div>
     </div>
@endsection
