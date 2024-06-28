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
            .selection-inner {
                width: 100%;
                background-color: rgba(255,255,255,0.25);
                    
                box-shadow: 0px 0px 48px rgba(0, 0, 0, 0.08);
                padding: 10px;
                border-radius: 10px;
            }
            
            .selection-outer {
                display: table-cell;
                vertical-align: middle;
                text-align: center;
            }
            
            .selection-box-outer {
                display: flex;
                width: 100%;
                justify-content: center;
                align-items: center;
                height: 100vh;
                border-top: 5px solid var(--brand-color);
                background-image: url({{ asset('assets/images/bg-110.jpg') }});
                background-repeat: no-repeat;
                background-size: cover;
            }
            
            .btn-selectoion {
                padding: 8px 0px !important;
                font-size: 18px;
                border-radius: 0px 0px 10px 10px !important;
                box-shadow: none !important;
            }
            
            .on-hover {
                display: none;
            }
            
            .sel-hover-1:hover .on-hover {
                display: block;
            }
            
            .sel-hover-1:hover .no-hover {
                display: none;
            }
            
            .sel-hover-1:hover .btn-selectoion {
                background-color: var(--brand-color-dark) !important;
                border-color: var(--brand-color-dark) !important;
            }
        </style>
    </head>

    <body>
        <div class="selection-box-outer">
            <div class="selection-outer">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <div class="selection-inner">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Login as:</h3>
                                    </div>
                                    <div class="col-md-6 pr-1 sel-hover-1">
                                        <a href="{{ route('google.setrole', base64_encode(2)) }}">
                                            <img src="{{ asset('assets/images/student-profile.png')}}" class="w-100 no-hover" alt="student">
                                            <img src="{{ asset('assets/images/student-profile-h.png')}}" class="w-100 on-hover" alt="student">
                                            <div class="btn btn-primary btn-block btn-lg btn-selectoion">STUDENT</div>
                                        </a>
                                    </div>
                                    <div class="col-md-6 pl-1 sel-hover-1">
                                        <a href="{{ route('google.setrole', base64_encode(1)) }}">
                                            <img src="{{ asset('assets/images/teacher-profile.png')}}" class="w-100 no-hover" alt="teacher">
                                            <img src="{{ asset('assets/images/teacher-profile-h.png')}}" class="w-100 on-hover" alt="teacher">
                                            <div class="btn btn-primary btn-block btn-lg btn-selectoion">TEACHER</div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
