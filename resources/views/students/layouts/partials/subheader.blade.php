<div class="sub-header">
    <div class="row">
        <div class="col-sm-8 col-lg-4 col-8">
            <div class="">
                <h5 class="mb-1">{{ $assessmentName }}</h5>
                <p class="mb-0">{{ sprintf(__('teachers.report.submittedOn') , utcToDate($resultDate)) }}</p>
            </div>
        </div>
        <div class="col-sm-4 col-lg-4 offset-lg-4 col-4">
            <div class="d-flex align-items-center justify-content-end">
                <a href="{{ $questionPDFUrl }}" type="button" class="btn btn-primary auto-width btn-sm-with-icon" target="_blank"><i class=" left">{!! config('constants.icons.question-list-icon') !!}</i> <span class="hide-mob">{{ __('teachers.report.questionPaper') }}</span></a>
            </div>
        </div>
    </div>
</div>