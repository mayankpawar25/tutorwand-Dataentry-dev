@extends('students.layouts.default')
@section('title', __('students.siteTitle'))
@section('content')
<div class="modal" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: block;">
  <div class="modal-backdrop2"></div>
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body text-center">
        <div class="showMessage ">
			<h5>{{ __('students.upcomingExam.comingSoon') }}</h5>
        </div>
        <br>
        <button type="button" class="btn btn-outline-primary closeModal" data-target="close">{{ __('students.button.close') }}</button>
      </div>
    </div>
  </div>
</div>
@endsection
