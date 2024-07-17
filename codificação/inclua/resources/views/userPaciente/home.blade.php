@extends('layouts.app', ['page' => __('home'), 'exibirPesquisa' => false, 'pageSlug' => 'home', 'class' => 'consulta'])
@section('content')
<style>
   .btnHome {
      position: relative;
      display: inline-block;
      width: 100px;
      min-height: 100px;
      border: 1px solid #ccc;
      text-align: center;
      line-height: 1.5;
      margin-right: 15px;
      margin-bottom: 10px;     
      padding-right: 20px;
      padding-top: 20px;
      cursor: pointer;
      border-radius: 10px;
      flex: 1;     
   }
 
   .full-link {
      display: block;
      /* Faz a âncora se comportar como um bloco */
      position: absolute;
      /* Posiciona absolutamente dentro da div */
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      text-decoration: none;
      /* Remove sublinhado padrão */
      padding: 20px;
      /* Espaçamento interno, ajuste conforme necessário */
      background-color: rgba(0, 0, 0, 0.1);
      /* Cor de fundo semi-transparente */
      text-align: center;
      /* Centraliza o texto horizontalmente */
      color: white;
   }

   .full-link:hover {
      background-color: rgba(255, 255, 255, 0.1);
      /* Fundo branco semi-transparente ao passar o mouse */
      color: white;
      /* Texto branco ao passar o mouse */
   }

   .proximasConsultas {
      border-radius: 10px;
   }
   .container {
        display: flex; /* Utiliza o flexbox para alinhar os itens */
        width: 100%; /* Define a largura total da tela */ 
        padding: 0px;     
    }
</style>
<section class="bg0 p-t-104 p-b-116">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks" style="height: auto; min-height: 500px;">
            <div class="card-header">

            </div>
            <div class="card-body">
               <div class="container">
                  <div class="btnHome btn-primary">
                     <a class="full-link" href="{{route('paciente.marcarconsulta')}}">
                        <i class="tim-icons icon-calendar-60 "></i> <br>
                        Marcar consulta </a>
                  </div>
                  <div class="btnHome btn-primary">
                     <a class="full-link" href="{{route('paciente.minhasconsultas')}}">
                        <i class="tim-icons icon-notes"></i> <br>
                        Minhas consultas </a>
                  </div>
                  <div class="btnHome btn-primary">
                     <a class="full-link" href="#">
                        <i class="tim-icons icon-components"></i> <br>
                        Exames </a>
                  </div>
                  <div class="btnHome btn-primary" style=" margin-right: 0px;">
                     <a class="full-link" href="#">
                        <i class="tim-icons icon-money-coins"></i> <br>
                        Histórico de pagamentos </a>
                  </div>
               </div>

               <div class="proximasConsultas btn-primary">
                  <h4 style="margin: 10px;">Suas próximas consultas</h4>
                  @if(sizeof($lista) > 0)
                  <div class="table-responsive">
                     <table class="table">
                        <thead>
                           <th> Horário</th>
                           <th> Dia </th>
                           <th> Médico </th>
                           <th> Especialidade </th>
                           <th> Clínica </th>
                        </thead>
                        <tbody>
                           @foreach($lista as $ent)
                           <tr>
                              <td>{{date( 'H:i' , strtotime($ent->horario_agendado))}}</td>
                              <td>{{date( 'd/m/Y' , strtotime($ent->horario_agendado))}}</td>
                              <td>{{$ent->nome_especialista}}</td>
                              <td>{{$ent->descricao_especialidade}}</td>
                              <td>{{$ent->nome_clinica}}</td>
                           </tr>
                           @endforeach

                        </tbody>
                     </table>
                     <div>
                        @else
                       <h5  style="margin: 10px;"> Você ainda não tem consulta agendada.</h5>
                        @endif
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      @endsection