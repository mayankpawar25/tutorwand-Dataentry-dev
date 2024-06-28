<ul>
    @if(isset($todayDue) && !empty($todayDue)) 
        @foreach($todayDue as $td)
            <li>
                <a href="{{ route('grading.assessments.board', base64_encode($td['assessmentId'])) }}" class="d-block text-brand">{{ $td['assessmentName'] }}</a>
                <p class="mb-0">{{ __('teachers.dashboard.due') }}: {{ date('h:i A', strtotime(localTimeZone($td['dueDateTime']))) }}</p>
            </li>
        @endforeach
    @else
        <li>
            <a href="javascript:void(0)" class="d-block"> {{ __('teachers.dashboard.noTodayDue') }}</a>
        </li>
    @endif
</ul>
@if(isset($todayDue) && !empty($todayDue)) 
    <a href="{{ route('grading.assessments.home') }}" class="text-brand">{{ __('teachers.dashboard.viewAll') }}</a>
@endif