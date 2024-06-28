<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="Create online assessment in a minute, Assessment creation and grading " />
    <meta name="description"
    content="Assessment creation in a minute,  Google classroom integration tool for teachers, auto grade assessment and student assessment analytics report" />
    <meta name="facebook-domain-verification" content="supifo0y8e6favzw5fm4gijajtothy" />
    <link rel="shortcut icon" href="{{ asset('assets/home/images/fave.png')}}" />
    <link rel="apple-touch-icon" href="{{ asset('assets/home/images/fave.png')}}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.css')}}">
    <link href="{{ asset('assets/home/css/animate.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/home/css/style.css')}}">
    <title>Tutor Wand</title>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('constants.landingGtag') }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', "{{ config('constants.landingGtag') }}");
    </script>
    
</head>

<body>
    <div id="loader-wrapper">
        <div id="loader1">
            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 64 80" enable-background="new 0 0 0 0" xml:space="preserve">
                <circle fill="#178D8D" stroke="none" cx="6" cy="50" r="6">
                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 15 ; 0 -15; 0 15" repeatCount="indefinite" begin="0.1" />
                </circle>
                <circle fill="#178D8D" stroke="none" cx="30" cy="50" r="6">
                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 10 ; 0 -10; 0 10" repeatCount="indefinite" begin="0.2" />
                </circle>
                <circle fill="#178D8D" stroke="none" cx="54" cy="50" r="6">
                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.3" />
                </circle>
            </svg>
        </div>
    </div>
    <header class="sticky">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-4 col-4">
                    <a href="{{route('home_page')}}">
                        <img src="{{ asset('assets/home/images/logo.png')}}" class="logo" alt="Tutor Wand">
                    </a>
                </div>
                <div class="col-md-9 col-sm-8 col-8">
                    <nav class="navbar navbar-expand-lg">

                        <button class="navbar-toggler drawer-hamburger" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <!-- <i class="fa fa-align-justify" aria-hidden="true"></i> -->
                            <span class="sr-only">toggle navigation</span> <span class="drawer-hamburger-icon"></span>
                        </button>
                        <!-- <div class="nav-overlay" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"></div> -->
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto" id="nav">
                                <li class="nav-item current">
                                    <a class="nav-link " href="#home">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="#vision">Value Prop</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="#demo">Demo</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="#feature">Features</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " href="#about">About Us</a>
                                </li>
                            </ul>
                            <form class="form-inline my-2 my-lg-0">
                                <ul class="social-icons">
                                    <li>
                                        <a href="{{route('auth2')}}" class="gc-login">
                                            <img src="{{ asset('assets/home/images/loginBtn.png')}}" alt="Tutor Wand" />
                                        </a>
                                    </li>
                                </ul>
                            </form>
                        </div>
                    </nav>
                    <!-- <ul class="top-sec">
                        <li>
                            <a href="mailto:Info@tutorwand.com" class="text-left">
                                <div class="top-bar-icon"><i class="fa fa-envelope-o mt--2" aria-hidden="true"></i>
                                </div>
                                <div class="pull-left">
                                    <small class="text-light1">Feal free to write us.</small>
                                    <p>Info@tutorwand.com</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="tel:+917314959456" class="text-left">
                                <div class="top-bar-icon"><i class="fa fa-phone" aria-hidden="true"></i></div>
                                <div class="pull-left">
                                    <small class="text-light1">Call Us</small>
                                    <p>(+91) 731 4959456</p>
                                </div>
                            </a>
                        </li>
                    </ul> -->
                </div>
            </div>
        </div>

    </header>

    <body>
        <div class="top-banner-section" id="home">
            <a href="#"><img src="{{ asset('assets/home/images/top-bnr.jpg')}}" alt="Tutor Wand" class="img-fluid"></a>
        </div>

        <!-- information section -->
        <div class="information-section custom-sec" id="vision">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h1 class="home-main-heading wow fadeInUp">Value Proposition</h1>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="home-info-box">
                                    <a>
                                        <div class="home-icon-box wow fadeInUp">
                                            <i class="hovicon effect-4 sub-b">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 45 45" enable-background="new 0 0 45 45" xml:space="preserve">
                                                    <g>
                                                        <circle cx="11.457" cy="15.129" r="4.577" />
                                                        <path d="M41.103,10.209H21.895c-0.941,0-1.711,0.77-1.711,1.711v13.133c0,0,0,0,0,0.043c0.3,0.085,0.856,0.214,1.711,0.214V11.92
                                        h19.208v15.144H26.301c0.086,0.256,0.171,0.47,0.214,0.727c0.043,0.343,0.043,0.642-0.043,0.984h14.631
                                        c0.94,0,1.711-0.771,1.711-1.711V11.92C42.813,10.979,42.043,10.209,41.103,10.209z" />
                                                        <path d="M24.547,26.808l2.695-6.802c0.171-0.428-0.043-0.941-0.471-1.112c-0.428-0.171-0.941,0.043-1.112,0.471l-2.866,7.144
                                        c-0.898,0.086-2.438,0.086-3.251-0.342c-0.556-0.257-1.155-1.712-1.412-2.354c-0.128-0.299-0.257-0.599-0.342-0.77
                                        c-0.428-0.856-1.369-1.882-3.294-1.882H8.676c-1.498,0-2.652,0.77-3.465,2.224L5.04,23.728c-0.77,1.411-1.54,2.909-1.84,4.021
                                        c-0.299,1.241-0.984,4.535-0.984,4.663c-0.171,0.941,0.428,1.883,1.369,2.054c0.128,0.043,0.257,0.086,0.342,0.086
                                        c0.813,0,1.54-0.6,1.711-1.412c0-0.043,0.642-3.337,0.941-4.406c0.128-0.428,0.385-1.069,0.727-1.711l-0.214,7.614
                                        c0,0.642,0.471,1.155,1.112,1.155h6.502c0.642,0,1.112-0.514,1.112-1.155l-0.257-7.871c0.556,1.026,1.326,2.096,2.481,2.652
                                        c2.182,1.026,5.304,0.642,5.647,0.599c0.983-0.128,1.625-1.026,1.497-1.968C25.188,27.492,24.932,27.106,24.547,26.808z" />
                                                        <path d="M37.894,14.487H25.103c-0.471,0-0.855,0.385-0.855,0.856c0,0.47,0.385,0.855,0.855,0.855h12.791
                                        c0.471,0,0.855-0.385,0.855-0.855C38.749,14.872,38.364,14.487,37.894,14.487z" />
                                                        <path d="M37.894,18.637h-7.828c-0.471,0-0.855,0.385-0.855,0.855s0.385,0.855,0.855,0.855h7.828c0.471,0,0.855-0.385,0.855-0.855
                                        S38.364,18.637,37.894,18.637z" />
                                                        <path d="M37.894,22.786h-7.828c-0.471,0-0.855,0.385-0.855,0.855s0.385,0.855,0.855,0.855h7.828c0.471,0,0.855-0.385,0.855-0.855
                                        S38.364,22.786,37.894,22.786z" />
                                                    </g>
                                                </svg>
                                            </i>
                                        </div>

                                        <h3>Teacher</h3>
                                        <ul>
                                            <li>Create an assessment in few seconds.</li>
                                            <li>Auto-correction for all types of questions.</li>
                                            <li>Reports at class, students, and topic level.</li>

                                        </ul>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="home-info-box">
                                    <a>
                                        <div class="home-icon-box wow fadeInUp">
                                            <i class="hovicon effect-4 sub-b">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 45 45" enable-background="new 0 0 45 45" xml:space="preserve">
                                                    <g>
                                                        <path d="M26.25,11.791l-2.6,1.139c-0.467,0.467-1.488,0.467-1.958,0l-3.277-1.466
                                                c-0.291,1.138,0.001,2.883,0.002,2.883c-0.295-0.206-0.564-0.313-0.787-0.368c0.326,3.529,2.396,6.251,4.9,6.251
                                                c2.549,0,4.644-2.813,4.914-6.426c0.035-0.233,0.054-0.472,0.057-0.714l-0.795,0.913C26.938,13.488,26.611,12.556,26.25,11.791z" />
                                                        <path d="M24.648,24.259h8.334c-1.109-2.256-3.337-3.864-5.959-4.104C27.008,20.833,25.824,22.634,24.648,24.259z" />
                                                        <path d="M18.04,20.155c-2.624,0.239-4.85,1.847-5.962,4.104h8.128C19.134,22.634,18.053,20.833,18.04,20.155z" />
                                                        <circle cx="22.5" cy="32.332" r="0.74" />
                                                        <path d="M34.196,40.508H10.804c-0.329,0-0.596,0.268-0.596,0.597c0,0.328,0.267,0.596,0.596,0.596h23.392
                                                c0.329,0,0.596-0.268,0.596-0.596C34.792,40.775,34.525,40.508,34.196,40.508z" />
                                                        <path d="M12.157,40.155h20.688c0.769,0,1.393-0.623,1.393-1.393l2.786-13.11c0-0.77-0.624-1.394-1.394-1.394h-2.647
                                                c0.038,0.076,0.074,0.151,0.109,0.227h2.412c0.761,0,1.379,0.609,1.379,1.362l-2.785,12.719c0,0.753-0.618,1.364-1.38,1.364H12.282
                                                c-0.761,0-1.379-0.612-1.379-1.364L8.117,25.85c0-0.755,0.618-1.363,1.379-1.363h2.474c0.035-0.076,0.072-0.151,0.108-0.226H9.371
                                                c-0.77,0-1.394,0.623-1.394,1.392l2.786,13.111C10.763,39.532,11.388,40.155,12.157,40.155z" />
                                                        <path d="M20.356,24.486c-0.051-0.076-0.1-0.15-0.15-0.226h-8.128c-0.036,0.075-0.073,0.15-0.108,0.226H20.356z" />
                                                        <path d="M24.648,24.261h-1.536l-0.077-1.101c0.521-0.269,0.923-0.828,0.923-1.396c0,0-0.772,0.34-1.561,0.34
                                                c-0.79,0-1.563-0.34-1.563-0.34c0,0.568,0.403,1.127,0.922,1.396l-0.076,1.101h-1.475c0.05,0.075,0.1,0.151,0.15,0.226h1.308h1.462
                                                l0,0h1.356h8.608c-0.035-0.076-0.071-0.151-0.109-0.226H24.648z" />
                                                        <path d="M14.926,7.493l-0.039,0.54c-0.208,0.035-0.371,0.218-0.371,0.438c0,0.198,0.13,0.365,0.31,0.424l-0.358,5.016l0.494,1.483
                                                l0.494-1.483l-0.359-5.016c0.178-0.059,0.309-0.226,0.309-0.424c0-0.221-0.16-0.403-0.369-0.438L15,7.536l0.857,0.496l0.035,0.021
                                                l1.623,0.939l-0.105,1.339c-0.229,0.51-0.394,1.057-0.477,1.634c-0.044,0.295-0.065,0.597-0.065,0.904
                                                c0,0.125,0.004,0.249,0.012,0.372c0.009,0.179,0.026,0.357,0.053,0.532c0.004,0.054,0.009,0.107,0.011,0.159
                                                c0.359,4.04,2.722,7.163,5.587,7.163c2.9,0,5.288-3.202,5.598-7.319c0.042-0.295,0.064-0.598,0.064-0.907s-0.022-0.611-0.064-0.907
                                                c-0.089-0.605-0.268-1.178-0.515-1.709l-0.105-1.046l1.66-0.96l0.371-0.214l1.545-0.893c0.096-0.098,0.096-0.254,0-0.351
                                                l-8.212-3.416c-0.096-0.097-0.252-0.097-0.347,0l-8.21,3.416c-0.099,0.097-0.099,0.253,0,0.351L14.926,7.493z M27.445,13.803
                                                c-0.271,3.613-2.366,6.426-4.914,6.426c-2.506,0-4.575-2.722-4.9-6.251c0.221,0.055,0.491,0.162,0.786,0.368
                                                c0,0-0.292-1.746-0.002-2.883l3.279,1.467c0.469,0.466,1.492,0.466,1.957,0l2.6-1.14c0.361,0.766,0.688,1.697,0.456,2.21
                                                l0.795-0.913C27.498,13.331,27.479,13.569,27.445,13.803z" />
                                                    </g>
                                                </svg>
                                            </i>
                                        </div>
                                        <h3>Students</h3>
                                        <ul>
                                            <li>Enjoy a seamless online assessment experience.</li>
                                            <li>Healthy competition with other students.</li>
                                            <li>Recommendation on improvement area. </li>
                                        </ul>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="video-section" id="demo">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <h1 class="text-center home-main-heading">
                            How It Works
                        </h1>
                        <h6 class="text-center">Quick Start: Teacher onboarding and class creation</h6>
                        <br><br>
                        <div class="gc-ic-box d-none">
                            <img src="{{ asset('assets/home/images/gc-ic.png')}}" alt="Tutor Wand">
                            <p class="text-center mb-0 mt-2"><strong>Google Classroom</strong></p>
                        </div>
                        <div class="video-outer" data-toggle="modal" data-target="#myModal" data-src="https://www.youtube.com/embed/IWMHBuODz9U">
                            <img src="{{ asset('assets/home/images/video-img.jpg')}}" class="w-100" alt="Tutor Wand">
                        </div>
                    </div>
                </div>
            </div>
            <div class="q-counter">
                <h1>Question Bank of 5,00,000+ questions.</h1>
            </div>
        </div>
        <div class="innovation-section" id="feature">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <img src="{{ asset('assets/home/images/feature-img.png')}}" class="w-100 mb-4" alt="Tutor Wand">
                    </div>
                    <div class="col-md-5 offset-md-2 ">
                        <div class="inner-padding wow fadeInLeft">

                            <h1 class="home-main-heading">Features</h1>
                            <ul class="innovation-list">
                                <li class="wow flipInY">
                                    <div class="iconbox">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="36px" height="36px" viewBox="0 0 36 36" enable-background="new 0 0 36 36" xml:space="preserve">
                                            <g>
                                                <circle fill="none" stroke="" stroke-miterlimit="10" cx="18" cy="18" r="17" />
                                                <path fill="" d="M15.645,23.03c-0.197,0-0.394-0.073-0.543-0.224l-4.709-4.71c-0.3-0.301-0.3-0.786,0-1.086
                                                c0.3-0.302,0.786-0.302,1.088,0l4.165,4.166l8.875-8.875c0.3-0.3,0.786-0.3,1.087,0c0.302,0.301,0.302,0.786,0,1.088l-9.418,9.418
                                                C16.039,22.957,15.842,23.03,15.645,23.03z" />
                                            </g>
                                        </svg>
                                    </div>
                                    <p>
                                        <strong>Assessment Creation:</strong><br>
                                        Create Test within 60 Seconds with customized blueprints

                                    </p>
                                </li>
                                <li class="wow flipInY">
                                    <div class="iconbox">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="36px" height="36px" viewBox="0 0 36 36" enable-background="new 0 0 36 36" xml:space="preserve">
                                            <g>
                                                <circle fill="none" stroke="" stroke-miterlimit="10" cx="18" cy="18" r="17" />
                                                <path fill="" d="M15.645,23.03c-0.197,0-0.394-0.073-0.543-0.224l-4.709-4.71c-0.3-0.301-0.3-0.786,0-1.086
                                                c0.3-0.302,0.786-0.302,1.088,0l4.165,4.166l8.875-8.875c0.3-0.3,0.786-0.3,1.087,0c0.302,0.301,0.302,0.786,0,1.088l-9.418,9.418
                                                C16.039,22.957,15.842,23.03,15.645,23.03z" />
                                            </g>
                                        </svg>
                                    </div>
                                    <p>
                                        <strong>Online Assessment:</strong><br>
                                        Gamified assessment experience

                                    </p>
                                </li>
                                <li class="wow flipInY">
                                    <div class="iconbox">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="36px" height="36px" viewBox="0 0 36 36" enable-background="new 0 0 36 36" xml:space="preserve">
                                            <g>
                                                <circle fill="none" stroke="" stroke-miterlimit="10" cx="18" cy="18" r="17" />
                                                <path fill="" d="M15.645,23.03c-0.197,0-0.394-0.073-0.543-0.224l-4.709-4.71c-0.3-0.301-0.3-0.786,0-1.086
                                                c0.3-0.302,0.786-0.302,1.088,0l4.165,4.166l8.875-8.875c0.3-0.3,0.786-0.3,1.087,0c0.302,0.301,0.302,0.786,0,1.088l-9.418,9.418
                                                C16.039,22.957,15.842,23.03,15.645,23.03z" />
                                            </g>
                                        </svg>
                                    </div>
                                    <p>
                                        <strong>Grading:</strong><br>
                                        Auto-grading for all the types of questions

                                    </p>
                                </li>
                                <li class="wow flipInY">
                                    <div class="iconbox">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="36px" height="36px" viewBox="0 0 36 36" enable-background="new 0 0 36 36" xml:space="preserve">
                                            <g>
                                                <circle fill="none" stroke="" stroke-miterlimit="10" cx="18" cy="18" r="17" />
                                                <path fill="" d="M15.645,23.03c-0.197,0-0.394-0.073-0.543-0.224l-4.709-4.71c-0.3-0.301-0.3-0.786,0-1.086
                                                c0.3-0.302,0.786-0.302,1.088,0l4.165,4.166l8.875-8.875c0.3-0.3,0.786-0.3,1.087,0c0.302,0.301,0.302,0.786,0,1.088l-9.418,9.418
                                                C16.039,22.957,15.842,23.03,15.645,23.03z" />
                                            </g>
                                        </svg>
                                    </div>
                                    <p>
                                        <strong>Report:</strong><br>
                                        In-depth analysis at class, students, assessment, and sub-topic level.

                                    </p>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- work-section -->
        <!-- testimonial slider section -->
        <div class="testimonial-outer ">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-6 offset-md-3">
                    <h1 class="home-main-heading text-center">Testimonials</h1>
                    
                        <div class="owl-carousel owl-theme" id="owl-carousel4">
                            <div class="item">
                                <img src="{{ asset('assets/home/images/t1.jpg')}}" alt="">
                            </div>
                            <div class="item">
                                <img src="{{ asset('assets/home/images/t2.jpg')}}" alt="">
                            </div>
                            <div class="item">
                                <img src="{{ asset('assets/home/images/t3.jpg')}}" alt="">
                            </div>
                            <div class="item">
                                <img src="{{ asset('assets/home/images/t4.jpg')}}" alt="">
                            </div>
                            <div class="item">
                                <img src="{{ asset('assets/home/images/t5.jpg')}}" alt="">
                            </div>
                            <div class="item">
                                <img src="{{ asset('assets/home/images/t6.jpg')}}" alt="">
                            </div>
                            <div class="item">
                                <img src="{{ asset('assets/home/images/t7.jpg')}}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- testimonial end -->
        <div class="modal" id="myModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">


                    <!-- Modal body -->
                    <div class="modal-body p-0">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="" id="player" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- footer -->

        <!-- footer secondary -->
        <div class="footer-secondary">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-9" id="about">
                                <h4 class="text-left">About Us</h4>
                                <p class="text-justify">
                                    We as a team, recognize that achieving growth for our partners requires a culture of continuous motion; experimenting with emerging technology, being ready to handle any obstacle at any time, and mastering continuity in an ever-changing agile environment.​ We are equipped to do exactly that. We​ have​​ a proven ​record​ ​with successful​ IT product development companies in India ​​​and across​ ​the​ globe​ ​with​ a leadership​ team​ ​that​ has​​ experience in​ ​managing​ multi-million​​dollar​​ IT​ products​​ for​ fortune 500​ ​customers.​​
                                </p>
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-left">Contact Us</h4>
                                <div class="footer-info">
                                    <div class="d-flex">
                                        <i class="">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
                                                <g>
                                                    <g>
                                                        <g>
                                                            <g>
                                                                <path fill="" d="M12.523,3.504c0.015,0,0.029,0,0.042,0c2.125,0,4.116,0.821,5.609,2.314
                                                        c1.506,1.506,2.332,3.514,2.32,5.654c-0.002,0.481,0.387,0.873,0.868,0.876c0.001,0,0.003,0,0.004,0
                                                        c0.479,0,0.869-0.387,0.872-0.868c0.012-2.608-0.993-5.058-2.831-6.894c-1.823-1.824-4.252-2.826-6.841-2.826
                                                        c-0.017,0-0.032,0-0.048,0c-0.482,0.001-0.871,0.394-0.868,0.875C11.653,3.116,12.043,3.504,12.523,3.504z" />
                                                                <path fill="#009CC2" d="M23.155,18.824c-0.031-0.864-0.391-1.67-1.012-2.27c-1.218-1.174-2.238-1.85-3.209-2.133
                                                        c-1.342-0.387-2.583-0.033-3.691,1.049c0,0-0.003,0.002-0.004,0.005l-1.18,1.169c-0.732-0.411-2.157-1.315-3.714-2.874
                                                        l-0.116-0.114c-1.547-1.549-2.458-2.98-2.874-3.717l1.17-1.178c0.001-0.002,0.003-0.002,0.005-0.005
                                                        c1.082-1.107,1.433-2.348,1.046-3.688c-0.281-0.973-0.959-1.994-2.133-3.21C6.845,1.234,6.04,0.875,5.176,0.844
                                                        C4.314,0.813,3.483,1.114,2.84,1.69L2.816,1.713C2.805,1.724,2.793,1.734,2.782,1.745c-1.279,1.279-1.95,3.072-1.939,5.182
                                                        C0.86,10.51,2.83,14.609,6.111,17.89c0.003,0.003,0.005,0.005,0.008,0.008c0.617,0.616,1.317,1.226,2.083,1.812
                                                        c0.381,0.294,0.929,0.221,1.221-0.16c0.294-0.382,0.22-0.93-0.161-1.224c-0.708-0.542-1.353-1.104-1.917-1.67
                                                        c-0.003-0.003-0.006-0.005-0.008-0.008c-2.958-2.962-4.735-6.598-4.75-9.731c-0.008-1.624,0.48-2.98,1.412-3.923l0.008-0.005
                                                        C4.639,2.419,5.599,2.455,6.19,3.067c2.257,2.34,2.093,3.445,1.096,4.468L5.671,9.163c-0.253,0.255-0.324,0.64-0.178,0.969
                                                        c0.041,0.092,1.034,2.285,3.504,4.756l0.115,0.114c2.472,2.474,4.665,3.465,4.755,3.506c0.33,0.147,0.714,0.076,0.97-0.177
                                                        l1.628-1.616c1.023-0.997,2.128-1.163,4.469,1.096c0.613,0.591,0.647,1.55,0.079,2.185l-0.007,0.006
                                                        c-0.936,0.926-2.275,1.413-3.883,1.413c-0.014,0-0.027,0-0.041,0c-1.283-0.005-2.771-0.356-4.301-1.019
                                                        c-0.441-0.19-0.955,0.014-1.146,0.455c-0.189,0.444,0.013,0.956,0.456,1.146c1.768,0.764,3.443,1.152,4.982,1.161
                                                        c0.016,0,0.032,0,0.049,0c2.088,0,3.862-0.67,5.132-1.939c0.012-0.012,0.022-0.022,0.033-0.033l0.021-0.027
                                                        C22.888,20.516,23.187,19.688,23.155,18.824z" />
                                                                <path fill="#009CC2" d="M16.946,7.056c-0.937-0.936-1.834-1.184-2.265-1.302c-0.466-0.129-0.945,0.143-1.073,0.607
                                                        c-0.128,0.463,0.145,0.944,0.607,1.072c0.354,0.097,0.886,0.246,1.496,0.854c0.588,0.589,0.743,1.119,0.847,1.469l0.013,0.043
                                                        c0.113,0.378,0.459,0.624,0.835,0.624c0.082,0,0.166-0.011,0.248-0.036c0.463-0.136,0.726-0.621,0.588-1.084l-0.011-0.04
                                                        C18.097,8.807,17.848,7.957,16.946,7.056z" />
                                                            </g>
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>
                                        </i>
                                        <p class="mb-0">
                                            <!-- <a href="tel:+119174469844"> -->(+91) 731 4959456
                                            <!--</a>-->
                                        </p>
                                    </div>
                                    <div class="d-flex">
                                        <i class="">
                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="24px" height="24px" viewBox="0 0 24 24" enable-background="new 0 0 24 24" xml:space="preserve">
                                                <g>
                                                    <g>
                                                        <path fill="" d="M20.551,1.86L1.391,8.918C0.982,9.07,0.867,9.593,1.175,9.9l3.841,3.84l-0.74,4.473
                                                c-0.064,0.405,0.283,0.753,0.686,0.686l4.475-0.738l3.842,3.842c0.305,0.306,0.828,0.196,0.98-0.217l7.059-19.159
                                                C21.491,2.151,21.026,1.686,20.551,1.86z M5.588,17.589l0.463-2.81l0.043,0.042c0.212,0.211,0.548,0.231,0.781,0.052l5.866-4.438
                                                c-4.77,6.299-4.457,5.884-4.486,5.937c-0.129,0.23-0.087,0.521,0.099,0.71l0.042,0.042L5.588,17.589z M13.461,20.498l-3.895-3.893
                                                c0.031-0.043,6.703-8.854,6.732-8.892c0.415-0.559-0.299-1.24-0.84-0.831l-8.888,6.726L2.678,9.716l17.072-6.29L13.461,20.498z" />
                                                    </g>
                                                </g>
                                            </svg>
                                        </i>
                                        <p class="mb-0">
                                            <!--<a href="mailto:info@tutorwand.com">-->info@tutorwand.com
                                            <!--</a>-->
                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="footer-3">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 mob-center">
                        <small>Copyright © Tutorwand.com 2021. All rights reserved. </small>
                    </div>
                    <div class="col-md-6 text-right mob-center">
                        <a href="{{route('privacypolicy')}}" class="text-brand"><small>{{ __('teachers.privacyPolicy') }}</small></a>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('assets/js/jquery-3.2.1.slim.min.js')}}">
        </script>
        <script src="{{ asset('assets/js/jquery-3.2.1.min.js')}}"></script>
        <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
        </script>
        <script src="{{ asset('assets/js/bootstrap.min.js')}}">
        </script>

        <script src="{{ asset('assets/home/js/wow.js')}}"></script>
        <script src="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.js')}}"></script>
        <script src="{{ asset('assets/home/js/script.js')}}"></script>

    </body>

</html>