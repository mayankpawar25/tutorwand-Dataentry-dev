<style type="text/css">
    .comments{
        background-color: yellow;
    }
</style>
<script src="{{ asset('assets/js/jquery-3.2.1.slim.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/utils.js') }}"></script>
<script type="text/javascript">
    let fewGradeLeft = "{{ __('grading.fewGradeLeft') }}";
    let graded = "graded";
	let ungraded = "ungraded";
	let autograded = "autograded";
	let answerstatus = "answerStatus";

	let allText = "{{ __('grading.all') }}";
	let gradedText = "{{ __('grading.graded') }}";
	let ungradedText = "{{ __('grading.ungraded') }}";
	let autogradedText = "{{ __('grading.autograded') }}";
	let overriddenText = "{{ __('grading.override') }}";
	let publishedErrorText = "{{ __('grading.publishedError') }}";

	let publishResultWarningText = "{{ __('grading.completeGradingFirst') }}";
	let releaseDateInfoText = "{{ __('grading.releaseDateInfo') }}";

	let publishResultUrl = "{{ route('grading.publish.result') }}";
	let confirmPublishResult = "{{ __('grading.confirmPublishResult') }}";

	let successResultPublish = "{{ __('grading.successResultPublish') }}";
	let somethingWentWrong = "{{ __('grading.somethingWentWrong') }}";

	let btnSpinner = `{!! config('constants.spinner') !!}`;

	let gradingFeedbackURL = "{{ route('grading.feedback') }}";

	let gradeToAllError = "{{ __('grading.gradeToAllError') }}";

	let paperId = "";
	let teacherId = "";

	let gradedCount = 0;
	let ungradedCount = 0;
	let autogradedCount = 0;
	let answerStatusCount = 0;
	let zoomIcon            = `{!! config('constants.icons.enlarge-icon') !!}`;
	let zoomOutIcon         = `{!! config('constants.icons.enlarge-big-icon') !!}`;
	
	$(document).on('click','.showShareLink', function(){
		let examUrl = $(this).data('href');
		$("#shareData #sharelinkurl2").val(examUrl);
		$("#shareData a").attr({"href": `https://web.whatsapp.com/send?text=${examUrl}`});
		$("#shareData #sharelinkurl2").attr({"value": `${examUrl}`});
	});
	

	function copyFunction() {
	  /* Get the text field */
	  copyToClipboard("#sharelinkurl2");
	}

	let gradeText = "{{ __('grading.grade') }}";
	let absentText = "{{ __('grading.absent') }}";
	let statusUpdateText = "{{ __('grading.statusUpdatedTo') }}";

	$(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
	let consGradedText = `{!! config('constants.graded') !!}`;
	let consAbsentText = `{!! config('constants.absent') !!}`;
	let consDueText = `{!! config('constants.due') !!}`;
	let consDraftText = `{!! config('constants.draft') !!}`;
</script>
<script src="{{ asset('assets/teachers/js/grading-scripts.js') }}"></script>
