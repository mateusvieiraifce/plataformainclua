<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @inject('configuracao', 'App\Models\Configuracao')
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!--<title>{{ config('app.name', 'Black Dashboard') }}</title> -->
        <title>@yield('title') | Inclua</title>
        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="76x76" href="{{ !empty($configuracao->getFavicon()) ? asset($configuracao->getFavicon()) : asset('asset/img/Icone2t.png') }}">
        <link rel="icon" type="image/png" href="{{ !empty($configuracao->getFavicon()) ? asset($configuracao->getFavicon()) : asset('assets/img/Icone2t.png') }}">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <!-- Icons -->
        <link href="/assets/css/nucleo-icons.css" rel="stylesheet" />
        <link href="{{ asset('fonts/iconic/css/material-design-iconic-font.css')}}" rel="stylesheet" />
        <!-- CSS -->
        <link href="/assets/css/black-dashboard.css" rel="stylesheet" />
        <link href="/assets/css/theme.css" rel="stylesheet" />
        <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- CSS do Select2 via CDN -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    </head>
    <body class="{{ $class ?? '' }}">
        <div class="wrapper">
            @include('layouts.navbars.sidebar')
            <div class="main-panel">
                @include('layouts.navbars.navbar')

                <div class="content">
                    @yield('content')
                </div>
            </div>
        </div>
        <form id="logout-form" action="" method="POST" style="display: none;">
            @csrf
        </form>
        @php
            $msg = Session::get('msg') ?? $msg ?? '';
        @endphp

            <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

            <script>
                nowuiDashboard = {
                    misc: {
                        navbar_menu_visible: 0
                    },

                    showNotification: function(from, align, msg, type) {
                        color = type;

                        $.notify({
                            icon: "now-ui-icons ui-1_bell-53",
                            message: msg

                        }, {
                            type: color,
                            timer: 8000,
                            placement: {
                                from: from,
                                align: align
                            }
                        });
                    }


                };
            </script>

        @if(!empty($msg))
            <script>
                $(document).ready(function() {
                    nowuiDashboard.showNotification('top','right','{{$msg["valor"]}}','{{$msg["tipo"]}}');
                });
            </script>
        @endif
        <script src="/assets/js/core/jquery.min.js"></script>
        <script src="/assets/js/core/popper.min.js"></script>
        <script src="/assets/js/core/bootstrap.min.js"></script>
        <script src="/assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
        <!--  Google Maps Plugin    -->
        <!-- Place this tag in your head or just before your close body tag. -->

        <!-- Chart JS -->
        <script src="/assets/js/plugins/chartjs.min.js"></script>
        <!--  Notifications Plugin    -->
        <script src="/assets/js/plugins/bootstrap-notify.js"></script>

        <script src="/assets/js/black-dashboard.min.js?v=1.0.0"></script>
        <script src="/assets/js/theme.js"></script>
        <!-- Select2 JS via CDN -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        @include('layouts.functions')

        <script>
            $(document).ready(function() {
                $().ready(function() {
                    $sidebar = $('.sidebar');
                    $navbar = $('.navbar');
                    $main_panel = $('.main-panel');

                    $full_page = $('.full-page');

                    $sidebar_responsive = $('body > .navbar-collapse');
                    sidebar_mini_active = true;
                    white_color = false;

                    window_width = $(window).width();

                    fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

                    $('.fixed-plugin a').click(function(event) {
                        if ($(this).hasClass('switch-trigger')) {
                            if (event.stopPropagation) {
                                event.stopPropagation();
                            } else if (window.event) {
                                window.event.cancelBubble = true;
                            }
                        }
                    });

                    $('.fixed-plugin .background-color span').click(function() {
                        $(this).siblings().removeClass('active');
                        $(this).addClass('active');

                        var new_color = $(this).data('color');

                        if ($sidebar.length != 0) {
                            $sidebar.attr('data', new_color);
                        }

                        if ($main_panel.length != 0) {
                            $main_panel.attr('data', new_color);
                        }

                        if ($full_page.length != 0) {
                            $full_page.attr('filter-color', new_color);
                        }

                        if ($sidebar_responsive.length != 0) {
                            $sidebar_responsive.attr('data', new_color);
                        }
                    });

                    $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
                        var $btn = $(this);

                        if (sidebar_mini_active == true) {
                            $('body').removeClass('sidebar-mini');
                            sidebar_mini_active = false;
                            blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
                        } else {
                            $('body').addClass('sidebar-mini');
                            sidebar_mini_active = true;
                            blackDashboard.showSidebarMessage('Sidebar mini activated...');
                        }

                        // we simulate the window Resize so the charts will get updated in realtime.
                        var simulateWindowResize = setInterval(function() {
                            window.dispatchEvent(new Event('resize'));
                        }, 180);

                        // we stop the simulation of Window Resize after the animations are completed
                        setTimeout(function() {
                            clearInterval(simulateWindowResize);
                        }, 1000);
                    });

                    $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
                            var $btn = $(this);

                            if (white_color == true) {
                                $('body').addClass('change-background');
                                setTimeout(function() {
                                    $('body').removeClass('change-background');
                                    $('body').removeClass('white-content');
                                }, 900);
                                white_color = false;
                            } else {
                                $('body').addClass('change-background');
                                setTimeout(function() {
                                    $('body').removeClass('change-background');
                                    $('body').addClass('white-content');
                                }, 900);

                                white_color = true;
                            }
                    });
                    
                    $('.select2').select2();
                });
            });
            const htmlEl = document.querySelector('html');
            htmlEl.style.setProperty('--primary', "{{ $configuracao->first()->color_primary ?? '#ba54f5' }}");
            htmlEl.style.setProperty('--color-gradient', "{{ $configuracao->first()->color_gradiente ?? 'rgb(137,119,249)' }}");
        </script>
        @stack('js')
    </body>
</html>
