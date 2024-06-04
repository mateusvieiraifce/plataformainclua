@extends('layouts.app', ['page' => __('especialista'), 'rotaPesquisa' => 'especialista.search', 'pageSlug' => 'especialista', 'class' => 'especialista'])
@section('title', 'Especialista')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5 class="title">Editar</h5>
        </div>
        <div class="card-body">
          <form method="post" action="{{route('especialista.save')}}">
            @csrf
            <div class="row">
              <div class="col-md-12 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Nome</label>
                  <input style="border-color: #C0C0C0" type="text" class="form-control" name="nome" required
                    value="{{$entidade->nome}}" maxlength="150">

                </div>
              </div>


              <div class="col-md-12 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Telefone</label>
                  <input style="border-color: #C0C0C0" type="tel" value="{{$entidade->telefone}}" name="telefone"
                    id="telefone" class="form-control" maxlength="150" required>
                </div>
              </div>

              <div class="col-md-12 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Especialidade</label>
                  <select name="especialidade_id" id="especialidade_id" class="form-control"
                    title="Por favor selecionar ..." required style="border-color: white">
                    @foreach($especialidades as $iten)
            <option style="color: #2d3748" value="{{old('especialidade_id', $iten->id)}}"
              @if($iten->id == $entidade->especialidade_id) <?php    echo 'selected'; ?> @endif> {{$iten->descricao}}
            </option>
          @endforeach
                  </select>
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-md-12 px-8">
                <div class="form-group">
                  <label id="labelFormulario">E-mail para login</label>
                  <input style="border-color: #C0C0C0" type="email" class="form-control" name="email" required
                    value="{{$usuario->email}}" maxlength="150">
                  @error('email')
            O e-mail já foi usado.
          @enderror
                </div>
              </div>
              <div class="col-md-12 px-8">
                <div class="form-group">
                  <label id="labelFormulario">Senha</label>
                  <input type="password" style="border-color: #C0C0C0" class="form-control" name="password"
                    @if(!$usuario->id) required @endif value="" maxlength="15">

                </div>
              </div>
            </div>

            <input type="hidden" name="id" value="{{$entidade->id}}">
            <input type="hidden" name="usuario_id" value="{{$entidade->usuario_id}}">
            <a href="{{route('especialista.list')}}" class="btn btn-primary"><i class="fa fa-reply"></i> Voltar</a>
            <button class="btn btn-success" onclick="$('#send').click(); "><i class="fa fa-save"></i> Salvar</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

  <script>
    $(document).ready(function ($) {
      $("#cep_input").mask("00000-000");
      $('#telefone').mask("(00) 0 0000-0000");
    });
  </script>
  @endsection