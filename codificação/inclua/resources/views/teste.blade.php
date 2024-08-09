@extends('layouts.app', ['page' => __('Marcar Consulta'), 'exibirPesquisa' => false, 'pageSlug' => 'marcarconsulta', 'class' => 'especialidade'])
@section('title', 'Marcar Consulta')
@section('content')
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação de Consulta</title>
    <style>
        /* Estilos do Modal */
        .modal {
            display: none;
            /* Esconde o modal por padrão */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .star-rating {
            display: flex;
            gap: 5px;
        }

        .star {
            font-size: 40px;
            cursor: pointer;
        }

        .star.selected {
            color: gold;
        }
    </style>
</head>

<body>

    <!-- O botão que abre o modal -->
    <button id="openModal">Avaliar Consulta</button>

    <!-- O Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Avalie sua Consulta</h2>
            <div class="star-rating">
                <span class="star" id="s1" data-value="1">&#9733;</span>
                <span class="star" id="s2" data-value="2">&#9733;</span>
                <span class="star" id="s3" data-value="3">&#9733;</span>
                <span class="star" id="s4" data-value="4">&#9733;</span>
                <span class="star" id="s5" data-value="5">&#9733;</span>
            </div>
            <button id="submitRating">Enviar Avaliação</button>
        </div>
    </div>

    <script>
        // Obter o modal
        var modal = document.getElementById("myModal");

        // Obter o botão que abre o modal
        var btn = document.getElementById("openModal");

        // Obter o elemento <span> que fecha o modal
        var span = document.getElementsByClassName("close")[0];

        // Quando o usuário clicar no botão, abre o modal
        btn.onclick = function () {
            modal.style.display = "block";
        }

        // Quando o usuário clicar no <span> (x), fecha o modal
        span.onclick = function () {
            modal.style.display = "none";
        }

        // Quando o usuário clicar fora do modal, fecha o modal
        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Gerenciar a seleção das estrelas
        document.querySelectorAll('.star').forEach(function (star) {
            star.addEventListener('click', function () {
                document.querySelectorAll('.star').forEach(function (s) {
                      s.classList.remove('selected');
                });
                var qtd = star.getAttribute('data-value');
                for (var i = 0; i <= qtd; i++) {
                    var id = 's' + i;
                    var estrela = document.getElementById(id);
                    if (estrela) {
                       estrela.classList.add('selected');
                    }
                }
            });
        });

        // Enviar avaliação
        document.getElementById('submitRating').addEventListener('click', function () {
            let rating = document.querySelector('.star.selected')?.getAttribute('data-value');
            if (rating) {
                alert('Você avaliou com ' + rating + ' estrelas.');
                modal.style.display = 'none';
            } else {
                alert('Por favor, selecione uma avaliação.');
            }
        });
    </script>

</body>

</html>

@endsection