<ul>
    @if(isset($previousDue) && !empty($previousDue)) 
        @foreach($previousDue as $pd)
            <li>
                <a href="{{ route('grading.assessments.board', base64_encode($pd['assessmentId'])) }}" class="d-block text-brand">{{ $pd['assessmentName'] }}</a>
                <p class="mb-0">Due: {{ utcToDate(localTimeZone($pd['dueDateTime'])) }}</p>
            </li>
        @endforeach
    @else
        <li>
            <a href="javascript:void(0)" class="d-block"> {{ __('teachers.dashboard.noDuePrevious') }}</a>
        </li>
    @endif
</ul>
@if(isset($previousDue) && !empty($previousDue)) 
    <a href="{{ route('grading.assessments.home') }}" class="text-brand">{{ __('teachers.dashboard.viewAll') }}</a>
@endif