<?php

namespace App\Http\Controllers\Students;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GoogleAPIController;
use App\Http\Controllers\HomeController;
use Illuminate\Http\Request;
use App\Models\Students;
use App\Models\Questions;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Hash;
class StudentController extends Controller
{
    private $timeOut = 0;
    private $longTimeOut = 0;

    /**
     * Students constructor
     */
    public function __construct () {
        $this->timeout = config('constants.CacheTimeOut');
        $this->longTimeOut = config('constants.CacheStoreTimeOut');
    }

    /**
     * Students dashboard
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request) {
        $data['questionData'] = Students::getStudent();
        Cache::put(getStudentUserId().':questionData', $data['questionData'], $this->longTimeOut);
        if ($data['questionData'] != false) {
            return view('students.pages.exam.instructions', $data);
        }
    }

    public function examInstructions(Request $request, $questionPaperId = "") {
        if(!$request->session()->has('profile')) {
            $request->session()->put('redirectURL', url()->current());
            (new GoogleAPIController)->token();
            return;
        }
        $response = [];
        Cache::put(getStudentUserId() . ':questionTemplate', $response , $this->longTimeOut);
        session()->put(getStudentUserId() . ':questionPaperId', $questionPaperId);
        $data['questionData'] = $response;
        if(!empty($data['questionData']) || $data['questionData'] == false){
            $data['questionData'] = Students::getStudent($questionPaperId, getStudentUserId());
            Cache::put($questionPaperId . ':getMyQuestionPaper', $data['questionData'], $this->longTimeOut);
            if($data['questionData'] == false || $data['questionData'] == 500) {

                $loginData = session()->get('profile');
                foreach($loginData['userRoles'] as $userData){
                    if($userData['roleId'] == 1){
                        return redirect(route('grading.assessments.home'));
                    }
                }
                // Internal Server Error
                $message = ['message' => __("students.notifications.InternalServerError")];
                return (new HomeController)->unAuthoriseStudent($message);

            } else if(isset($data['questionData']['examStatus']) && $data['questionData']['examStatus'] == config('constants.unauthorized')) {
                $loginData = session()->get('profile');
                foreach($loginData['userRoles'] as $userData){
                    if($userData['roleId'] == 1){
                        return redirect(route('grading.assessments.home'));
                    }
                }
                // UnAuthorized Exam
                $message = ['message' => __("students.notifications.unauthorizeExamText")];
                return (new HomeController)->unAuthoriseStudent($message);

            } else if(isset($data['questionData']['examStatus']) && ($data['questionData']['examStatus'] == config('constants.submitted') || $data['questionData']['examStatus'] == config('constants.timeOver'))){
                // Submitted Exam
                $message = ['message' => __("students.notifications.alreadySubmittedText")];
                return (new HomeController)->unAuthoriseStudent($message);

            } else if(isset($data['questionData']['examStatus']) && ($data['questionData']['examStatus'] == config('constants.expired') || $data['questionData']['examStatus'] == config('constants.absent'))){
                // Expired Exam
                $message = ['message' => sprintf(__("students.notifications.examExpiredText"), date("d F Y h:i A", strtotime($data['questionData']['header']['dueByDateTime'])))];
                return (new HomeController)->unAuthoriseStudent($message);

            } else  if(isset($data['questionData']['examStatus']) && $data['questionData']['examStatus'] == config('constants.upComing')){
                // Upcoming Exam
                $message = ['message' => sprintf(__("students.notifications.upcomingExamText"), date("d F Y h:i A", strtotime($data['questionData']['header']['startDateTime'])))];
                return (new HomeController)->unAuthoriseStudent($message);

            } else {
                Cache::put(getStudentUserId().':questionData', $data['questionData'], $this->longTimeOut);
            }
        }
        return response()->view('students.pages.exam.instructions', $data);
    }

    public function examPaper(Request $request, $questionPaperId = "") {
        if($request->server('HTTP_REFERER') != null) {
            $studentId = getStudentUserId();
            $questionPaperId = session()->get(getStudentUserId() . ':questionPaperId');
            $data = Students::getStudentsFastTrackConfig();
            // Cache Question paper
            $data['questionData'] = Cache::get(getStudentUserId().':questionData');
            if(!empty($data['questionData'])) {
                // Submitted Exam Page
                if(isset($data['questionData']['examStatus']) && $data['questionData']['examStatus'] == 'Submitted') {
                    $message = ['message' => __("students.notifications.alreadySubmittedText")];
                    return (new HomeController)->unAuthoriseStudent($message);
                }
            }
            
            // If not have question paper fetched
            if(empty($data['questionData'])) {
                $data['questionData'] = Students::getStudent($questionPaperId, $studentId);
                Cache::put(getStudentUserId().':questionData', $data['questionData'], $this->longTimeOut);
            }
            return view('students.pages.exam.paper', $data);
        }
        return abort(404);
    }

    public function updateReviewQuestions(Request $request){
        if(!empty($request->answersArray)){
            $answered = [];
            $unAnswered = [];
            $markReview = [];
            $unattempted = [];
            foreach($request->answersArray as $answer){
                if (stripos(strtolower($answer['className']), 'answered') !== false || $answer['className'] == 'answered') {
                    $answered[] = $answer;
                }
            }
            foreach($request->answersArray as $answer){
                if(stripos(strtolower($answer['className']), 'unattempted') !== false || $answer['className'] == 'unattempted'){
                    $unattempted[] = $answer;
                }
            }
            foreach($request->answersArray as $answer){
                if($answer['className'] == 'mark-review' || stripos(strtolower($answer['className']), 'mark-review') !== false){
                    $markReview[] = $answer;
                }
            }
            $data['questionData']   = Cache::get(getStudentUserId().':questionData');
            $data['notAttempt'] = $unattempted;
            $data['answered']   = $answered;
            $data['markReview'] = $markReview;
            $data['timeLeft']   = $request->timeLeft;
            session()->put('answerData' , $data);
            $html = view('students.pages.exam.ajax.submitReview', $data)->render();
            return response()->json([ "html" => $html]);
        }
    }

    public function showSubmitPreview(Request $request){
        $data = session()->get('answerData');
        return view('students.pages.exam.submitReview')->with($data);
    }

    public function feedbackScreen(Request $request){
        $data = [];
        $data['removeTimer'] = true;
        $questionData = Cache::get(getStudentUserId().':questionData');
        $data['questionData'] = $questionData;
        return view('students.pages.exam.feedbackScreen', $data);
    }

    public function fileupload(Request $request) {
        $response = "";
        if($request->hasFile('files')) {
            $data = [];
            $response = Students::uploadGlobalFile($request->file('files'), $request->paperId, $request->studentId, $request->global, $request->questionId);
            if($response){
                return response()->json(['status' => true, 'data' => $response]);
            }
        }

        if($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = time().rand(1111111,99999999).".png";
            $urlRoute = 'upload.image.ckeditor';
            $filePath = $file->path();
            $fileData = fopen($filePath, 'r');
            $response = uploadCkeditorImage($urlRoute,$fileData, $fileName);
            return response()->json($response->json());
        }

        return response()->json(["status" => false, 'data' => $response]);
    }

    public function fileRemove(Request $request) {
        if(isset($request->url) && !empty($request->url)) {
            $postData = [];
            $postData['studentId']  = $request->studentID;
            $postData['paperId']    = $request->paperId;
            if($request->questionId) {
                $postData['questionId'] = $request->questionId;
            }
            if($request->questionId == "") {
              $postData['isGlobalUpload'] = true;
            } else {
              $postData['isGlobalUpload'] = false;
            }
            $postData['file']['fileName'] = $request->name;
            $postData['file']['fileUrl'] = $request->url;
            $response = Students::removeFile($postData);
            if(isset($response['Message'])) {
                $data = ['status' => false , 'data' => $response['Message']];
            } else {
                $data = ['status' => true, 'data' => $response];
            }
            return response()->json($data);
        }
    }

    public function reportQuestion(Request $request) {
        return response()->json(["status" => true, "data" => true]);
    }

    public function questionResponse(Request $request){
        $body = $request->post;
        $contentType = "application/json-patch+json";
        $responseType = "json";
        if($request->status == "true"){
            $urlRoute = 'submit.question.response';
            $responseReturn = postCurl($contentType, $urlRoute, $body, $responseType);
        } else {
            $urlRoute = "update.question.response";
            $responseReturn = patchCurl($contentType, $urlRoute, $body, $responseType);
        }
        if($responseReturn == true) {
            return response()->json(['status' => $responseReturn , 'msg' => 'response updated']);
        } else {
            return response()->json(['status' => false , 'msg' => __('students.somethingWentWrong')]);
        }
    }

    public function clearQuestion(Request $request) {
        $data['studentId'] = getStudentUserId();
        $data['paperId'] = $request['paperId'];
        $data['questionId'] = $request['questionId'];
        $requestData = Students::clearExamQuestion($data);
    }

    public function submitExam(Request $request){
        $data = [];
        $data['studentId'] = $request['studentId'];
        $data['paperId'] = $request['paperId'];
        $data['responseId'] = $request['responseId'];
        $urlRoute = 'submit.exam';
        $responseReturn = putCurl($urlRoute, $data, 'body');
        if($responseReturn){
            return response()->json(['status' => true]);
        }
        return response()->json(['status' => false]);
    }

    public function resumeExam(Request $request) {
        $resp = getCurl('resume.exam', 'json', ['studentId' => getStudentUserId(), 'paperId' => $request['paperId']]);
        if($resp) {
            Cache::put($request['paperId'] . ':resume', $resp, config('constants.CacheStoreTimeOut'));
            return response()->json(['status' =>true, 'data' => $resp]);
        } else {
            return response()->json(['status' =>false, 'data' =>'' ]);
        }
    }

    public function updateTimer(Request $request) {
        $url = 'updatetimer';
        $contentType = "application/json-patch+json";
        $responseType = "body";
        $param = "studentId=config(constants.ownerId)&paperId=".$request['paperId']."&questionId=".$request['remainingTime'];
        $body = '';
        $resp = patchCurl($contentType, $url, $body, $responseType = 'body', $param);
        return $resp;
    }
}