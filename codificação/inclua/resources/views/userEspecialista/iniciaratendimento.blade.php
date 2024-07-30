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
      text-align: center; /* Centraliza o texto horizontalmente */
      display: flex; /* Permite usar flexbox para o alinhamento */
      justify-content: center; /* Centraliza o texto horizontalmente com flexbox */
      align-items: center; /* Centraliza o texto verticalmente com flexbox */
      height: 100px;
   }
</style>


<div class="card">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks" style="height: auto; min-height: 500px;">
            <div class="card-header">
            <div class="row">
               <div class="col-lg-2">
                  <div class="photo">
                        <img src="/assets/img/anime3.png" alt="{{ __('Profile Photo') }}" style="height: 100px; width: 100px;">
                  </div>
               </div>
               <div class="col-lg-3">
                  <h6 class="title d-inline">Paciente: nome fulanto de tal</h6> 
                  <br>  
                  <h6 class="title d-inline">Idade: nometal</h6>   
               </div>
               <div class="col-4">
                 
               </div>
               <div class="col-lg-2">
                  <div id="chronometer">00:00:00</div>
               </div>
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