@extends('layouts.app', ['page' => __('especialistaclinica'), 'pageSlug' => 'especialistaclinica', 'class' => 'especialistaclinica'])
@section('title', 'Adicionar Especialista')
@section('content')

<!-- script para add funcao select2 do medicamento-->
<script>
    // Concept: Render select2 fields after all javascript has finished loading
    var initSelect2 = function() {
        // function that will initialize the select2 plugin, to be triggered later
        var renderSelect = function() {
            $('#especialista_id').each(function() {
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
    $(document).ready(function() {
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
      color: black !important; /* Substitua "blue" pela cor desejada */
   }
</style>

<!-- Modal para ENVIAR email de convite para um ESPECIALISTA, caso nao seja encontrado -->
<div class="modal fade" id="modalEnviarConvite" tabindex="-1" role="dialog"
 aria-labelledby="modalEnviarConvite" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="emailModalLabel">Enviar e-mail de convite</h5>
          <button type="button" class="close" id="close-modal1" 
             data-dismiss="modal" aria-label="Fechar">
               <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
        <form action="{{ route('clinica.enviarConviteEspecialista') }}" method="POST">
             @csrf
                <div class="mb-3">
                  <label for="recipientEmail" class="form-label">Nome do especialista</label>
                  <input style="color:black" type="text" class="form-control" id="nome" name="nome" 
                  placeholder="Digite o nome do especialista aqui" required>
                </div>

                <div class="mb-3">
                  <label for="recipientEmail" class="form-label">E-mail</label>
                  <input style="color:black" type="email" class="form-control" id="email_destino" name="email_destino" 
                  placeholder="Digite o e-mail do especialista aqui" required>
                </div>
              
            
            </div>
            <div class="modal-footer">
            <button type="button"  class="btn btn-secondary" data-dismiss="modal">
                              <i class="fa fa-reply"></i> Voltar
                            </button>
              <button type="submit" class="btn btn-primary">Enviar Convite</button>
            </div>
            </div>
        </form>
    </div>
</div>


<div class="row">
  <div class="col-md-12">
    <div class="card card-tasks">
      <div class="card-header">
        <h5 class="title">Adicionar vínculo com um novo especialista</h5>
      </div>
      <div class="card-body">
        <form method="post" action="{{route('especialistaclinica.save', $clinica->id)}}">
          @csrf
          <div class="col-md-10 px-8">
            <div class="form-group">
              <label id="labelFormulario">Especialista</label>             
              <select name="especialista_id" id="especialista_id" class="select2 form-control"
               title="Por favor selecionar ..."
                required style="border-color: white;">
                @foreach($especialistas as $iten)
                  <option value="{{old('especialista_id', $iten->id)}}"
                    @if($iten->id == $entidade->especialista_id) <?php    echo 'selected'; ?> @endif> {{$iten->nome}}</option>
                @endforeach
              </select>           
            
            </div>
          </div>

          <div class="row" style="padding-top:10%; width: 100%;">               
                <div class="col-12">
                  <p> Não encontrou o especialista? 
                      <a href="#" id="enviarConvite"  rel="tooltip" title="Convidar novo especialista" >                                       
                      Click aqui para enviar um convite.</a>   
                      </p>
                </div>
          </div>     


          </div>
          <div class="row" style="padding: 2%;">
          <input type="hidden" name="id" value="{{$entidade->id}}">
          <a href="{{route('especialistaclinica.list', $clinica->id)}}" class="btn btn-primary"><i
              class="fa fa-reply"></i> Voltar</a>

          <button class="btn btn-success" onclick="$('#send').click(); " style="margin-right: 5px;margin-left: 5px;">
            <i class="fa fa-save"></i>
              Salvar</button>


      </form>
    </div>
  </div>
</div>
<script>
document.getElementById('enviarConvite').addEventListener('click', function() {       
        // Abra o modal
        $('#modalEnviarConvite').modal('show');
    });
    </script>
@endsection