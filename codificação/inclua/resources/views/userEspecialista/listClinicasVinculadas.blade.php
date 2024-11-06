@extends('layouts.app', ['page' => __('clinicas'), 'pageSlug' => 'clinicas', 'class' => 'especialistaclinica'])
@section('content')
@section('title', 'Clínicas')
<div class="card">

   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks">
            <div class="card-header">
               <h6 class="title d-inline">Lista de clínicas vinculadas </h6>              
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <th> Clínica </th>
                        
                        <th>Financeiro </th>
                        <th>Vínculo </th>
                     </thead>
                     <tbody>
                        @if(sizeof($lista) > 0)
                         @foreach($lista as $ent)
                           <tr>
                           <td>{{$ent->nome}}</td>                        
                          
                           <td>
                              <a rel="tooltip" title="Editar" class="btn btn-link" data-original-title="Edit"
                              href="{{route('especialistaclinica.edit', $ent->id)}}">
                              <i class="tim-icons icon-money-coins"> &nbsp Financeiro</i>
                              </a>
                           </td>
                           <td>
                           @if($ent->isVinculado)
                                 <label class="title" style="font-color:write">Ativo
                                 </label>                             
                           @else
                                 <p class="title">Inativo                                
                                 </p>                              
                           @endif                              
                           </td>
                           <td>                               
                              @if($ent->isVinculado)
                              <a href="{{route('especialistaclinica.cancelarVinculo', [$ent->id, $especialista->id])}}" 
                              onclick="return confirm('Deseja relamente excluir o vínculo?')" rel="tooltip"
                                    title="Excluir vínculo" class="btn btn-link" data-original-title="Remove">
                                    <i class="tim-icons icon-simple-remove"></i>
                                 </a>
                              @else
                              <a href="{{route('especialistaclinica.cancelarVinculo', [$ent->id, $especialista->id])}}" 
                              onclick="return confirm('Deseja retomar vínculo?')" rel="tooltip"
                                    title="Vincular novamente" class="btn btn-link" data-original-title="Remove">
                                    <i class="tim-icons icon-check-2"></i>
                                    </a>
                              @endif  
                           </td>
                            @endforeach 
                     @endif                     
                   </tbody>
                  </table>
                  <div>
                     {{$lista->appends(request()->query())->links()}} 
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
   @endsection