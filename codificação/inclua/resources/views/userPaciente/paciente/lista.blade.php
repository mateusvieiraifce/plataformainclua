@extends('layouts.app', ['page' => __('Pacientes'), 'exibirPesquisa' => false, 'pageSlug' => 'pacientes', 'class' => 'pacientes'])
@section('title', 'Pacientes')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="title d-inline">Pacientes</h6>
                    <div class="dropdown">
                        <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                            <i class="tim-icons icon-settings-gear-63"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('paciente.create') }}">Cadastrar paciente</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-full-width table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Sexo</th>
                                    <th>Data de Nascimento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pacientes as $paciente)
                                    <tr>
                                        <td>
                                            {{ $paciente->nome }}
                                        </td>
                                        <td>
                                            @if ($paciente->sexo == "F")
                                                Feminino
                                            @elseif ($paciente->sexo == "M")
                                                Masculino
                                            @elseif ($paciente->sexo == "O")
                                                Outro
                                            @else
                                                Não informado
                                            @endif
                                        </td>
                                        <td>
                                            {{ isset($paciente->data_nascimento) ? date('d/m/Y', strtotime($paciente->data_nascimento)) : "-" }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection