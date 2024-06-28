@if(!empty($classList))
    @foreach($classList as $class)
        <div class="col-md-3 text-center report-tile-color-loop">
            <div class="report-home-tile">
                <a href="{{ route('assessment.report4', base64_encode($class['id'])) }}">
                    <div class="tile-header-dark">
                        <div class="tile-header-icon">
                            {!! config('constants.icons.class-icon') !!}
                        </div>
                        <h4 class="mt-2 mb-0">{{ $class['googleClassroomName'] }}</h4>
                    </div>
                    <div class="tile-count">
                        <div class="left-count">
                            <div>
                                <p class="mb-0">{{ __('teachers.report.testCount') }}</p>
                            </div>
                            <div>
                                <h1 class="mt-0 mb-0">{{ $class['assessmentCount'] }}</h1>
                            </div>
                        </div>
                        <div class="right-count">
                            <div>
                                <p class="mb-0">{{ __('teachers.report.students') }}</p>
                            </div>
                            <div>
                                <h1 class="mt-0 mb-0">{{ $class['totalStudents'] }}</h1>
                            </div>
                        </div>
                    </div>
                    <h5>{{ __('teachers.report.board') }}: {{ isset($class['subjectData']['board']) ? $class['subjectData']['board']['boardName'] : '-' }}</h5>
                    <h5>{{ __('teachers.report.grade') }}: {{ isset($class['subjectData']['grade']) ? $class['subjectData']['grade']['gradeName'] : '-' }}</h5>
                    <h5>{{ __('teachers.report.subject') }}: {{ isset($class['subjectData']['subject']) ? $class['subjectData']['subject']['subjectName'] : '-' }}</h5>
                </a>
            </div>
        </div>
    @endforeach

@endif

@if(isset($globalClassList) && !empty($globalClassList))
    @foreach($globalClassList as $class)
        <div class="col-md-3 text-center report-tile-color-loop">
            <div class="report-home-tile">
                <a href="{{ route('board.index', base64_encode($class['assessmentId'])) }}">
                    <div class="tile-header-dark">
                        <div class="tile-header-icon">
                            {!! config('constants.icons.class-icon') !!}
                        </div>
                        <h4 class="mt-2 mb-0">{{ $class['googleClassroomName'] }}</h4>
                    </div>
                    <div class="tile-count">
                        <div class="left-count">
                            <div>
                                <p class="mb-0">{{ __('teachers.report.testCount') }}</p>
                            </div>
                            <div>
                                <h1 class="mt-0 mb-0">{{ $class['assessmentCount'] }}</h1>
                            </div>
                        </div>
                        <div class="right-count">
                            <div>
                                <p class="mb-0">{{ __('teachers.report.students') }}</p>
                            </div>
                            <div>
                                <h1 class="mt-0 mb-0">{{ $class['totalStudents'] }}</h1>
                            </div>
                        </div>
                    </div>
                    <h5>{{ __('teachers.report.board') }}: {{ isset($class['subjectData']['board']) ? $class['subjectData']['board']['boardName'] : '-' }}</h5>
                    <h5>{{ __('teachers.report.grade') }}: {{ isset($class['subjectData']['grade']) ? $class['subjectData']['grade']['gradeName'] : '-' }}</h5>
                    <h5>{{ __('teachers.report.subject') }}: {{ isset($class['subjectData']['subject']) ? $class['subjectData']['subject']['subjectName'] : '-' }}</h5>
                </a>
            </div>
        </div>
    @endforeach
@endif

@if(empty($globalClassList) && empty($classList))
    <div class="col-12">{{ __('teachers.report.noClassroomAvailable') }}</div>
@endif