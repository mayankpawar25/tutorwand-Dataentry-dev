<div class="cloneData d-none">
    <div class="row ">
        <div class="col-sm-6">
            <input type="text" name="student_name" class="form-control input-regular" placeholder="{{ __('teachers.class.enterStudentName') }}">
        </div>
        <div class="col-sm-6">
            <div class="d-flex">
                <input type="text" name="student_email" class="form-control input-regular mr-2" placeholder="{{ __('teachers.class.enterStudentEmail') }}">
                <button class="btn removeMe btn-outline-primary btn-auto  btn-remove  ml-3">
                    {!! config('constants.icons.class-close-icon') !!}
                </button>
            </div>
        </div>
    </div>
</div>