@if(isset($studentList))
    @foreach($studentList as $studentHeader)
        <div class="student-icon">
            <a href="{{ route('grading.assessments.index', base64_encode($studentHeader['profile']['id'].'_'.$paperId.'_'.$studentHeader['responseId'])) }}">
                <ul>
                    <li><img src="{{ handleProfilePic($studentHeader['profile']['profilePicUrl']) }}"></li>
                    <li><div class="s-name" data-studentid="{{ $studentHeader['profile']['id'] }}" data-id="{{ $studentHeader['profile']['name'] }}">{{ $studentHeader['profile']['name'] }}</div></li>
                    <li class="s-status {{ strtolower($studentHeader['status']) }}">{{ $studentHeader['status'] }}</li>
                </ul>
            </a>
        </div>
    @endforeach
@endif