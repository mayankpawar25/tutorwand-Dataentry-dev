<ul class="stepper">
    @foreach ($stepperData as $key => $step)
        @if ($step["class"] == "active")
            @if (count($stepperData) != $key+1)
                <li><a class="{{ $step['class'] }}" data-toggle="{{ $step['data-toggle'] }}" href="{{ $step['href'] }}" >{{ $step['label'] }}</a><span></span></li>
            @else
                <li><a class="{{ $step['class'] }}" data-toggle="{{ $step['data-toggle'] }}" href="{{ $step['href'] }}" >{{ $step['label'] }}</a></li>
            @endif
        @else
            <li class="disabled"><a class="{{ $step['class'] }}" href="{{ $step['href'] }}">{{ $step['label'] }}</a> </li>
        @endif
    @endforeach
</ul>


{{--<ul class="nav nav-tabs step-anchor">
    @foreach ($stepperData as $key => $step)
        @if ($step["class"] == "active")
            @if (count($stepperData) != $key+1)
            <li class="nav-item active"><a class="nav-link {{ $step['class'] }}" data-toggle="{{ $step['data-toggle'] }}" href="{{ $step['href'] }}" >{{ $step['label'] }}</a><span></span></li>
            @else
            <li class="nav-item done"><a class="nav-link {{ $step['class'] }}" data-toggle="{{ $step['data-toggle'] }}" href="{{ $step['href'] }}" >{{ $step['label'] }}</a></li>
            @endif
        @else
        <li class="nav-item done"><a class="nav-link {{ $step['class'] }}" href="{{ $step['href'] }}">{{ $step['label'] }}</a> </li>
        @endif
    @endforeach
</ul>--}}

