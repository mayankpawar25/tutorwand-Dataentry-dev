<!-- Student Report Home Card -->
@if(!empty($classList))
    @foreach($classList as $class)
        @php
            $classId = base64_encode($class['googleClassroomId'] . '_' . $class['subjectData']['board']['id'] . '_' . $class['subjectData']['grade']['id'] . '_' . $class['subjectData']['subject']['id']);
            $url = route('students.class.report', $classId);
        @endphp

        <div class="col-lg-3 col-md-4 col-sm-6 col-12 text-center report-tile-color-loop">
            <div class="report-home-tile">
                <a href="{{ $url }}">
                    <div class="tile-header-dark">
                        <div class="tile-header-icon"> {!! config('constants.icons.class-icon') !!} </div>
                        <h4 class="mt-2 mb-0">{{ $class['googleClassroomName'] }}</h4>
                    </div>
                    <div class="tile-count">
                        <div class="left-count">
                            <div>
                                <p class="mb-0">{{ __('teachers.report.testCount') }}</p>
                            </div>
                            <div>
                                <h1 class="mt-0 mb-0"> {{ $class['attemptedAssessmentCount'] }} / {{ $class['assessmentCount'] }}</h1>
                            </div>
                        </div>

                    </div>
                    <h5>{{ __('teachers.report.board') }}: {{ $class['subjectData']['board']['boardName'] }}</h5>
                    <h5>{{ __('teachers.report.grade') }}: {{ $class['subjectData']['grade']['gradeName'] }}</h5>
                    <h5>{{ __('teachers.report.subject') }}: {{ $class['subjectData']['subject']['subjectName'] }}</h5>
                </a>
            </div>
        </div>
    @endforeach
    @foreach($globalClassList as $gKey => $globalClass)
        <div class="col-lg-3 col-md-4 col-sm-6 col-12 text-center report-tile-color-loop {{ $gKey > 0 ? 'd-none' : '' }}">
            <div class="report-home-tile">
                <a href="{{ route('students.class.board.report', [base64_encode($globalClass['globalEventId']), base64_encode($globalClass['id'])]) }}">
                    <div class="tile-header-dark">
                        <div class="tile-header-icon"> {!! config('constants.icons.class-icon') !!} </div>
                        <h4 class="mt-2 mb-0">{{ $globalClass['googleClassroomName'] }}</h4>
                    </div>
                    <div class="tile-count">
                        <div class="left-count">
                            <div>
                                <p class="mb-0">{{ __('teachers.report.testCount') }}</p>
                            </div>
                            <div>
                                <h1 class="mt-0 mb-0"> {{ $globalClass['attemptedAssessmentCount'] }} / {{ $globalClass['assessmentCount'] }}</h1>
                            </div>
                        </div>

                    </div>
                    <h5>{{ __('teachers.report.board') }}: {{ $globalClass['subjectData']['board']['boardName'] }}</h5>
                    <h5>{{ __('teachers.report.grade') }}: {{ $globalClass['subjectData']['grade']['gradeName'] }}</h5>
                    <h5>&nbsp;</h5>
                </a>
            </div>
        </div>
    @endforeach
@else
    <div class="col-12">{{ __('teachers.report.noClassroomAvailable') }}</div>
@endif