@extends('layouts.app', ['page' => __('Perfil'), 'pageSlug' => 'profile','class'=>'profile'])
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="title">{{ __('Tamanhos') }}</h5>
                    <form autocomplete="off" enctype="multipart/form-data" method="post" action="{{route('advertisement.tamanho.add', $obj->id)}}" >
                        <input type="hidden" name="id" value="{{$obj->id}}">
                        <input type="hidden" name="idtamanho" value="{{$obj->idtamanho}}">
                        @csrf

                        <div class="card-body">

                            <div class="form-group{{ $errors->has('quantidade') ? ' has-danger' : '' }}">
                                <label id="qtd">{{ __('Quantidade') }}</label>
                                <input type="text" name="quantidade" class="form-control{{ $errors->has('quantidade') ? ' is-invalid' : '' }}" placeholder="{{ __('quantidade') }}" value="{{ old('quantidade') }}"  maxlength="15">
                                @include('alerts.feedback', ['field' => 'titulo'])
                            </div>
                            <div class="form-group{{ $errors->has('tamanho') ? ' has-danger' : '' }}">
                                <label id="tamanho">{{ __('Tamanho') }}</label>
                                <select name="tamanho" class="form-control{{ $errors->has('tamanho') ? ' is-invalid' : '' }}">
                                    @foreach($tamanhos as $tam)
                                        <option style="background-color: #1e1e2f" value="{{$tam->id}}">{{$tam->descricao}}</option>
                                    @endforeach

                                </select>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-group ">{{ __('Incluir') }}</button>


                                </div>
                                @include('alerts.feedback', ['field' => 'descricao'])
                            </div>

                            <div class="card-body ">
                                <div class="table-full-width table-responsive">
                                    <table class="table">
                                        <tbody>
                                        <tr>
                                            <td>Tamanho</td>
                                            <td>Qtd</td>
                                            <td>Editar</td>
                                            <td>Remover</td>
                                        </tr>

                                        @foreach($anuncios as $ende)
                                            <tr style="height: 20px">

                                                <td style="max-width: 200px;">
                                                    <p class="title">{{$ende->descricao}}</p>
                                                </td>

                                                <td>
                                                    <p class="title">{{\App\Helper::padronizaMonetario($ende->qtd_id)}}</p>
                                                </td>


                                                <td class="td-actions text-left">
                                                    <a href="{{route('advertisement.tamanho.edit',$ende->id)}}">
                                                        <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                                            <i class="tim-icons icon-pencil"></i>
                                                        </button>
                                                    </a>
                                                </td>
                                                <td class="td-actions text-left">
                                                    <a onclick="return confirm('Deseja realmente excluir?') " href="{{route('advertisement.tamanho.del',$ende->id)}}">
                                                        <button type="button" rel="tooltip" title="" class="btn btn-link" data-original-title="Edit Task">
                                                            <i class="tim-icons icon-simple-remove"></i>
                                                        </button>
                                                    </a>
                                                </td>


                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </form>
                    <div class="card-footer">
                        <a href="{{route('advertisement.tamanho.finalizar', $obj->id)}}" type="submit" class="btn btn-fill btn-primary">{{ __('Finalizar') }}</a>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>

        function showname(id, ret) {
            var name = document.getElementById(id);
            document.getElementById(ret).value =  name.files.item(0).name;
            //alert('Selected file: ' + name.files.item(0).name);
            /*alert('Selected file: ' + name.files.item(0).size);
            alert('Selected file: ' + name.files.item(0).type);*/

        }
    </script>
    <script src="/assets/js/functions.js">

    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>


@endsection
