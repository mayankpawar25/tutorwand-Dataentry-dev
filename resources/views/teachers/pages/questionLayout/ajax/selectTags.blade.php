<select class="form-control selectpicker onchangeValue get_curl_data" name="{{ $name }}" data-get="{{ $next_route }}">
    @if (!empty($datas) && count($datas) > 0)
    <option value="">{{ $label }}</option>
    @foreach ($datas as $value)
        <option value="{{ $value['id'] }}">{{ $value['name'] }}</option>
    @endforeach
    @else
        <option value="">{{ __('questionLayout.noRecord') }}</option>
    @endif
</select>
