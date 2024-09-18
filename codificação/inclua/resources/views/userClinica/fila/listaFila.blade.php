@extends('layouts.app', ['page' => __('Fila'), 'exibirPesquisa' => false, 'pageSlug' => 'fila', 'class' => 'fila'])
@section('title', 'Fila')
@section('content')


<div class="row">
   <div class="col-lg-12 col-md-12">
      <div class="card card-tasks">
         <div class="card-header">
            <h6 class="title d-inline">Fila</h6>
         </div>
         <form method="post" action="#">
            @csrf
          
         
            <div class="row" style="padding-top: 30%;padding-left: 2%;">
            
            <a href="{{route('fila.listEspecialistaDaClinica')}}" class="btn btn-primary"><i
            class="fa fa-reply"></i> Voltar</a>

            <button class="btn btn-success" onclick="$('#send').click(); " style="margin-right: 5px;margin-left: 5px;">
             
              Salvar</button>
               </div>

             
         </form>
      </div>
   </div>
</div>

@endsection