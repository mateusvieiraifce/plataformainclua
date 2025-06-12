@if(\Illuminate\Support\Facades\Auth::check())
    @if($class!="login-page")
        <div class="sidebar">
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <!-- usuario tipo clinica -->
                    @if(\Illuminate\Support\Facades\Auth::user()->tipo_user === 'C')
                        <?php
                            $clinica = App\Models\Clinica::where('usuario_id', '=', Auth::user()->id)->first();
                        ?>

                        <li @if ($pageSlug == 'dashboard') class="active" @endif>
                            <a href="{{route('dashboard.dashboardClinica')}}">
                                <i class="tim-icons icon-chart-pie-36"></i>
                                <p>{{ __('Dashboard') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'listaAgenda') class="active" @endif>
                            <a href="{{route('consulta.agendaConsultas',$clinica->id)}}">
                                <i class="tim-icons icon-calendar-60"></i>
                                <p>{{ __('Agenda') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'fila') class="active" @endif>
                            <a href="{{route('fila.listEspecialistaDaClinica')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Fila de atendimento') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'marcarconsulta') class="active" @endif>
                            <a href="{{route('clinica.marcarConsultaSelecionarPaciente')}}">
                                <i class="tim-icons icon-notes"></i>
                                <p>{{ __('Marcar consulta') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'historico-consultas-clinica') class="active" @endif>
                            <a href="{{route('consulta.listConsultaporClinica')}}">
                                <i class="tim-icons icon-single-copy-04"></i>
                                <p>{{ __('Histórico de Consultas') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'pacientes') class="active" @endif>
                            <a href="{{route('clinica.listaPacientes')}}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('Pacientes') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'especialistaclinica') class="active" @endif>
                                <a href="{{route('especialistaclinica.list')}}">
                            <i class="tim-icons icon-badge"></i>
                            <p>{{ __('Especialistas') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'reputacao') class="active" @endif>
                            <a href="{{route('avaliacao.reputacaoClinica')}}">
                                <i class="tim-icons icon-chat-33"></i>
                                <p>{{ __('Reputação') }}</p>
                            </a>
                        </li>

                        <li>
                            <a data-toggle="collapse" href="#relatorioclinica" aria-expanded="false">
                                <i class="tim-icons icon-single-copy-04"></i>
                                <span class="nav-link-text">{{ __('Relatórios') }}</span>
                                <b class="caret mt-1"></b>
                            </a>

                            <div class="collapse" id="relatorioclinica">
                                <ul class="nav pl-4">

                                    <li @if ($pageSlug == 'dashboard2') class="active" @endif>
                                        <a href="{{ route("user.relatorio") }}">
                                            <i class="tim-icons icon-components"></i>
                                            <p>{{ __('Caixa ') }}</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li @if ($pageSlug == 'financeiro') class="active" @endif>
                            <a href="{{route('clinica.financeiro')}}">
                                <i class="tim-icons icon-coins"></i>
                                <p>{{ __('Financeiro') }}</p>
                            </a>
                        </li>

                        <li>
                            <a data-toggle="collapse" href="#configclinica" aria-expanded="false">
                                <i class="tim-icons icon-atom"></i>
                                <span class="nav-link-text">{{ __('Configurações') }}</span>
                                <b class="caret mt-1"></b>
                            </a>

                            <div class="collapse" id="configclinica">
                                <ul class="nav pl-4">
                                    <li @if ($pageSlug == 'especialidades-clinica') class="active" @endif>
                                        <a href="{{route('especialidadeclinica.listclinicas')}}">
                                            <i class="tim-icons icon-components"></i>
                                            <p>{{ __('Especialidades') }}</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                    <!-- usuario tipo Root -->
                    @if(\Illuminate\Support\Facades\Auth::user()->tipo_user === 'R')
                        <li @if ($pageSlug == 'dashboard') class="active" @endif>
                            <a href="{{ route('home') }}">
                                <i class="tim-icons icon-chart-pie-36"></i>
                                {{ __('Dashboard') }}
                            </a>
                        </li>

                        <li>
                            <a data-toggle="collapse" href="#pacientes" aria-expanded="false">
                                <i class="tim-icons icon-single-02"></i>
                                {{ __('Pacientes') }}
                                <b class="caret mt-1"></b>
                            </a>

                            <div class="collapse" id="pacientes">
                                <ul class="nav pl-4">
                                    <li @if ($pageSlug == 'marcar-consulta') class="active" @endif>
                                        <a href="{{ route('paciente.marcarconsultaSelecionarPaciente') }}">
                                            <i class="tim-icons icon-calendar-60"></i>
                                            <p>{{ __('Marcar de consulta') }}</p>
                                        </a>
                                    </li>

                                    <li @if ($pageSlug == 'historico-consultas') class="active" @endif>
                                        <a href="{{route('paciente.historicoconsultas')}}">
                                            <i class="tim-icons icon-single-copy-04"></i>
                                            <p>{{ __('Histórico de Consulta') }}</p>
                                        </a>
                                    </li>

                                    <li @if ($pageSlug == 'reputacao-pacientes') class="active" @endif>
                                        <a href="{{ route('pacientes.avaliacao.lista') }}">
                                            <i class="tim-icons icon-chat-33"></i>
                                            <p>{{ __('Reputação') }}</p>
                                        </a>
                                    </li>

                                    <li @if ($pageSlug == 'historico-pagamentos-pacientes') class="active" @endif>
                                        <a href="{{ route('pacientes.financeiro') }}">
                                            <i class="tim-icons icon-money-coins"></i>
                                            <p>{{ __('Histórico de Pagamentos') }}</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li>
                            <a data-toggle="collapse" href="#especilistas" aria-expanded="false">
                                <i class="tim-icons icon-badge"></i>
                                {{ __('Especialistas') }}
                                <b class="caret mt-1"></b>
                            </a>

                            <div class="collapse" id="especilistas">
                                <ul class="nav pl-4"><li @if ($pageSlug == 'listconsultaporespecialista') class="active" @endif>
                                        <a href="{{ route('consulta.listConsultaPorEspecialistaPesquisar') }}">
                                            <i class="tim-icons icon-notes"></i>
                                            <p>{{ __('Consultas') }}</p>
                                        </a>
                                    </li>

                                    <li @if ($pageSlug == 'agendaespecialista') class="active" @endif>
                                        <a href="{{ route('selecionar.especialista', ['rota' => 'agenda']) }}">
                                            <i class="tim-icons icon-calendar-60"></i>
                                            <p>{{ __('Agenda') }}</p>
                                        </a>
                                    </li>

                                    <li @if ($pageSlug == 'clinicas') class="active" @endif>
                                        <a href="{{ route('selecionar.especialista', ['rota' => 'clinicas']) }}">
                                            <i class="tim-icons icon-bank"></i>
                                            <p>{{ __('Clínicas') }}</p>
                                        </a>
                                    </li>

                                    <li @if ($pageSlug == 'favoritos') class="active" @endif>
                                        <a href="#">
                                            <i class="tim-icons icon-coins"></i>
                                            <p>{{ __('Histórico de Recebimentos') }}</p>
                                        </a>
                                    </li>

                                    <li @if ($pageSlug == 'reputacao-especialista') class="active" @endif>
                                        <a href="{{ route('especialistas.avaliacao.lista') }}">
                                            <i class="tim-icons icon-chat-33"></i>
                                            <p>{{ __('Reputação') }}</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li>
                            <a data-toggle="collapse" href="#clinicas" aria-expanded="false">
                                <i class="tim-icons icon-bank"></i>
                                {{ __('Clinicas') }}
                                <b class="caret mt-1"></b>
                            </a>

                            <div class="collapse" id="clinicas">
                                    <ul class="nav pl-4">
                                        <li @if ($pageSlug == 'listaAgenda') class="active" @endif>
                                            <a href="{{ route('selecionar.clinica', ['rota' => 'agenda']) }}">
                                                <i class="tim-icons icon-calendar-60"></i>
                                                <p>{{ __('Agenda') }}</p>
                                            </a>
                                        </li>

                                        <li @if ($pageSlug == 'marcarconsulta') class="active" @endif>
                                            <a href="{{ route('selecionar.clinica', ['rota' => 'marcar-consulta']) }}">
                                                <i class="tim-icons icon-notes"></i>
                                                <p>{{ __('Marcar consulta') }}</p>
                                            </a>
                                        </li>

                                        <li @if ($pageSlug == 'historico-consultas-clinica') class="active" @endif>
                                            <a href="{{route('consulta.listConsultaporClinica')}}">
                                                <i class="tim-icons icon-single-copy-04"></i>
                                                <p>{{ __('Histórico de Consultas') }}</p>
                                            </a>
                                        </li>

                                        <li @if ($pageSlug == 'especialistaclinica') class="active" @endif>
                                                <a href="{{ route('selecionar.clinica', ['rota' => 'especialista']) }}">
                                            <i class="tim-icons icon-badge"></i>
                                            <p>{{ __('Especialistas') }}</p>
                                            </a>
                                        </li>

                                        <li @if ($pageSlug == 'reputacao-clinicas') class="active" @endif>
                                            <a href="{{route('clinicas.avaliacao.lista')}}">
                                                <i class="tim-icons icon-chat-33"></i>
                                                <p>{{ __('Reputação') }}</p>
                                            </a>
                                        </li>

                                        <li>
                                            <a data-toggle="collapse" href="#relatorioclinica" aria-expanded="false">
                                                <i class="tim-icons icon-single-copy-04"></i>
                                                <span class="nav-link-text">{{ __('Relatórios') }}</span>
                                                <b class="caret mt-1"></b>
                                            </a>

                                            <div class="collapse" id="relatorioclinica">
                                                <ul class="nav pl-4">
                                                    <li @if ($pageSlug == 'dashboard2') class="active" @endif>
                                                        <a href="#">
                                                            <i class="tim-icons icon-components"></i>
                                                            <p>{{ __('Especialista') }}</p>
                                                        </a>
                                                    </li>
                                                    <li @if ($pageSlug == 'dashboard2') class="active" @endif>
                                                        <a href="#">
                                                            <i class="tim-icons icon-components"></i>
                                                            <p>{{ __('Paciente') }}</p>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="collapse" id="relatorioclinica">
                                                <ul class="nav pl-4">
                                                    <li @if ($pageSlug == 'dashboard2') class="active" @endif>
                                                        <a href="#">
                                                            <i class="tim-icons icon-components"></i>
                                                            <p>{{ __('Financeiro') }}</p>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>

                                        <li>
                                            <a data-toggle="collapse" href="#configclinica" aria-expanded="false">
                                                <i class="tim-icons icon-atom"></i>
                                                <span class="nav-link-text">{{ __('Configurações') }}</span>
                                                <b class="caret mt-1"></b>
                                            </a>

                                            <div class="collapse" id="configclinica">
                                                <ul class="nav pl-4">
                                                    <li @if ($pageSlug == 'especialidades-clinica') class="active" @endif>
                                                        <a href="{{ route('selecionar.clinica', ['rota' => 'especialidades']) }}">
                                                            <i class="tim-icons icon-components"></i>
                                                            <p>{{ __('Especialidades') }}</p>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                </ul>

                            </div>
                        </li>

                        <li>
                            <a data-toggle="collapse" href="#adminitracao" aria-expanded="false">
                                <i class="tim-icons icon-chart-bar-32"></i>
                                <span class="nav-link-text">{{ __('Administração') }}</span>
                                <b class="caret mt-1"></b>
                            </a>

                            <div class="collapse" id="adminitracao">
                                <ul class="nav pl-4">
                                    <li @if ($pageSlug == 'clinicas') class="active" @endif>
                                        <a href="{{ route('clinica.list') }}">
                                            <i class="tim-icons icon-bank"></i>
                                            <p>{{ __('Clínicas') }}</p>
                                        </a>
                                    </li>
                                </ul>

                                <ul class="nav pl-4">
                                    <li @if ($pageSlug == 'especialistas') class="active" @endif>
                                        <a href="{{ route('especialista.list') }}">
                                            <i class="tim-icons icon-badge"></i>
                                            <p>{{ __('Especialistas') }}</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li>
                            <a data-toggle="collapse" href="#configuracao" aria-expanded="false">
                                <i class="tim-icons icon-settings"></i>
                                <span class="nav-link-text">{{ __('Configuração') }}</span>
                                <b class="caret mt-1"></b>
                            </a>

                            <div class="collapse" id="configuracao">
                                <ul class="nav pl-4">
                                    <li @if ($pageSlug == 'especialidades') class="active" @endif>
                                        <a href="{{ route('especialidade.list') }}">
                                            <i class="tim-icons icon-puzzle-10"></i>

                                            <p>{{ __('Especialidades') }}</p>
                                        </a>
                                    </li>

                                    <li @if ($pageSlug == 'tipo-exames') class="active" @endif>
                                        <a href="{{ route('tipoexame.list') }}">
                                            <i class="tim-icons icon-chart-bar-32"></i>

                                            <p>{{ __('Tipo de Exames') }}</p>
                                        </a>
                                    </li>

                                    <li @if ($pageSlug == 'tipo-medicamento') class="active" @endif>
                                        <a href="{{ route('tipomedicamento.list') }}">
                                            <i class="tim-icons icon-simple-add"></i>
                                            <p>{{ __('Tipo de Medicamentos') }}</p>
                                        </a>
                                    </li>

                                    <li @if ($pageSlug == 'medicamentos') class="active" @endif>
                                        <a href="{{ route('medicamento.list') }}">
                                            <i class="tim-icons icon-caps-small"></i>
                                            <p>{{ __('Medicamentos') }}</p>
                                        </a>
                                    </li>

                                    <li @if ($pageSlug == 'exames') class="active" @endif>
                                        <a href="{{ route('exame.list') }}">
                                            <i class="tim-icons icon-zoom-split"></i>

                                            <p>{{ __('Exames') }}</p>
                                        </a>
                                    </li>

                                    <li @if ($pageSlug == 'layout') class="active" @endif>
                                        <a href="{{ route('configuracao.layout') }}">
                                            <i class="tim-icons icon-html5"></i>
                                            <p>{{ __('Layout') }}</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li @if ($pageSlug == 'profile') class="active" @endif>
                            <a href="{{ route('user.perfil') }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('Meu Perfil') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'dashboard2') class="active" @endif>
                            <a href="{{  route("user.relatorio")  }}">
                                <i class="tim-icons icon-paper"></i>
                                <p>{{ __('Relatório de Caixa') }}</p>
                            </a>
                        </li>
                    @endif

                    <!-- usuario tipo Paciente -->
                    @if(\Illuminate\Support\Facades\Auth::user()->tipo_user === 'P')

                        <li @if ($pageSlug == 'home') class="active" @endif>
                            <a href="{{route('paciente.home')}}">
                                <i class="tim-icons icon-bank"></i>
                                <p>{{ __('HOME') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'minhasconsultas') class="active" @endif>
                            <a href="{{route('paciente.minhasconsultas')}}">
                                <i class="tim-icons icon-notes"></i>
                                <p>{{ __('Minhas consultas') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'marcarconsulta') class="active" @endif>
                            <!-- caso o paciente nao possua dependete abrir loga a tela de selecionar clinica/especialista-->
                            <?php
                            $pacientes = App\Models\Paciente::where('usuario_id', '=', Auth::user()->id)->get();
                        ?>
                            @if(sizeof($pacientes) > 1)
                            <a href="{{route('paciente.marcarconsultaSelecionarPaciente')}}">
                            @else
                                <a href="{{route('paciente.marcarconsulta')}}">
                            @endif
                                <i class="tim-icons icon-calendar-60"></i>
                                <p>{{ __('Marcação de consultas') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'historico-consultas') class="active" @endif>
                            <a href="{{route('paciente.historicoconsultas')}}">
                                <i class="tim-icons icon-single-copy-04"></i>
                                <p>{{ __('Histórico de Consulta') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'pacientes') class="active" @endif>
                            <a href="{{ route('paciente.index') }}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('Pacientes') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'reputacao') class="active" @endif>
                            <a href="{{route('paciente.avaliacao.lista')}}">
                                <i class="tim-icons icon-chat-33"></i>
                                <p>{{ __('Reputação') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'financeiro') class="active" @endif>
                            <a href="{{route('paciente.financeiro')}}">
                                <i class="tim-icons icon-money-coins"></i>
                                <p>{{ __('Financeiro') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'exames') class="active" @endif>
                            <a href="{{route('paciente.pedido_exames.lista')}}">
                                <i class="tim-icons icon-paper"></i>
                                <p>{{ __('Exames') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'profile') class="active" @endif>
                            <a href="{{route('user.perfil')}}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('Meu Perfil') }}</p>
                            </a>
                        </li>
                    @endif

                    <!-- usuario tipo Especialista -->
                    @if(\Illuminate\Support\Facades\Auth::user()->tipo_user === 'E')
                        <li @if ($pageSlug == 'fila') class="active" @endif>
                                <a href="{{route('fila.listClinicaDoEspecialista')}}">
                                    <i class="tim-icons icon-bullet-list-67"></i>
                                    <p>{{ __('Fila de atendimento') }}</p>
                                </a>
                            </li>

                        <li @if ($pageSlug == 'listconsultaporespecialista') class="active" @endif>
                            <a href="{{route('consulta.listConsultaPorEspecialistaPesquisar')}}">
                                <i class="tim-icons icon-notes"></i>
                                <p>{{ __('Consultas') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'disponibilizar-consultas') class="active" @endif>
                            <a href="{{ route('consulta.agenda') }}">
                                <i class="tim-icons icon-calendar-60"></i>
                                <p>{{ __('Disponibilizar consultas') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'agendaespecialista') class="active" @endif>
                            <a href="{{route('consulta.list')}}">
                                <i class="tim-icons icon-calendar-60"></i>
                                <p>{{ __('Agenda') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'pacientes') class="active" @endif>
                            <a href="{{route('especialista.listaPacientes')}}">
                                <i class="tim-icons icon-single-02"></i>
                                <p>{{ __('Pacientes') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'clinicas') class="active" @endif>
                            <a href="{{route('especialistaclinica.clinicas')}}">
                                <i class="tim-icons icon-bank"></i>
                                <p>{{ __('Clínicas') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'recebimentos') class="active" @endif>
                            <a href="{{route('especialista.recebeimentos.list')}}">
                                <i class="tim-icons icon-coins"></i>
                                <p>{{ __('Histórico de Recebimentos') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'reputacao') class="active" @endif>
                            <a href="{{route('avaliacao.reputacaoEspecialista')}}">
                                <i class="tim-icons icon-chat-33"></i>
                                <p>{{ __('Reputação') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'dashboard2') class="active" @endif>
                            <a href="{{  route("user.relatorio")  }}">
                                <i class="tim-icons icon-paper"></i>
                                <p>{{ __('Relatório de Caixa') }}</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    @endif
@endif
