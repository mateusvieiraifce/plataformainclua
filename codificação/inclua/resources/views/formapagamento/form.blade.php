@extends('layouts.app', ['page' => __('formapagamento'), 'rotaPesquisa' => 'formapagamento.search', 'pageSlug' => 'formapagamento', 'class' => 'formapagamento'])
@section('content')
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">
               <h5 class="title">Editar</h5>
            </div>
            <div class="card-body">
               <form method="post" action="{{route('formapagamento.save')}}">
                  @csrf

                  <div class="col-md-12 px-8">
                     <div class="form-group">
                        <label id="labelFormulario">Descrição</label>
                        <input style="border-color: #C0C0C0" type="text" class="form-control" name="descricao" required
                           value="{{$entidade->descricao}}" maxlength="150">
                     </div>
                  </div>

                  <input type="hidden" name="id" value="{{$entidade->id}}">
                  <a href="{{route('formapagamento.list')}}" class="btn btn-primary"><i class="fa fa-reply"></i>
                     Voltar</a>
                  <button class="btn btn-success" onclick="$('#send').click(); "><i class="fa fa-save"></i>
                     Salvar</button>

               </form>
            </div>
         </div>
      </div>
   </div>
   @endsection