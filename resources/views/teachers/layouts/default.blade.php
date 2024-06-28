<!doctype html>
<html>
    <head>
        @include('teachers.includes.head')
    </head>
    <body class="copy-enable">
        @include('teachers.layouts.partials.sidebar')
        <div class="main-warp">
            @include('teachers.includes.header')
            <div class="main-body">
                <div class="fixed-side-panel-trigger" role="button" tabindex="0"><i class="fa fa-caret-right" aria-hidden="true"></i></div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 col-lg-12">
                            <div class="canvas-area-full">    
                                @yield('content')
                            </div>
                    </div>
                </div>
            </div>
        </div>

        @include('teachers.includes.footer')
        
        @if (Route::currentRouteName() == "assignment")
            @include('teachers.pages.assignment.script')
        @elseif(Route::currentRouteName() == "boardPreparation")
            @include('teachers.includes.boardPreparationScript')
        @elseif(request()->is('class/*'))
            @include('teachers.layouts.partials.reportScript')
        @else
            @include('teachers.includes.script')
        @endif

        @yield('onPageJs')
        <script>
            window.Userback = window.Userback || {};
            Userback.access_token = '31485|47430|YxsbjnO6prOphZfyaW2NYVB3Q';
            (function(d) {
                var s = d.createElement('script');s.async = true;
                s.src = 'https://static.userback.io/widget/v1.js';
                (d.head || d.body).appendChild(s);
            })(document);
            
        </script>
    </body>
</html>
