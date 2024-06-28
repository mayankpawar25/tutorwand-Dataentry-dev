<script type="text/javascript">
  let myDropZone;    
  let shortTypeId         = "HH9Tu7BZ";
  let longTypeId          = "nOFiSUZ8";
  let studentID           = $("#studentID").val();
  let enterAnswerText     = `{{ __('students.enterAnswerText') }}`;
  let questionId          = $('.question-text.active').find('.q-text').data('id');
  let paperId             = `{{ isset($questionData['questionPaperId']) ? $questionData['questionPaperId'] : '' }}`;
  let examTimer           = `{{ isset($questionData['header']['testDuration']) ? $questionData['header']['testDuration'] : 5 }}`;
  let examTimerInSeconds  = examTimer*60;
  // Student Language Text
  let allQuestionText     = `{{ __('students.allQuestion') }}`;
  let unattemptedText     = `{{ __('students.unattempted') }}`;
  let attemptedText       = `{{ __('students.attempted') }}`;
  let unansweredText      = `{{ __('students.unanswered') }}`;
  let markedForReviewText = `{{ __('students.bookmarked') }}`;
  
  let max2Files5MB        = `{{ __('students.max2Files5MB') }}`;
  let max5Files5MB        = `{{ __('students.max5Files5MB') }}`;
  let errorText           = `{{ __('students.error') }}`;
  let successText         = `{{ __('students.success') }}`;
  let successTextMessage  = `{{ __('students.successTextMessage') }}`;
  let timeUpText          = `{{ __('students.notifications.timeUpText') }}`;


  let btnText             = `<i class="fa fa-plus"></i> {{ __('students.addResponse') }}`;
  let fileRemovedText     = `{{ __('students.fileRemovedText') }}`;
  let fileAddedText       = `{{ __('students.fileAddedText') }}`;
  let somethingWentWrong  = `{{ __('students.somethingWentWrong') }}`;
  let sessionDestroyText  = `{{ __('students.sessionDestroyText') }}`;

  // Language Error Text
  let checkTncError           = `{{ __('students.checkTncError') }}`;
  let fileUploadTypeError     = `{{ __('students.fileUploadTypeError') }}`;
  let fileUploadLimitError    = `{{ __('students.fileUploadLimitError') }}`;

  let uploadFailedText        = `{{ __('students.uploadFailedText') }}`;
  let answerClearText         = `{{ __('students.answerClearText') }}`;

  let attachmentSizeLimitText     = `{{ __('students.attachmentSizeLimitText') }}`;
  let attachmentFormatText        = `{{ __('students.attachmentFormatText') }}`;

  let allowedFiveAttachmentText   = `{{ __('students.notifications.allowedFiveAttachmentText') }}`;
  let allowedTwoAttachmentText    = `{{ __('students.notifications.allowedTwoAttachmentText') }}`;
  let resumeExamText              = `{{ __('students.notifications.resumeAssessmentInfoText') }}`;

  let assessmentSubmitSuccessText = `{{ __('students.assessmentSubmitSuccessText') }}`;
  let questionReportedSuccessText = `{{ __('students.questionReportedSuccessText') }}`;
  let wantToDeleteAttachmentText  = `{{ __('students.wantToDeleteAttachmentText') }}`;
  let noInternetConnectionText    = `{{ __('students.noInternetConnectionText') }}`;
  let assessmentStartInfoText     = `{{ __('students.assessmentStartInfoText') }}`;
  let assessmentProgressInfoText  = `{{ __('students.assessmentProgressInfoText') }}`;
  
  let wantToSubmitAssessmentText  = `{{ __('students.notifications.wantToSubmitAssessmentText') }}`;
  let backToOnlineText            = `{{ __('students.notifications.backToOnlineText') }}`;
  let offlineMessage              = `{{ __('students.notifications.siteOfflineSubmitAnswer') }}`;
  let successSubmitExamText       = `{{ __('students.notifications.assessmentSuccessSubmit') }}`;

  // Config file constants
  let fileIcon            = `{!! config('constants.icons.add-response') !!}`;
  let removeFileIcon      = `{!! config('constants.icons.remove-response') !!}`;
  let maxFileSizeLimit    = `{{ config('constants.maxFileUploadSize') }}`;
  let spinner             = `{!! config('constants.spinner') !!}`;
  let simpleSpinner       = `{!! config('constants.simpleSpinner') !!}`;
  let addImagePdfBtn      = `{!! config('constants.addImagePdf') !!}`;
  let zoomIcon            = `{!! config('constants.icons.enlarge-icon') !!}`;
  let zoomOutIcon         = `{!! config('constants.icons.enlarge-big-icon') !!}`;

  let timeId              = paperId + "  {{ config('constants.ownerId') }}" + " timer";
  let flagId              = paperId + "  {{ config('constants.ownerId') }}" + " flag";

  let userName            = "{{ str_replace(" ","_", getStudentName()) }}";

  // Route URL
  let uploadFileUrl       = `{{ route('students.fileupload') }}`;
  let feedBackScreenURL   = `{{ route('students.feedback.screen') }}`;
  let uploadAnswerFileUrl = `{{ route('students.fileupload') }}`;
  let removeFileUrl       = `{{ route('students.fileremove') }}`;
  let clearResponseUrl    = `{{ route('students.clearQuestion') }}`;
  let submitPaperUrl      = `{{ route('students.submit.paper') }}`;

  let submitResponseOfflineError = "{{ __('students.notifications.offlineTimeUpText') }}";
  let fiveSeconds = 5000;
  // Credit: Mateusz Rybczonec
  const FULL_DASH_ARRAY = 283;
  const ALERT_THRESHOLD = 4;

  const COLOR_CODES = {
    info: {
      color: "green"
    },
    alert: {
      color: "red",
      threshold: ALERT_THRESHOLD
    }
  };
  let sixtyMinutes = "{{ config('constants.sixtyMinutes') }}";
  let answeredData = [];
  let totalTime = 0;
  let timeLeft = 0;
</script>