{{-- Long-Short Answer with Solution  --}}
@if (isset($response['solution']['answer']) && !empty($response['solution']['answer']))
    <div class="long-short-ans-outer">
        <p class="mb-0"><strong>{{ __('grading.studentAnswer') }}:</strong></p>
        <div class="long-short-ans-inner">{!! removeSpace($response['answer']['answer']) !!}</div>
        <div class="accordion" id="smaple-ans">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <span class="accordion-toggle collapsed" data-toggle="collapse" data-parent="smaple-ans" href="#sample{{ $responseKey }}">
            <strong class="cursor-pointer">{{ __('grading.sampleAnswer') }}</strong>
            </span>
                </div>
                <div id="sample{{ $responseKey }}" class="accordion-body collapse">
                    <div class="accordion-inner">{!! removeSpace($response['solution']['answer']) !!}</div>
                </div>
            </div>
        </div>

        @if (isset($response['files']) && !empty($response['files']))
            <div class="clearfix"></div>
            <div class="w-100"><hr></div>
            <p><strong>{{ __('grading.attachments') }}</strong></p>
            <ul class="uploaded-doc mb-0">
                @foreach ($response['files'] as $file)
                    <li>
                        <a href="javascript:void(0)" data-href="{{ $file['fileUrl'] }}" data-filename="{{ $file['fileName'] }}" class="viewFile">
                            <div>{!! config('constants.icons.add-response') !!}</div>
                            <div style="color: var(--dark);">{{ $file['fileName'] }}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endif
