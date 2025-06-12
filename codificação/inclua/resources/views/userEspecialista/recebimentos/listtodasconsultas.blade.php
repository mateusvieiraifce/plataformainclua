@extends('layouts.app', ['page' => __('Recebimentos'), 'exibirPesquisa' => false, 'pageSlug' => 'recebimentos', 'class' => 'agenda'])
@section('content')
    @section('title', 'Recebimentos')

<style type="text/css">
    input:read-only {
       /* Light gray background */
        color: #ffffff;                /* Dark gray text */
        cursor: not-allowed;        /* Show "not allowed" cursor */
        border: 1px solid #ccc;     /* Optional: subtle border */
    }
</style>

    <div class="card">
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card card-tasks" style="height: auto; min-height: 500px;">
                    <div class="card-header">

                        <div class="col-lg-12 col-md-12">
                            <form action="{{route('especialista.recebeimentos.create')}}" method="post" id="pesquisar">
                                @csrf

                                <input type="hidden" value="{{$especialista_id}}" id="especialista_id">
                                <fieldset>
                                    <div class="row">

                                        <div class="col-md-3 px-8">
                                            <div class="form-group">
                                                <label id="labelFormulario">
                                                    Clínica(s) vinculada(s)
                                                </label>
                                                <div class="input-button-inline">
                                                    <select name="clinica_id" id="clinica_id" class="form-control">
                                                        @foreach($clinicas as $iten)
                                                            <option value="{{$iten->clinica_id}}"
                                                                    @if(isset($clinicaselecionada_id))
                                                                    @if($iten->clinica_id == $clinicaselecionada_id) selected @endif
                                                                @endif
                                                            >
                                                                {{$iten->nome}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 px-8">
                                            <div class="form-group">
                                                <label for="inicio_data">

                                                    Data início:
                                                </label>
                                                <input type="date" name="inicio_data" id="inicio_data" readonly
                                                       class="form-control" value="{{ (isset($inicio)) ? (\Carbon\Carbon::parse($inicio)->format('Y-m-d'))  : date('Y-m-d') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-2 px-8">
                                            <div class="form-group">
                                                <label for="final_data">
                                                    Data final:
                                                </label>
                                                <input type="date" name="final_data" id="final_data"
                                                       class="form-control" value="{{ (isset($fim)) ? (\Carbon\Carbon::parse($fim)->format('Y-m-d'))  : date('Y-m-d') }}">
                                            </div>
                                        </div>

                                        <div class="col-md-4 px-8">
                                            <div class="form-group">
                                                <label for="inicio_data">
                                                    Especialista
                                                </label>
                                                <input type="text" name="especialista" id="inicio_data" readonly
                                                       class="form-control" @if(isset($filtro)) value="{{$filtro}}" @endif>
                                            </div>
                                        </div>

                                        <div class="col-md-3 px-8">
                                            <div class="form-group">
                                                <label for="inicio_data">
                                                    Número de Consultas
                                                </label>
                                                <input type="text" name="numero" id="inicio_data" readonly style="text-align: right"
                                                       class="form-control" @if(isset($numero)) value="{{number_format($numero, 0, ',', '.')}}" @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-2 px-8">
                                            <div class="form-group">
                                                <label for="inicio_data">
                                                   Total Pix
                                                </label>
                                                <input type="text" name="pix" id="inicio_data" readonly style="text-align: right"
                                                       class="form-control" @if(isset($pix)) value="{{number_format($pix, 2, ',', '.')}}" @endif>
                                            </div>
                                        </div>



                                        <div class="col-md-2 px-8">
                                            <div class="form-group">
                                                <label for="inicio_data">
                                                    Total em Dinheiro(R$)
                                                </label>
                                                <input type="text" name="especie" id="inicio_data" readonly style="text-align: right"
                                                       class="form-control" @if(isset($especie)) value="{{number_format($especie, 2, ',', '.')}}" @endif>
                                            </div>
                                        </div>

                                        <div class="col-md-4 px-8">
                                            <div class="form-group">
                                                <label for="inicio_data">
                                                    Total Cartão  -  Inclua
                                                </label>
                                                <input type="text" name="cartao" id="inicio_data" readonly style="text-align: right"
                                                       class="form-control" @if(isset($cartao)) value="{{number_format($cartao, 2, ',', '.')}}" @endif>
                                            </div>
                                        </div>

                                        <div class="col-md-3 px-8">
                                            <div class="form-group">
                                                <label for="inicio_data">
                                                    Total Cartão  - Maquineta
                                                </label>
                                                <input type="text" name="maquina" id="inicio_data" readonly style="text-align: right"
                                                       class="form-control" @if(isset($maquina)) value="{{number_format($maquina, 2, ',', '.')}}" @endif>
                                            </div>
                                        </div>

                                        <div class="col-md-2 px-8">
                                            <div class="form-group">
                                                <label for="inicio_data">
                                                   Comissão Clínica
                                                </label>
                                                <input type="text" name="comissao_clinica" id="inicio_data" readonly style="text-align: right"
                                                       class="form-control" @if(isset($comissaoClinica)) value="{{number_format($comissaoClinica, 2, ',', '.')}}" @endif>
                                            </div>
                                        </div>

                                        <div class="col-md-2 px-8">
                                            <div class="form-group">
                                                <label for="inicio_data">
                                                    Comissão Inclua
                                                </label>
                                                <input type="text" name="comissao_inclua" id="inicio_data" readonly style="text-align: right"
                                                       class="form-control" @if(isset($comissaoInclua)) value="{{number_format($comissaoInclua, 2, ',', '.')}}" @endif>
                                            </div>
                                        </div>

                                        <div class="col-md-4 px-8">
                                            <div class="form-group">
                                                <label for="inicio_data">
                                                    Saldo
                                                </label>
                                                <input type="text" name="saldo" id="inicio_data" readonly style="text-align: right"
                                                       class="form-control" @if(isset($saldo)) value="{{number_format($saldo, 2, ',', '.')}}" @endif>
                                            </div>
                                        </div>
                                        <div class="col-md-4 px-8">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-fill btn-primary">{{ __('Solicitar') }} <i class="tim-icons icon-money-coins"> </i></button>

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
                                                @if ($ent->saldo>0)
                                                <a style="max-width:160px; text-align: left;padding:10px " rel="tooltip"
                                                   title="Prontuário" class="btn btn-secondary" data-original-title="Edit"
                                                   href="#">
                                                    @if ($ent->saldo>0)
                                                    Ver Comprovante
                                                    @endif
                                                </a>
                                                @else
                                                    @if ($ent->status!="F")
                                                    <a style="max-width:160px; text-align: left;padding:10px " rel="tooltip"
                                                       title="Prontuário" class="btn btn-secondary" data-original-title="Edit"
                                                       href="{{route("pix.generate.recebimento",$ent->id)}}">
                                                        Pagar
                                                    </a>
                                                    @endif
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

    <script>
        document.getElementById('clinica_id').addEventListener('change', function() {
            const selectedValue = this.value;
            const id = document.getElementById("especialista_id").value
            if (selectedValue) {

                const baseRoute = "{{ route('especialista.recebeimentos.list', ['clinicaId' => '']) }}";

                // Remove any trailing slash if present
                const cleanRoute = baseRoute.endsWith('/')
                    ? baseRoute.slice(0, -1)
                    : baseRoute;
                // Or for a named parameter route like '/items/{id}'
                 window.location.href = `${cleanRoute}/${id}/${selectedValue}`;

            }
        });
    </script>
@endsection
