<div class="row">
    @php
        $question = decryptBlobData($question);
    @endphp
	@if(!empty($question['options']))
		@php $a = 'A'; @endphp
		@foreach($question['options'] as $option_key => $option)
            <div class="col-sm-12 mb-2" data-id="data_{{ $key+1 }}_{{ $option_key+1 }}">
                <div class="option-list" tabindex="0">
                    <div class="option-radio">
                        <label>
                            <input type="radio" name="selectedOption[{{ $key+1 }}]" class="custom-control-input radioBox optionnumber{{ $option_key+1 }}" data-answerKey="{{ $option_key+1 }}" data-questionId="{{ $question['questionId'] }}" name="options[{{ $key+1 }}]" id="customRadio_{{ $key+1 }}_{{ $option_key+1 }}" value="{!! html_entity_decode($option['optionText']) !!}"/>
                            <span class="sr-no">{{ $a }}</span> <p>{!! html_entity_decode($option['optionText']) !!}</p>
                        </label>
                    </div>
                </div>
            </div>
			@php $a++; @endphp
		@endforeach
	@endif
</div>