    <div class="d-table" >
        <div class="d-table w-100 vh-100" >
            <div class="d-table-cell align-middle text-center">
                <img src="{{ asset('assets/images/errors/500.jpg') }}" alt="" class="img-fluid">
            </div>
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