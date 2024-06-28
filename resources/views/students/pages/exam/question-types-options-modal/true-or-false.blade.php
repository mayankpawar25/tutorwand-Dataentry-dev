<div class="row">
	@if(!empty($question['options']))
		@php $a = 'A'; @endphp
		@foreach($question['options'] as $option_key => $option)
            <div class="col-sm-12 mb-2" data-id="data_{{ $key+1 }}_{{ $option_key+1 }}">
                <div class="option-list">
                    <div class="option-radio">
                        <label>
                                <span class="sr-no">{{ $a }}</span> <p>{!! html_entity_decode($option['optionText']) !!}</p>
                        </label>
                        
                    </div>
                </div>
            </div>
			@php $a++; @endphp
		@endforeach
	@endif
</div>