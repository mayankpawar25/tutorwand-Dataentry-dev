<ul class="classroom-listing">
        <li>
            <a href="{{ route('class.create') }}" class="text-brand">
                <div class="icon-box">
                    {!! config('constants.icons.plus-icon') !!}
                </div>
                <div class="content-box">
                    <h4 class="mt-2">{{ __('teachers.class.createClass') }}</h4>
                </div>
            </a> 
        </li>
    @foreach($classList as $class)
        @if(isset($class['students']))
            @if($class['status'] == "ACTIVE")
                <li>
                    <a href="{{ route('class.show', $class['courseId']) }}" target="_blank">
                        <div class="icon-box  {{ $class['courseId'] }}">
                            {!! config('constants.icons.class-icon') !!}
                        </div>
                        <div class="content-box">
                            <h5 class="mb-0 ">{{ $class['googleClassroomName'] }}</h5>
                            <p class="mb-0 ">{{ __('teachers.dashboard.students') }}: {{ $class['totalStudents'] }}</p>
                           
                        </div>
                    </a>
                </li>
            @else
                <li>
                    <div class="icon-box opacity-30 {{ $class['courseId'] }}">
                        {!! config('constants.icons.class-icon') !!}
                    </div>
                    <div class="content-box">
                        <h5 class="mb-0 opacity-30 ">{{ $class['googleClassroomName'] }}</h5>
                        <p class="mb-0 opacity-30">{{ __('teachers.dashboard.students') }}: {{ $class['totalStudents'] }}</p>
                        <a href="{{ route('class.show', $class['courseId']) }}" target="_blank" class="mb-0 text-brand">Activate</a>
                    </div>
                </li>
            @endif
        @endif
    @endforeach
</ul>