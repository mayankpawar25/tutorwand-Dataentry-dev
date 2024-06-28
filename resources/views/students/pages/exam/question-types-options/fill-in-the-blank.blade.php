<div class="row answer-padding">
    @php
        $question = decryptBlobData($question);
    @endphp
	@if(!empty($question['options']))
		@php $a = 1; @endphp
		@foreach($question['options'] as $option_key => $option)
            <div class="col-sm-12 mb-2" data-id="data_{{ $key+1 }}_{{ $option_key+1 }}">
                <div class="fill-ups form-inline">
                    <label class="mr-{{ $key+1 }}{{ $option_key+1 }}">{{ __('students.fib.blank') }} {{ $a }}&emsp;
                        <input type="text" class="form-control fillupAnswer" name="correctAnswer_{{ $key+1 }}_{{ $option_key+1 }}" maxlength="20">
                    </label>
                </div>
            </div>
			@php $a++; @endphp
		@endforeach
	@endif
</div>