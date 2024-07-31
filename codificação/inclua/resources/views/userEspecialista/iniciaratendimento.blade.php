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











<div class="card">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks" style="height: auto; min-height: 500px;">
            <div class="card-header">
               <div class="row">
                  <div class="col-6 col-lg-2">
                     <div class="photo">
                        <img src="/assets/img/anime3.png" alt="{{ __('Profile Photo') }}" style="height: 100px; width: 100px;">
                     </div>
                  </div>
                  <div class="col-6 col-lg-3">
                     <h6 class="title d-inline">Paciente: nome fulanto de tal</h6>
                     <br>
                     <h6 class="title d-inline">Idade: 30 anos</h6>
                  </div>
                  <div class="col-6 col-lg-4">
                     <h6 class="title d-inline">Primeira consulta em DATA</h6>
                     <br>
                     <h6 class="title d-inline">Total de consultas realizadas: qtd</h6>
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
                        <button class="tab-button active btn-primary" onclick="openTab(event, 'home')">Anamnese</button>
                        <button class="tab-button btn-primary" onclick="openTab(event, 'services')">Prescrições</button>
                        <button class="tab-button btn-primary" onclick="openTab(event, 'about')"> Pedidos de exames</button>
                        <button class="tab-button btn-primary" onclick="openTab(event, 'contact')">Atestados</button>
                        <button class="tab-button btn-primary" onclick="openTab(event, 'prontuario')">  Prontuário completo</button>
                      
                     </div>
                     <div class="tab-content">
                        <div id="home" class="tab-pane active">
                           <h1>Bem-vindo à página inicial!</h1>
                           <p>Conteúdo da aba Início.</p>
                           Anamnese -
                           <!-- Tela com lista de anamnese precadastradas
                           no cad de anamnese vai ter id e descricao
                           na tela de atendimento o especialista vai poder inserir um texto    cada anamnese    
                           * quando abrir o modal mostrar dados já preenchidos de consultas anteriores-->
                           <!-- Tela com Queixa principal-->
                           <!-- História do problema = História-->
                        </div>
                        <div id="services" class="tab-pane">
                           <h1>Nossos Serviços</h1>
                           <p>Conteúdo da aba Serviços.</p>
                        </div>
                        <div id="about" class="tab-pane">
                           <h1>Sobre Nós</h1>
                           <p>Conteúdo da aba Sobre.</p>
                        </div>
                        <div id="contact" class="tab-pane">
                           <h1>Contato</h1>
                           <p>Conteúdo da aba Contato.</p>
                           <div class="col-lg-2">

<h6 class="title d-inline">Impressões</h6>
<a rel="tooltip" title="tela com " class="btn btn-primary" data-original-title="Edit" href="{{route('especialista.iniciarAtendimento',1)}}">
  
</a>

<a rel="tooltip" title="Iniciar atendimento" class="btn btn-primary" data-original-title="Edit" href="{{route('especialista.iniciarAtendimento',1)}}">
   Prescrições
   <!--  Tela que vai aparecer um botao para inserir nova prescricao
add medicamentos e formas de usos.

*vai mostrar as ultimas prescriçoes.
-->
</a>
<a rel="tooltip" title="Iniciar atendimento" class="btn btn-primary" data-original-title="Edit" href="{{route('especialista.iniciarAtendimento',1)}}">
   Pedidos de exames
   <!-- tela para add novo pedido
    *vai mostrar os ultimos pedidos -->
</a>
<a rel="tooltip" title="Iniciar atendimento" class="btn btn-primary" data-original-title="Edit" href="{{route('especialista.iniciarAtendimento',1)}}">
   Atestados
   <!-- tela que vai auxiliar a criar um novo atestado -->
</a>

<a rel="tooltip" title="Iniciar atendimento" class="btn btn-primary" data-original-title="Edit" href="{{route('especialista.iniciarAtendimento',1)}}">
   Prontuário completo
   <!-- dados completos com todas as consultas, exames e prescrições -->
</a>


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
            <div class="col-lg-2">
            <a rel="tooltip" title="Finalizar" class="btn btn-primary" style="margin-bottom: 0px;" data-original-title="Edit" href="{{route('especialista.iniciarAtendimento',1)}}">
   Finalizar
   <!-- dados completos com todas as consultas, exames e prescrições -->
</a> </div>
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
@endsection