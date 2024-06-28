<?php



namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Admin;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Cache;



class ReviewController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index() {

        $data = Admin::getReviewFilters();

        $userData = session()->get('user_session');

        $allowedArray = ['Review (all status)', 'Review Screen(status except approved)'];

        $userRoleArr = array_map('trim',explode(',', $userData['role']['description']));

        $isAllowedArr = array_intersect($userRoleArr, $allowedArray);

        if(count($isAllowedArr) <= 0) {

            return abort(401);

        }

        foreach ($data['questionStatus'] as $keyValue => $status) {

            if(isset($userData['userName']) && $userData['role']['roleId'] != config("constants.publisher") && ($status['statusName'] == config("constants.published") )){

                unset($data['questionStatus'][$keyValue]);

            }

        }

        return view('admin.review.filter', $data);

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        //

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        //

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        //

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id="")

    {

        

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        //

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        //

    }



    public function updateOnChangeFilter(Request $request){

        $data = $request->all();

        $searchOn = $request->changeOn;

        $searchFor = $request->selectType;

        $searchVal = $request->currentValue;



        $boardId = $request->boardId;

        $gradeId  = $request->gradeId;

        $subjectId  = $request->subjectId;

        $topicId = $request->topicId;

        $response = [];

        $label = "No Record Found";

        switch ($searchOn) {

            case 'grades':

                $label = "Select grade";

                $response = Admin::getGrades($boardId, "reviewFilters");

                session()->put('grades', $response);

            break;

            case 'subjects':

                $label = "Select subject";

                $response = Admin::getSubject($boardId, $gradeId, "reviewFilters");

                session()->put('subjects', $response);

            break;

            case 'topics':

                $label = "Select topic";

                $response = Admin::getTopics($boardId, $gradeId, $subjectId, "reviewFilters");

                session()->put('topics', $response);

            break;

            case 'subtopics':

                $label = "Select subtopic";

                $response = Admin::getSubTopics($boardId, $gradeId, $subjectId, $topicId, "reviewFilters");

                session()->put('subtopics', $response);

            break;

        }

        $status = false;

        if(!empty($response)){

            session()->put($searchOn, $response);

            $status = true;

        }

        $data['response'] = $response;

        $data['label'] = $label;

        $html_view = view('admin.selectbox', $data)->render();

        return response()->json([ 'status' => $status, 'html' => $html_view]);

    }



    public function getQuestion(Request $request){
        if(session()->get('questionData') != null){
            session()->forget('questionData');
        }
        $postBody  = $request->all();
        $postBody   = Admin::getFilterBody($postBody);
        session()->put('questionBody', $postBody);
        $contentType = 'application/json-patch+json';
        $url = route('swagger.question.pagination', $postBody);
        $questionData = HTTP::withHeaders(getAADHeader())->get($url);
        $data = Admin::getQuestionInjection('boards');
        $data['question'] = [];
        $data['questionNumber'] = (session()->put('questionNumber')) ? session()->put('questionNumber') : 1;

        $userData = session()->get('user_session');
        $userRoleArr = array_map('trim',explode(',', $userData['role']['description']));
        $data['roleAllowed'] = $userRoleArr;

        if($questionData->successful()){
            $pagination = $questionData->json();
           
            if( $pagination['questionCount'] > -1 ) {
                session()->put('reviewQuestionCount', $pagination['questionCount']);
            } else {
                $pagination['questionCount'] = session()->get('reviewQuestionCount');
            }
            $data['question'] = [];
            
            if ( $pagination['questionCount'] > 0) {
                $data['question'] = decryptBlobData($pagination['questions'][0]);
                $data['questionCount'] = $pagination['questionCount'];
                $data['s_questionId']    = $data['question']['id'];
                $data['s_questionTypeId']    = $data['question']['questionTypeId'];
                $data['questionTypeId'] = $data['question']['questionTypeId'];
                $data['questionTypeName'] = Admin::getQuestionTypeNameById($data['question']['questionTypeId']);
                session()->put('editQuestion', $pagination['questions'][0]);
                session()->put('questionNumber', $data['questionNumber']);
                $data['s_questionTypeName'] = Admin::getQuestionTypeNameById($data['s_questionTypeId']);
                $data['s_board']    = $data['question']['board']['id'];
                $data['s_grade']    = $data['question']['grade']['id'];
                $data['s_subject']    = $data['question']['subject']['id'];
                $data['s_topic']    = $data['question']['topic']['id'];
                $data['s_subtopic']    = isset($data['question']['subTopic']['id']) ? $data['question']['subTopic']['id'] : "";
                $data['s_source']   = $data['question']['source'];
                $data['s_difficultyLevel'] = $data['question']['difficultyLevel'];
                $data['s_questionText'] = $data['question']['questionText'];
                $data['s_options']      = $data['question']['answerBlock']['options'];
                $data['s_hint']         = $data['question']['answerBlock']['hint'];
                $data['s_extendedSolution'] = $data['question']['answerBlock']['extendedSolution'];
                $data['s_answer']       = $data['question']['answerBlock']['answer'];
                $data['s_answer_variations'] = $data['question']['answerBlock']['additionalAnswers'];
                $data['s_askedYear']   = $data['question']['askedYears'];
                $data['grades']     = Admin::getGrades($data['question']['board']['id']);
                $data['subjects']   = Admin::getSubject($data['question']['board']['id'], $data['question']['grade']['id']);
                $data['topics']     = Admin::getTopics($data['question']['board']['id'], $data['question']['grade']['id'], $data['question']['subject']['id']);
                $data['subtopics']  = Admin::getSubTopics($data['question']['board']['id'], $data['question']['grade']['id'], $data['question']['subject']['id'], $data['question']['topic']['id']);
                $data['childrenQuestions']  = $data['question']['childrenQuestions'];
            }
        }

        if(session()->get('user_session')){
            $user = session()->get('user_session');
            if(isset($user) && !empty($user)){
                $data['username'] = $user['userName'];
            }
        }
        // dd($data);
        return view('admin.review.question', $data);
    }



    public function getQuestionGet(Request $request){

        $postBody = session()->get('questionBody');

        $postBody['Parameter.QuestionNumber'] =  (session()->get('questionNumber')) ? session()->get('questionNumber') : 1;

        $url = route('swagger.question.pagination', $postBody);

        $questionData = HTTP::withHeaders(getAADHeader())->get($url);

        $data = Admin::getQuestionInjection('boards');

        $data['question'] = [];

        $data['questionNumber'] = (session()->get('questionNumber')) ? session()->get('questionNumber') : 1;

        $userData = session()->get('user_session');
        $userRoleArr = array_map('trim',explode(',', $userData['role']['description']));
        $data['roleAllowed'] = $userRoleArr;

        if($questionData->successful()){

            $pagination = $questionData->json();

            if( $pagination['questionCount'] > -1 ) {

                session()->put('reviewQuestionCount', $pagination['questionCount']);

            } else {

                $pagination['questionCount'] = session()->get('reviewQuestionCount');

            }

            $data['question'] = decryptBlobData($pagination['questions'][0]);

            $data['questionCount'] = $pagination['questionCount'];

            $data['questionTypeId'] = $data['question']['questionTypeId'];

            $data['questionTypeName'] = Admin::getQuestionTypeNameById($data['question']['questionTypeId']);

            session()->put('editQuestion', decryptBlobData($pagination['questions'][0]));

            session()->put('questionCount', $pagination['questionCount']);

        }



        if(session()->get('questionData') != null){

            $data['question'] = decryptBlobData(session()->get('questionData'));

            $data['questionCount'] = session()->get('reviewQuestionCount');

            $data['questionTypeId'] = $data['question']['questionTypeId'];

            $data['questionTypeName'] = Admin::getQuestionTypeNameById($data['question']['questionTypeId']);

            session()->put('editQuestion', decryptBlobData(session()->get('questionData')));

        }



        if(isset($data['question']) && !empty($data['question'])) {



            $data['s_questionId']    = $data['question']['id'];

            $data['s_questionTypeId']    = $data['question']['questionTypeId'];

            $data['questionTypeId'] = $data['question']['questionTypeId'];

            $data['questionTypeName'] = Admin::getQuestionTypeNameById($data['question']['questionTypeId']);

            session()->put('questionNumber', $data['questionNumber']);



            $data['s_questionTypeName'] = Admin::getQuestionTypeNameById($data['s_questionTypeId']);

            $data['s_board']    = $data['question']['board']['id'];

            $data['s_grade']    = $data['question']['grade']['id'];

            

            $data['s_subject']    = $data['question']['subject']['id'];

            $data['s_topic']    = $data['question']['topic']['id'];

            $data['s_subtopic']    = isset($data['question']['subTopic']['id']) ? $data['question']['subTopic']['id'] : "";



            $data['s_source']   = $data['question']['source'];

            $data['s_difficultyLevel'] = $data['question']['difficultyLevel'];

            $data['s_questionText'] = $data['question']['questionText'];

            $data['s_options']      = $data['question']['answerBlock']['options'];

            $data['s_hint']         = $data['question']['answerBlock']['hint'];

            $data['s_extendedSolution'] = $data['question']['answerBlock']['extendedSolution'];

            $data['s_answer']       = $data['question']['answerBlock']['answer'];

            $data['s_answer_variations'] = $data['question']['answerBlock']['additionalAnswers'];

            $data['s_askedYear']   = $data['question']['askedYears'];

                

            $data['grades']     = Admin::getGrades($data['question']['board']['id']);

            $data['subjects']   = Admin::getSubject($data['question']['board']['id'], $data['question']['grade']['id']);

            $data['topics']     = Admin::getTopics($data['question']['board']['id'], $data['question']['grade']['id'], $data['question']['subject']['id']);

            $data['subtopics']  = Admin::getSubTopics($data['question']['board']['id'], $data['question']['grade']['id'], $data['question']['subject']['id'], $data['question']['topic']['id']);

        }

        if(session()->get('user_session')){

            $user = session()->get('user_session');

            if(isset($user) && !empty($user)){

                $data['username'] = $user['userName'];

            }

        }

        return view('admin.review.question', $data);

    }



    public function changeQuestionStatus(Request $request){

        $postData = [];

        $postData['questionId'] = $request['questionId'];

        $postData['reviewerId'] = isset($request['reviewerId']) && !empty($request['reviewerId']) ? $request['reviewerId'] : getAdminUserId();

        $postData['statusId'] = $request['statusId'];

        $urlRoute = 'admin.question.review';

        $questionData = putCurl($urlRoute, $postData, "");

        if($questionData->successful()){

            $questionCount = session()->get('reviewQuestionCount');

            if(session()->get('questionData') != null){

                session()->forget('questionData');

            }

            $counter = session()->get('reviewQuestionCount') <= 1 ? 2 : session()->get('reviewQuestionCount');

            session()->put('reviewQuestionCount', ($counter-1));        

            $response = ['status' => true, 'msg' => $questionData->body()];

        } else {

            $response = ['status' => false, 'msg' => 'Question status update failed'];

        }

        return response()->json($response);

    }



    public function ajaxPagination(Request $request){

        if(session()->get('user_session')){

            $user = session()->get('user_session');

            if(isset($user) && !empty($user)){

                $data['username'] = $user['userName'];

            }

        }

        $postBody = session()->get('questionBody');

        $postBody['ReviewerId'] =  $request['reviewerId'];

        $postBody['StatusId'] =  $request['statusId'];

        $postBody['Parameter.QuestionNumber'] =  $request['questionNumber'];

        $postBody['FetchCount'] = "false";

        $url = route('swagger.question.pagination', $postBody);

        $questionData = HTTP::withHeaders(getAADHeader())->get($url);

        $data = Admin::getQuestionInjection('boards');

        $data['question'] = [];

        $data['questionNumber'] = $request['questionNumber'];

        $userData = session()->get('user_session');

        $userRoleArr = array_map('trim',explode(',', $userData['role']['description']));

        $data['roleAllowed'] = $userRoleArr;

        if($questionData->successful()){

            $pagination = $questionData->json();  

            $pagination['questionCount'] = (session()->get('reviewQuestionCount'));

            if(!empty($pagination['questions'])) {

                $data['question'] = isset($pagination['questions'][0]) ? decryptBlobData($pagination['questions'][0]) : [];

                $data['questionCount'] = $pagination['questionCount'];

                $data['questionTypeId'] = $data['question']['questionTypeId'];



                /* Filter Update */

                $data['s_questionTypeId']    = $data['question']['questionTypeId'];

                $data['questionTypeName'] = Admin::getQuestionTypeNameById($data['question']['questionTypeId']);

                session()->put('editQuestion', $data['question']);



                $data['s_questionTypeName'] = Admin::getQuestionTypeNameById($data['s_questionTypeId']);

                $data['s_board']    = $data['question']['board']['id'];

                $data['s_grade']    = $data['question']['grade']['id'];

                

                $data['s_subject']    = $data['question']['subject']['id'];

                $data['s_topic']    = $data['question']['topic']['id'];

                $data['s_subtopic']    = isset($data['question']['subTopic']['id']) ? $data['question']['subTopic']['id'] : "";



                $data['s_source']   = $data['question']['source'];

                $data['s_difficultyLevel'] = $data['question']['difficultyLevel'];

                $data['s_questionText'] = $data['question']['questionText'];

                $data['s_options']      = $data['question']['answerBlock']['options'];

                $data['s_hint']         = $data['question']['answerBlock']['hint'];

                $data['s_extendedSolution'] = $data['question']['answerBlock']['extendedSolution'];

                $data['s_answer']       = $data['question']['answerBlock']['answer'];

                $data['s_answer_variations'] = $data['question']['answerBlock']['additionalAnswers'];

                $data['s_askedYear']   = $data['question']['askedYears'];

                    

                $data['grades']     = Admin::getGrades($data['question']['board']['id']);

                $data['subjects']   = Admin::getSubject($data['question']['board']['id'], $data['question']['grade']['id']);

                $data['topics']     = Admin::getTopics($data['question']['board']['id'], $data['question']['grade']['id'], $data['question']['subject']['id']);

                $data['subtopics']  = Admin::getSubTopics($data['question']['board']['id'], $data['question']['grade']['id'], $data['question']['subject']['id'], $data['question']['topic']['id']);

                /* Filter Update */

                $data['questionTypeName'] = Admin::getQuestionTypeNameById($data['question']['questionTypeId']);

                session()->put('editQuestion', decryptBlobData($pagination['questions'][0]));

                session()->put('questionNumber', $request['questionNumber']);



                $ajaxQuestion = view('admin.review.ajax.question', $data)->render();

                $ajaxQuestionDetails = view('admin.review.ajax.question-details', $data)->render();



                return response()->json(['status' => true , 'ajaxQuestion' => $ajaxQuestion, 'ajaxQuestionDetails' => $ajaxQuestionDetails]);

            }

        }

        $ajaxQuestion = view('admin.review.ajax.question', $data)->render();

        $ajaxQuestionDetails = view('admin.review.ajax.question-details', $data)->render();

        return response()->json(['status' => false , 'ajaxQuestion' => $ajaxQuestion, 'ajaxQuestionDetails' => $ajaxQuestionDetails]);

    }

}