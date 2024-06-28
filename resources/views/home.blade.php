<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="TutorWand" />
    <meta name="keywords" content="TutorWand"/>
    <title>@yield('title', 'TutorWand')</title>
    <link rel="apple-touch-icon" href="{{ asset('assets/images/teachers/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/teachers/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- bootstrap css -->
</head>

<body>
    <div class="main-warp grading">
        <div class="main-body slide-100">
            <div style="width: 100%; text-align: center; margin-top: 150px; ">
               <div class="w-100"> <img src="{{ asset('assets/images/teachers/login.png') }}" alt=""></div>
               <div class="w-100 text-center" style="margin-top:50px"> <a href="{{ route('auth2') }}" class="btn btn-primary"> Login </a>    </div>        
            </div>
        </div>
    </div>
</body>
</html>
