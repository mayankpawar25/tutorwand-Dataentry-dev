<!-- Common JS -->

<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery-3.2.1.min.js')); ?>"></script>



<!-- Plugins JS -->

<script type="text/javascript" src="<?php echo e(asset('assets/plugins/jquery-ui-1.12.1/jquery-ui.min.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('assets/plugins/materialize/js/materialize.min.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('assets/plugins/slimScroll/jquery.slimscroll.min.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('assets/plugins/malihu-custom-scrollbar/jquery.mCustomScrollbar.concat.min.js')); ?>"></script>



<!-- Custom Js -->

<script type="text/javascript" src="<?php echo e(asset('assets/admin/dist/js/custom.js')); ?>"></script>



<!-- Common JS -->

<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.amsify.suggestags.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('assets/js/utils.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('assets/js/popper.min.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('assets/js/bootstrap.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('assets/js/moment.min.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('assets/js/jquery.datetimepicker.full.min.js')); ?>"></script>



<!-- Plugin JS -->

<script type="text/javascript" src="<?php echo e(asset('assets/plugins/ckeditor/ckeditor.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('assets/plugins/ckeditor/ckeditor-custom.min.js')); ?>"></script>

<script type="text/javascript" src="<?php echo e(asset('assets/plugins/toastr/toastr.min.js')); ?>"></script>



<script type="text/javascript">

	let multiChoice 		= "<?php echo e(__('admin.multiChoice')); ?>";

	let longQuestion 		= "<?php echo e(__('admin.longQuestion')); ?>";

	let shortQuestion 		= "<?php echo e(__('admin.shortQuestion')); ?>";

	let trueOrFalse 		= "<?php echo e(__('admin.trueOrFalse')); ?>";

	let fillInTheBlank 		= "<?php echo e(__('admin.fillInTheBlank')); ?>";

	let shortQuestionWMCA 		= "<?php echo e(__('admin.shortQuestionWMCA')); ?>";

	let somethingWentWrong 	= "<?php echo e(__('admin.somethingWentWrong')); ?>";

	let copiedContentError 	= "<?php echo e(__('admin.copiedContentError')); ?>";

	let timeout 			= "<?php echo e(__('admin.timeout')); ?>";

	let selectFilterMsg 	= "<?php echo e(__('admin.selectFilterMsg')); ?>";

	let duplicateOptionText = "<?php echo e(__('admin.duplicateOptionText')); ?>";

	let defaultUrl 			= "<?php echo e(config('constants.defaultUrl')); ?>";

	let enterQuestion 		= "<?php echo e(__('admin.enterQuestion')); ?>";

	let enterOption 		= "<?php echo e(__('admin.enterOption')); ?>";

	let enterAnswer 		= "<?php echo e(__('admin.enterAnswer')); ?>";

	let selectOption 		= "<?php echo e(__('admin.selectOption')); ?>";

	let addAtleastOneBlank 	= "<?php echo e(__('admin.addAtleastOneBlank')); ?>";

	let selectTrueFalse 	= "<?php echo e(__('admin.selectTrueFalse')); ?>";

	$(document).ready(function() {

		toastr.options.closeButton = true;

		toastr.options.titleClass = true;

		toastr.options.preventDuplicates = true;



		<?php 

		if(Request::path() != 'admin/mobile/not') {

		?>

			if(detectMob()) {

				window.location.href = "<?php echo e(route('mobile.not')); ?>";

			}

		<?php 

		}

		?>



	});



	function detectMob() {

		return ( ( window.innerWidth <= 1023 ) );

	}

</script><?php /**PATH /home1/abhyur2a/public_html/tutorwand.com/dataentry-dev/resources/views/admin/layout/partials/scripts.blade.php ENDPATH**/ ?>