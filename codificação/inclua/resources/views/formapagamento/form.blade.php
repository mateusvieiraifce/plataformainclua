@extends('layouts.app',['page' => __('formapagamento'),'rotaPesquisa' => 'formapagamento.search', 'pageSlug' => 'formapagamento','class'=>'formapagamento'])
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
<form  method="post" action="{{route('formapagamento.save')}}" >
  @csrf

    <div class="col-md-5 px-8">
     <div class="form-group">
       <label id="labelFormulario">Descricao</label>
       <input style="border-color: #C0C0C0" type="text" class="form-control" name="descricao" required value="{{$entidade->descricao}}" maxlength="150">

  </div>
 </div>
    <input type="hidden" name ="id" value="{{$entidade->id}}">
    <a href="{{route('formapagamento.list')}}" class="btn btn-primary"><i class="fa fa-reply"></i><span> Voltar</span></a>
    <button class="btn btn-success" onclick="$('#send').click(); "><i class="fa fa-save"></i><span> Salvar</span></button>
  </div>
</form>
           </div>
            </div>
     </div>
@endsection
