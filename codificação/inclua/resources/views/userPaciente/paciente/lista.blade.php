@extends('layouts.app', ['page' => __('Pacientes'), 'exibirPesquisa' => false, 'pageSlug' => 'pacientes', 'class' => 'pacientes'])
@section('title', 'Pacientes')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="title d-inline">Pacientes</h6>
                    <div class="dropdown">
                        <button type="button" class="btn btn-link dropdown-toggle btn-icon" data-toggle="dropdown">
                            <i class="tim-icons icon-settings-gear-63"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="{{ route('paciente.create') }}">Cadastrar paciente</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-full-width table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Sexo</th>
                                    <th>Data de Nascimento</th>
                                    <th>Foto</th>
                                    <th>Editar</th>
                                    <th>Desativar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pacientes as $paciente)
                                    <tr>
                                        <td>
                                            {{ $paciente->nome }}
                                        </td>
                                        <td>
                                            @if ($paciente->sexo == "F")
                                                Feminino
                                            @elseif ($paciente->sexo == "M")
                                                Masculino
                                            @elseif ($paciente->sexo == "O")
                                                Outro
                                            @else
                                                Não informado
                                            @endif
                                        </td>
                                        <td>
                                            {{ isset($paciente->data_nascimento) ? date('d/m/Y', strtotime($paciente->data_nascimento)) : "-" }}
                                        </td>


                                        <td class="td-actions text-left">

                                            <a href="#">
                                                <button type="button" rel="tooltip" title="Adicionar Foto" class="btn btn-link"
                                                        data-original-title="Edit Task" style="color: white;" onclick="uploadArquivo({{$paciente->id}})">

                                                    @if ($paciente->avatar)

                                                        <img src="{{ asset('storage/public/avatar-user/paciente/'.$paciente->avatar) }}"
                                                             alt="Descrição da imagem"
                                                             width="50"
                                                             height="auto"
                                                             title="Título da imagem"
                                                             loading="lazy">

                                                    @else
                                                        <i class="tim-icons icon-upload"></i>
                                                    @endif


                                                </button>
                                            </a>

                                        </td>

                                        <td class="td-actions text-left">

                                            <a href="{{ route('paciente.edit', $paciente->id) }}">
                                                <button type="button" rel="tooltip" title="Editar" class="btn btn-link"
                                                        data-original-title="Edit Task" style="color: white;">
                                                    <i class="tim-icons icon-pencil"></i>
                                                </button>
                                            </a>
                                        </td>
                                        <td class="td-actions text-left">
                                            <a href="{{ route('paciente.edit', $paciente->id) }}">
                                                <button type="button" rel="tooltip" title="Editar" class="btn btn-link"
                                                        data-original-title="Desative" style="color: white;">
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
        </div>
    </div>
    <div class="foto">
        <form name="arquivo" id="arquivo" enctype="multipart/form-data" method="post" action="{{route("paciente.foto.upload")}}">
            @csrf
            <div style="visibility: hidden">
                <input name="receb" type="file" text="incluir documento" class="form-control" id="inputArquivo" accept=",.jpg,.png,.docx">
                <input type="text" id="recebimentoSelecionado" name="recebimentoSelecionado">
            </div>


        </form>
    </div>

    <script>

        document.getElementById('inputArquivo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
                document.getElementById("arquivo").submit();
             //uploadFile(file);
        });
        function uploadArquivo(id){
                const fileReal = document.getElementById('inputArquivo');
                document.getElementById("recebimentoSelecionado").setAttribute("value", id);
                fileReal.click();
        }

    </script>
@endsection
