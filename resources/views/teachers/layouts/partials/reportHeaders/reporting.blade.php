<div class="main-header">
    <div class="header-bg-strip">
        <div class="container-fluid">
            <div class="header-left">
                    <span  class="float-left d-none d-lg-block d-md-block">{!! getEnvironment() !!}</span>
                    <span  class="mob-logo d-block d-lg-none d-md-none">
                    <img src="{{ asset('assets/images/students/logo-sm.svg')}}" class="small-logo">
                    </span>
            </div>  
                    @include('teachers.layouts.partials.profile')
        </div>
    </div>

    <!-- container-fluid end -->
    <div class="sub-header">
        <div class="row">
            <div class="col-sm-2 col-lg-4">
                <div class="">
                    <h5 class="mb-1">{{ $assessmentName }}</h5>
                    <p class="mb-0">{{ isset($resultDate) ? sprintf(__('teachers.report.resultPublishDate') , utcToDate($resultDate)) : sprintf(__('teachers.report.submittedOn') , utcToDate($submittedOn)) }}</p>
                </div>
            </div>
            <div class="col-lg-4 offset-lg-4">
                <div class="d-flex align-items-center justify-content-end">
                    <a href="{{ $questionPDFUrl }}" type="button" class="btn btn-primary auto-width" target="_blank"><i class=" left">{!! config('constants.icons.question-list-icon') !!}</i> {{ __('teachers.report.questionPaper') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
