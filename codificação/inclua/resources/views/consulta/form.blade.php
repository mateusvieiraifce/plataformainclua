@extends('layouts.app', ['page' => __('consulta'), 'pageSlug' => 'consulta', 'class' => 'consulta'])
@section('content')
<section class="bg0 p-t-104 p-b-116">
  <div class="container">
    <div class="row">

      <div class="col-md-10">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Editar</h5>
          </div>
          <div class="card-body">
            <form method="post" action="{{route('consulta.save', $especialista->id)}}">
              @csrf

              <div class="col-md-5 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Status</label>
                  <input style="border-color: #C0C0C0" type="text" class="form-control" name="status" required
                    value="{{$entidade->status}}" maxlength="150">

                </div>
              </div>
              <div class="col-md-5 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Horario_agendado</label>
                  <input style="border-color: #C0C0C0" type="text" class="form-control" name="horario_agendado" required
                    value="{{$entidade->horario_agendado}}" maxlength="150">

                </div>
              </div>
              <div class="col-md-5 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Horario_iniciado</label>
                  <input style="border-color: #C0C0C0" type="text" class="form-control" name="horario_iniciado" required
                    value="{{$entidade->horario_iniciado}}" maxlength="150">

                </div>
              </div>
              <div class="col-md-5 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Horario_finalizado</label>
                  <input style="border-color: #C0C0C0" type="text" class="form-control" name="horario_finalizado"
                    required value="{{$entidade->horario_finalizado}}" maxlength="150">

                </div>
              </div>
              <div class="col-md-5 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Preco</label>
                  <input style="border-color: #C0C0C0" type="text" class="form-control" name="preco" required
                    value="{{$entidade->preco}}" maxlength="150">

                </div>
              </div>
              <div class="col-md-5 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Porcetagem_repasse_clinica</label>
                  <input style="border-color: #C0C0C0" type="text" class="form-control"
                    name="porcetagem_repasse_clinica" required value="{{$entidade->porcetagem_repasse_clinica}}"
                    maxlength="150">

                </div>
              </div>
              <div class="col-md-5 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Porcetagem_repasse_plataforma</label>
                  <input style="border-color: #C0C0C0" type="text" class="form-control"
                    name="porcetagem_repasse_plataforma" required value="{{$entidade->porcetagem_repasse_plataforma}}"
                    maxlength="150">

                </div>
              </div>
              <div class="col-md-5 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Paciente_id</label>
                  <input style="border-color: #C0C0C0" type="text" class="form-control" name="paciente_id" required
                    value="{{$entidade->paciente_id}}" maxlength="150">

                </div>
              </div>
              <div class="col-md-5 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Especialista_id</label>
                  <input style="border-color: #C0C0C0" type="text" class="form-control" name="especialista_id" required
                    value="{{$entidade->especialista_id}}" maxlength="150">

                </div>
              </div>
              <div class="col-md-5 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Clinica_id</label>
                  <input style="border-color: #C0C0C0" type="text" class="form-control" name="clinica_id" required
                    value="{{$entidade->clinica_id}}" maxlength="150">

                </div>
              </div>
              <input type="hidden" name="id" value="{{$entidade->id}}">
              <a href="{{route('consulta.list', $especialista->id)}}" class="btn btn-primary"><i class="fa fa-reply"></i>
                Voltar</a>
              <button class="btn btn-success" onclick="$('#send').click(); "><i class="fa fa-save"></i> Salvar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    @endsection