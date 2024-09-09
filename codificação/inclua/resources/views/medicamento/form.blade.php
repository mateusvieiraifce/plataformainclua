@extends('layouts.app', ['page' => __('medicamento'), 'rotaPesquisa' => 'medicamento.search', 'pageSlug' => 'medicamento', 'class' => 'medicamento'])
@section('content')
<div class="row">

  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="title">Editar</h5>
      </div>
      <div class="card-body">
        <form method="post" action="{{route('medicamento.save')}}">
          @csrf

          <div class="col-md-12 px-8">
            <div class="form-group">
              <label id="labelFormulario">Nome Comercial</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="nome_comercial" required
                value="{{old('nome_comercial', $entidade->nome_comercial)}}" maxlength="150">

            </div>
          </div>
          <div class="col-md-12 px-8">
            <div class="form-group">
              <label id="labelFormulario">Nome Genérico</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="nome_generico" 
                value="{{old('nome_generico', $entidade->nome_generico)}}" maxlength="150">

            </div>
          </div>
          <div class="col-md-12 px-8">
            <div class="form-group">
              <label id="labelFormulario">Forma</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="forma" 
                value="{{old('forma', $entidade->forma)}}" maxlength="150">

            </div>
          </div>
          <div class="col-md-12 px-8">
            <div class="form-group">
              <label id="labelFormulario">Concentração</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="concentracao" 
                value="{{old('concentracao', $entidade->concentracao)}}" maxlength="150">

            </div>
          </div>
          <div class="col-md-12 px-8">
            <div class="form-group">
              <label id="labelFormulario">Via</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="via" 
                value="{{old('via', $entidade->via)}}" maxlength="150">

            </div>
          </div>
          <div class="col-md-12 px-8">
            <div class="form-group">
              <label id="labelFormulario">Indicação</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="indicacao" 
                value="{{old('indicacao', $entidade->indicacao)}}" maxlength="150">

            </div>
          </div>
          <div class="col-md-12 px-8">
            <div class="form-group">
              <label id="labelFormulario">Posologia</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="posologia" 
                value="{{old('posologia', $entidade->posologia)}}" maxlength="150">

            </div>
          </div>
          <div class="col-md-12 px-8">
            <div class="form-group">
              <label id="labelFormulario">Precaução</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="precaucao" 
                value="{{old('precaucao', $entidade->precaucao)}}" maxlength="150">

            </div>
          </div>
          <div class="col-md-12 px-8">
            <div class="form-group">
              <label id="labelFormulario">Advertência</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="advertencia" 
                value="{{old('advertencia', $entidade->advertencia)}}" maxlength="150">

            </div>
          </div>
          <div class="col-md-12 px-8">
            <div class="form-group">
              <label id="labelFormulario">Contraindicação</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="contraindicacao" 
                value="{{old('contraindicacao', $entidade->contraindicacao)}}" maxlength="150">

            </div>
          </div>
          <div class="col-md-12 px-8">
            <div class="form-group">
              <label id="labelFormulario">Composição</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="composicao" 
                value="{{old('composicao', $entidade->composicao)}}" maxlength="150">

            </div>
          </div>
          <div class="col-md-12 px-8">
            <div class="form-group">
              <label id="labelFormulario">Latoratório Fabricante</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="latoratorio_fabricante"
                 value="{{old('latoratorio_fabricante', $entidade->latoratorio_fabricante)}}" maxlength="150">

            </div>
          </div>
          <div class="col-md-12 px-8">
            <div class="form-group">
              <label id="labelFormulario">Tipo de Medicamento</label>
              <select  style="border-color: #C0C0C0" name="tipo_medicamento_id" id="tipo_medicamento_id" class="form-control"
                title="Por favor selecionar ..." required> style="border-color: white"
                @foreach($tipo_medicamentos as $iten)
          <option style="border-color: #C0C0C0;color: #2d3748" value="{{old('tipo_medicamento_id', $iten->id)}}"
            @if($iten->id == $entidade->tipo_medicamento_id) <?php    echo 'selected'; ?> @endif> {{$iten->descricao}}
          </option>
        @endforeach
              </select>
            </div>
          </div>
          <input type="hidden" name="id" value="{{$entidade->id}}">
          <a href="{{route('medicamento.list')}}" class="btn btn-primary"><i class="fa fa-reply"></i>
              Voltar</a>
          <button class="btn btn-success" onclick="$('#send').click(); ">
            <i class="fa fa-save"></i>
              Salvar</button>


      </div>
      </form>
    </div>
  </div>
</div>
@endsection