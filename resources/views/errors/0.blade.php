<head>
    @include('../teachers.includes.head')
</head>
<body>
    <div class="d-table" >
        <div class="d-table-cell align-middle text-center">
            <!-- <img src="{{ asset('assets/errors/500.jpg') }}" class="" style="height: 100vh"/> -->
        </div>
        @php
            if(isset($error)){
                foreach($error as $key => $data){
        @endphp
                    <label for="">{{ $key }}:</label> {{ $data }} <br>
        @php                    
                }
            }
        @endphp
    </div>
</body>