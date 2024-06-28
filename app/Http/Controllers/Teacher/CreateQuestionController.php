<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Controllers\GoogleAPIController;
use App\Models\Questions;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use PDF;
use URL;

class CreateQuestionController extends Controller
{

    private $timeOut = 0;
    private $longTimeOut = 0;

    public function __construct () {
        $this->timeout = config('constants.CacheTimeOut');
        $this->longTimeOut = config('constants.CacheStoreTimeOut');
    }

    /**
     * @Method for Home Page
     */
    public function index(Request $request) {
        $data = [];
        if (! $request->session()->has('profile')) {
            (new GoogleAPIController)->token();
            return;
        }
        if (! Cache::get(getStudentUserId() . ':questionTemplate') || Cache::get(getStudentUserId() . ':questionTemplate') == null) {
            Cache::put(getStudentUserId() . ':questionTemplate', Questions::getTeachersFastTrackConfig(), $this->longTimeOut);
        }
        $data['questionLayout'] = Cache::get(getStudentUserId() . ':questionTemplate'); 
        $dropDownData = Cache::get(getStudentUserId() . ':syllabus');
        Cache::put(getStudentUserId() . ':dropDownFilterData', $dropDownData, $this->longTimeOut);
        
        $session = $request->session()->get('saved_right_panel_data');
        if(! empty($session)) {
            $data['questionLayout']['lastUsedTemplate'] = $session['selectedTemplateId'];
            $data['questionLayout']['lastUsedTemplateType'] = $session['selectedTemplateType'];
            $data['session'] = $session;
        } else {
            $templateData = getCurl('get.my.templates', 'json', ["userId" => getStudentUserId() ]);
            $data['questionLayout']['lastUsedTemplateType'] = $request->session()->get('profile')['settings']['assignmentFormatIdToSelect'];
            if(Cache::has(getStudentUserId() . ':savedRightPanelData') && Cache::get(getStudentUserId() . ':savedRightPanelData') != null) {
                $data['session'] = Cache::get(getStudentUserId() . ':savedRightPanelData');
            } else {
                $data['session'] = $request->session()->get('profile')['settings'];
            }
        }

        if( ! empty($data['session']['selectBoard']) ) {
            $session['selectBoard'] = $data['session']['selectBoard'];
            $session['selectGrade'] = $data['session']['selectGrade'];
            $session['selectSubject'] = $data['session']['selectSubject'];
        } else if( empty($session) ) {
            $session['selectBoard'] = [];
            $session['selectGrade'] = [];
            $session['selectSubject'] = [];
        }

        $data['questionLayout']['rightPanelData']['Board'] = createBoardStructure($dropDownData);
        Cache::put(getStudentUserId() . ':select_board', $data['questionLayout']['rightPanelData']['Board'], $this->longTimeOut);
        
        $data['questionLayout']['rightPanelData']['Grade'] = getGrades($session['selectBoard']);
        Cache::put(getStudentUserId() . ':select_grade', $data['questionLayout']['rightPanelData']['Grade'], $this->longTimeOut);

        $data['questionLayout']['rightPanelData']['Subject'] = getSubject($session['selectBoard'], $session['selectGrade']);
        Cache::put(getStudentUserId() . ':select_subject', $data['questionLayout']['rightPanelData']['Subject'], $this->longTimeOut);
        
        $data['questionLayout']['rightPanelData']['Topic'] = getTopics($session['selectBoard'], $session['selectGrade'], $session['selectSubject']);
        Cache::put(getStudentUserId() . ':select_topic', $data['questionLayout']['rightPanelData']['Topic'], $this->longTimeOut);

        $data['questionLayout']['savedRightPanelData'] = [];
        if ( Cache::get(getStudentUserId() . ':savedRightPanelData') || Cache::get(getStudentUserId() . ':savedRightPanelData') != null ) {
            $savedRightPanelData = Cache::get(getStudentUserId() . ':savedRightPanelData');
            $data['questionLayout']['savedRightPanelData'] = Cache::get(getStudentUserId() . ':savedRightPanelData');
            $data['selectedTemplateId'] = $savedRightPanelData['selectedTemplateId'];
        }

        $data['stepperArr'] = json_encode([
            ["class"=> "active",
                "data-toggle"=> "tab",
                "href"=> "javascript:void(0)",
                "label"=> "Set paper",
            ],
            [
                "class"=> "disabled reviewTabDisabled",
                "data-toggle"=> "tab",
                "href"=> "javascript:void(0)",
                "label"=> "Review paper",
            ],
        ]);

        $data['questionLayout']['rightPanelData'] = Cache::get(getStudentUserId() . ':tagsData');
        $data['questionLayout']['rightPanelData']['forFilter'] = Cache::get(getStudentUserId() . ':forFilter');
        $data['questionLayout']['rightPanelData']['Board'] = Cache::get(getStudentUserId() . ':select_board');
        $data['questionLayout']['rightPanelData']['Grade'] = (Cache::get(getStudentUserId() . ':select_grade') != null) ? Cache::get(getStudentUserId() . ':select_grade') : [];
        $data['questionLayout']['rightPanelData']['Subject'] = (Cache::get(getStudentUserId() . ':select_subject') != null) ? Cache::get(getStudentUserId() . ':select_subject') : [];
        $data['questionLayout']['rightPanelData']['Topic'] = (Cache::get(getStudentUserId() . ':select_topic') != null) ? Cache::get(getStudentUserId() . ':select_topic') : [];
        $data['questionLayout']['rightPanelData']['isPrevious'] = false;
        $questionDifficulties = [];
        foreach (Cache::get(getStudentUserId() . ':questionDifficulties') as $key => $value) {
            array_push($questionDifficulties, $value['value']);
        }
        $data['questionLayout']['rightPanelData']['questionDifficulties'] = $questionDifficulties;
        return view('teachers.pages.questionLayout.index', $data);
    }

    /**
     * @Method to save Right Panel Data in Cache
     */
    public function saveGeneralData(Request $request){
        Cache::put(getStudentUserId() . ':savedRightPanelData', $request->all(), $this->timeout);
        Session::put('saved_right_panel_data', $request->all());
        echo json_encode(Cache::get(getStudentUserId() . ':savedRightPanelData'));
    }

    /**
     * @Method to create Filter Data
     */
    public function getCurlData(Request $request){
        $multi = false;
        $label = "";
        $next_route = "";
        $forFilter = [];
        if (Cache::has(getStudentUserId() . ':forFilter') || Cache::get(getStudentUserId() . ':forFilter') != null) {
            $board = Cache::get(getStudentUserId() . ':forFilter');
        } else {
            $dropDownData = Cache::get(getStudentUserId() . ':syllabus');
            $board  = createBoardStructure($dropDownData);
            Cache::put(getStudentUserId() . ':forFilter', $board, $this->longTimeOut);
        }
        $board = Cache::get(getStudentUserId() . ':forFilter');

        switch ( $request->route_name ) {
            // Fetch Grades
            case 'select_grade':
                $response = getGrades($request->boardName);
                $label =  __('questionLayout.selectGrade');
                $next_route = 'select_subject';
                Cache::put(getStudentUserId() . ':select_grade', $response, $this->longTimeOut);
            break;

            // Fetch Subject
            case 'select_subject':
                $response = getSubject($request->boardName, $request->gradeName);
                $label =  __('questionLayout.selectSubject');
                $next_route = 'select_topic';
                Cache::put(getStudentUserId() . ':select_subject', $response, $this->longTimeOut);
            break;
            case 'select_topic':
                $response = getTopics($request->boardName, $request->gradeName, $request->subjectName);
                $label =  __('questionLayout.selectTopic');
                $next_route = '';
                $multi = true;
                Cache::put(getStudentUserId() . ':select_topic', $response, $this->longTimeOut);
            break;
            
            default:
                # code...
            break;
        }

        if($multi){
            return view('teachers.pages.questionLayout.ajax.selectMultiTags', ['datas' => $response, 'label' => $label, 'name' => $request->route_name, 'next_route' => $next_route, 'datajson' => $forFilter]);
        }
        return view('teachers.pages.questionLayout.ajax.selectTags', ['datas' => $response, 'label' => $label, 'name' => $request->route_name, 'next_route' => $next_route , 'datajson' => $forFilter]);
    }

    /**
     * @Method to save My Template data
     */
    public function saveTemplateData(Request $request) {
        $questionData = Questions::setQuestionTemplate($request->all());
        if($questionData == false){
            return "false";
        }
        $data['selectedTemplateId'] = $questionData['id'];
        Cache::put(getStudentUserId() . ':savedRightPanelData', $data, $seconds = 600);
        return $data['selectedTemplateId'];
    }

    /**
     * @Method to update My Template data
     */
    public function updateTemplateData(Request $request){
        $urlRoute = 'update.template';
        $contentType = "application/json-patch+json";
        $responseType = "body";
        $body = json_encode($request->all());
        $response = patchCurl($contentType, $urlRoute, $body, $responseType = 'body');
        if($response) {
            $data['selectedTemplateId'] = $request['id'];
            Cache::put(getStudentUserId() . ':savedRightPanelData', $data, $seconds = 600);
            echo $response;
        } else {
            echo false;
        }
    }

    /**
     * @Method to Assign Template data
     */
    public function assignTemplateData(Request $request) {
        $urlRoute = 'assign.examination';
        $contentType = "application/json-patch+json";
        $responseType = "body";
        $postDatas = json_decode($request->postdata, true);

        if($postDatas['header']['maximumMarks'] == 0){
            $templateDatas = getFormatStructure($request->templateId);
            if (isset($templateDatas['questionFormats']) && ! empty($templateDatas['questionFormats'])) {
                $totalMarks = 0;
                foreach ($templateDatas['questionFormats'] as $key => $questionFormat) {
                    $totalMarks += ($questionFormat['weightage'] * $questionFormat['numberOfQuestion']);
                }
                
                if(isset($postDatas['header']['maximumMarks'])){
                    $postDatas['header']['maximumMarks'] = $totalMarks;
                }
            }
        }
        $response = postCurl($contentType, $urlRoute, json_encode($postDatas), 'json');
        if(isset($response['paperId'])) {
            $postDatas['paperId'] = $response['paperId'];
            $request->session()->put('postData', $postDatas);
            $request->session()->forget('saved_right_panel_data');
            $request->session()->forget(getStudentUserId() . ':paperId');
            $savedAssignmentData = Cache::get(getStudentUserId() . ':savedRightPanelData');
            unset($savedAssignmentData['inputTitle']);
            Cache::put(getStudentUserId() . ':savedRightPanelData', $savedAssignmentData);
            $pdfUrl = $this->uploadPDF($request);
            $response['questionPaperFileUrl'] = $pdfUrl;
            $request->session()->put('assignData', $response);
            $msg = "";
            if($pdfUrl != false) {
                return response()->json(["status" => true, "resp" => $response, "pdfUrl" => $pdfUrl, 'msg' => $msg]);
            } else {
                return response()->json(["status" => true, "resp" => $response, "pdfUrl" => false, 'msg' => $msg]);
            }

        } else {
            $msg = __('students.notifications.InternalServerError');
            if(isset($response['errors'])) {
                $msg = "";
                foreach ($response['errors'] as $errorKey => $error) {
                    $msg .= '<p>'.$errorKey.": ".implode(", ", $error) .'<p>';
                }
            }
            return response()->json(["status" => false, "resp" => $response, 'msg' => $msg]);
        }
    }

    public function checkDuplicateString(Request $request){
        $myTemp = Questions::questionTemplate();
        $newArr = [];
        $newString = $request->string;
        foreach($myTemp as $temp) {
            if(trim($temp['formatName']) == trim($newString)){
                return response()->json(['string_name' => 'duplicate']);
            }
        }
        return response()->json(['string_name' => $newString ]);
    }

    public function getSelectPanel(Request $request) {
        $data = [];
        $session = $request->session()->get('saved_right_panel_data');

        if (! Cache::get(getStudentUserId() . ':select_board') || Cache::get(getStudentUserId() . ':select_board') == null) {
            $dropDownData = Questions::getQuestionDropdownData();
            $data['questionLayout']['rightPanelData']['Board']  = createBoardStructure($dropDownData);
            Cache::put(getStudentUserId() . ':select_board', $data['questionLayout']['rightPanelData']['Board'], $this->longTimeOut);
            Cache::put(getStudentUserId() . ':forFilter', $data['questionLayout']['rightPanelData']['Board'], $this->longTimeOut);
            
            $data['questionLayout']['rightPanelData']['Grade'] = getGrades($session['selectBoard']);
            Cache::put(getStudentUserId() . ':select_grade', $data['questionLayout']['rightPanelData']['Grade'], $this->longTimeOut);

            $data['questionLayout']['rightPanelData']['Subject'] = getSubject($session['selectBoard'], $session['selectGrade']);
            Cache::put(getStudentUserId() . ':select_subject', $data['questionLayout']['rightPanelData']['Subject'], $this->longTimeOut);
            
            $data['questionLayout']['rightPanelData']['Topic'] = getTopics($session['selectBoard'], $session['selectGrade'], $session['selectSubject']);
            Cache::put(getStudentUserId() . ':select_topic', $data['questionLayout']['rightPanelData']['Topic'], $this->longTimeOut);
            
            $data['session'] = $session;
        }else {
            $data['questionLayout']['rightPanelData']['Board']      = Cache::get(getStudentUserId() . ':select_board');

            /* If grade matches with the selected board value */

            $data['questionLayout']['rightPanelData']['Grade']      = Cache::get(getStudentUserId() . ':select_grade');
            $data['questionLayout']['rightPanelData']['Subject']    = Cache::get(getStudentUserId() . ':select_subject');
            $data['questionLayout']['rightPanelData']['Topic']      = Cache::get(getStudentUserId() . ':select_topic');
            $data['session'] = Cache::get(getStudentUserId() . ':savedRightPanelData');
        }
        if(! empty($session)) {
            $data['questionLayout']['lastUsedTemplate'] = $session['selectedTemplateId'];
            $data['questionLayout']['lastUsedTemplateType'] = $session['selectedTemplateType'];
            $data['session'] = $session;
        }
        return view('teachers.pages.questionLayout.ajax.selectPanel' , $data);
    }
    
    public function getMyTemplate(Request $request) {
        $data = [];
        $data['questionLayout']['savedQuestionTemplate'] = Questions::questionTemplate(true);
        $data['questionLayout']['lastUsedTemplate'] = Cache::get(getStudentUserId() . ':lastUsedTemplate');
        $session = Cache::get(getStudentUserId() . ':savedRightPanelData');
       
        if(! empty($session)) {
            $data['questionLayout']['lastUsedTemplate'] = $session['selectedTemplateId'];
        }

        $data['userProfile'] = '<img src="' . getStudentProfileImage() . '" />';
        return view('teachers.pages.questionLayout.ajax.myTemplate' , $data);
    }

    /**
     * @Method to Flush Cache and Session data
     */
    public function flushCache() {
        $route = "home_page";
        if(Session::has('profile')) {
            Session::forget('profile');
        }
        Cache::flush();
        Session::flush();
        session()->flush();
        return redirect()->route($route);
    }

    public function feedbackSubmit(Request $request) {
        return response()->json($request);
    }

    public function feedbackPage(Request $request) {
        $data = []; 
        $data['postData'] = session()->get("postData");
        $data['examUrls'] = session()->get("assignData");
        return view('teachers.pages.feedback.index', $data);
    }

    public function uploadPDF(Request $request) {
        ini_set("pcre.backtrack_limit", "50000000");
        $data['canvasData'] = Cache::get(getStudentUserId() . ':canvasData');
        $data['postData'] = session()->get("postData");
        if($data['canvasData'] == null) {
            $data['canvasData'] = Questions::getOldPaper($data['postData']['paperId']);
        }
        $pdf = PDF::loadView('teachers.pages.questionReview.ajax.downloadPDF', $data);
        $questionPaperName = isset($data['postData']['paperName']) ? str_replace(' ',  '-', $data['postData']['paperName']) : time();
        URL::forceScheme('https');
        $pdfData = $pdf->Output();
        $url = route('post.savequestionpaper', ['PaperId' => $data['postData']['paperId']]);
        $response = HTTP::withHeaders(getAADHeader())->accept('multipart/form-data');
        $response = $response->attach('File', $pdfData, $questionPaperName . '.pdf');
        $resp = $response->post($url);
        if($resp->successful()) {
            return $pdfUrl = $resp->body();
        } else {
            return false;
        }
    }
    
}
