<!doctype html>
<html>
    <head>
        @include('students.layouts.partials.head')
    </head>
    <body>
        @include('students.layouts.partials.sidebar')
        <div class="main-warp {{ request()->is('students/assessment/report/*') || request()->is('students/assessment/result/*') || request()->is('students/global/assessment/*') ? 'reporting' : '' }}">
            @include('students.layouts.partials.header')
            <!-- main header-end -->
            <div class="main-body">
                <div class="fixed-side-panel-trigger"><i class="fa fa-caret-right" aria-hidden="true"></i></div>
                @yield('content')
            </div><!-- main-body end -->
        </div>
        <a class="" id="back-to-top">
            <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
        </a>
        @if(request()->is('students/exam') || request()->is('students/instructions/*'))
            <!-- Condition Scripts Show Here -->
            @include('students.layouts.partials.paper.reviewModal')
        @endif
        
        @include('students.layouts.partials.script')
        
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