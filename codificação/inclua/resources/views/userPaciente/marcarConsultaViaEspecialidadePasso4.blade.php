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
                <a href="{{route('paciente.marcarConsultaViaEspecialidadePasso3',[$especialidade->id,$clinica->id])}}" class="btn btn-primary"><i class="fa fa-reply"></i>
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

    function geraDias(currentWeekStart, daysContainer) {

        // Loop para gerar os dias da semana
        for (var i = 0; i < 7; i++) {
            var day = new Date(currentWeekStart);
            day.setDate(currentWeekStart.getDate() + i);

            var dayElement = document.createElement('div');
            dayElement.id = "" + day.getDate() + '/' + (day.getMonth() + 1) + "/" + day.getFullYear();
            dayElement.classList.add('day');
            // Monta o conteúdo do dia com nome do dia e data completa
            //aqui desenhar o dia apenas se tiver consulta disponível
            var dayName = getDayName(day.getDay());
            var dayText = dayName + '<br>' + day.getDate() + '/' + (day.getMonth() + 1);
            dayElement.innerHTML = dayText;
            dayElement.onclick = function() {
                consultasDisponiveis(this);
            };
            daysContainer.appendChild(dayElement);
        }
    }

    function consultasDisponiveis(dayElement) {
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

        @foreach($lista as $consulta)       
              var dayElement = document.createElement('div');
            dayElement.id =  {{$consulta->id}};
            dayElement.classList.add('day');
            //aqui desenhar as consulta disponíveis no dia
            var hora = {{($consulta->horario_agendado).toString()}};
            alert(hora)
            dayElement.innerHTML = "<br>";
         
            dayElement.onclick = function() {
                finalizar(this);
            };
            consultasContainer.appendChild(dayElement);
        @endforeach

    }

    function finalizar(consultaElement) {
        alert('aqui chama modal finalizar:' + consultaElement.innerHTML);
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