<head>
    @section('title', __('Service Unavailable'))
    @include('../teachers.includes.head')
</head>
<body>
    <div class="d-table" >
        <div class="d-table w-100 vh-100" >
            <div class="d-table-cell align-middle text-center">
                <img src="{{ asset('assets/images/errors/503.jpg') }}" alt="" class="img-fluid">
                @if(isset($exception))
                    @section('message', __($exception->getMessage() ?: 'Service Unavailable'))
                @endif
            </div>
        </div>
    </div>
</body>