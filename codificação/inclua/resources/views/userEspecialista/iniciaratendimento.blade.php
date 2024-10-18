@extends('layouts.app', ['page' => __('Consultas'), 'exibirPesquisa' => false, 'pageSlug' => 'listconsultaporespecialista', 'class' => 'agenda'])
@section('content')

<!-- script para add funcao select2 do medicamento-->
<script>
    // Concept: Render select2 fields after all javascript has finished loading
    var initSelect2 = function() {
        // function that will initialize the select2 plugin, to be triggered later
        var renderSelect = function() {
            $('#medicamento_id').each(function() {
                $(this).select2({
                    dropdownParent: $('#modalPedirMedicamento')                   
                });               
            })

            $('#exame_id').each(function() {
                $(this).select2({
                    dropdownParent: $('#modalPedirExame')                   
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
        
        //mostrar o modal
        var mostrarModal = @json($mostrarModal);
       if(mostrarModal){
           $('#'+mostrarModal).modal('show');         
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


<!--formatacao do cronometro-->
<style>
   #chronometer {
      font-size: 1.5rem;
      color: #033;
      background: #fff;
      border: 2px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      text-align: center;
      /* Centraliza o texto horizontalmente */
      display: flex;
      /* Permite usar flexbox para o alinhamento */
      justify-content: center;
      /* Centraliza o texto horizontalmente com flexbox */
      align-items: center;
      /* Centraliza o texto verticalmente com flexbox */
      height: 70px;
   }
</style>


<!-- menu em forma de abas-->
<style>
   body {
      font-family: Arial, sans-serif;
   }

   .tab-container {
      width: 100%;
      margin: auto;
   }

   .tabs {
      display: flex;
      cursor: pointer;
   }

   .tab-button {
      flex: 1;
      padding: 10px;
      background-color: #f1f1f1;
      border: 1px solid #ddd;
      border-bottom: none;
      text-align: center;
      outline: none;
      cursor: pointer;
   }

   .tab-button.active {
      background-color: #fff;
      border-top: 2px solid #007bff;
      font-weight: bold;
      font-size: 18px;
   }

   .tab-content {
      border: 1px solid #ddd;
      padding: 20px;
      background-color: #fff;
   }

   .tab-pane {
      display: none;
   }

   .tab-pane.active {
      display: block;
   }

   @media (max-width: 768px) {
      .tabs {
         flex-direction: column;
      }

      .tab-button {
         border-bottom: 1px solid #ddd;
      }

      .tab-button:last-child {
         border-bottom: none;
      }
   }
</style>
<script>
   function openTab(event, tabId) {
      // Hide all tab panes
      var tabPanes = document.querySelectorAll('.tab-pane');
      tabPanes.forEach(pane => {
         pane.classList.remove('active');
      });

      // Remove active class from all tab buttons
      var tabButtons = document.querySelectorAll('.tab-button');
      tabButtons.forEach(button => {
         button.classList.remove('active');
      });

      // Show the clicked tab pane and add active class to the clicked tab button
      document.getElementById(tabId).classList.add('active');
      event.currentTarget.classList.add('active');
   }
</script>

<!--Customização para centralizar o modal verticalmente-->
<style>
   .modal-dialog {
      display: flex;
      justify-content: center;
      align-items: flex-start;
      /* Alinha o modal ao topo da tela */
      height: 10vh;
      /* Garante que o modal usa toda a altura da viewport */
      margin-left: 20%;
      /* Remove qualquer margem padrão */
   }

   .modal-content {
      border-radius: 0;
      /* Remove bordas arredondadas se necessário */
      height: auto;
      /* Ajusta a altura conforme o conteúdo */
   }

   .modal-dialog-cad-exame {
      display: flex;
      justify-content: center;
      align-items: flex-start;  
       /* Alinha o modal ao topo da tela */
       height: 10vh;
      /* Garante que o modal usa toda a altura da viewport */
      margin-left: 20%;
      margin-top: 5%;
      margin-right: 20%;
      /* Remove qualquer margem padrão */  
   }  
   .modal-dialog-cad-medicamento{
     
      justify-content: center;
      align-items: flex-start;  
       /* Alinha o modal ao topo da tela */
       height: 10vh;
      /* Garante que o modal usa toda a altura da viewport */
      margin-left: 20%;
      margin-top: 5%;
      margin-right: 20%;
   }
      
</style>

<!-- scrips para abrir e fechar os modais corretamete -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>
<script>
   function closeModal(modalId) {
    $('#' + modalId).hide(); 
    //resolve o problema na qual ocorria quando todos os modais eram fechadas, que era a 
    //de nao deixar clicar nos links.
    var backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
       backdrop.remove();
    }
    $('#' + modalId).modal('dispose')
  } 
  function openModal(modalId) { 
       $('#' + modalId).modal('show');
  }   
</script>



<!-- Modal add EXAME-->
<div class="modal fade" id="modalPedirExame" tabindex="-1" role="dialog" aria-labelledby="modalPedirExame"
   aria-hidden="true">
   <div class="modal-dialog  modal-dialog-top modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">
               <label>Favor selecionar o exame desejado</label>
            </h4>
            <button type="button" class="close" id="close-modal1"  onclick="closeModal('modalPedirExame')"
             data-dismiss="modal" aria-label="Fechar">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="container">
               <form method="post" action="{{route('pedido_exame.salveVarios')}}">
                  @csrf
               
                     <div class="col-md-12">
                          <div class="form-group">
                              <label id="labelFormulario">Selecionar exame:</label>                       
                                <select class="select2"  name="exames[]" multiple="multiple" 
                                    style="color:#2d3748; width: 100%; height: 39px; " 
                                    id="exame_id" class="form-control"
                                     title="Por favor selecionar o exame..." required>                                       
                                        @foreach($exames as $ent)
                                        <option data-color="red" value="{{old('exame+id', $ent->id)}}"                                       
                                        >
                                           {{$ent->nome}}
                                            </option>
                                        @endforeach
                                 </select>                         
                          </div>
                     </div>
                                    
                     <div class="row" style="padding-top:10%; width: 100%;">               
                           <div class="col-12">
                             <p> Não encontrou o exame? 
                                 <a href="#"  rel="tooltip" title="Adicionar novo exame"                         
                                 onclick="openModal('addNovoExameBDModal')">                       
                                 Click aqui para cadastrar.</a>   
                                 </p>
                           </div>
                     </div>                 
                  
                     <div class="modal-footer">
                        <button type="button"  onclick="closeModal('modalPedirExame')" class="btn btn-secondary" data-dismiss="modal">
                           <i class="fa fa-reply"></i> Voltar
                        </button>
                        <input type="hidden" name="consulta_id" value="{{$consulta->id}}">
                        <input type="submit" name="mover" class="btn btn-success" value="Adicionar pedido"></input>
                     </div>
                  
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Modal para add novo EXAME no bd caso nao seja encontrado -->
<div class="modal fade" id="addNovoExameBDModal" tabindex="-2" role="dialog"
 aria-labelledby="addNovoExameBDModal" aria-hidden="true">
    <div class="modal-dialog-cad-exame modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <label>Adicionar novo exame:</label>
                </h5>
                <button type="button" class="close" id="close-modal2" onclick="closeModal('addNovoExameBDModal')"
                 data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <!--aqui a rota de salvar o novo exame -->
                    <form method="post" action="{{route('especialista.salvaNovoExame')}}">
                        @csrf
                        <div class="row">
                           
                           <div class="col-md-12 px-8">
                              <div class="form-group">
                                 <label id="labelFormulario">Nome</label>
                                 <input style="border-color: #111; color: #111;" type="text" class="form-control" name="nome" required
                                 value="" maxlength="150">
                              </div>
                           </div>
                           <div class="col-md-12 px-8">
                              <div class="form-group">
                                 <label id="labelFormulario">Descrição</label>
                                 <input style="border-color: #111;color: #111;" type="text" class="form-control" name="descricao" required
                                 value="" maxlength="150">
                              </div>
                           </div>
                           <div class="col-md-12 px-8">
                              <div class="form-group">
                                 <label id="labelFormulario">Tipo</label>
                                 <select  style="border-color: #111;color: #111;" name="tipoexame_id" id="tipoexame_id" class="form-control"
                                 title="Por favor selecionar um tipo de exame ..." required>
                                    @foreach($tipoexames as $entLista)
                                    <option style="border-color: #111;color: #2d3748"
                                    value="{{old('tipoexame_id', $entLista->id)}}" 
                                                   > {{$entLista->descricao}}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>                        
                        </div>
                        <input type="hidden" name="consulta_id" value="{{$consulta->id}}">
                        
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="closeModal('addNovoExameBDModal')"
                             data-dismiss="modal">
                              <i class="fa fa-reply"></i> Voltar
                            </button>
                            <button type="submit" class="btn btn-primary">
                              <i class="fa fa-save"></i> Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal add medicamento-->
<div class="modal fade" id="modalPedirMedicamento" tabindex="-1" role="dialog" aria-labelledby="modalPedirMedicamento"
   aria-hidden="true">
   <div class="modal-dialog  modal-dialog-top modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">
               <label>Favor selecionar o medicamento desejado</label>
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar"
            onclick="closeModal('modalPedirMedicamento')">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="container">
               <form method="post" action="{{route('pedido_medicamento.salveVarios')}}">
                  @csrf
                  <div class="row">
                     <div class="col-md-12">
                        <div class="form-group"  style="color:#2d3748">
                              <label id="labelFormulario">Selecionar medicamento:</label>
                                    <select class="select2"  name="medicamentos[]" multiple="multiple" 
                                    style="color:#2d3748; width: 100%; height: 39px; " 
                                    id="medicamento_id" class="form-control"
                                     title="Por favor selecionar medicamento...">                                       
                                        @foreach($medicamentos as $ent)
                                        <option data-color="red" value="{{old('medicamento_id', $ent->id)}}"                                       
                                        >
                                           {{$ent->nome_comercial}}
                                            </option>
                                        @endforeach
                                    </select>
                        </div>
                     </div>     
                     <div class="row" style="padding-top:10%; width: 100%;">               
                           <div class="col-12">
                             <p> Não encontrou o medicamento? 
                                 <a href="#"  rel="tooltip" title="Adicionar novo exame"                         
                                 onclick="openModal('addNovoMedicamentoBDModal')">                       
                                 Click aqui para cadastrar.</a>   
                                 </p>
                           </div>
                     </div>     
                 
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal"
                     onclick="closeModal('modalPedirMedicamento')">
                        <i class="fa fa-reply"></i> Voltar
                     </button>
                     <input type="hidden" name="consulta_id" value="{{$consulta->id}}">
                     <input type="submit" name="mover" class="btn btn-success" value="Adicionar medicamentos"></input>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- Modal para add novo MEDICAMENTO no bd caso nao seja encontrado -->
<div class="modal fade" id="addNovoMedicamentoBDModal" tabindex="-3" role="dialog"
 aria-labelledby="addNovoMedicamentoBDModal" aria-hidden="true">
    <div class="modal-dialog-cad-medicamento modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <label>Adicionar novo medicamento:</label>
                </h5>
                <button type="button" class="close" id="close-modal2"
                 data-dismiss="modal" aria-label="Fechar"  onclick="closeModal('addNovoMedicamentoBDModal')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <!--aqui a rota de salvar o novo medicamento -->
                    <form method="post" action="{{route('especialista.salvaNovoMedicamento')}}">
                        @csrf
                        <div class="row">                           
                        
                           <div class="col-md-12 px-8">
                              <div class="form-group">
                              <label id="labelFormulario">Nome Comercial</label>
                              <input style="border-color: #111; color: #111;" type="text" class="form-control" name="nome_comercial" required
                                 value="" maxlength="150">
                              </div>
                           </div>
                           <div class="col-md-12 px-8">
                              <div class="form-group">
                              <label id="labelFormulario">Nome Genérico</label>
                              <input style="border-color: #111; color: #111;" type="text" class="form-control" name="nome_generico" 
                                 value="" maxlength="150">
                              </div>
                           </div>
                           <div class="col-md-12 px-8">
                              <div class="form-group">
                              <label id="labelFormulario">Forma</label>
                              <input style="border-color: #111; color: #111;" type="text" class="form-control" name="forma" 
                                 value="" maxlength="150">
                              </div>
                           </div>
                           <div class="col-md-12 px-8">
                              <div class="form-group">
                              <label id="labelFormulario">Concentração</label>
                              <input style="border-color: #111; color: #111;" type="text" class="form-control" name="concentracao" 
                                 value="" maxlength="150">
                              </div>
                           </div>
                           <div class="col-md-12 px-8">
                              <div class="form-group">
                              <label id="labelFormulario">Via</label>
                              <input style="border-color: #111; color: #111;" type="text" class="form-control" name="via" 
                                 value="" maxlength="150">
                              </div>
                           </div>
                           <div class="col-md-12 px-8">
                              <div class="form-group">
                              <label id="labelFormulario">Indicação</label>
                              <input style="border-color: #111; color: #111;" type="text" class="form-control" name="indicacao" 
                                 value="" maxlength="150">
                              </div>
                           </div>
                           <div class="col-md-12 px-8">
                              <div class="form-group">
                              <label id="labelFormulario">Posologia</label>
                              <input style="border-color: #111; color: #111;" type="text" class="form-control" name="posologia" 
                                 value="" maxlength="150">
                              </div>
                           </div>
                           <div class="col-md-12 px-8">
                              <div class="form-group">
                              <label id="labelFormulario">Precaução</label>
                              <input style="border-color: #111; color: #111;" type="text" class="form-control" name="precaucao" 
                                 value="" maxlength="150">
                              </div>
                           </div>
                           <div class="col-md-12 px-8">
                              <div class="form-group">
                              <label id="labelFormulario">Advertência</label>
                              <input style="border-color: #111; color: #111;" type="text" class="form-control" name="advertencia" 
                                 value="" maxlength="150">
                              </div>
                           </div>
                           <div class="col-md-12 px-8">
                              <div class="form-group">
                              <label id="labelFormulario">Contraindicação</label>
                              <input style="border-color: #111; color: #111;" type="text" class="form-control" name="contraindicacao" 
                                 value="" maxlength="150">
                              </div>
                           </div>
                           <div class="col-md-12 px-8">
                              <div class="form-group">
                              <label id="labelFormulario">Composição</label>
                              <input style="border-color: #111; color: #111;" type="text" class="form-control" name="composicao" 
                                 value="" maxlength="150">
                              </div>
                           </div>
                           <div class="col-md-12 px-8">
                              <div class="form-group">
                              <label id="labelFormulario">Latoratório Fabricante</label>
                              <input style="border-color: #111; color: #111;" type="text" class="form-control" name="latoratorio_fabricante"
                                 value="" maxlength="150">
                              </div>
                           </div>

                           <div class="col-md-12 px-8">
                              <div class="form-group">
                                 <label id="labelFormulario">Tipo de Medicamento</label>
                                 <select  style="border-color: #111; color: #111;" name="tipo_medicamento_id" id="tipo_medicamento_id" class="form-control"
                                    title="Por favor selecionar ..." required> style="border-color: white"
                                    @foreach($tipo_medicamentos as $iten)
                                       <option style="border-color: #111;color: #2d3748" value="{{$iten->id}}"
                                         > {{$iten->descricao}}
                                       </option>
                                    @endforeach
                                 </select>
                               </div>
                           </div>
         
                        </div>
                        <input type="hidden" name="consulta_id" value="{{$consulta->id}}">
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" onclick="closeModal('addNovoMedicamentoBDModal')" 
                             data-dismiss="modal" >
                              <i class="fa fa-reply"></i> Voltar
                            </button>
                            <button type="submit" class="btn btn-primary">
                              <i class="fa fa-save"></i> Salvar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks" style="height: auto; min-height: 500px;">
            <div class="card-header">
               <div class="row">
                  <div class="col-6 col-lg-2">
                     <div class="photo">
                        <img src="/assets/img/anime3.png" alt="{{ __('Profile Photo') }}"
                           style="height: 100px; width: 100px;">
                     </div>
                  </div>
                  <div class="col-6 col-lg-3">
                     <h6 class="title d-inline">Paciente: {{$paciente->nome}}</h6>
                     <br>
                     <h6 id="idadePaciente" class="title d-inline">
                        {{date('d/m/Y', strtotime($usuarioPaciente->data_nascimento))}}
                     </h6>
                  </div>
                  <div class="col-6 col-lg-4">
                     @if(isset($primeiraConsulta))
                   <h6 class="title d-inline">Primeira consulta em
                     {{date('d/m/Y H:i', strtotime($primeiraConsulta->horario_agendado))}}
                   </h6>
                @else
                <h6 class="title d-inline">Primeira consulta.</h6>
             @endif
                     <br>
                     <h6 class="title d-inline">Total de consultas realizadas: {{$qtdConsultasRealizadas}}</h6>
                  </div>
                  <div class="col-6 col-lg-2">
                     <div id="chronometer" name="cronometro">
                        
                     </div>
                  </div>
               </div>

            </div>
            <div class="card-body">
               <div class="row">
                  <div class="tab-container">
                     <div class="tabs">
                        <button class="tab-button 
                         @if($aba == "prontuarioatual")
                              <?php echo 'active'; ?>
                         @endif                        
                         btn-primary"
                           onclick="openTab(event, 'prontuarioatual')">Pronturário Atual</button>
                        <button class="tab-button 
                        @if($aba == "prescricoes")
                              <?php echo 'active'; ?>
                         @endif                        
                         btn-primary"
                           onclick="openTab(event, 'prescricoes')">Prescrições</button>
                        <button class="tab-button  
                        @if($aba == "exames")
                              <?php echo ' active '; ?>
                         @endif 
                         btn-primary"
                        onclick="openTab(event, 'exames')"> Pedidos de
                           exames</button>
                        <button class="tab-button
                         @if($aba == "atestados")
                              <?php echo 'active'; ?>
                         @endif                        
                         btn-primary" onclick="openTab(event, 'atestados')">Atestados</button>
                        <button class="tab-button 
                        @if($aba == "prontuario")
                              <?php echo 'active'; ?>
                         @endif   
                        btn-primary" onclick="openTab(event, 'prontuario')"> Prontuário
                           completo</button>

                     </div>
                     <div class="tab-content">
                        <div id="prontuarioatual" class="tab-pane
                         @if($aba == "prontuarioatual")
                              <?php echo 'active'; ?>
                         @endif 
                         ">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="form-group">
                                 <label style="color: #111">&nbsp; &nbsp; Dados da consulta:</label>
                                 <input style="color: #111" type="area" placeholder="Digite os dados da consulta aqui"
                                    name="dadosconsulta" id="dadosconsulta" class="form-control" value="">
                              </div>
                           </div>
                        </div>
                        </div>
                        <div id="prescricoes" class="tab-pane
                         @if($aba == "prescricoes")
                              <?php echo 'active'; ?>
                         @endif 
                         ">
                         <div class="row">
                              <div class="col-2">
                                 <a id="adicionarMedicamento" rel="tooltip" title="Pedir medicamento" class="btn btn-success"
                                    data-original-title="Edit" href="#">
                                    <i class="tim-icons  icon-components"></i> Prescrever medicamento
                                 </a>
                              </div>    
                              <div class="col-4">
                                 
                              </div>
                              <div class="col-6 btn-primary">
                                 <div class="table-responsive">
                                    <table class="table">
                                       <thead>
                                          <tr>
                                             <th> Medicamentos </th>
                                             <th> </th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                       @if(sizeof($listaPedidosMedicamentos) > 0)
                                       @foreach($listaPedidosMedicamentos as $pedidoMedicamento)
                                          <tr>
                                             <td> {{$pedidoMedicamento->nome_comercial}} </td>
                                             <td>                                                                                           
                                                <a href="{{route('pedido_medicamento.delete',[$pedidoMedicamento->id,$consulta->id] )}}"
                                                   rel="tooltip"
                                                   title="Excluir" class="btn btn-link" data-original-title="Remove">
                                                   <i class="tim-icons icon-simple-remove"></i>
                                                </a>
                                             </td>
                                          </tr>
                                          @endforeach 
                                          @endif   
                                       </tbody>
                                    </table>
                                    <div>

                                    </div>
                                 </div>
                              </div>
                           </div>
                           
                        </div>
                        <div id="exames" class="tab-pane
                          @if($aba == "exames")
                              <?php echo 'active'; ?>
                         @endif 
                         ">
                           <div class="row">
                              <div class="col-2">
                                 <a id="adicionarExame" rel="tooltip" title="Pedir Exame" class="btn btn-success"
                                    data-original-title="Edit" href="#">
                                    <i class="tim-icons  icon-components"></i> Pedir exame
                                 </a>
                              </div>    
                              <div class="col-4">
                                 
                              </div>
                              <div class="col-6 btn-primary">
                                 <div class="table-responsive">
                                    <table class="table">
                                       <thead>
                                          <tr>
                                             <th> Exames </th>
                                             <th> </th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                       @if(sizeof($listaPedidosExames) > 0)
                                       @foreach($listaPedidosExames as $pedidoexame)
                                          <tr>
                                             <td> {{$pedidoexame->nome}} </td>
                                             <td>                                                                                           
                                                <a href="{{route('pedido_exame.delete',[$pedidoexame->id,$consulta->id] )}}"
                                                  rel="tooltip"
                                                   title="Excluir" class="btn btn-link" data-original-title="Remove">
                                                   <i class="tim-icons icon-simple-remove"></i>
                                                </a>
                                             </td>
                                          </tr>
                                          @endforeach 
                                          @endif   
                                       </tbody>
                                    </table>
                                    <div>

                                    </div>
                                 </div>
                              </div>
                           </div>
                           </div>
                           <div id="atestados" class="tab-pane
                            @if($aba == "atestados")
                              <?php echo 'active'; ?>
                            @endif
                           ">
                              <p>Conteúdo da aba atestados.</p>
                           </div>
                           <div id="prontuario" class="tab-pane
                             @if($aba == "prontuario")
                              <?php echo 'active'; ?>
                            @endif
                            ">
                            <div class="row">
                              <div class="col-2">
                                 <a id="adicionarExame" rel="tooltip" title="Pedir Exame" class="btn btn-success"
                                    data-original-title="Edit" href="#">
                                    <i class="tim-icons  icon-components"></i> Anamnese
                                 </a>
                              </div>    
                              <div class="col-4">
                                 
                              </div>                              
                           </div>
                           </div>
                        </div>
                     </div>
                  </div>


                  <div class="row">
                     <div class="col-lg-2">

                     </div>
                     <div class="col-lg-3">

                     </div>
                     <div class="col-4">

                     </div>

                  </div>


               </div>

            </div>
            <div class="row">
               <div class="col-6" style="margin-left: 10px;">

                  <a href="{{route('consulta.listconsultaporespecialista')}}" class="btn btn-primary"><i
                        class="fa fa-reply"></i>
                     Voltar</a>
                  <a rel="tooltip" title="Finalizar" id="btnFinalizar" class="btn btn-success" data-original-title="Edit"                  
                     href="{{route('especialista.finalizarAtendimento', $consulta->id)}}">
                     <i class="fa fa-save"></i> Finalizar
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>

   <script>
      const chronometer = document.getElementById('chronometer');
      let startTime = Date.now();
      //aqui add startTime dentro da sessao
      let elapsedTime = 0;
      let timerInterval;

      let tempo = localStorage.getItem('tempo') ? parseInt(localStorage.getItem('tempo')) : 0;
   

      function updateChronometer() {         
         tempo++;
         localStorage.setItem('tempo', tempo);
         const hours = String(Math.floor(tempo / 3600)).padStart(2, '0');
         const minutes = String(Math.floor((tempo % 3600) / 60)).padStart(2, '0');
         const seconds = String(tempo % 60).padStart(2, '0');       


    /*     elapsedTime = Date.now() - startTime;
         const hours = Math.floor(elapsedTime / (1000 * 60 * 60));
         const minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
         const seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);
*/

         const formattedHours = String(hours).padStart(2, '0');
         const formattedMinutes = String(minutes).padStart(2, '0');
         const formattedSeconds = String(seconds).padStart(2, '0');

         chronometer.textContent = `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
      /*  //atualizo a variavel cronomentro toda vez que a tela eh atualizada voltar com o tempo
         //que ja tinha
        
         cronometroAntigo = sessionStorage.getItem('timerValue');
         if(cronometroAntigo == '00:00:00'){  
            sessionStorage.removeItem('timerValue');
           
         }else{            
            chronometer.textContent = sessionStorage.getItem('timerValue');
           // alert(sessionStorage.getItem('timerValue'));
         }
         sessionStorage.setItem('timerValue',  chronometer.textContent);

         verificar a variavel startTime, eh ela que zera o tempo
         */
      }

      function startTimer() {
         timerInterval = setInterval(updateChronometer, 1000);  
        
      }

      startTimer();

      document.getElementById('btnFinalizar').onclick = () => {
            tempo = 0;
            localStorage.removeItem('tempo'); // Remove o tempo do localStorage
            document.getElementById('chronometer').innerText = '00:00:00'; 
        };
   </script>



   <script>
      // Função para calcular a idade
      function calcularIdade(dataNascimento) {
         const hoje = new Date();
         const nascimento = new Date(dataNascimento);
         let idade = hoje.getFullYear() - nascimento.getFullYear();
         const mes = hoje.getMonth() - nascimento.getMonth();
         if (mes < 0 || (mes === 0 && hoje.getDate() < nascimento.getDate())) {
            idade--;
         }
         return idade;
      }
      // Data de nascimento no formato YYYY-MM-DD
      var dataNascimento = '{{$usuarioPaciente->data_nascimento}}';
      var idade = calcularIdade(dataNascimento);
      // Exibir a idade no HTML
      document.getElementById('idadePaciente').textContent = "IDADE: " + idade + " anos";
   </script>

  
   <script>
       <!-- abrindo o modal de add exames -->
      document.getElementById('adicionarExame').addEventListener('click', function () {
         // Abra o modal
         $('#modalPedirExame').modal('show');
      });

      <!-- abrindo o modal de add medicamento -->
      document.getElementById('adicionarMedicamento').addEventListener('click', function () {
         // Abra o modal
         $('#modalPedirMedicamento').modal('show');
      });
   </script>
   
   @endsection