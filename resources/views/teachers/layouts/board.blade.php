<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

<head>
    @include('teachers.layouts.partials.head')
</head>
<body>
    @include('teachers.layouts.partials.sidebar')
    <!-- main-warp -->
    <div class="main-warp grading">
        @include('teachers.layouts.partials.gradingHeaders.board')
        <div class="main-body slide-100">
            <div class="fixed-side-panel-trigger "><i class="fa fa-caret-right" aria-hidden="true"></i></div>
            <div class="">
                @yield('content')
            </div>
            <!-- main-body end -->
        </div>
        <!-- main-body end -->
    </div>
    <div class="modal confirm" id="confirm" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <!-- Modal body -->
                <div class="modal-body">

                    <h5>{{ __("grading.confirmPublishResult") }}</h5>
                    <!-- question type table end -->
                    <hr>
                    <button class="btn btn-outline-primary mr-2" data-dismiss="modal" id="close-confirm">{{ __("teachers.button.cancel") }}</button>
                    <button class="btn btn-primary publish-confirm">{{ __("teachers.button.confirm") }}</button>
                    <div class="clearfix"></div>
                    <hr>
                    <span id="countAbsent"></span>
                </div>
                <!-- Modal footer -->
            </div>
        </div>
    </div>

    <div class="modal confirm" id="confirmGradeAll" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <!-- Modal body -->
                <div class="modal-body">

                    <h5>{{ __("grading.confirmGradeAll") }}</h5>
                    <!-- question type table end -->
                    <hr>
                    <button class="btn btn-outline-primary mr-2" data-dismiss="modal" id="close-confirm">{{ __("teachers.button.cancel") }}</button>
                    <button class="btn btn-primary gradeall-confirm">{{ __("teachers.button.confirm") }}</button>
                    <hr>
                    <span id="countData"></span>
                </div>
                <!-- Modal footer -->
            </div>
        </div>
    </div>

    <a class="" id="back-to-top" data-toggle="tooltip" data-placement="left" title="Back to Top">
        <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
    </a>
    @include('teachers.layouts.partials.scripts')
</body>
<script>
    window.Userback = window.Userback || {};
    Userback.access_token = '31485|47430|YxsbjnO6prOphZfyaW2NYVB3Q';
    (function(d) {
        var s = d.createElement('script');s.async = true;
        s.src = 'https://static.userback.io/widget/v1.js';
        (d.head || d.body).appendChild(s);
    })(document);
</script>
</html>
