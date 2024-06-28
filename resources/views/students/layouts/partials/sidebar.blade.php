<div class="fixed-side-panel">
    <a href="{{ route('home_page') }}" class="d-none d-lg-block d-md-block">
        <img src="{{ asset('assets/images/students/logo-sm.svg')}}" class="small-logo">
        <img src="{{ asset('assets/images/students/logo-lg.svg')}}" class="larg-logo">
    </a>
    <ul class="fixed-side-panel-ul">
        <li class="{{ request()->is('students') ? 'active' : '' }}">
            <a href="{{ route('students.dashboard') }}">
                {!! config('constants.icons.student-menu-dashboard-svg') !!}<span>{{ __('students.dashboard.dashboard') }}</span>
            </a>
        </li>
        <li class="{{ request()->is('students/assessment') || request()->is('students/instructions/*') ? 'active' : '' }}">
            <a href="{{ route('students.assessment') }}">
                {!! config('constants.icons.student-menu-assessment-svg') !!}<span>{{ __('students.assessment') }}</span>
            </a>
        </li>
        <li  class="{{ request()->is('students/report') || request()->is('students/class/report/*') || request()->is('students/class/report/*') || request()->is('students/assessment/result/*') ? 'active' : '' }}">
            <a href="{{ route('students.report.home') }}">
                {!! config('constants.icons.student-menu-report-svg') !!}<span>{{ __('students.report') }}</span>
            </a>
        </li>
    </ul>
    <div class="panel-footer">
        &copy; 2021
    </div>
</div>
