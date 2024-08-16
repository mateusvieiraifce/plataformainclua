@extends('layouts.app', ['page' => __('Consultas'), 'exibirPesquisa' => false, 'pageSlug' => 'listconsultaporespecialista', 'class' => 'agenda'])
@section('content')
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




<!-- Modal add exames-->
<div class="modal fade" id="modalPedirExame" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">
               <label>Favor selecionar o exame desejado</label>
            </h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="container">
               <form method="post" action="#">
                  @csrf
                  <div class="row">
                     <div class="col-md-5">
                        <div class="form-group">
                           <label>&nbsp; &nbsp; Exame:</label>
                           <input style="border-color: #C0C0C0" type="text" placeholder="Digite o nome do exame"
                              name="pesquisaexame" id="pesquisaexame" class="form-control" value="">
                        </div>
                     </div>
                     <div class="col-md-5">
                        <div class="form-group">
                           <label>&nbsp; &nbsp; Tipo:</label>
                           <input style="border-color: #C0C0C0" type="text" placeholder="Digite o nome do exame"
                              name="pesquisaexame" id="pesquisaexame" class="form-control" value="">
                        </div>
                     </div>

                     <div class="col-md-1">
                        <div class="form-group">
                           <label id="labelFormulario"></label>
                           <a href="#" rel="tooltip" title="Adicionar " data-original-title="Adicionar " href="#"
                              data-target="#addProdutoBDModal" data-toggle="modal" data-whatever="@mdo">
                              <button style="width: 10px;" type="button" rel="tooltip" title="" class="btn btn-success"
                                 data-original-title="Edit Task">
                                 <i class="tim-icons icon-simple-add"></i>
                              </button>
                           </a>
                        </div>
                     </div>
                  </div>
                  <div class="row">

                     aqui tabela com todos os tipos de exames
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        <i class="fa fa-reply"></i> Voltar
                     </button>
                     <input type="submit" name="mover" class="btn btn-success" value="Adicionar pedido"></input>
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
                     <div id="chronometer">00:00:00</div>
                  </div>
               </div>

            </div>
            <div class="card-body">


               <div class="row">
                  <div class="tab-container">
                     <div class="tabs">
                        <button class="tab-button active btn-primary"
                           onclick="openTab(event, 'anamnese')">Anamnese</button>
                        <button class="tab-button btn-primary"
                           onclick="openTab(event, 'prescricoes')">Prescrições</button>
                        <button class="tab-button btn-primary" onclick="openTab(event, 'exames')"> Pedidos de
                           exames</button>
                        <button class="tab-button btn-primary" onclick="openTab(event, 'atestados')">Atestados</button>
                        <button class="tab-button btn-primary" onclick="openTab(event, 'prontuario')"> Prontuário
                           completo</button>

                     </div>
                     <div class="tab-content">
                        <div id="anamnese" class="tab-pane active">
                           <p>Conteúdo da aba Anamnese.</p>
                           <!-- Tela com lista de anamnese precadastradas
                           no cad de anamnese vai ter id e descricao
                           na tela de atendimento o especialista vai poder inserir um texto    cada anamnese    
                           * quando abrir o modal mostrar dados já preenchidos de consultas anteriores-->
                           <!-- Tela com Queixa principal-->
                           <!-- História do problema = História-->
                        </div>
                        <div id="prescricoes" class="tab-pane">
                           <p>Conteúdo da aba prescriçoes.</p>
                        </div>
                        <div id="exames" class="tab-pane">
                           <div class="row">
                              <div class="col-2">
                                 <a id="adicionarExame" rel="tooltip" title="Finalizar" class="btn btn-success"
                                    data-original-title="Edit" href="#">
                                    <i class="tim-icons  icon-components"></i> Pedir exame
                                 </a>
                              </div>
                           </div>


                           <div class="row">

                              <div class="col-12" style="background-color: Aquamarine;">
                                 <div class="table-responsive">
                                    <table class="table">
                                       <thead>
                                          <tr>
                                             <th> Exame </th>
                                             <th> </th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <tr>
                                             <td> teste </td>
                                             <td>
                                                <a rel="tooltip" class="btn btn-link" href="#">
                                                   <i class="tim-icons icon-pencil"></i>
                                                </a>
                                                <a href="{{route('exame.delete', 0)}}"
                                                   onclick="return confirm('Deseja relamente excluir?')" rel="tooltip"
                                                   title="Excluir" class="btn btn-link" data-original-title="Remove">
                                                   <i class="tim-icons icon-simple-remove"></i>
                                                </a>
                                             </td>
                                          </tr>
                                       </tbody>
                                    </table>
                                    <div>

                                    </div>
                                 </div>
                              </div>




                           </div>
                           <div id="atestados" class="tab-pane">
                              <p>Conteúdo da aba atestados.</p>
                           </div>
                           <div id="prontuario" class="tab-pane">
                              <p>Conteúdo da aba prontuário.</p>
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
                  <a rel="tooltip" title="Finalizar" class="btn btn-success" data-original-title="Edit"
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
      let elapsedTime = 0;
      let timerInterval;

      function updateChronometer() {
         elapsedTime = Date.now() - startTime;
         const hours = Math.floor(elapsedTime / (1000 * 60 * 60));
         const minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
         const seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);

         const formattedHours = String(hours).padStart(2, '0');
         const formattedMinutes = String(minutes).padStart(2, '0');
         const formattedSeconds = String(seconds).padStart(2, '0');

         chronometer.textContent = `${formattedHours}:${formattedMinutes}:${formattedSeconds}`;
      }

      function startTimer() {
         timerInterval = setInterval(updateChronometer, 1000);
      }

      startTimer();
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

   <!-- abrindo o modal de add exames -->
   <script>
      document.getElementById('adicionarExame').addEventListener('click', function () {
         //  mandaDadosFormPrincipalParaModal();
         //  preencheModalCustos();
         // Abra o modal
         $('#modalPedirExame').modal('show');
      });
   </script>
   @endsection