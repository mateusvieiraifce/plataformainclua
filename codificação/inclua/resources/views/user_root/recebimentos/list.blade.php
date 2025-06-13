@extends('layouts.app', ['page' => __('Pagamentos'), 'exibirPesquisa' => false, 'pageSlug' => 'historico-pagamentos-pacientes', 'class' => 'pagamentos'])
@section('title', 'Pagamentos')
@section('content')

    <div class="card">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card card-tasks" style="height: auto; min-height: 500px;">
                    <div class="card-header">

                        <div class="col-lg-12 col-md-12">
                            <form action="{{route('root.recebimentos.solicitacoes')}}" method="post" id="pesquisar" name="pesquisar">
                                @csrf

                                <fieldset>
                                    <div class="row">

                                        <div class="col-md-3 px-8">
                                            <div class="form-group">
                                                <label id="labelFormulario">
                                                    Clínica(s) vinculada(s)
                                                </label>
                                                <div class="input-button-inline">
                                                    <select name="clinica_id" id="clinica_id" class="form-control">
                                                        <option value="">Todos</option>
                                                        @foreach($clinicas as $iten)
                                                            <option value="{{$iten->id}}"
                                                                    @if(isset($clinicaId))
                                                                        @if($clinicaId==$iten->id) selected @endif
                                                                @endif
                                                            >
                                                                {{$iten->nome}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-4 px-8">
                                            <div class="form-group">
                                                <label for="inicio_data">
                                                    Especialista
                                                </label>
                                                <div class="input-button-inline">
                                                    <select name="especialista_id" id="especialista_id" class="form-control">
                                                        <option value=""> Todos</option>
                                                        @foreach($especialistas as $iten)
                                                            <option value="{{$iten->id}}"
                                                                    @if(isset($especialistaId))
                                                                        @if($iten->id == $especialistaId) selected @endif
                                                                @endif
                                                            >
                                                                {{$iten->nome}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 px-8">
                                            <div class="form-group">
                                                <label for="inicio_data">
                                                    Situaçao
                                                </label>
                                                <div class="input-button-inline">
                                                    <select name="situacao" id="situacao" class="form-control">
                                                        <option value=""> Todos</option>
                                                        <option value="A" @if($situacao=="A") selected @endif> Aberto</option>
                                                        <option value="F" @if($situacao=="F") selected @endif> Fechado</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-sm-1">
                                        </div>


                                    </div>

                                </fieldset>
                            </form>
                        </div>

                        <h6 class="title d-inline">Lista de Solicitaçao de Recebimentos </h6>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <th>Solicitação </th>
                                <th> Status </th>
                                <th> Consultas </th>
                                <th> Saldo </th>
                                <th> Situação </th>
                                <th> Pix (R$)</th>
                                <th> Dinheiro(R$) </th>
                                <th> Cart. Inclua(R$) </th>
                                <th> Cart. Maquineta(R$) </th>
                                <th> Comissão Inclua(R$) </th>
                                <th> Especialista </th>

                                <th>  </th>
                                </thead>
                                <tbody>

                                @if(sizeof($lista) > 0)
                                    @foreach($lista as $ent)
                                        <tr>
                                            <td>{{date( 'd/m/Y' , strtotime($ent->created_at))}}
                                            <td>{{$ent->status}}</td>
                                            <td>{{$ent->numero_consultas}}</td>
                                            <td>{{\App\Helper::padronizaMonetario($ent->saldo) }}
                                            <td>{{$ent->pagamento?"Creditado":"Em Aberto"}}</td>
                                            <td>{{\App\Helper::padronizaMonetario($ent->total_consultas_pix) }}
                                            <td>{{\App\Helper::padronizaMonetario($ent->total_consultas_especie) }}
                                            <td>{{\App\Helper::padronizaMonetario($ent->total_consultas_credito) }}
                                            <td>{{\App\Helper::padronizaMonetario($ent->total_consultas_maquininha) }}
                                            <td>{{\App\Helper::padronizaMonetario($ent->taxa_inclua) }}
                                            <td>{{$ent->especialista_nome}}</td>
                                            <td>

                                                @if ($ent->comprovante=="")
                                                    <a style="max-width:160px; text-align: left;padding:10px " rel="tooltip"
                                                       title="Prontuário" class="btn btn-secondary" data-original-title="Edit"
                                                       href="#" onclick="uploadArquivo({{$ent->id}})">
                                                        @if ($ent->saldo>0)
                                                            Incluir Comprovante
                                                        @endif
                                                    </a>
                                                @else
                                                        <a style="max-width:160px; text-align: left;padding:10px " rel="tooltip"
                                                           title="Prontuário" class="btn btn-secondary" data-original-title="Edit"
                                                           href="{{route("root.recebimentos.download",$ent->id)}}">
                                                            Download
                                                        </a>
                                                @endif

                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            @if(isset($lista))
                                <div>
                                    {{$lista->appends(request()->query())->links()}}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <form name="arquivo" id="arquivo" enctype="multipart/form-data" method="post" action="{{route("root.recebimentos.upload")}}">
        @csrf
        <div style="visibility: hidden">
            <input name="receb" type="file" text="incluir documento" class="form-control" id="inputArquivo" accept=".pdf,.jpg,.png,.docx">
            <input type="text" id="recebimentoSelecionado" name="recebimentoSelecionado">
        </div>


    </form>

    <script>
        document.getElementById('clinica_id').addEventListener('change', function() {
           // Só envia se um valor foi selecionado
                document.getElementById('pesquisar').submit();

        });
        document.getElementById('especialista_id').addEventListener('change', function() {
           // Só envia se um valor foi selecionado
                document.getElementById('pesquisar').submit();

        });
        document.getElementById('situacao').addEventListener('change', function() {
            // Só envia se um valor foi selecionado
            document.getElementById('pesquisar').submit();

        });
    </script>
    <script>

        document.getElementById('inputArquivo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
             document.getElementById("arquivo").submit();
           // uploadFile(file);
        });
        function uploadArquivo(id){
            const fileReal =  document.getElementById('inputArquivo');
            document.getElementById("recebimentoSelecionado").setAttribute("value",id);
            fileReal.click();

        }

    </script>


@endsection
