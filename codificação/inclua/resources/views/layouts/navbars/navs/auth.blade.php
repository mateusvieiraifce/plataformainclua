<nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-toggle d-inline">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>

            <br/>
            <p>
                <img src="/assets/img/Icone2t.png" style="max-width: 50px; height: auto;"/>
                @if(\Illuminate\Support\Facades\Auth::user()->tipouser ==='V')
                <a class="navbar-brand" href="#">{{ $page ?? __('Dashboard') }}</a>
                @else
                    <a class="navbar-brand" href="{{route('index')}}">{{ $page ?? __('Continuar comprando') }}</a>
                @endif
            </p>

        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse" id="navigation">
            <ul class="navbar-nav ml-auto">
                <li class="search-bar input-group">
                    <button class="btn btn-link" id="search-button" data-toggle="modal" data-target="#searchModal"><i class="tim-icons icon-zoom-split"></i>
                        <span class="d-lg-none d-md-block">{{ __('Search') }}</span>
                    </button>
                </li>
                <?php
                $notifcatio = \App\Models\Notificacoes::where('id_user','=',auth()->user()->id)
                    ->whereNull('data_leitura')->get()->count();
                $texto = 'Você tem ' . $notifcatio ." notificações";
                ?>
                @if ($notifcatio>0)
                    @if ($notifcatio==1)
                       <?php $texto = 'Você tem ' . $notifcatio ." notificação"; ?>
                    @endif
                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <div class="notification d-none d-lg-block d-xl-block"></div>
                        <i class="tim-icons icon-sound-wave"></i>
                        <p class="d-lg-none"> {{ __('Notifications') }} </p>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-navbar">
                        <li class="nav-link">


                            <a href="{{route('user.notificacoes')}}" class="nav-item dropdown-item">{{$texto}}</a>

                        </li>

                    </ul>
                </li>
                @endif
                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                        <div class="photo">
                            @if(auth()->user()->avatar)
                                {!! Html::image(auth()->user()->avatar) !!}

                            @else
                            <img src="/assets/img/anime3.png" alt="{{ __('Profile Photo') }}">
                            @endif
                        </div>
                        <b class="caret d-none d-lg-block d-xl-block"></b>
                        <p class="d-lg-none">{{ __('Log out') }}</p>
                    </a>
                    <ul class="dropdown-menu dropdown-navbar">
                        <li class="nav-link">
                            <a href="{{route('user.preedit')}}" class="nav-item dropdown-item">{{ __('Perfil') }}</a>
                        </li>
                        <li class="nav-link">
                            <form action="{{route('user.delete')}}" id="formremove" method="post">
                                @csrf
                                <input type="hidden" value="{{auth()->user()->id}}" name="id">
                            </form>
                            <a onclick="if (confirm('Deseja realmente excluir?')){getElementById('formremove').submit()}" href="#" class="nav-item dropdown-item">{{ __('Excluir') }}</a>
                        </li>

                        <li class="nav-link">
                            <a href="{{route('index')}}" class="nav-item dropdown-item" >{{ __('Continuar comprando') }}</a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li class="nav-link">
                            <a href="{{route('logout')}}" class="nav-item dropdown-item" >{{ __('Sair') }}</a>
                        </li>
                    </ul>
                </li>
                <li class="separator d-lg-none"></li>
            </ul>
        </div>
    </div>
</nav>
<div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="{{ __('SEARCH') }}">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Close') }}">
                    <i class="tim-icons icon-simple-remove"></i>
              </button>
            </div>
        </div>
    </div>
</div>
