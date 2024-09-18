@extends('layouts.app', ['page' => __('Exames'), 'exibirPesquisa' => false,'pageSlug' => 'exames', 'class' => 'exames'])
@section('title', 'Exames')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="title">Exames</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if($pedidoExames->count())
                            <table class="table">
                                <thead>
                                    <th>Paciente</th>
                                    <th>Exame</th>
                                    <th>Especialista solicitante</th>
                                    <th>Data de solicitação</th>
                                    <th>Efetuado?</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @foreach($pedidoExames as $pedidoExame)
                                        <tr>
                                            <td>
                                                {{ $pedidoExame->nome_paciente }}
                                            </td>
                                            <td>
                                                {{ $pedidoExame->nome_exame }}
                                            </td>
                                            <td>
                                                {{ $pedidoExame->nome_especialista }}
                                            </td>
                                            <td>
                                                {{ date('d/m/Y', strtotime($pedidoExame->data_solicitacao)) }}
                                            </td>
                                            <td>
                                                <div class="form-check text-left">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input" type="checkbox" id="pedido_exame_{{ $pedidoExame->pedido_exame_id }}" name="efetuado"
                                                            onclick="checkExame(this)" @if($pedidoExame->exame_efetuado == "Sim") checked @endif value="{{ $pedidoExame->pedido_exame_id }}">
                                                        <span class="form-check-sign"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                @if ($pedidoExame->local_arquivo_exame != null)
                                                    <a download href="{{ asset("$pedidoExame->local_arquivo_exame")}}" title="Abrir arquivo">
                                                        <i class="fa fa-file"></i>
                                                    </a>
                                                @else
                                                    <a href="#" title="Inserir arquivo" data-toggle="modal" onclick="insertPedidoExameId({{ $pedidoExame->pedido_exame_id }})" data-target="#modal-form">
                                                        <i class="fa fa-folder-open"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $pedidoExames->appends(request()->query())->links() }}
                        @else
                            <h5>Não há nenhuma solicitação de exame.</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL ARQUIVO --}}
    @component('layouts.form_modal', ["title" => "Inserir arquivo do exame", "route" => route('paciente.pedido_exames.file_store')])
        <div class="form-group">
            <label for="arquivo">
                Arquivo <span class="required">*</span>
            </label>
            <div class="custom-file">
                <input class="custom-file-input hidden" type="file" id="arquivo" name="arquivo" accept="image/jpeg,image/jpg,image/png,application/pdf">
                <label class="btn custom-file-label input-medium {{ $errors->has('arquivo') ? 'is-invalid' : '' }}" for="arquivo"></label>
            </div>
            @include('alerts.feedback', ['field' => 'arquivo'])
        </div>
        <input type="hidden" id="pedido_exame_id" name="pedido_exame_id" value="">
    @endcomponent

    <script>
        function insertPedidoExameId(pedido_exame_id) {
            document.getElementById('pedido_exame_id').value = pedido_exame_id;
        }

        function checkExame(checkbox) {
            if ($('#'+checkbox.id).is(':checked')) {
                var efetuado = "Sim"
            } else {
                var efetuado = "Não"
            }

            $.ajax({
                url: "{{ route('paciente.pedido_exames.check') }}",
                method: 'GET',
                data: {
                    pedido_exame_id: checkbox.value,
                    efetuado: efetuado
                },
                success: function(response) {
                    nowuiDashboard.showNotification('top', 'right', response, 'success');
                }
            });
        }
    </script>
@endsection