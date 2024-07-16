@extends('layouts.app', ['page' => __('home'), 'exibirPesquisa' => false, 'pageSlug' => 'home', 'class' => 'consulta'])
@section('content')
<style>
   .btnHome{
      position: relative;
      display: inline-block;
      width: 120px;
        height: 120px;
        border: 1px solid #ccc;
        text-align: center;
        line-height: 1.5;
        margin-right: 10px;
        margin-bottom: 10px;
        padding-top: 20px;
        cursor: pointer;
        border-radius: 10px;
       
   }

   .full-link {
    display: block; /* Faz a âncora se comportar como um bloco */
    position: absolute; /* Posiciona absolutamente dentro da div */
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    text-decoration: none; /* Remove sublinhado padrão */
    padding: 20px; /* Espaçamento interno, ajuste conforme necessário */
    background-color: rgba(0, 0, 0, 0.1); /* Cor de fundo semi-transparente */
    text-align: center; /* Centraliza o texto horizontalmente */
    color: white;
}
.full-link:hover {
    background-color: rgba(255, 255, 255, 0.1); /* Fundo branco semi-transparente ao passar o mouse */
    color: white; /* Texto branco ao passar o mouse */
}

   </style>
<section class="bg0 p-t-104 p-b-116">
   <div class="row">
      <div class="col-lg-12 col-md-12">
         <div class="card card-tasks">
            <div class="card-header">
               
            </div>
            <div class="card-body">
               <div  class="btnHome btn-primary">    
                     <a class="full-link" 
                     href="{{route('paciente.marcarconsulta')}}" > 
                     <i class="tim-icons icon-calendar-60 "></i> <br> 
                     Marcar consulta </a>                     
               </div>            

               <div  class="btnHome btn-primary">    
                     <a class="full-link" 
                     href="{{route('paciente.minhasconsultas')}}" > 
                     <i class="tim-icons icon-notes"></i> <br> 
                     Minhas consultas  </a>                     
               </div>

               <div  class="btnHome btn-primary">    
                     <a class="full-link" 
                     href="#" > 
                     <i class="tim-icons icon-components"></i> <br> 
                     Exames  </a>                     
               </div>

               <div  class="btnHome btn-primary">    
                     <a class="full-link" 
                     href="#" > 
                     <i class="tim-icons icon-money-coins"></i> <br> 
                     Histórico de pagamentos  </a>                     
               </div>

               <div class="proximasConsultas">
                  <h5>Suas próximas consultas</h5>
                  aqui a lista das 3 próximas consutas
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection