@extends('layouts.app',['page' => __('especialistaclinica'), 'pageSlug' => 'especialistaclinica','class'=>'especialistaclinica'])
@section('content')
<section class="bg0 p-t-104 p-b-116">
   <div class="container">
  <div class="row">

     <div class="col-md-12">
         <div class="card">
            <div class="card-header">
                <h5 class="title">Adicionar especialista</h5>
            </div>
            <div class="card-body">
<form  method="post" action="{{route('especialistaclinica.save',$clinica->id)}}" >
  @csrf

   

 <div class="col-md-5 px-8">
            <div class="form-group">
              <label id="labelFormulario">Especialista</label>
        <select name="especialista_id" id="especialista_id" class="form-control"
        title="Por favor selecionar ..." required style="border-color: white">
          @foreach($especialistas as $iten)
            <option style="color: #2d3748"
              value="{{old('especialista_id', $iten->id)}}"
                @if($iten->id == $entidade->especialista_id)
                  <?php    echo 'selected'; ?>
                @endif
                > {{$iten->nome}}</option>
            @endforeach
          </select>
          </div>
          </div>
    <input type="hidden" name ="id" value="{{$entidade->id}}">
    <a href="{{route('especialistaclinica.list',$clinica->id)}}" class="btn btn-primary"><i class="fa fa-reply"></i><span> Voltar</span></a>

    <button class="btn btn-success" onclick="$('#send').click(); "><i class="fa fa-save"></i><span> Salvar</span></button>
 

    <a href="{{route('especialistaclinica.list',$clinica->id)}}" class="btn btn-info"><i class="tim-icons icon-email-85"></i><span> Enviar convite</span></a>
  </div>
</form>
           </div>
            </div>
     </div>
@endsection
