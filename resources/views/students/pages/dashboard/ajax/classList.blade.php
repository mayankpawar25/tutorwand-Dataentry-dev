@if(!empty($classList))
    <ul class="classroom-listing">
        @foreach($classList as $class)
            <li>
                <div class="icon-box">
                    {!! config('constants.icons.class-icon') !!}
                </div>
                <div class="content-box">
                    <h5 class="mb-0">{{ $class['courseName'] }}</h5>
                </div>
            </li>
        @endforeach
    </ul>
@else
    <p>{{ __('students.dashboard.noClassAvail') }}</p>
@endif
