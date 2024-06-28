@extends('teachers.layouts.default')
@section('content')
	<div class="canvas-inner position-relative ">
	    <div class="canvas-body">
	        <div class="top-cards">
	        	{{ csrf_field() }}
            	<div id="loader-wrapper" class="100vh">
	                <div id="loader1">{!! config('constants.icons.loader-icon') !!}</div>
	            </div>
	            <div class="row" id="googleClassrooms">
	            	<!-- Teacher Report Home Card -->
	            </div>
	        </div>
	    </div>
	</div>
@endsection

@section('onPageJs')
<script type="text/javascript">
	function getGoogleClassRooms() {
		$.ajax({
			url: "{{ route('ajax.google.classrooms') }}",
			type: 'POST',
			dataType: 'json',
			headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
			success: function(resp) {
				if(resp.status == true) {
					$("#googleClassrooms").html(resp.html);
					$("#loader-wrapper").remove();
				} else {
					$("#googleClassrooms").html(resp.html);
					$("#loader-wrapper").remove();
				}
			},
			error: function(error) {
				$("#googleClassrooms").html(`<div class="col-12">{{ __('teachers.report.noClassroomAvailable') }}</div>`);
				$("#loader-wrapper").remove();
			}
		});
	}
	getGoogleClassRooms();
</script>
@endsection