@extends('layouts.app', ['page' => __('consulta'), 'pageSlug' => 'consulta', 'class' => 'consulta'])
@section('content')
<section class="bg0 p-t-104 p-b-116">
<style>
/* Adicionando um estilo personalizado para criar uma coluna e meia */
.custom-col {
    flex: 0 0 calc(5.5% * 1.5);
    max-width: calc(5.5% * 1.5);
    padding-right: 5px;
    padding-left: 5px;
}
</style>
  <div class="container">
    <div class="row">

      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Disponibilizar consultas</h5>
          </div>
          <div class="card-body">
            <form method="post" action="{{route('consulta.save', $especialista->id)}}">
              @csrf
              <div class="row">
                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Clinica_id</label>
                    <input style="border-color: #C0C0C0" type="text" class="form-control" name="clinica_id" required
                      value="{{$entidade->clinica_id}}" maxlength="150">
                  </div>
                </div>

                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Data início</label>
                    <input style="border-color: #C0C0C0" type="date" class="form-control" name="preco" required
                      value="{{$entidade->preco}}" maxlength="150">

                  </div>
                </div>

                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Data fim</label>
                    <input style="border-color: #C0C0C0" type="date" class="form-control" name="preco" required
                      value="{{$entidade->preco}}" maxlength="150">

                  </div>
                </div>

              </div>
              <div class="row">
                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Duração média (min)</label>
                    <input style="border-color: #C0C0C0" type="text" class="form-control" name="preco" required
                      value="{{$entidade->preco}}" maxlength="150">
                  </div>
                </div>
                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Horário de início dos atendimentos</label>
                    <input style="border-color: #C0C0C0" type="time" class="form-control" name="preco" required
                      value="{{$entidade->preco}}" maxlength="150">
                  </div>
                </div>
                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Horário de fim dos atendimentos</label>
                    <input style="border-color: #C0C0C0" type="time" class="form-control" name="preco" required
                      value="{{$entidade->preco}}" maxlength="150">
                  </div>
                </div>

              </div>

              <div class="row">
                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Preco</label>
                    <input style="border-color: #C0C0C0" type="text" class="form-control" name="preco" required
                      value="{{$entidade->preco}}" maxlength="150">
                  </div>
                </div>
                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Porcetagem_repasse_clinica</label>
                    <input style="border-color: #C0C0C0" type="text" class="form-control"
                      name="porcetagem_repasse_clinica" required value="{{$entidade->porcetagem_repasse_clinica}}"
                      maxlength="150">
                  </div>
                </div>
                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Porcetagem_repasse_plataforma</label>
                    <input style="border-color: #C0C0C0" type="text" class="form-control"
                      name="porcetagem_repasse_plataforma" required value="{{$entidade->porcetagem_repasse_plataforma}}"
                      maxlength="150">
                  </div>
                </div>
              </div>

              <label id="labelFormulario">Dias na semana de atemdimento</label>
              <div class="row">
            
              
                <div class="custom-col">
                  <label class="checkbox-inline"><input type="checkbox" name="dia" value="Segunda-feira">
                    Segunda</label>
                </div>
                <div class="custom-col ">
                  <label class="checkbox-inline"><input type="checkbox" name="dia" value="Terça-feira">
                    Terça</label>
                </div>
                <div class="custom-col">
                  <label class="checkbox-inline"><input type="checkbox" name="dia" value="Quarta-feira">
                    Quarta</label>
                </div>
                <div class="custom-col">
                  <label class="checkbox-inline"><input type="checkbox" name="dia" value="Quinta-feira">
                    Quinta</label>
                </div>
                <div class="custom-col">
                  <label class="checkbox-inline  mt-1 mb-1"><input type="checkbox" name="dia" value="Sexta-feira">
                    Sexta</label>
                </div>
                <div class="custom-col" >
                  <label class="checkbox-inline"><input type="checkbox" name="dia" value="Sábado"> Sábado</label>
                </div>
                <div class="custom-col">
                  <label class="checkbox-inline"><input type="checkbox" name="dia" value="Domingo"> Domingo</label>
                </div>
              </div>
              <input type="hidden" name="id" value="{{$entidade->id}}">
              <a href="{{route('consulta.list', $especialista->id)}}" class="btn btn-primary"><i
                  class="fa fa-reply"></i>
                Voltar</a>
              <button class="btn btn-success" onclick="$('#send').click(); "><i class="fa fa-save"></i> Salvar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
    @endsection