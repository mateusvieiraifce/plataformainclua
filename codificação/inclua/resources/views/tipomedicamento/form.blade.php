@extends('layouts.app', ['page' => __('tipomedicamento'), 'rotaPesquisa' => 'tipomedicamento.search', 'pageSlug' => 'tipomedicamento', 'class' => 'tipomedicamento'])
@section('content')
<div class="row">

  <div class="col-md-12">
    <div class="card">
      <div class="card-header">
        <h5 class="title">Editar</h5>
      </div>
      <div class="card-body">
        <form method="post" action="{{route('tipomedicamento.save')}}">
          @csrf

          <div class="col-md-12 px-8">
            <div class="form-group">
              <label id="labelFormulario">Descrição</label>
              <input style="border-color: #C0C0C0" type="text" class="form-control" name="descricao" required
                value="{{old('descricao', $entidade->descricao)}}" maxlength="150">

            </div>
          </div>

     
      <div class="col-md-12 px-8">
        <div class="form-group">
          <label id="labelFormulario">Quantidade de folhas</label>
          <input style="border-color: #C0C0C0" type="number" class="form-control" name="qtdFolha" required
            value="{{old('qtdFolha', $entidade->qtdFolha)}}" maxlength="150">
        </div>

        <input type="hidden" name="id" value="{{$entidade->id}}">
        <a href="{{route('tipomedicamento.list')}}" class="btn btn-primary"><i class="fa fa-reply"></i>
            Voltar</a>
        <button class="btn btn-success" onclick="$('#send').click(); "><i class="fa fa-save"></i>
            Salvar</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection