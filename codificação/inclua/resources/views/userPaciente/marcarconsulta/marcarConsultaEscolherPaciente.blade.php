@extends('layouts.app', ['page' => __('Marcar Consulta'),'exibirPesquisa' => false, 'pageSlug' => 'marcarconsulta', 'class' => 'especialidade'])
@section('title', 'Marcar Consulta')
@section('content')
<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="title d-inline">Escolha o paciente</h6>
            </div>
            <div class="card-body">
                <div class="table-full-width table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pacientes as $ent)
                            <tr>
                                <td>
                                    {{ $ent->nome }}
                                </td>
                                <td>
                                    <a style="max-height: 35px;" href="{{route('paciente.marcarconsulta', $ent->id)}}" 
                                    class="btn btn-success">Próximo <i class="tim-icons icon-double-right"> </i> </a>
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