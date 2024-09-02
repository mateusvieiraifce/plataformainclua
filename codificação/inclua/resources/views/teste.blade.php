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




<!-- scpritp para filtrar os EXAMES a medida que eh digitado algo


 Modal add exames
<div class="modal fade" id="modalPedirExame" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
   aria-hidden="true">
   <div class="modal-dialog  modal-dialog-top modal-lg" role="document">
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
               <form method="post" action="{{route('pedido_exame.salveVarios')}}">
                  @csrf
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           <label>&nbsp; &nbsp; Exame:</label>
                           <input style="color: #111" type="text" placeholder="Digite o nome do exame"
                              name="pesquisaexame" id="pesquisaexame" class="form-control" value="">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label id="labelFormulario">Tipo</label>
                           <select style="color: #111;" name="tipoexame_id" id="tipoexame_id" class="form-control"
                              title="Por favor selecionar um tipo de exame ..." >
                              <option style="color: #2d3748" value="">Todos </option>
                              @foreach($tipoexames as $entLista)
                          <option style="color: #2d3748" value="{{old('tipoexame_id', $entLista->id)}}">
                            {{$entLista->descricao}}
                          </option>
                       @endforeach
                           </select>
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

                  <div class="row" style="width: 100%;">
                  <div class="col-6">
                     <fieldset >
                        <legend  style="font-size: 14px;">Selecionar exames</legend>
                        <div id="checkboxContainer" style="margin-left:30px">
                           <div class="row">
                              @foreach($exames as $entExame)                        
                          <div class="col-4">
                            <label>
                              <input type="checkbox" style="color: #2d3748"
                                 value="{{old('exame_id', $entExame->id)}}">
                              {{$entExame->nome}}
                            </label>
                          </div>
                       @endforeach                     
                           </div>
                        </div>
                     </fieldset>
                     </div>
                     <div class="col-6">
                     <fieldset>
                        <legend  style="font-size: 14px;">Exames selecionados</legend>
                        <div class="selected-items">                        
                           <ul style="color: #2d3748" id="selectedList"></ul>
                        </div>
                     </fieldset>
                     </div>
                     </div>

                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">
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

<script>
   // Lista de itens simulada que poderia vir do controlador
   const itemsExames = JSON.parse('{!! $exames !!}');
   const itemsExamesSelecionados = [];
   function renderCheckboxes(filteredItems) {
      const container = document.getElementById('checkboxContainer');
      container.innerHTML = ''; // Limpa o conteúdo anterior
      for (var i = 0; i < filteredItems.length; i++) {
         exame = filteredItems[i];
         const checkbox = document.createElement('div');
         checkbox.innerHTML = `          
         <label class="form-check-label"  style="color:#111">       
                    <input class="form-check-input" type="checkbox" id="${exame.id}" value="${exame.id}">                  
                          ${exame.nome}
                    </label>              
                    `;
      checkbox.querySelector('input').addEventListener('change', updateSelectedList);
      container.appendChild(checkbox);
      }
     // container.innerHTML =  container.innerHTML+'</div></div>';      
   }

   function filterItems(query) {
      var tipoSelecionado = document.getElementById('tipoexame_id');
      if (tipoSelecionado.value != "") {
         var filtraPeloTipo = itemsExames.filter(item => item.tipoexame_id == tipoSelecionado.value);
      } else {
         var filtraPeloTipo = itemsExames;
      }
      const filteredItems = filtraPeloTipo.filter(item => item.nome.toLowerCase().includes(query.toLowerCase()));
      renderCheckboxes(filteredItems);
   }

   document.getElementById('pesquisaexame').addEventListener('input', function () {
      const query = this.value.trim();
      filterItems(query);
   });

   // Renderizar todos os itens no início
   renderCheckboxes(itemsExames);

   function tipoAlterado(event) {
      var textoPesquisa = document.getElementById('pesquisaexame').value.trim();
      filterItems(textoPesquisa);
   }

   // Adiciona um ouvinte de eventos ao select do tipo 
   const selectElement = document.getElementById('tipoexame_id');
   selectElement.addEventListener('change', tipoAlterado);

   function updateSelectedList() {
      const selectedList = document.getElementById('selectedList');
      const selectedCheckboxes = document.querySelectorAll('#checkboxContainer input:checked');    

      selectedCheckboxes.forEach(checkbox => {  
         const label = checkbox.parentNode; 
         const descricao = label.textContent.trim();             
         const novoExame = {
                nome: descricao,
                id: checkbox.value
            };        
            const existe = itemsExamesSelecionados.some(objeto => objeto.id === novoExame.id);
            if (!existe) {
               itemsExamesSelecionados.push(novoExame);
            } 
      });
    
      let listaHTML = '<ul style="list-style-type: none; padding: 0; margin: 0;">';
      itemsExamesSelecionados.forEach(objeto => { 
            listaHTML += `<li  style="color:#111" id="${objeto.id}">     
            
            <input type="hidden" name="pedidosExames[]" value="${objeto.id}">

             ${objeto.nome}  <a onclick="removerItem(this)">
              <i class="tim-icons icon-simple-remove"></i>
              </a></li>`;    
      });
      listaHTML += '</ul>'; 
      const resultado = document.getElementById('selectedList');
      resultado.innerHTML = listaHTML || '<p>Nenhum checkbox selecionado.</p>';
       

   }

   function removerItem(botao) {
            const li = botao.parentNode; // Obtém o <li> pai do botão
            li.remove(); // Remove o <li> da lista
            const index = itemsExamesSelecionados.findIndex(objeto => objeto.id === li.id);
            if (index !== -1) {
                itemsExamesSelecionados.splice(index, 1);              
            }
        }
</script>
-->