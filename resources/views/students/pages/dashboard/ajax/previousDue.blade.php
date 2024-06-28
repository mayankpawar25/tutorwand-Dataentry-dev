<ul>
    @if(isset($result) && !empty($result))
        @foreach($result as $resultData)
            <li>
                <a href="{{ route('students.assessment.report', base64_encode($resultData['id'].'_'.$resultData['classRoomId'])) }}" class="d-block text-brand">{{ $resultData['assessmentName'] }}</a>
                <p class="mb-0">{{ utcToDate(localTimeZone($resultData['resultPublishedOn'])) }}</p>
            </li>
        @endforeach
        @else
            <li>
                <a href="javascript:void(0)" class="d-block"> {{ __('students.dashboard.noTodayDue') }}</a>
            </li>
        @endif
</ul>
@if(isset($result) && !empty($result))
    <a href="{{ route('students.report.home') }}" class="text-brand">{{__('students.dashboard.viewAll')}}</a>
@endif