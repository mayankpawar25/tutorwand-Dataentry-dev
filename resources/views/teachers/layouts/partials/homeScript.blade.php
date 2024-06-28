<script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('assets/teachers/js/common-scripts.js') }}"></script>
<script src="{{ asset('assets/js/utils.js') }}"></script>
<script src="//rawgit.com/kottenator/jquery-circle-progress/1.2.2/dist/circle-progress.js"></script>
<script src="//cdn.jsdelivr.net/npm/chart.js@3.5.0/dist/chart.min.js"></script>
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
