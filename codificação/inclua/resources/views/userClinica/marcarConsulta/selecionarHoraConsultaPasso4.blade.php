@extends('layouts.app', ['page' => __('Marcar Consulta'),'exibirPesquisa' => false, 'pageSlug' => 'marcarconsulta', 'class' => 'especialidade'])
@section('title', 'Marcar Consulta')
@section('content')

<style>
    .calendar {
        max-width: 100%;
        margin: 0 auto;
        padding: 10px;
    }

    .weekdays {
        display: flex;
        justify-content: space-around;
        margin-bottom: 5px;
    }

    .weekdays span {
        width: 100px;
        text-align: center;
    }

    .days {
        display: flex;
        flex-wrap: wrap;
    }

    .day {
        width: 80px;
        height: 80px;
        border: 1px solid #ccc;
        text-align: center;
        line-height: 1.5;
        margin-right: 10px;
        margin-bottom: 10px;
        padding-top: 20px;
        cursor: pointer;
        border-radius: 10px;
        color: white;
    }

    .navigation {
        margin-top: 5px;
        padding: 5px;
        text-align: center;
        border: 1px solid #ccc;
    }

    .navigation button {
        margin: 0 10px;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
    }
</style>

 <!-- Modal confirmar consulta-->
 <div class="modal" id="modalFinalizarConsulta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h3 class="modal-title">
                <label style="color:black; font-size: 20px;">Revise sua consulta</label>
            </h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
            <div class="container">
                <!--aqui a rota de salvar de confirmar consulta -->
                <form method="post" action="{{route('clinica.marcarConsultaFinalizar')}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                        <div class="form-group" style=" border-bottom: 1px solid black; ">
                            <label style="color:black; font-size: 15px;"><strong>Paciente:</strong> {{$paciente->nome}}</label>
                        </div>
                        </div>
                        <div class="col-md-12 px-8">
                        <div class="form-group" style="border-bottom: 1px solid black; ">
                            <label style="color:black; font-size: 15px; "><strong>Data:</strong></label>
                            <label id="diaModal" style="color:black; font-size: 15px;"></label>
                        </div>
                        </div>
                        <div class="col-md-12 px-8">
                        <div class="form-group" style=" border-bottom: 1px solid black; ">
                        <label style="color:black; font-size: 15px; "><strong>Hora:</strong></label>
                            <label id="horarioModal" style="color:black; font-size: 15px;"> </label>
                        </div>
                        </div>
                        <div class="col-md-12 px-8">
                        <div class="form-group" style="border-bottom: 1px solid black;">
                            <label style="color:black; font-size: 15px;"><strong>Área de atuação:</strong> {{$especialidade->descricao}}</label>
                        </div>
                        </div>
                        <div class="col-md-12 px-8">
                        <div class="form-group"  style=" border-bottom: 1px solid black;">
                            <label style="color:black; font-size: 15px;"><strong>Especialista:</strong> {{$especialista->nome}}</label>
                        </div>
                        </div>
                        <div class="col-md-12 px-8">
                        <div class="form-group"  style=" border-bottom: 1px solid black; ">
                            <label style="color:black; font-size: 15px;"><strong>Clínica:</strong> {{$clinica->nome}}</label>
                        </div>
                        </div>
                    </div>
                    <input type="hidden" id="consulta_id" name="consulta_id">
                    <input type="hidden" id="paciente_id" value=" {{$paciente->id}}" name="paciente_id">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-reply"></i>
                    Voltar
                </button>
                <button type="submit" class="btn btn-success">Confirmar consulta</button>
            </div>
            </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card card-tasks">
            <div class="card-header">
                <div class="navigation">
                    <button onclick="previousWeek()">
                        <i class="tim-icons icon-minimal-left">
                        </i> </button>
                    <span id="intervalodias">Segunda-feira</span>
                    <button onclick="nextWeek()"> <i class="tim-icons icon-minimal-right">
                        </i></button>
                </div>

            </div>
            <div class="card-body">
                <div class="calendar">
                    <div class="weekdays">
                    </div>
                    <p>Selecione o dia</p>
                    <div class="days" id="calendarDays">
                        <!-- Dias da semana serão gerados dinamicamente pelo JavaScript -->
                    </div>
                    <p id="paragrafohora"></p>
                    <div class="days" id="consultasDisponivel">
                        <!-- Dias da semana serão gerados dinamicamente pelo JavaScript -->
                    </div>

                </div>

            </div>
            <div class="col-2">
                <a href="{{route('clinica.marcarConsultaSelecionarEspecialista',[$paciente->id,$especialista->id])}}" class="btn btn-primary"><i class="fa fa-reply"></i>
                    Voltar</a>
            </div>
        </div>
    </div>
</div>

<script>
    var currentWeekStart; // Variável global para armazenar o início da semana atual

    // Função para gerar o calendário semanal
    function generateWeeklyCalendar(startDate) {
        var meses = [
            "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
            "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
        ];
        var intervalodias = document.getElementById('intervalodias');

        var daysContainer = document.getElementById('calendarDays');
        daysContainer.innerHTML = ''; // Limpa o conteúdo anterior

        // Define a data de início da semana
        currentWeekStart = new Date(startDate);
        var currentDay = currentWeekStart.getDay(); // 0 = Domingo, 1 = Segunda, ..., 6 = Sábado
        //o codigo abaixo serve para definir o primeiro dia da semana sendo domingo
        //   currentWeekStart.setDate(currentWeekStart.getDate() - currentDay); // Define o primeiro dia da semana (segunda-feira)

        geraDias(currentWeekStart, daysContainer);

        var day = new Date(currentWeekStart);
        var dayMais7 = new Date(currentWeekStart);
        dayMais7.setDate(currentWeekStart.getDate() + 6);
        //  var dayText = dayMais7.getDate();
        var dayText = day.getDate() + ' de ' + (meses[day.getMonth()]) + ' a ' + dayMais7.getDate() + ' de ' + ((meses[dayMais7.getMonth()]));
        intervalodias.innerHTML = dayText;
    }

    //funcao para poder comparar as datas considerando apenas o dia, mes e ano.
    function normalizarDataParaComparacao(data) {
         return new Date(data.getFullYear(), data.getMonth(), data.getDate());
    }

     //funcao para poder verificar se existe consulta na data criada 
     function existeConsulta(dataTela) {
        @foreach($lista as $consulta)           
            var dataString ={!! json_encode(date( 'd/m/Y' , strtotime($consulta->horario_agendado))) !!}; 
            var partesData = dataString.split('/');    
            // Constrói um objeto Date no formato esperado (mês-1 porque o mês no objeto Date é baseado em zero)
            var data = new Date(partesData[2], partesData[1] - 1, partesData[0]);
            var data = normalizarDataParaComparacao(data);    
            if(data.getTime() === dataTela.getTime())
            {
                return true;               
            }
        @endforeach
        return false;
    }

    function geraDias(currentWeekStart, daysContainer) {
        // Loop para gerar os dias da semana
       
        for (var i = 0; i < 7; i++) {            
            var day = new Date(currentWeekStart);        
            var data1  =  new Date(day.setDate(currentWeekStart.getDate() + i));
            var data1 = normalizarDataParaComparacao(data1);
            //aqui desenhar o dia apenas se tiver consulta disponível             
            if(existeConsulta(data1)){   
                var dayElement = document.createElement('div');
                dayElement.id = "" + day.getDate() + '/' + (day.getMonth() + 1) + "/" + day.getFullYear();
                dayElement.classList.add('day');  
                var dayName = getDayName(day.getDay());
                var dayText = dayName + '<br>' + day.getDate() + '/' + (day.getMonth() + 1);
                dayElement.innerHTML = dayText;
                dayElement.onclick = function() {
                    //aqui esta dando erro ************* estpa passando sempre a ultima data.
                    consultasDisponiveis(this,data1.toDateString());
                };
                daysContainer.appendChild(dayElement);
           }
        }
    }

    function consultasDisponiveis(dayElement, dia) {
        var paragrafohora = document.getElementById('paragrafohora');
        paragrafohora.innerText = 'Selecione a hora'; // Limpa o conteúdo anterior
        var dataDoElemento = dayElement.innerHTML;
        var consultasContainer = document.getElementById('consultasDisponivel');
        consultasContainer.innerHTML = ''; // Limpa o conteúdo anterior

        var divs = document.querySelectorAll('.day');
        // Iterar sobre cada div e mudar o estilo
        divs.forEach(function(div) {
            div.style.backgroundColor = 'transparent';
        });
        dayElement.style.backgroundColor = 'lightblue';


        //desenhando as divs dos horarios das consultas
        @foreach($lista as $consulta)     

            var hora ={!! json_encode(date( 'H:i' , strtotime($consulta->horario_agendado))) !!};   
            var dataString ={!! json_encode(date( 'd/m/Y' , strtotime($consulta->horario_agendado))) !!}; 
            var partesData = dataString.split('/');    
            // Constrói um objeto Date no formato esperado (mês-1 porque o mês no objeto Date é baseado em zero)
            var data = new Date(partesData[2], partesData[1] - 1, partesData[0]);
            var data ="" + data.getDate() + '/' + (data.getMonth() + 1) + "/" + data.getFullYear();  
            var diaselecionado = dayElement.id;
            if(diaselecionado === data)
            {
                console.log("As datas são iguais."+dia+" "+data);                     
                var horaElemento = document.createElement('div');
                horaElemento.id =  {{$consulta->id}};
                horaElemento.classList.add('day');
                //aqui desenhar as consulta disponíveis no dia       

                horaElemento.innerHTML = " "+ hora+" ";         
                horaElemento.onclick = function() {
                    finalizar(this,diaselecionado);
                };
                consultasContainer.appendChild(horaElemento);
        }
        @endforeach

    }

    function finalizar(consultaElement,diaselecionado) {
       // alert('aqui chama modal finalizar:' + consultaElement.innerHTML+" id:"+consultaElement.id);
        document.getElementById('diaModal').textContent  = diaselecionado;
        document.getElementById('horarioModal').textContent  = consultaElement.innerHTML;
        document.getElementById('consulta_id').value  = consultaElement.id;
        // Abra o modal
        $('#modalFinalizarConsulta').modal('show');
    }

    // Função auxiliar para obter o nome do dia
    function getDayName(dayIndex) {
        var weekdays = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
        return weekdays[dayIndex];
    }

    // Função para navegar para a semana anterior
    function previousWeek() {
        var diaAtual = new Date();
        // deixando voltar apenas ateh a data atual
        if (currentWeekStart > diaAtual) {
            currentWeekStart.setDate(currentWeekStart.getDate() - 7); // Subtrai 7 dias (uma semana)
        }
        generateWeeklyCalendar(currentWeekStart);
        var consultasContainer = document.getElementById('consultasDisponivel');
        consultasContainer.innerHTML = ''; // Limpa o conteúdo anterior
        var paragrafohora = document.getElementById('paragrafohora');
        paragrafohora.innerText = ''; // Limpa o conteúdo anterior
    }

    // Função para navegar para a próxima semana
    function nextWeek() {
        currentWeekStart.setDate(currentWeekStart.getDate() + 7); // Adiciona 7 dias (uma semana)
        generateWeeklyCalendar(currentWeekStart);
        var consultasContainer = document.getElementById('consultasDisponivel');
        consultasContainer.innerHTML = ''; // Limpa o conteúdo anterior
        var paragrafohora = document.getElementById('paragrafohora');
        paragrafohora.innerText = ''; // Limpa o conteúdo anterior
    }

    // Chamada inicial para gerar o calendário ao carregar a página
    generateWeeklyCalendar(new Date()); // Começa com a data atual
</script>
@endsection