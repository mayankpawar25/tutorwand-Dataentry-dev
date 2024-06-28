<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
<head>
 	@include('students.layouts.partials.head')
</head>
<body>
    <div class="overlay-slide-panel"></div>
    <div class="loader-outer" style="display:none;">
        <div class="quote12">{{ __('students.bestMessage') }}</div>
        <!-- <div class="count5">
            {!! config('constants.icons.loader-icon-five') !!}
        </div>
        <div class="count4">
            {!! config('constants.icons.loader-icon-four') !!}
        </div> -->
        <div class="count3">
            {!! config('constants.icons.loader-icon-three') !!}
        </div>
        <div class="count2">
            {!! config('constants.icons.loader-icon-two') !!}
        </div>
        <div class="count1">
            {!! config('constants.icons.loader-icon-one') !!}
        </div>
    </div>
    <!-- main-warp -->
    <div class="exam-warp" style="display:none;">
        @include('students.layouts.partials.paper.header')
        <div class="main-body">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
    <!-- modal end -->
    @include('students.layouts.partials.paper.reviewModal')
    @include('students.layouts.partials.script')
    @include('students.layouts.partials.paper.timeScript')
    @include('students.layouts.partials.paper.examScript')
</body>
</html>