<?php

namespace App\Http\Controllers\Admin;
use Auth;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function login(Request $request){
        return redirect()->route('admin.dashboard')->with("success", "Login successfully");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index() {
        if(session()->has('user_session')) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $data = Admin::getQuestionInjection('boards');
        if(session()->get('user_session')){
            $allowedArray = ['Data Entry Edit', 'Only Data entry Screen', 'Data entry'];
            $user = session()->get('user_session');
            if(isset($user) && !empty($user)){
                $data['username'] = getAdminUserId();
            }
            $userRoleArr = array_map('trim',explode(',', $user['role']['description']));
            $isAllowedArr = array_intersect($userRoleArr, $allowedArray);
            if(count($isAllowedArr) <= 0) {
                return abort(401);
            }
        }
        if(session()->get('grades')){
            $data['grades'] = session()->get('grades');
        } else if(Cache::get('grades')){
            $data['grades'] = Cache::get('grades');
        }
        if(session()->get('subjects')){
            $data['subjects'] = session()->get('subjects');
        } else if(Cache::get('subjects')) {
            $data['subjects'] = Cache::get('subjects');
        }
        if(session()->get('topics')){
            $data['topics'] = session()->get('topics');
        } else if(Cache::get('topics')){
            $data['topics'] = Cache::get('topics');
        }
        if(session()->get('subtopics')){
            $data['subtopics'] = session()->get('subtopics');
        } else if(Cache::get('subtopics')){
            $data['subtopics'] = Cache::get('subtopics');
        }
        $data['s_questionTypeId'] = Config('constants.staticQuestionTypeId');
        $data['s_questionTypeName'] = "";
        if(session()->get('formData')){
            $submittedData = session()->get('formData');
            $data['s_board'] = $submittedData['board']['id'];
            $data['s_grade'] = $submittedData['grade']['id'];
            $data['s_subject'] = $submittedData['subject']['id'];
            $data['s_topic'] = $submittedData['topic']['id'];
            $data['s_subtopic'] = isset($submittedData['subTopic']['id']) ? $submittedData['subTopic']['id'] : '';
            $data['s_questionTypeId'] = $submittedData['questionTypeId'];
            $data['s_questionTypeName'] = Admin::getQuestionTypeNameById($submittedData['questionTypeId']);
            $data['s_topicTags'] = [];
            $data['s_source'] = $submittedData['source'];
            $data['s_difficultyLevel'] = $submittedData['difficultyLevel'];
        }
        return view('admin.forms.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request) {


        $replaceArray = encryptBlobData(json_decode($request->templateData, true));


        session()->put('formData', $replaceArray);


        $body = json_encode($replaceArray);


        $contentType = "application/json-patch+json";


        $urlRoute = 'swagger.store.question';


        $url = route($urlRoute);


        $response =  createQuestion($contentType, $urlRoute, $body);


        if($response->successful()){


            return response()->json(['status' => true , 'msg' => __('admin.questionAddSuccess'), 'id' => $response->body() ]);


        } else {


            return response()->json(['status' => false , 'msg' => $response->body(), 'body'=> $body]);


        }


    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request) {
        if(session()->get('questionData') != null){
            session()->forget('questionData');
        }
        if(session()->get('user_session')){
            $user = session()->get('user_session');
            if(isset($user) && !empty($user)){
                $data['username'] = getAdminUserId();
            }
        }
        $postBody  = $request->all();
        $postBody   = Admin::getFilterBody($postBody);
        session()->put('questionBody', $postBody);
        $contentType = 'application/json-patch+json';
        $url = route('swagger.question.pagination', $postBody);
        $questionData = HTTP::withHeaders(getAADHeader())->get($url);
        $data['question'] = [];
        $data['questionNumber'] = 1;
        if($questionData->successful()){
            $pagination = $questionData->json();
            $data['question'] = decryptBlobData($pagination['questions'][0]);
            $data['questionCount'] = $pagination['questionCount'];
            $data['questionTypeId'] = $data['question']['questionTypeId'];
            $data['questionTypeName'] = Admin::getQuestionTypeNameById($data['question']['questionTypeId']);
            session()->put('editQuestion', $pagination['questions'][0]);
        }
        return view('admin.review.question', $data);
    }


    public function ajaxPagination(Request $request){


        if(session()->get('user_session')){


            $user = session()->get('user_session');


            if(isset($user) && !empty($user)){


                $data['username'] = getAdminUserId();


            }


        }


        $postBody = session()->get('questionBody');


        $postBody['Parameter.QuestionNumber'] =  $request['questionNumber'];


        $url = route('swagger.question.pagination', $postBody);


        $questionData = HTTP::withHeaders(getAADHeader())->get($url);


        $data['question'] = [];


        $data['questionNumber'] = $request['questionNumber'];


        if($questionData->successful()){


            $pagination = $questionData->json();


            $data['question'] = decryptBlobData($pagination['questions'][0]);


            $data['questionCount'] = $pagination['questionCount'];


            $data['questionTypeId'] = $data['question']['questionTypeId'];


            $data['questionTypeName'] = Admin::getQuestionTypeNameById($data['question']['questionTypeId']);


            session()->put('editQuestion', decryptBlobData($pagination['questions'][0]));


            session()->put('questionNumber', $request['questionNumber']);


            $ajaxQuestion = view('admin.review.ajax.question', $data)->render();


            $ajaxQuestionDetails = view('admin.review.ajax.question-details', $data)->render();


            return response()->json(['status' => true , 'ajaxQuestion' => $ajaxQuestion, 'ajaxQuestionDetails' => $ajaxQuestionDetails]);


        }


        $ajaxQuestion = view('admin.review.ajax.question', $data)->render();


        $ajaxQuestionDetails = view('admin.review.ajax.question-details', $data)->render();


        return response()->json(['status' => false , 'ajaxQuestion' => $ajaxQuestion, 'ajaxQuestionDetails' => $ajaxQuestionDetails]);


    }





    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request) {

        $data = Admin::getQuestionInjection('boards');

        $user = session()->get('user_session');

        if(isset($user)){

            $data['username'] = getAdminUserId();

        }

        if(session()->get('grades')){

            $data['grades'] = session()->get('grades');

        } else if(Cache::get('grades')){

            $data['grades'] = Cache::get('grades');

        }


        if(session()->get('subjects')){

            $data['subjects'] = session()->get('subjects');

        } else if(Cache::get('subjects')) {

            $data['subjects'] = Cache::get('subjects');

        }


        if(session()->get('topics')){

            $data['topics'] = session()->get('topics');

        } else if(Cache::get('topics')){

            $data['topics'] = Cache::get('topics');

        }


        if(session()->get('subtopics')){

            $data['subtopics'] = session()->get('subtopics');

        } else if(Cache::get('subtopics')){

            $data['subtopics'] = Cache::get('subtopics');

        }


        if(!empty(session()->get('editQuestion'))){
            $question = decryptBlobData(session()->get('editQuestion'));
            $data['s_questionId']    = $question['id'];
            $data['s_questionTypeId']    = $question['questionTypeId'];
            $data['s_questionTypeName'] = Admin::getQuestionTypeNameById($question['questionTypeId']);
            $data['s_board']    = $question['board']['id'];
            $data['s_grade']    = $question['grade']['id'];
            $data['s_subject']    = $question['subject']['id'];
            $data['s_topic']    = $question['topic']['id'];
            $data['s_subtopic']    = isset($question['subTopic']['id']) ? $question['subTopic']['id'] : "";
            $data['s_source']   = $question['source'];
            $data['s_difficultyLevel'] = $question['difficultyLevel'];
            $data['s_questionText'] = $question['questionText'];
            $data['s_options']      = $question['answerBlock']['options'];
            $data['s_hint']         = $question['answerBlock']['hint'];
            $data['s_extendedSolution'] = $question['answerBlock']['extendedSolution'];
            $data['s_answer']       = $question['answerBlock']['answer'];
            $data['s_answer_variations']       = $question['answerBlock']['additionalAnswers'];
            $data['s_askedYear']   = $question['askedYears'];
            $subjectId = 0;
            $topicId = 0;
            $subtopicId = 0;
            $data['s_topicTags'] = [];
            if(!empty($question['topicTags'])){
                foreach($question['topicTags'] as $topic){
                    $data['s_topicTags'][] = $topic['id'];
                    if($topic['topicType'] == 1){
                        $subjectId = $topic['id'];
                    } 
                    if($topic['topicType'] == 2){
                        $topicId = $topic['id'];
                    }
                    if($topic['topicType'] == 2){
                        $subtopicId = $topic['id'];
                    }
                }
            }
            $data['grades']     = Admin::getGrades($question['board']['id']);
            $data['subjects']   = Admin::getSubject($question['board']['id'], $question['grade']['id']);
            $data['topics']     = Admin::getTopics($question['board']['id'], $question['grade']['id'], $question['subject']['id']);
            $data['subtopics']  = Admin::getSubTopics($question['board']['id'], $question['grade']['id'], $question['subject']['id'], $question['topic']['id']);
            $data['question']   = decryptBlobData($question);
            
            if($data['s_questionTypeId']  === 'kc8fmydg') {
                $question['questionType'] = $data['s_questionTypeId'];
                $question['sno'] = 0;
                $data['questionView'] = view('admin.forms.questiontypes.multipleselect', $question);
            } else if($data['s_questionTypeId']  === 'XQV1T7gD') {
                $question['questionType'] = $data['s_questionTypeId'];
                $question['sno'] = 0;
                $data['questionView'] = view('admin.forms.questiontypes.multipleblanks', $question);
            } else if(isset($question['childrenQuestions']) && count($question['childrenQuestions'])) {
                $data['childrenQuestions']   = $question['childrenQuestions'];    
                $questionView = '';
                foreach($question['childrenQuestions'] as $index => $question) {
                    $question['questionType'] = $question['questionTypeId'];
                    $question['sno'] = $index;
                    if($question['questionTypeId'] === 'kc8fmydg') {
                        $questionView .= view('admin.forms.questiontypes.passage.multipleselect', $question);
                    } else if($question['questionTypeId'] === '529kWMwg') {
                        $questionView .= view('admin.forms.questiontypes.passage.multichoice', $question);
                    }
                }

                $data['questionView'] = $questionView;
            }
        }
        // dd($data);
        return view('admin.forms.edit', $data);
    }





    /**


     * Update the specified resource in storage.


     *


     * @param  \Illuminate\Http\Request  $request


     * @param  \App\Models\Admin  $admin


     * @return \Illuminate\Http\Response


     */


    public function update(Request $request, Admin $admin) {
        $body = json_encode(encryptBlobData(json_decode($request->templateData, true)));
        $contentType = "application/json-patch+json";
        $urlRoute = 'swagger.update.question';
        $url = route($urlRoute);
        $response =  updateQuestion($contentType, $urlRoute, $body);
        if($response->successful()){
            if(session()->has('questionBody')) {
                $sessionData = session()->get('questionBody');
            } else {
                $sessionData = $response->json();
            }
            session()->put('questionData' , $response->json());
            session()->put('questionBody' , $sessionData);
            return response()->json(['status' => true , 'msg' => __('admin.questionUpdateSuccess'), 'data' => $response->json(), 'questionID' => $request->id ]);
        } else {
            return response()->json(['status' => false , 'msg' => __('admin.'.$response->status()), 'body'=> $body]);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */

    public function destroy(Admin $admin){
        //
    }

    public function dashboard(Request $request) {
        $data = Admin::getReviewFilters();
        if($request->session()->has('user_session')) {
            $session = $request->session()->get('user_session');
            $allowedArray = ['Dashboard'];
            $userRoleArr = array_map('trim',explode(',', $session['role']['description']));
            $isAllowedArr = array_intersect($userRoleArr, $allowedArray);
            if(count($isAllowedArr) <= 0) {
                return view('admin.dashboard.index', $data);
            }
            return view('admin.dashboard.indexAdmin', $data);
        }
    }


    /* Delete this function */
    public function form(Request $request) {
        $data = [];
        $data = Admin::getQuestionInjection('boards');
        if(session()->get('grades')){
            $data['grades'] = session()->get('grades');
        } else if(Cache::get('grades')){
            $data['grades'] = Cache::get('grades');
        }
        if(session()->get('subjects')){
            $data['subjects'] = session()->get('subjects');
        } else if(Cache::get('subjects')) {
            $data['subjects'] = Cache::get('subjects');
        }

        if(session()->get('topics')){
            $data['topics'] = session()->get('topics');
        } else if(Cache::get('topics')){
            $data['topics'] = Cache::get('topics');
        }

        if(session()->get('subtopics')){
            $data['subtopics'] = session()->get('subtopics');
        } else if(Cache::get('subtopics')){
            $data['subtopics'] = Cache::get('subtopics');
        }

        if(session()->get('formData')){
            $submittedData = session()->get('formData');
            $data['s_board'] = $submittedData['board']['id'];
            $data['s_grade'] = $submittedData['grade']['id'];
            $data['s_questionTypeId'] = $submittedData['questionTypeId'];
            $data['s_topicTags'] = [];
            foreach($submittedData['topicTags'] as $topic){
                $data['s_topicTags'][] = $topic['id'];
            }
            $data['s_source'] = $submittedData['openTags'][0];
            $data['s_difficultyLevel'] = $submittedData['difficultyLevel'];
        }
        return view('admin.forms.create', $data);
    }





    /* Select filters are here */


    public function getSqlInjection(Request $request) {


        $boardId = $request->boardId;


        $gradeId = $request->gradeId;


        $subjectId = $request->subjectId;


        $types = $request->type;





        if($types == 'grades') {


            $label = 'Select grade';


            $response = Admin::getGrades($boardId);


            Cache::put('grades' , $response, $seconds = 6000);


            session()->put('grades' , $response);


        } else if($types == 'subjects') {


            $label = 'Select subject';


            $response = Admin::getSubject($boardId, $gradeId);


            Cache::put('subjects' , $response, $seconds = 6000);


            session()->put('subjects' , $response);


        } else if($types == 'topics') {


            $label = 'Select topic';


            $response = Admin::getTopics($boardId, $gradeId, $subjectId);


            Cache::put('topics' , $response, $seconds = 6000);


            session()->put('topics' , $response);


        } else if($types == 'subtopics') {


            $topicId = $request->topicId;


            $label = 'Select subtopic';


            $response = Admin::getSubTopics($boardId, $gradeId, $subjectId, $topicId);


            Cache::put('subtopics' , $response, $seconds = 6000);


            session()->put('subtopics' , $response);


        }


        $data['response'] = $response;


        $data['label'] = $label;


        echo view('admin.selectbox', $data);


    }





    public function uploadCkeditor(Request $request) {


        $file = $request->file('upload');


        $fileName = time().rand(1111111,99999999).".png";


        $urlRoute = 'upload.image.ckeditor';


        $filePath = $file->path();


        $fileData = fopen($filePath, 'r');


        $response = uploadCkeditorImage($urlRoute,$fileData, $fileName);


        if($response->successful()){


            return response()->json($response->json());


        }


    }





    public function uploadUrlCkeditor(Request $request){


        $fileUrl = $request->imageURL;


        $fileName = time().rand(1111111,99999999).".png";


        $postData = [];


        $fileData = file_get_contents($request->imageURL);


        $postData['fileName'] = $fileName;


        $urlRoute = 'upload.image.ckeditor';


        $response = uploadCkeditorImage($urlRoute,$fileData, $fileName);


        if($response->successful()){


            return response()->json(['data' => $response->json() , 'index' => $request->index]);


        } else {


            return response()->json($response->json());


        }


    }





    public function dashboardSearch(Request $request) {

        $data['BoardId'] = $request['BoardId'];


        $data['GradeId'] = $request['GradeId'];


        $data['SubjectId'] = $request['SubjectId'];


        $data['StatusId'] = $request['StatusId'];

        $data['Source'] = !empty($request['Source']) ? $request['Source'] : ''; 

        $data['DifficultyLevel'] = !empty($request['DifficultyLevel']) ? $request['DifficultyLevel'] : 0;

        $response = Admin::getSearchResultDashboard($data);
        
        echo view('admin.dashboard.ajax.searchResult', $response);

    }

    public function questionTypeTemplates (Request $request) {
        $response['sno'] = $request['sno'] ? $request['sno'] : 0;
        $response['questionType'] = $request['questionType'];
        if($request['questionType'] === '529kWMwg') { // Multiple Choice
            echo view('admin.forms.questiontypes.multichoice', $response);
        } else if($request['questionType'] === 'kc8fmydg') { // Multiple Select
            if(isset($request['isPassage']) && $request['isPassage'] == "true") {
                echo view('admin.forms.questiontypes.passage.multipleselect', $response);
            } else {
                echo view('admin.forms.questiontypes.multipleselect', $response);
            }
        }else if($request['questionType'] === '4NcrZAcU') { // True or false
            echo view('admin.forms.questiontypes.trueorfalse', $response);
        }else if($request['questionType'] === 'Tqg3XB1M') { // Fill in the blanks
            echo view('admin.forms.questiontypes.fillintheblanks', $response);
        }else if($request['questionType'] === 'XQV1T7gD') { // Multiple Blanks
            echo view('admin.forms.questiontypes.multipleblanks', $response);
        }
    }


}


