<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário Semanal com Navegação</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .calendar {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .weekdays {
            display: flex;
            justify-content: space-around;
            margin-bottom: 10px;
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
            width: 100px;
            height: 100px;
            border: 1px solid #ccc;
            text-align: center;
            line-height: 1.5;
            margin-right: 10px;
            margin-bottom: 10px;
            cursor: pointer;
        }

        .navigation {
            margin-top: 20px;
            text-align: center;
        }

        .navigation button {
            margin: 0 10px;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="calendar">
        <div class="navigation">
            <button onclick="previousWeek()">< </button>
                    <span id="intervalodias">Segunda-feira</span>
                    <button onclick="nextWeek()">></button>
        </div>
        <div class="weekdays">

        </div>
        <div class="days" id="calendarDays">
            <!-- Dias da semana serão gerados dinamicamente pelo JavaScript -->
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
            currentWeekStart.setDate(currentWeekStart.getDate() - currentDay); // Define o primeiro dia da semana (segunda-feira)

            // Loop para gerar os dias da semana
            for (var i = 0; i < 7; i++) {
                var day = new Date(currentWeekStart);
                day.setDate(currentWeekStart.getDate() + i);

                var dayElement = document.createElement('div');
                dayElement.classList.add('day');

                // Monta o conteúdo do dia com nome do dia e data completa
                //aqui desenhar o dia apenas se tiver consulta disponível
                var dayName = getDayName(day.getDay());
                var dayText = dayName + '<br>' + day.getDate() + '/' + (day.getMonth() + 1);
                dayElement.innerHTML = dayText;

                dayElement.addEventListener('click', function() {
                    alert('Você clicou no dia ' +  dayElement.textContent);
                    // Aqui você pode adicionar a lógica desejada para quando o dia for clicado
                    // Por exemplo: exibir detalhes, adicionar eventos, etc.
                });

                daysContainer.appendChild(dayElement);

              

            }
            var day = new Date(currentWeekStart);
            var dayMais7 = new Date(currentWeekStart);
            dayMais7.setDate(currentWeekStart.getDate() +6);
            //  var dayText = dayMais7.getDate();
            var dayText = day.getDate() + ' de ' + (meses[day.getMonth()]) + ' a ' + dayMais7.getDate() + ' de ' + ((meses[dayMais7.getMonth()]));
            intervalodias.innerHTML = dayText;
        }

        // Função auxiliar para obter o nome do dia
        function getDayName(dayIndex) {
            var weekdays = ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb'];
            return weekdays[dayIndex];
        }

        // Função para navegar para a semana anterior
        function previousWeek() {
            currentWeekStart.setDate(currentWeekStart.getDate() - 7); // Subtrai 7 dias (uma semana)
            generateWeeklyCalendar(currentWeekStart);
        }

        // Função para navegar para a próxima semana
        function nextWeek() {
            currentWeekStart.setDate(currentWeekStart.getDate() + 7); // Adiciona 7 dias (uma semana)
            generateWeeklyCalendar(currentWeekStart);
        }

        // Chamada inicial para gerar o calendário ao carregar a página
        generateWeeklyCalendar(new Date()); // Começa com a data atual
    </script>
</body>

</html>