<!-- Common JS -->

<script type="text/javascript" src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>



<!-- Plugins JS -->

<script type="text/javascript" src="{{ asset('assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/plugins/materialize/js/materialize.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/plugins/malihu-custom-scrollbar/jquery.mCustomScrollbar.concat.min.js') }}"></script>



<!-- Custom Js -->

<script type="text/javascript" src="{{ asset('assets/admin/dist/js/custom.js') }}"></script>



<!-- Common JS -->

<script type="text/javascript" src="{{ asset('assets/js/jquery.amsify.suggestags.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/utils.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/popper.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/bootstrap.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/moment.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/js/jquery.datetimepicker.full.min.js')}}"></script>



<!-- Plugin JS -->

<script type="text/javascript" src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/plugins/ckeditor/ckeditor-custom.min.js') }}"></script>

<script type="text/javascript" src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>



<script type="text/javascript">

	let multiChoice 		= "{{ __('admin.multiChoice') }}";

	let longQuestion 		= "{{ __('admin.longQuestion') }}";

	let shortQuestion 		= "{{ __('admin.shortQuestion') }}";

	let trueOrFalse 		= "{{ __('admin.trueOrFalse') }}";

	let fillInTheBlank 		= "{{ __('admin.fillInTheBlank') }}";

	let shortQuestionWMCA 		= "{{ __('admin.shortQuestionWMCA') }}";

	let somethingWentWrong 	= "{{ __('admin.somethingWentWrong') }}";

	let copiedContentError 	= "{{ __('admin.copiedContentError') }}";

	let timeout 			= "{{ __('admin.timeout') }}";

	let selectFilterMsg 	= "{{ __('admin.selectFilterMsg') }}";

	let duplicateOptionText = "{{ __('admin.duplicateOptionText') }}";

	let defaultUrl 			= "{{ config('constants.defaultUrl') }}";

	let enterQuestion 		= "{{ __('admin.enterQuestion') }}";

	let enterOption 		= "{{ __('admin.enterOption') }}";

	let enterAnswer 		= "{{ __('admin.enterAnswer') }}";

	let selectOption 		= "{{ __('admin.selectOption') }}";

	let addAtleastOneBlank 	= "{{ __('admin.addAtleastOneBlank') }}";

	let selectTrueFalse 	= "{{ __('admin.selectTrueFalse') }}";

	$(document).ready(function() {

		toastr.options.closeButton = true;

		toastr.options.titleClass = true;

		toastr.options.preventDuplicates = true;



		@php 

		if(Request::path() != 'admin/mobile/not') {

		@endphp

			if(detectMob()) {

				window.location.href = "{{ route('mobile.not') }}";

			}

		@php 

		}

		@endphp



	});



	function detectMob() {

		return ( ( window.innerWidth <= 1023 ) );

	}

</script>