<div class="right-panel hide-panel d-none">
    <div class="fixed-side-panel-trigger-right rotate-180"><i class="fa fa-caret-right " aria-hidden="true "></i></div>
    <div class="d-block right-panel-body ">

        <div class="feedback-box">
            <textarea class="form-control input-regular" rows="2">

            </textarea>
            <div class="text-right mt-2">
                <button class="btn btn-outline-primary mr-2 ">{{ __('teachers.button.cancel') }}</button>
                <button class="btn btn-primary">{{ __('teachers.button.save') }}</button>
            </div>
        </div>
        <hr>
        <div class="feedback-msg">
            <div class="cursor-pointer close">
				{!! config('constants.icons.remove-response') !!}
            </div>
            <p id="cloned"></p>
        </div>
        <div class="clearfix "></div>
    </div>
    <div class="clearfix "></div>
</div>
