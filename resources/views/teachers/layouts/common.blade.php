<!doctype html>
<html>
    <head>
        @include('teachers.layouts.partials.head')
    </head>
    <body>
        @include('teachers.layouts.partials.sidebar')
        <div class="main-warp">
            @include('teachers.layouts.common.header')
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
        </div>
        <a class="" id="back-to-top" data-toggle="tooltip" data-placement="left" title="Back to Top">
            <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
        </a>
        @include('teachers.layouts.common.scripts')
        @yield('onPageJs')
    </body>
</html>
