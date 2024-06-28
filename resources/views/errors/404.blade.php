<head>
    @section('title', __('Page not found'))
    @include('../teachers.includes.head')
</head>
<body>
    <div class="d-table w-100 vh-100" >
        <div class="d-table-cell align-middle text-center">
            <a href="{{ url('/') }}">
                <img src="{{ asset('assets/images/errors/404.jpg') }}" alt="" class="img-fluid">
            </a>
        </div>
    </div>
</body>