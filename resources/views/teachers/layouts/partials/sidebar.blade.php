<div class="fixed-side-panel">
    <a href="{{ route('home_page') }}"><img src="{{ asset('assets/images/teachers/logo-sm.svg') }}" class="small-logo">
        <img src="{{ asset('assets/images/teachers/logo-lg.svg') }}" class="larg-logo">
    </a>

    <ul class="fixed-side-panel-ul">
        <li class="{{ request()->is('teacher') ? 'active' : '' }}">
            <a href="{{ route('teacher.dashboard') }}">
                {!! config('constants.icons.dashboard-icon') !!}
                <span>{{ __('teachers.sidebar.dashboard') }}</span>
            </a>
        </li>
        <li class="{{ request()->is('assignment') || request()->is('fastrack') || request()->is('boardPreparation') ? 'active' : '' }}">
            <a href="{{ route('assignment') }}">
                {!! config('constants.icons.assignment-icon') !!}
                <span>{{ __('teachers.sidebar.create') }}</span>
            </a>
        </li>
        <li class="{{ request()->is('grading') || request()->is('grading/*') ? 'active' : '' }}">
            <a href="{{ route('grading.assessments.home') }}">
                {!! config('constants.icons.grade-icon') !!}
                <span>{{ __('teachers.sidebar.grade') }}</span>
            </a>
        </li>
        <li  class="{{ request()->is('student/subject/report/*') || request()->is('board/report/*') || request()->is('board/student/report/*') || request()->is('assessment/report/*') || request()->is('student/report/*') || request()->is('class/list') || request()->is('class/*') ? 'active' : '' }}">
            <a href="{{ route('report.home') }}">
                {!! config('constants.icons.report-icon') !!}
                <span>{{ __('teachers.sidebar.report') }}</span>
            </a>
        </li>
        
    </ul>
    <!-- fixed-side-panel-ul end -->
    <div class="panel-footer">
        © 2021
    </div>
</div>
