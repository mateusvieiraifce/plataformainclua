@extends('layouts.app', ['page' => __('Fila'), 'exibirPesquisa' => false, 'pageSlug' => 'fila', 'class' => 'fila'])
@section('title', 'Fila')
@section('content')

<!-- script para add funcao select2 do medicamento-->
<script>
   // Concept: Render select2 fields after all javascript has finished loading
   var initSelect2 = function () {
      // function that will initialize the select2 plugin, to be triggered later
      var renderSelect = function () {
         $('#especialista_id').each(function () {
            $(this).select2({
               // dropdownParent: $('#modalPedirMedicamento')                   
            });
         })
      };

      // create select2 HTML elements
      var style = document.createElement('link');
      var script = document.createElement('script');
      style.rel = 'stylesheet';
      style.href = 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css';
      script.type = 'text/javascript';
      script.src = 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.full.min.js';
      // trigger the select2 initialization once the script tag has finished loading
      script.onload = renderSelect;
      // render the style and script tags into the DOM
      document.getElementsByTagName('head')[0].appendChild(style);
      document.getElementsByTagName('head')[0].appendChild(script);

   };
</script>

<!-- inicializando o select2-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   var select2Inicializado = false;
   $(document).ready(function () {
      if (!select2Inicializado) {
         // Inicializar o select2
         initSelect2();
         select2Inicializado = true;
      }
   });
</script>
<!-- formatacao css do select2-->
<style>
   /* Estiliza o texto das opções no dropdown */
   .select2-container .select2-results__option {
      color: #111;
   }

   .select2-container .select2-selection--multiple .select2-selection__choice {
      color: black !important;
      /* Substitua "blue" pela cor desejada */
   }
</style>


<div class="row">
   <div class="col-lg-12 col-md-12">
      <div class="card card-tasks">
         <div class="card-header">
            <h6 class="title d-inline">Escolha a clínica</h6>
         </div>
         <div class="card-body">
            <form method="post" action="{{route('fila.listUserEspecialista')}}">
               @csrf
               <div class="col-md-10 px-8">
                  <div class="form-group">
                     <label id="labelFormulario"></label>
                     <select name="clinica_id" id="clinica_id" class="select2 form-control"
                        title="Por favor selecionar ..." required style="border-color: white;">
                        @foreach($lista as $iten)
                     <option value="{{old('clinica_id', $iten->id)}}"> {{$iten->nome}}</option>
                  @endforeach
                     </select>

                  </div>
               </div>
            
             
          
         </div>
         <div class="col-2">
               <button class="btn btn-success" onclick="$('#send').click(); " style="margin-right: 5px;margin-left: 5px;">
               
                  Visualizar Fila</button>
                  </div>
                  </form>
      </div>
   </div>
</div>

@endsection