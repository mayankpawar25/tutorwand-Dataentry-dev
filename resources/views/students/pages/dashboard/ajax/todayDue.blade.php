<ul>
    @if(isset($todayDue) && !empty($todayDue)) 
        @foreach($todayDue as $assessment)
            <li>
                <a href="{{ route('students.instructions', $assessment['id']) }}" class="d-block text-brand">{{ $assessment['assessmentName'] }}</a>
                <p class="mb-0">{{ __('students.assessments.dueLabel') }}: {{ date('h:i A', strtotime(localTimeZone($assessment['header']['dueByDateTime']))) }}</p>
            </li>
        @endforeach
    @else
        <li>
            <a href="javascript:void(0)" class="d-block"> {{ __('students.dashboard.noTodayDue') }}</a>
        </li>
    @endif
</ul>
@if(isset($todayDue) && !empty($todayDue)) 
    <a href="{{ route('students.assessment') }}" class="text-brand">{{__('students.dashboard.viewAll')}}</a>
@endif