
<!-- Common js -->
<script type="text/javascript" src="{{ asset('assets/js/jquery-3.2.1.slim.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap-select.min.js')}}"></script>    
<script type="text/javascript" src="{{ asset('assets/js/utils.js') }}"></script>

<!-- Constants -->
@include('students.layouts.partials.constants')

<!-- Plugins JS -->
<script type="text/javascript" src="{{ asset('assets/plugins/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/js/image-zoom.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/js/dropzone.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/js/cropper.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/ckeditor/createEditor.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/elevatezoom/jquery.elevatezoom.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/zoom/jquery.zoom.js')}}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/owlcarousel/owl.carousel.min.js') }}"></script>


<!-- Student Common JS -->
<script type="text/javascript" src="{{ asset('assets/students/js/common-scripts.js') }}"></script>

<script>
    let InternalServerError = "{{ __('students.notifications.InternalServerError') }}";
    let popupBlocker = "{{ __('students.popupBlockerText') }}";
    $(document).on('change','#subjectFilter',function(){
        let subjectName = $('#subjectFilter option:selected').val();
        let countInProgress = 0;
        let countAttempted  = 0;
        let countMissing    = 0;
        let countUpcoming   = 0;
        if(subjectName.length > 0) {
            $("#myTabContent .card").each(function(index, element){
                var myTitle = $(element).attr('data-subject');
                if(myTitle == subjectName){
                    $(element).fadeIn("800");

                    if($(element).data('status') == 'inprogress') {
                        countInProgress++;
                    }
                    if($(element).data('status') == 'attempted') {
                        countAttempted++;
                    }
                    if($(element).data('status') == 'missing') {
                        countMissing++;
                    }
                    if($(element).data('status') == 'upcoming') {
                        countUpcoming++;
                    }
                } else {
                    if(!$(element).hasClass('blankCard')){
                        $(element).fadeOut("800");
                    }
                }
            });
        } else {
            $("#myTabContent .card").each(function(index, element){
                if($(element).data('status') == 'inprogress') {
                    countInProgress++;
                }
                if($(element).data('status') == 'attempted') {
                    countAttempted++;
                }
                if($(element).data('status') == 'missing') {
                    countMissing++;
                }
                if($(element).data('status') == 'upcoming') {
                    countUpcoming++;
                }
            });
            $("#myTabContent .card").fadeIn("800");
        }

        if(countInProgress > 0){
            $("#in-progress").find('.blankCard').hide();
        } else {
            $("#in-progress").find('.blankCard').show();
        }

        if(countAttempted > 0){
            $("#attempted").find('.blankCard').hide();
        } else {
            $("#attempted").find('.blankCard').show();
        }

        if(countMissing > 0){
            $("#missing").find('.blankCard').hide();
        } else {
            $("#missing").find('.blankCard').show();
        }

        if(countUpcoming > 0){
            $("#upcoming").find('.blankCard').hide();
        } else {
            $("#upcoming").find('.blankCard').show();
        }

        $(".inProgressCount").text(countInProgress);
        $(".attemptedCount").text(countAttempted);
        $(".missingCount").text(countMissing);
        $(".upcomingCount").text(countUpcoming);

    });

    $(".clock").click(function() {
        $(".clock").toggleClass("active");
        let flagData = JSON.parse(localStorage.getItem(flagId));
        if($(".clock").hasClass('active')) {
            flagData.timeHide = false;
        } else {
            flagData.timeHide = true;
        }
        localStorage.setItem(flagId, JSON.stringify(flagData));
    });
    
    $(function () {
	    $('[data-toggle="tooltip"]').tooltip();
    });

    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });

</script>
@if(request()->is('students/instructions/*'))
    @include('students.layouts.partials.paper.instructionScript')
@endif