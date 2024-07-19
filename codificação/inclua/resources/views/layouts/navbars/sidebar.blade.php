@if(\Illuminate\Support\Facades\Auth::check())
@if($class!="login-page")
<div class="sidebar">
    <div class="sidebar-wrapper">

        <ul class="nav">

            <!-- usuario tipo clinica -->
            @if(\Illuminate\Support\Facades\Auth::user()->tipo_user ==='C')
            <?php
            $clinica = App\Models\Clinica::where('usuario_id', '=', Auth::user()->id)->first();
            ?>
            <li @if ($pageSlug=='dashboard' ) class="active " @endif>
                <a href="{{route('home')}}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>

            <li @if ($pageSlug=='users' ) class="active " @endif>
                <a href="{{route('sales.list')}}">
                    <i class="tim-icons icon-calendar-60"></i>
                    <p>{{ __('Agenda') }}</p>
                </a>
            </li>

            <li @if ($pageSlug=='users' ) class="active " @endif>
                <a href="{{route('sales.list')}}">
                    <i class="tim-icons icon-bullet-list-67"></i>
                    <p>{{ __('Consultas') }}</p>
                </a>
            </li>

            <li @if ($pageSlug=='users' ) class="active " @endif>
                <a href="{{route('advertisement.list')}}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ __('Pacientes') }}</p>
                </a>
            </li>
            
                <li @if ($pageSlug == 'especialistaclinica') class="active " @endif>
                    <a href="{{route('especialistaclinica.list',$clinica->id)}}">
            <i class="tim-icons icon-badge"></i>
            <p>{{ __('Especialistas') }}</p>
            </a>
            </li>


            <li @if ($pageSlug=='users' ) class="active " @endif>
                <a href="{{route('sales.list')}}">
                    <i class="tim-icons icon-key-25"></i>
                    <p>{{ __('Usuários') }}</p>
                </a>
            </li>

            <li>
                <a data-toggle="collapse" href="#configclinica" aria-expanded="true">
                    <i class="tim-icons icon-atom"></i>
                    <span class="nav-link-text">{{ __('Configurações') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse" id="configclinica">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='dashboard2' ) class="active " @endif>

                            <a href="{{route('especialidadeclinica.listclinica')}}">
                                <i class="tim-icons icon-components"></i>
                                <p>{{ __('Especialidades') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            <!-- usuario tipo Root -->
            @if(\Illuminate\Support\Facades\Auth::user()->tipo_user ==='R')

            <li @if ($pageSlug=='dashboard' ) class="active " @endif>
                <a href="{{route('home')}}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#compras" aria-expanded="true">
                    <i class="tim-icons icon-badge"></i>
                    <span class="nav-link-text">{{ __('Especialistas') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse" id="compras">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='compras' ) class="active " @endif>
                            <a href="{{route('user.compras')}}">
                                <i class="tim-icons icon-bank"></i>
                                <p>{{ __('Clinicas') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='comentarios' ) class="active " @endif>
                            <a href="{{route('user.comentarios')}}">
                                <i class="tim-icons icon-calendar-60"></i>
                                <p>{{ __('Agenda') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug=='favoritos' ) class="active " @endif>
                            <a href="{{route('user.favoritos')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Consultas') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug=='favoritos' ) class="active " @endif>
                            <a href="{{route('user.favoritos')}}">
                                <i class="tim-icons icon-coins"></i>
                                <p>{{ __('Histórico de Recebimentos') }}</p>
                            </a>
                        </li>


                        <li @if ($pageSlug=='favoritos' ) class="active " @endif>
                            <a href="{{route('user.favoritos')}}">
                                <i class="tim-icons icon-chat-33"></i>
                                <p>{{ __('Reputação') }}</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#pacientes" aria-expanded="true">
                    <i class="tim-icons icon-single-02"></i>
                    <span class="nav-link-text">{{ __('Pacientes') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse" id="pacientes">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='compras' ) class="active " @endif>
                            <a href="{{route('user.compras')}}">
                                <i class="tim-icons icon-components"></i>
                                <p>{{ __('Marcação de consultas') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug=='comentarios' ) class="active " @endif>
                            <a href="{{route('user.comentarios')}}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Histórico de Consulta') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug=='favoritos' ) class="active " @endif>
                            <a href="{{route('user.favoritos')}}">
                                <i class="tim-icons icon-chat-33"></i>
                                <p>{{ __('Reputação') }}</p>
                            </a>
                        </li>


                        <li @if ($pageSlug=='favoritos' ) class="active " @endif>
                            <a href="{{route('user.favoritos')}}">
                                <i class="tim-icons icon-money-coins"></i>
                                <p>{{ __('Histórico de Pagamentos') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug=='favoritos' ) class="active " @endif>
                            <a href="{{route('user.favoritos')}}">
                                <i class="tim-icons icon-notes"></i>
                                <p>{{ __('Exames') }}</p>
                            </a>
                        </li>


                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#adminitracao" aria-expanded="true">
                    <i class="tim-icons icon-chart-bar-32"></i>
                    <span class="nav-link-text">{{ __('Administração') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse" id="adminitracao">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='compras' ) class="active " @endif>
                            <a href="{{route('clinica.list')}}">
                                <i class="tim-icons icon-bank"></i>
                                <p>{{ __('Clínicas') }}</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='compras' ) class="active " @endif>
                            <a href="{{route('especialista.list')}}">
                                <i class="tim-icons icon-badge"></i>
                                <p>{{ __('Especialistas') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>

            </li>
            <li>
                <a data-toggle="collapse" href="#config" aria-expanded="true">
                    <i class="tim-icons icon-atom"></i>
                    <span class="nav-link-text">{{ __('Configuração') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse" id="config">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug=='compras' ) class="active " @endif>
                            <a href="{{route('especialidade.list')}}">
                                <i class="tim-icons icon-components"></i>
                                <p>{{ __('Especialidades') }}</p>
                            </a>
                        </li>


                    </ul>
                </div>
                <!--  <div class="collapse" id="config">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'compras' ) class="active " @endif>
                            <a href="{{route('formapagamento.list')}}">
                                <i class="tim-icons icon-money-coins"></i>
                                <p>{{ __('Formas de Pagamento') }}</p>
                            </a>
                        </li>


                    </ul>
                </div>
            -->
            </li>
            <li @if ($pageSlug=='profile' ) class="active " @endif>
                <a href="{{route('user.preedit')}}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ __('Meu Perfil') }}</p>
                </a>
            </li>
            @endif

            <!-- usuario tipo Paciente -->
            @if(\Illuminate\Support\Facades\Auth::user()->tipo_user ==='P')
           <!--  <li @if ($pageSlug=='dashboard' ) class="active " @endif>
                <a href="{{route('home')}}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li> -->
            <li @if ($pageSlug=='home' ) class="active " @endif>
                <a href="{{route('paciente.home')}}">
                    <i class="tim-icons icon-bank"></i>
                    <p>{{ __('HOME') }}</p>
                </a>
            </li>
            <li @if ($pageSlug=='minhasconsultas' ) class="active " @endif>
                <a href="{{route('paciente.minhasconsultas')}}">
                    <i class="tim-icons icon-notes"></i>
                    <p>{{ __('Minhas consultas') }}</p>
                </a>
            </li>
            <li @if ($pageSlug=='marcarconsulta' ) class="active " @endif>
                <a href="{{route('paciente.marcarconsulta')}}">
                    <i class="tim-icons icon-calendar-60"></i>
                    <p>{{ __('Marcação de consultas') }}</p>
                </a>
            </li>
            <li @if ($pageSlug=='historicoconsultas' ) class="active " @endif>
                <a href="{{route('paciente.historicoconsultas')}}">
                    <i class="tim-icons icon-bullet-list-67"></i>
                    <p>{{ __('Histórico de Consulta') }}</p>
                </a>
            </li>
            <li @if ($pageSlug=='favoritos' ) class="active " @endif>
                <a href="{{route('user.favoritos')}}">
                    <i class="tim-icons icon-chat-33"></i>
                    <p>{{ __('Reputação') }}</p>
                </a>
            </li>
            <li @if ($pageSlug=='favoritos' ) class="active " @endif>
                <a href="{{route('user.favoritos')}}">
                    <i class="tim-icons icon-money-coins"></i>
                    <p>{{ __('Histórico de Pagamentos') }}</p>
                </a>
            </li>
            <li @if ($pageSlug=='favoritos' ) class="active " @endif>
                <a href="{{route('user.favoritos')}}">
                    <i class="tim-icons  icon-components"></i>
                    <p>{{ __('Exames') }}</p>
                </a>
            </li>
            <li @if ($pageSlug=='profile' ) class="active " @endif>
                <a href="{{route('user.preedit')}}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ __('Meu Perfil') }}</p>
                </a>
            </li>
            @endif

            <!-- usuario tipo Especialista -->
            @if(\Illuminate\Support\Facades\Auth::user()->tipo_user ==='E')
            <li @if ($pageSlug=='dashboard' ) class="active " @endif>
                <a href="{{route('home')}}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>

            <li @if ($pageSlug=='listconsultaporespecialista' ) class="active " @endif>
                <a href="{{route('consulta.listconsultaporespecialista')}}">
                    <i class="tim-icons icon-bullet-list-67"></i>
                    <p>{{ __('Consultas') }}</p>
                </a>
            </li>

            <li @if ($pageSlug=='agendaespecialista' ) class="active " @endif>
                <a href="{{route('consulta.list')}}">
                    <i class="tim-icons icon-calendar-60"></i>
                    <p>{{ __('Agenda') }}</p>
                </a>
            </li>



            <li @if ($pageSlug=='users' ) class="active " @endif>
                <a href="#">
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ __('Pacientes') }}</p>
                </a>
            </li>

            <li @if ($pageSlug=='clinicas' ) class="active " @endif>
                <a href="{{route('especialistaclinica.clinicas')}}">
                    <i class="tim-icons icon-bank"></i>
                    <p>{{ __('Clínicas') }}</p>
                </a>
            </li>

            <li @if ($pageSlug=='favoritos' ) class="active " @endif>
                <a href="{{route('user.favoritos')}}">
                    <i class="tim-icons icon-coins"></i>
                    <p>{{ __('Histórico de Recebimentos') }}</p>
                </a>
            </li>


            <li @if ($pageSlug=='favoritos' ) class="active " @endif>
                <a href="{{route('user.favoritos')}}">
                    <i class="tim-icons icon-chat-33"></i>
                    <p>{{ __('Reputação') }}</p>
                </a>
            </li>

            @endif
        </ul>
    </div>
</div>
@endif
@endif