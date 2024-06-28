<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="TutorWand" />
    <meta name="keywords" content="TutorWand"/>
    <title>@yield('title', 'TutorWand')</title>
    <link rel="apple-touch-icon" href="{{ asset('assets/images/teachers/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/teachers/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/teachers/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/teachers/css/custom-style.css') }}">
    
    <title>Document</title>
    <style>
        .alert-box-outer {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        
        .alert-box-blank {
            width: 400px;
            border: 1px solid var(--brand-color);
            padding: 16px;
            font-size: var(--font-16);
            text-align: center;
            border-radius: 4px;
            box-shadow: 0px 3px 6px var(--shadow-bg);
        }
        a {
            text-decoration: none;
        }
    </style>

</head>

<body>

    <div class="alert-box-outer">
        <div class="alert-box-blank">
            {{ $message }}<hr>
            <a href="{{ route('students.dashboard') }}" class="btn btn-primary">{{ __('teachers.sidebar.dashboard') }}</a>
            <a href="{{ route('students.assessment') }}" class="btn btn-primary">{{ __('teachers.sidebar.goToAssessment') }}</a>
        </div>
    </div>
</body>

</html>