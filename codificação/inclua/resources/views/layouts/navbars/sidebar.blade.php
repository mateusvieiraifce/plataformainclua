@if(\Illuminate\Support\Facades\Auth::check())
@if($class!="login-page")
    <div class="sidebar">
    <div class="sidebar-wrapper">

        <ul class="nav">
            @if(\Illuminate\Support\Facades\Auth::user()->tipouser ==='V')
            <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{route('home')}}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>


            <li>
                <a data-toggle="collapse" href="#laravel-examples" aria-expanded="true">
                    <i class="fab fa-laravel" ></i>
                    <span class="nav-link-text" >{{ __('Vendas') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse" id="laravel-examples">
                    <ul class="nav pl-4">

                        <li @if ($pageSlug == 'users') class="active " @endif>
                            <a href="{{route('advertisement.list')}}">
                                <i class="tim-icons icon-spaceship"></i>
                                <p>{{ __('Anúncios') }}</p>
                            </a>
                        </li>

                        <li @if ($pageSlug == 'users') class="active " @endif>
                            <a href="#">
                                <i class="tim-icons icon-chat-33"></i>
                                <p>{{ __('Perguntas') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'users') class="active " @endif>
                            <a href="{{route('sales.list')}}">
                                <i class="tim-icons icon-coins"></i>
                                <p>{{ __('Vendas') }}</p>
                            </a>
                        </li>
                        <!--
                        <li @if ($pageSlug == 'users') class="active " @endif>
                            <a href="">
                                <i class="tim-icons icon-chart-bar-32"></i>
                                <p>{{ __('Métricas') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'users') class="active " @endif>
                            <a href="">
                                <i class="tim-icons icon-trophy"></i>
                                <p>{{ __('Reputação') }}</p>
                            </a>
                        </li>
                        -->
                    </ul>
                </div>
            </li>
            @endif

            <li>
                <a data-toggle="collapse" href="#compras" aria-expanded="true">
                    <i class="tim-icons icon-money-coins" ></i>
                    <span class="nav-link-text" >{{ __('Compras') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse" id="compras">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'compras' ) class="active " @endif>
                            <a href="{{route('user.compras')}}">
                                <i class="tim-icons icon-components"></i>
                                <p>{{ __('Compras') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'comentarios') class="active " @endif>
                            <a href="{{route('user.comentarios')}}">
                                <i class="tim-icons icon-alert-circle-exc"></i>
                                <p>{{ __('Comentários') }}</p>
                            </a>
                        </li>
                        <li @if ($pageSlug == 'favoritos') class="active " @endif>
                            <a href="{{route('user.favoritos')}}">
                                <i class="tim-icons icon-spaceship"></i>
                                <p>{{ __('Favoritos') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

                @if(\Illuminate\Support\Facades\Auth::user()->tipouser !='V')
                    <li @if ($pageSlug == 'icons') class="active " @endif>
                        <a href="{{route('user.turnvendedor')}}">
                            <i class="tim-icons icon-chart-pie-36"></i>
                            <p>{{ __('Virar Vendedor') }}</p>
                        </a>
                    </li>
                @endif


            @if(\Illuminate\Support\Facades\Auth::user()->tipouser ==='V')
            <li @if ($pageSlug == 'icons') class="active " @endif>
                <a href="">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Faturamento') }}</p>
                </a>
            </li>
            @endif
            <li @if ($pageSlug == 'profile') class="active " @endif>
                <a href="{{route('user.preedit')}}">
                    <i class="tim-icons icon-single-02"></i>
                    <p>{{ __('Meu Perfil') }}</p>
                </a>
            </li>
        </ul>
    </div>
</div>
@endif
@endif
