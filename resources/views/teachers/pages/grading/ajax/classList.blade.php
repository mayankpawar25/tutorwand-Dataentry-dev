<div class="row">
    @foreach($classList as $class)
        <div class="col-lg-6  col-sm-6 col-12 text-center mt-2 report-tile-color-loop">
            <div class="report-home-tile">
                <a href="{{ route('assessment.report', base64_encode($assessmentId .'_'. $class['classId'])) }}" target="_blank">
                    <div class="tile-header-dark">
                        <div class="tile-header-icon"> 
                            {!! config('constants.icons.class-icon') !!}
                        </div>
                        <h4 class="mt-2 mb-0">{{ $class['className'] }}</h4>
                    </div>
                    <div class="tile-count">
                        <div class="left-count">
                            <div><p class="mb-0">Assignee Count</p></div>
                            <div><h1 class="mt-0 mb-0"> {{ $class['attemptedStudentCount'] }} / {{ $class['assingedStudentCount'] }}</h1></div>
                        </div>
                    </div>
                    <h5>Board: {{ $class['board']['boardName'] }}</h5>
                    <h5>Grade: {{ $class['grade']['gradeName'] }}</h5>
                    <h5>Subject: {{ $class['subject']['subjectName'] }}</h5>
                </a>
            </div>
        </div>
    @endforeach
</div>