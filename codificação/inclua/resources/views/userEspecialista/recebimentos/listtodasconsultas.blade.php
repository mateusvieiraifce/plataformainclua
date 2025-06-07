@extends('layouts.app', ['page' => __('Pacientes'), 'exibirPesquisa' => false, 'pageSlug' => 'recebimentos', 'class' => 'agenda'])
@section('content')
    @section('title', 'Pacientes')

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
                                <fieldset>
                                    <div class="row">
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

                                        <div class="col-md-2 px-8">
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

                                        <div class="col-md-2 px-8">
                                            <div class="form-group">
                                                <label for="inicio_data">
                                                    Total Cartão  -  Inclua
                                                </label>
                                                <input type="text" name="cartao" id="inicio_data" readonly style="text-align: right"
                                                       class="form-control" @if(isset($cartao)) value="{{number_format($cartao, 2, ',', '.')}}" @endif>
                                            </div>
                                        </div>

                                        <div class="col-md-2 px-8">
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

                                        <div class="col-md-2 px-8">
                                            <div class="form-group">
                                                <label for="inicio_data">
                                                    Saldo
                                                </label>
                                                <input type="text" name="saldo" id="inicio_data" readonly style="text-align: right"
                                                       class="form-control" @if(isset($saldo)) value="{{number_format($saldo, 2, ',', '.')}}" @endif>
                                            </div>
                                        </div>

                                        <div class="col-sm-1">
                                            <button style="max-height: 40px; max-width: 40px;margin-top: 25px" class="btn btn-primary">
                                                <i class="tim-icons icon-zoom-split">
                                                </i></button>
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
                                <th> Data de Solicitacao </th>
                                <th> Status </th>
                                <th> Saldo </th>
                                <th> Total de consultas </th>
                                <th>  </th>
                                </thead>
                                <tbody>

                                @if(sizeof($lista) > 0)
                                    @foreach($lista as $ent)
                                        <tr>
                                            <td>{{date( 'd/m/Y' , strtotime($ent->created_at))}}
                                            <td>{{$ent->status}}</td>
                                            <td>{{\App\Helper::padronizaMonetario($ent->saldo) }}
                                            <td>{{$ent->numero_consultas}}</td>
                                            <td><a style="max-width:160px; text-align: left;padding:10px " rel="tooltip"
                                                   title="Prontuário" class="btn btn-secondary" data-original-title="Edit"
                                                   href="{{route('paciente.prontuario', $ent->id)}}">
                                                    Incluir Comprovante
                                                </a>   </td>
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
@endsection
