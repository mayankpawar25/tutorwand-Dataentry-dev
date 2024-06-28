<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Questions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Session;
use PDF;
use Google_Service_Classroom;

class ReviewQuestionController extends Controller
{
    private $timeOut = 0;
    private $longTimeOut = 0;

    public function __construct () {
        $this->timeout = config('constants.CacheTimeOut');
        $this->longTimeOut = config('constants.CacheStoreTimeOut');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $requestData = Questions::createGetQuestionsBody($request);
        $urlRoute = 'post.questions';
        $contentType = "application/json-patch+json";
        $responseType = "body";
        if($request['newPaper'] == 'false' && Cache::has(getStudentUserId() . ':canvasData') && Cache::get(getStudentUserId() . ':canvasData') != null) {
            $data['issueTypes'] = Cache::get(getStudentUserId() . ':questionIssueTypes');
            $data['canvasData'] = Cache::get(getStudentUserId() . ':canvasData');
            return view('teachers.pages.questionReview.index', $data);
        } else {
            Cache::forget(getStudentUserId() . ':canvasData');
            if($request->session()->has(getStudentUserId().':paperId')) {
                $requestData['paperId'] = $request->session()->get(getStudentUserId().':paperId');
            }
            $body = json_encode($requestData);
            $response = postCurlWithoutJson($contentType, $urlRoute, $body, $responseType = 'json');
            if($response->successful()){
                Cache::put(getStudentUserId() . ':canvasData', $response->json(), $this->longTimeOut);
                $data['issueTypes'] = Cache::get(getStudentUserId() . ':questionIssueTypes');
                $data['canvasData'] = Cache::get(getStudentUserId() . ':canvasData');
                $request->session()->put(getStudentUserId().':paperId', $data['canvasData']['questionPaperId']);
                return view('teachers.pages.questionReview.index', $data);
            } else {
                if( $response->status() == 400) {
                    return view('teachers.pages.questionReview.ajax.insufficientQuestion', ['error' => $response->json()]);
                }
                if( $response->status() == 419) {
                    return view('teachers.pages.questionReview.ajax.insufficientQuestion', ['error' => $response->json(), 'type' => 419]);
                }

                if(config('app.debug') == true) {
                    $data['message'] = $th->getMessage();
                    $data['code'] = $th->getCode();
                    $data['file'] = $th->getFile();
                    $data['line'] = $th->getLine();
                    $data['requestData'] = json_encode(Questions::createGetQuestionsBody($request));
                    return view('errors.ajax.' . $response->status(), ['error' => $data]);
                }
            }
        }
    }

    /**
     * @Method to show Question Review Right Panel
     */
    public function schedule(Request $request) {
        $data = [];
        $data['pointEventNone'] = isset($request['pointEventNone']) ? $request['pointEventNone'] : '';
		if(Cache::has(getStudentUserId() . ':dashboardClassList')){
            $data['studentGroups'] = Cache::get(getStudentUserId() . ':dashboardClassList');
        } else {
            $data['studentGroups'] = Questions::assigneeList($isTeacher = "true");
        }
        if(isset($request->templateId) && $request->templateId != null){
            $format = getFormatStructure($request->templateId);
            $data['restrictResult'] = false;
            $allowedUntimed = [config("constants.longQuesId"), config("constants.shortQuesId")];
            foreach ($format['questionFormats'] as $key => $questionFormat) {
                if(in_array($questionFormat['questionTypeId'], $allowedUntimed)) {
                    $data['restrictResult'] = true;
                    break;
                }
            }
        } else {
            $data['restrictResult'] = ($request->restrictresult == 'false') ? false : true;
        }
        return view('teachers.pages.questionReview.schedule', $data);
    }

    public function questionSwap(Request $request) {
        if( isset($request['id']) && ! empty($request['id']) && isset($request['paperId']) && ! empty($request['paperId'])) {
            $requestData['questionPaperId'] = $request->paperId;
            $requestData['questionId'] = $request->id;
            $urlRoute = 'get.swap.question';
            $response = getCurl($urlRoute, $responseType = 'json', $requestData);
            if(is_array($response)) {
                $updData = Cache::get(getStudentUserId() . ':canvasData');
                $index = $request->questionNumber;
                $data['question'] = decryptBlobData($response);
                $data['questionNumber'] = $request['questionNumber'];
                $data['id'] = $request['id'];
                $data['paperId'] = $request['paperId'];
                $data['weightage'] = $request['weightage'];
                $updData['questions'][$index - 1] = decryptBlobData($response);
                Cache::put(getStudentUserId() . ':canvasData', $updData, $this->longTimeOut);
                return view('teachers.pages.questionReview.ajax.question', $data);
            } else {
                return "";
            }
        }
    }

    public function questionModal(Request $request) {
        $data['canvasData'] = Cache::get(getStudentUserId() . ':canvasData');
        $data['questionFilters'] = Questions::getQuestionFilters();
        return view('teachers.pages.questionReview.ajax.questionModal', $data);
    }

    public function getQuestions(Request $request) {
        $data['canvasData'] = Cache::get(getStudentUserId() . ':canvasData');
        return view('teachers.pages.questionReview.index', $data);        
    }

    public function swapModalQuestion(Request $request){
        $requestData = [];
        $indexId = $request['indexKey'];
        $urlRoute = 'get.swap.question';
        $requestData['questionPaperId'] = $request['paperId'];
        $requestData['questionId'] = $request['id'];
        $response = getCurl($urlRoute, 'json', $requestData);
        $updData = Cache::get(getStudentUserId() . ':canvasData');
        $updData['questions'][$indexId] = $response;
        if(is_array($response)) {
            Cache::put(getStudentUserId() . ':canvasData', $updData, $this->longTimeOut);
            $data = [];
            $data['question'] = decryptBlobData($response);
            $data['questionNumber'] = $request['questionNumber'];
            $data['questionid'] = $request['id'];
            $data['paperId'] = $request['paperId'];
            $data['dataId'] = $request['dataId'];
            $data['indexId'] = $indexId;
            $html_view_1 = false;
            $html_view_2 = false;
            if(is_array($response)) {
                $html_view_1 = view('teachers.pages.questionReview.ajax.question', $data)->render();
                $html_view_2 = view('teachers.pages.questionReview.ajax.question-swap', $data)->render();
            }
            $json_response = [ 'question_view' => $html_view_1, 'modal_view' => $html_view_2 ];
            return response()->json($json_response)->header('Content-Type', 'application/json');
        } else {
            $json_response = [ 'question_view' => "", 'modal_view' => "" ];
            return response()->json($json_response)->header('Content-Type', 'application/json');
        }
    }

    public function reportQuestion(Request $request) {
        $data['userId'] = getStudentUserId();
        $data['questionId'] = $request['id'];
        $data['issueId'] = json_decode($request['issueIds'], true);
        $issueTexts = json_decode($request['issueTexts'], true);
        $data['feedbacks'] = [];
        if(!empty($data['issueId'])) {
            foreach($data['issueId'] as $issueKey => $issueId) {
                $data['feedbacks'][$issueId] = $issueTexts[$issueKey];
            }
        }
        $requestData = Questions::reportQuestionRequest($data);
        $contentType = "application/json-patch+json";
        $urlRoute = 'post.report.question';
        $responseType = "json";
        $response = postCurl($contentType, $urlRoute, $requestData, $responseType);
        
        if ($response) {
            return $response;
        } else {
            return "error";
        }
    }

    public function downloadPDF(Request $request, $paperId) {
        $questionData = Questions::getQuestionPaper($paperId);
        $data['paperUrl'] = $questionData['questionPaperFileUrl'];
        return view('teachers.pages.questionReview.ajax.viewPDF', $data);
    }

    public function downloadPDF1(Request $request) {
        $data['canvasData'] = Cache::get(getStudentUserId() . ':canvasData');
        $data['postData'] = session()->get("postData");
        $pdf = PDF::loadView('teachers.pages.questionReview.ajax.downloadPDF', $data);
        $questionPaperName = isset($data['canvasData']['questionPaperName']) ? $data['canvasData']['questionPaperName'] : time();
        return $pdf->stream($questionPaperName . '.pdf');
    }
    
    public function downloadPDFHtml(Request $request) {
        $data['canvasData'] = Cache::get(getStudentUserId() . ':canvasData');
        $data['postData'] = session()->get("postData");
        return view('teachers.pages.questionReview.ajax.downloadPDF', $data);
    }
}
