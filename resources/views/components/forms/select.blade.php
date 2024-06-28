<select name="{{ $name }}" id="{{$id}}" class="{{$class}}" {{$attributes}}>
    <option value="">{{ $label }}</option>
    @if(!empty($options))
        @foreach($options as $optKey => $option)
            <option value="{{ $optKey }}" @if($isSelected($optKey)) selected="selected" @endif>{{ $option }}</option>
        @endforeach
    @endif
</select>