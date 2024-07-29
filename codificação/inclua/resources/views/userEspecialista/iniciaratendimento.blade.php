@extends('layouts.app', ['page' => __('Consultas'), 'exibirPesquisa' => false, 'pageSlug' => 'listconsultaporespecialista', 'class' => 'agenda'])
@section('content')



<div class="card">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks" style="height: auto; min-height: 500px;">
            <div class="card-header">

               <div class="col-lg-12 col-md-12">
                  <form action="#" method="get" id="pesquisar">
                     @csrf
                     <label style="font-size: 20px"></label>
                     <fieldset>
                     
                     </fieldset>
                  </form>
               </div>

               <h6 class="title d-inline">Lista de consultas </h6>              
            </div>
            <div class="card-body">

               <div class="table-responsive">                  
                  
                
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection