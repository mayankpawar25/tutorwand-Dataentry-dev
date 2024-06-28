<div class="main-header">
    <div class="header-bg-strip">
        <div class="container-fluid">
            <div class="header-left">
                <span  class="float-left d-none d-lg-block d-md-block"><h5 class="mt-4 ml-3 text-white">{{ ucfirst($gradingData['assessmentName']) }}</h5></span>
                <span  class="mob-logo d-block d-lg-none d-md-none">
                <img src="{{ asset('assets/images/students/logo-sm.svg')}}" class="small-logo">
                </span>
            </div>
            
            @include('teachers.layouts.partials.profile') 
          
        </div>
    </div>
    <!-- container-fluid end -->

<!-- main header-end -->

  <div class="sub-header">
      <div class="row">
          <div class="col-sm-6 col-lg-6">
              <h5 class="mb-1">{{ $gradingData['board'] }} | {{ __('grading.class') }} {{ $gradingData['grade'] }} | {{ $gradingData['subject'] }}</h5>
              <p>{{ sprintf(__('grading.startOn'), localTimeZone($gradingData['startDateTime'])) }} | {{ sprintf( __('grading.dueOn'), localTimeZone($gradingData['dueDateTime'])) }}</p>
          </div>
          <div class="col-lg-6">
              <div class="d-flex align-items-center justify-content-end">
                  <div class="report-ic mr-3" data-toggle="tooltip" data-placement="top" title="View Question Paper">
                      <a href="{{ route('get.question.pdf', $gradingData['assessmentId']) }}" target="_blank">
                          {!! config('constants.icons.question-list-icon') !!}
                      </a>
                  </div>
                  <button type="button" class="btn btn-primary auto-width{{ $disablePublishResult ? '' : ' publishResult' }}" {{ $gradingData['isResultPublished'] == true ? 'disabled' : '' }}><i class=" left">
                    {!! config('constants.icons.publish-result') !!}
                    </i>{{ __('grading.publishResult') }}
                  </button>

              </div>
          </div>
      </div>
  </div>
  <!-- container-fluid end -->
</div>
