@extends('students.layouts.paper')
@section('title', __('students.siteTitle'))
@section('content')
    <div class="canvas-area paper-area">
        <input type="hidden" id="isUntimed" name="isUntimed" value="{{ $questionData['header']['isUntimed'] }}">
        <input type="hidden" id="submitResponseUrl" name="submitResponseUrl" value="{{ route('students.question.response') }}">
        <input type="hidden" id="paperID" name="paperID" value="{{ $questionData['questionPaperId'] }}">
        <input type="hidden" id="studentID" name="studentID" value="{{ Session::get('profile')['userId'] }}">
        {{ csrf_field() }}
        @include('students.pages.exam.questionPaper')
        @include('students.layouts.partials.paper.rightBar')
    </div>
    <div class="canvas-area w-100 pr-0 submit-review-area" style="display:none;">
        <div class="offline-error"></div>
        <input type="hidden" name="submitReviewUrl" id="submit-review-url" value="{{ route('students.update.submit.review') }}">
        @include('students.pages.exam.submitReview')
    </div>
@endsection
