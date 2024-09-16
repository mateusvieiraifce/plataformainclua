@extends('layouts.app', ['page' => __('Agenda'), 'exibirPesquisa' => false, 'pageSlug' => 'especialistaclinica', 'class' => 'consulta'])
@section('content')
<section class="bg0 p-t-104 p-b-116">
<style>
/* Adicionando um estilo personalizado para criar uma coluna e meia */
.custom-col {
    flex: 0 0 calc(5.5% * 1.5);
    max-width: calc(5.5% * 1.5);
    padding-right: 5px;
    padding-left: 5px;
    margin-left: 40px;
    font-size: 30px;
}
</style>
<script>
function validarCheckBoxes() {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    var peloMenosUmSelecionado = false;
    
    checkboxes.forEach(function(checkbox) {
        if (checkbox.checked) {
            peloMenosUmSelecionado = true;
        }
    });
    
    if (!peloMenosUmSelecionado) {
        alert("Por favor, selecione pelo menos um dia da semana.");
        return false;
    }
    
    return true;
}
</script>

    <div class="row">

      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5 class="title">Disponibilizar consultas para o especialista {{$especialista->nome}}</h5>
          </div>
          <div class="card-body">
            <form method="post" action="{{route('consulta.saveVariasConsultasUserClinica', $especialista->id)}}" onsubmit="return validarCheckBoxes()">
              @csrf
              <div class="row">

             
              @php
                use Carbon\Carbon;
                $data = Carbon::now()->addMonths(1);
              @endphp


                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Data início</label>
                    <input style="border-color: #C0C0C0" type="date" class="form-control" name="data_inicio" required
                      value="{{date('Y-m-d') }}" maxlength="150">

                  </div>
                </div>

                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Data fim</label>
                    <input style="border-color: #C0C0C0" type="date" class="form-control" name="data_fim" required
                      value="{{\Carbon\Carbon::now()->addMonth()->format('Y-m-d') }}" maxlength="150">

                  </div>
                </div>

                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Duração média (min)</label>
                    <input style="border-color: #C0C0C0" type="number" min="1" step="1" class="form-control" name="duracao_media" required
                      value="" maxlength="150">
                  </div>
                </div>

              </div>
              <div class="row">
               
                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Intervalo entre as consultas (min)</label>
                    <input style="border-color: #C0C0C0" type="number" min="0" step="1" class="form-control" name="intervalo_consulta" required
                      value="" maxlength="150">
                  </div>
                </div>

                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Horário de início dos atendimentos</label>
                    <input style="border-color: #C0C0C0" type="time" class="form-control" name="hora_inicio" required
                      value="" maxlength="150">
                  </div>
                </div>
                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Horário de fim dos atendimentos</label>
                    <input style="border-color: #C0C0C0" type="time" class="form-control" name="hora_fim" required
                      value="" maxlength="150">
                  </div>
                </div>

              </div>

              <div class="row">           
                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Preço</label>
                    <input style="border-color: #C0C0C0" type="number" step="0.01" class="form-control" name="preco" required
                      value="{{$precoConsulta}}" maxlength="150">
                  </div>
                </div>
                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Porcetagem de repasse para clínica</label>
                    <input style="border-color: #C0C0C0" type="text" class="form-control"
                      name="porcetagem_repasse_clinica"  required value="{{$entidade->porcetagem_repasse_clinica}}"
                      maxlength="150">
                  </div>
                </div>
                <div class="col-md-4 px-8">
                  <div class="form-group">
                    <label id="labelFormulario">Porcetagem de repasse para plataforma</label>
                    <input style="border-color: #C0C0C0" type="text" class="form-control"
                      name="porcetagem_repasse_plataforma" required value="{{$entidade->porcetagem_repasse_plataforma}}"
                      maxlength="150">
                  </div>
                </div>
              </div>

              <label id="labelFormulario">Dias na semana de atemdimento</label>
              <div class="row">
                <div class="custom-col">
                  <label class="checkbox-inline"><input type="checkbox" name="dia[]" value="1">
                    Segunda</label>
                </div>
                <div class="custom-col ">
                  <label class="checkbox-inline"><input type="checkbox" name="dia[]" value="2">
                    Terça</label>
                </div>
                <div class="custom-col">
                  <label class="checkbox-inline"><input type="checkbox" name="dia[]" value="3">
                    Quarta</label>
                </div>
                <div class="custom-col">
                  <label class="checkbox-inline"><input type="checkbox" name="dia[]" value="4">
                    Quinta</label>
                </div>
                <div class="custom-col">
                  <label class="checkbox-inline  mt-1 mb-1"><input type="checkbox" name="dia[]" value="5">
                    Sexta</label>
                </div>
                <div class="custom-col" >
                  <label class="checkbox-inline"><input type="checkbox" name="dia[]" value="6"> Sábado</label>
                </div>
                <div class="custom-col">
                  <label class="checkbox-inline"><input type="checkbox" name="dia[]" value="0"> Domingo</label>
                </div>
              </div>
              <input type="hidden" name="id" value="{{$entidade->id}}">
              <input type="hidden" name="especialista_id" value="{{$especialista->id}}">


              <a href="{{route('especialistaclinica.list')}}" class="btn btn-primary"><i
                  class="fa fa-reply"></i>
                Voltar</a>
              <button class="btn btn-success" onclick="$('#send').click(); "><i class="fa fa-save"></i> Disponibilizar</button>


          </form>
          </div>
        </div>
      </div>
    </div>

@endsection
