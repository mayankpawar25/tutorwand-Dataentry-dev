<html>
    <head>
        @section('title', __('Mobile not supported'))
        @include('teachers.layouts.partials.head')
    </head>
    <body>
        <div class="d-table" >
            <div class="d-table w-100 vh-100" >
                <div class="d-table-cell align-middle text-center">
                    <img src="{{ asset('assets/images/mobile-ban-icon.png') }}">
                    <p>This functionality is available only on Desktop. Hold tight, soon it will be available on mobile.</p>
                </div>
            </div>
        </div>
    </body>
</html>