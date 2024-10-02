@extends('layouts.app', ['page' => __('Cadastro de Especialidade'), 'rotaPesquisa' => 'clinica.search', 'pageSlug' => 'especialidadeclinica', 'class' => 'especialidadeclinica'])
@section('content')
@section('title', 'Cadastro de Especialidade')
<section class="bg0 p-t-104 p-b-116">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5 class="title">Editar</h5>
        </div>
        <div class="card-body">
          <form method="post" action="{{route('especialidadeclinica.saveUserClinica', $clinica->id)}}">
            @csrf
            <div class="row">
              <div class="col-md-12 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Especialidade</label>
                  <select name="especialidade_id" id="especialidade_id" class="form-control"
                    title="Por favor selecionar ..." required style="border-color: white" onchange="atualizaValor()"
                    @if($entidade->id>0) <?php    echo 'disabled'; ?> @endif
                   
                    >
                    @foreach($especialidades as $iten)
                    <option style="color: #2d3748" value="{{old('especialidade_id', $iten->id)}}"
                      @if($iten->id == $entidade->especialidade_id) <?php    echo 'selected'; ?> @endif> {{$iten->descricao}}
                    </option>
          @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-12 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Valor</label>
                  <input style="border-color: #C0C0C0" type="number" step=".01" min="0" class="form-control"
                    name="valor" id="valor" required 
                    @if(isset($entidade->valor))
                       value="{{$entidade->valor}}" 
                    @else
                      value="{{$especialidades[0]->valorpadrao}}" 
                    @endif
                    maxlength="150">
                </div>
              </div>
            </div>
            <input type="hidden" name="id" value="{{$entidade->id}}">
            <input type="hidden" name="clinica_id" value="{{$clinica->id}}">
            <a href="{{route('especialidadeclinica.listclinicas')}}" class="btn btn-primary"><i
                class="fa fa-reply"></i> Voltar</a>
            <button class="btn btn-success" onclick="$('#send').click(); "><i class="fa fa-save"></i> Salvar</button>
        </div>
        </form>
      </div>
    </div>
    <script>
      function atualizaValor() {
        var selectValue = document.getElementById("especialidade_id").value;       
        @foreach($especialidades as $iten)
           if({{$iten->id}}==selectValue ){ 
            document.getElementById("valor").value = {{$iten->valorpadrao}};
           }
        @endforeach
      }
    </script>
    @endsection