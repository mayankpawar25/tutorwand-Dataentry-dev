@if (!empty($datas) && count($datas) > 0)
    <select class="selectOptGroup d-none  onchangeValue get_curl_data" data-label="Select Topic" multiple name="{{ $name }}">
            @foreach ($datas as $key => $topic)
                    @if (isset($topic['topics']) && !empty($topic['topics']))
                        <optgroup data-type="topic" data-value="{{ $topic['id'] }}"  label="{{ $topic['name'] }}">
                            @foreach ($topic['topics'] as $key => $subTopic)
                                <option data-type="subtopic" data-value={{ $subTopic['topicId'] }} value="{{ $subTopic['topicId'] }}">{{ $subTopic['topicName'] }}</option>
                            @endforeach
                        </optgroup>
                    @else
                        <option data-type="topic" data-value="{{ $topic['id'] }}" value="{{ $topic['id'] }}">{{ $topic['name'] }}</option>
                    @endif
            @endforeach
    </select>
@else
    <select class="form-control selectpicker onchangeValue get_curl_data" data-label="Select Topic" name="{{ $name }}">
        <option value="">{{ __('questionLayout.noRecord') }}</option>
    </select>
@endif
