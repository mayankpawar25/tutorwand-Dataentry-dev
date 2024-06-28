<script type="text/javascript" src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/teachers/js/popper.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/teachers/js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/utils.js') }}"></script>

<script>
    let subjectFilter = "";
    let gradeFilter = "";
    
    $(function() {
        $(".fixed-side-panel-trigger").click(function() {
            $(".fixed-side-panel").toggleClass("fixed-panel-open");
            $(".fixed-side-panel-trigger").toggleClass("rotate-180");
            $(".main-header").toggleClass("slide-100");
        });
        onlineChecker("{{ __('questionLayout.onlineNotification') }}", "{{ __('questionLayout.offlineNotification') }}");
        $('[data-toggle="popover"]').popover();
        $('[data-toggle="tooltip"]').tooltip();

        
        /* Call Student Classroom and student list */
        getStudentList();
    });

    function getStudentList() {
        @if (!Cache::has(getStudentUserId() . ':courseStudents') || Cache::get(getStudentUserId() . ':courseStudents') == null)
            $.ajax({
                url: `{{ route('get.course.student.list') }}`,
                type: 'GET',
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                success: function(resp){ 
                    return true;
                },
                error: function(err) {
                    getStudentList();
                }
            });
        @endif
        return true;
    }
    /* Accordian Filters */
    $(document).on('change', '#subject-filter, #grade-filter',  function() {
        subjectFilter = $("#subject-filter").val() != "" ? $.trim($("#subject-filter").val()) : '';
        gradeFilter = $("#grade-filter").val() != "" ? $.trim($("#grade-filter").val()) : '';

        if(subjectFilter.length > 0) {
            $(".accordion-group").each(function (index, element) {
                let accordianSubject = $.trim($(element).data('subject'));
                let accordianGrade = $.trim($(element).data('grade'));
                if(accordianSubject == subjectFilter) {
                    if(gradeFilter.length > 0) {
                        if(accordianGrade == gradeFilter) {
                            $(element).fadeIn('800');  // show
                        } else {
                            $(element).fadeOut('800'); // hide
                        }
                    } else {
                        $(element).fadeIn('800');      // show
                    }
                } else {
                    $(element).fadeOut('800');         // hide
                }
            });
        } else {
            $("#home .accordion-group").each(function (index, element) {
                let accordianSubject = $(element).data('subject');
                let accordianGrade = $(element).data('grade');
                if(accordianSubject != subjectFilter) {
                    if(gradeFilter.length > 0) {
                        if(accordianGrade == gradeFilter) {
                            $(element).fadeIn('800');  // show
                        } else {
                            $(element).fadeOut('800'); // hide
                        }
                    } else {
                        $(element).fadeIn('800');      // show
                    }
                }
            });
        }
    });


    $('#videoModal').on('shown.bs.modal', function (e) {
        // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
        let videoSrc = $('.video-btn').data( "src" );
        $("#videoplayer").attr('src', videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0" ); 
    });
        
    // stop playing the youtube video when I close the modal
    $('#videoModal').on('hide.bs.modal', function (e) {
        // a poor man's stop video
        let videoSrc = $('.video-btn').data( "src" );
        $("#videoplayer").attr('src', videoSrc); 
    });


    $(window).scroll(function () {
        if ($(window).scrollTop() > 100) {
            btn.addClass('show');
        } else {
            btn.removeClass('show');
        }
    });
</script>
