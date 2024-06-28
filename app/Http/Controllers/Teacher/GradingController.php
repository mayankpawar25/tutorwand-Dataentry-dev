<?php
namespace App\Http\Controllers\Teacher;

use App\Models\Teachers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Grading;
use App\Models\Questions;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use PDF;
use Http;
class GradingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $studentId_paperId_responseId = "") {
        $base64Decode = base64_decode($studentId_paperId_responseId);
        list($studentId, $paperId, $responseId) = explode('_', $base64Decode);
        $students = [];
        $selected = [];
        /* Header Student session data */
        if(session::has('submittedStudentList')) {
            $gradeStudents = session::get('submittedStudentList');
            $students = $gradeStudents;
            foreach ($students as $key => $student) {
                if($student['profile']['id'] == $studentId) {
                    $selected = $student;
                }
            }
        }
        /* Header Student session data */

        /* Header Student reset if selected blank array */
        if(empty($selected)) {
            $gradeStudents = Teachers::getGradeStudents($paperId);
            $students = $this->getStudentList($gradeStudents['students']);
            foreach ($students as $key => $student) {
                if($student['profile']['id'] == $studentId) {
                    $selected = $student;
                }
            }
            session::put('submittedStudentList', $students);
        }
        $data['selected'] = $selected;
        $data['students'] = $students;
        /* Header Student reset if selected blank array */

        $data['back'] = $request->server('HTTP_REFERER');
        $param = [];
        $data['studentId'] = $param['studentId'] = $studentId; 
        $data['paperId'] = $param['paperId']   = $paperId;
        $data['responseId'] = $param['responseId'] = $responseId;
        session()->put('sessionData', $param);
        $response = getCurl('get.student.response.solution', 'json', $param);
        $data['studentResponse'] = $response;
        if(isset($data['studentResponse']['responses'])) {
            $data['sortOrder'] = ["sortBy" => "", "orderBy" => "asc"];
            if(session()->has('studentSortOrder')) {
                $data['sortOrder'] = session()->get('studentSortOrder');
            }
            return view('teachers.pages.grading.index', $data);
        }
        abort(500);
    }

    /**
     * Display a view Grading Home Page
     *
     * @return \Illuminate\Http\Response
     */
    public function home(Request $request) {
        $gradingData = Teachers::getGradingAssessments();
        $request->session()->put('gradingData', $gradingData);
        if($gradingData) {
            $data['grades']   = $gradingData['grades'];
            $data['subjects'] = $gradingData['subjects'];
            $data['status']   = $gradingData['status'];
            if(isset($gradingData['assessments']) && !empty($gradingData['assessments'])) {
                foreach ($gradingData['assessments'] as $key => $assessments) {
                    if($assessments['isResultPublished']) {
                        $data['assessments']['Graded'][] = $assessments;
                    } else {
                        $data['assessments']['Due'][] = $assessments;
                    }
                }
            }
            // Sort the array 
            if(isset($data['assessments']['Graded']) && !empty($data['assessments']['Graded'])) {
                usort($data['assessments']['Graded'], 'resultDateCompare');
            }
            return view('teachers.pages.grading.home', $data);
        }
        abort(404);
    }

    /**
     * Display a view Assessment Board Home
     *
     * @return \Illuminate\Http\Response
     */
    public function board(Request $request, $paperId) {
        $paperId = base64_decode($paperId);
        $gradingData = session()->get('gradingData');
        $gradingInfo = [];
        $disablePublishResult = false;
        if(!session()->has('gradingData')) {
            $gradingData = Teachers::getGradingAssessments();
            session()->put('gradingData', $gradingData);
        }
        $dataKey = array_search($paperId, array_column($gradingData['assessments'], 'assessmentId'));
        if($dataKey) {
            $gradingInfo = $gradingData['assessments'][$dataKey];
        } else {
            $gradingData = Teachers::getGradingAssessments();
            $dataKey = array_search($paperId, array_column($gradingData['assessments'], 'assessmentId'));
            $gradingInfo = $gradingData['assessments'][$dataKey];
        }
        $data['gradingData'] = $gradingInfo;
        if(strtotime($gradingInfo['startDateTime']) > time()) {
            $disablePublishResult = true;
        }
        $data['disablePublishResult'] = $disablePublishResult;
        $data['paperId'] = $paperId;
        $data['teacherId'] = getStudentUserId();
        $gradeStudents = Teachers::getGradeStudents($paperId);
        $data['total'] = []; // All
        $data['submitted'] = []; // Ungraded
        $data['graded'] = []; // Graded
        $data['draft'] = []; // Drafted
        $submittedCount = 0;
        $gradedCount = 0;
        $draftCount = 0;
        if(isset($gradeStudents['students'])) {
            foreach ($gradeStudents['students'] as $key => $student) {
                $data['total'][$key] = $student;
                $data['total'][$key]['button'] = __('teachers.grading.disabled');
                $data['total'][$key]['status'] = __('teachers.grading.due');
    
                if($student['responseStatus'] == config('constants.submitted')) {
                    // Graded
                    if($student['gradingStatus'] == config('constants.graded')) {
                        $data['graded'][$gradedCount] = $student;                    
                        $data['graded'][$gradedCount]['button'] = $data['total'][$key]['button'] = __('teachers.grading.graded');
                        $data['graded'][$gradedCount]['status'] = $data['total'][$key]['status'] = __('teachers.grading.graded');
                        $gradedCount++;
                    }
    
                    /* Ungraded */
                    if($student['gradingStatus'] == config('constants.due') || $student['gradingStatus'] == config('constants.overDue')) {
                        $data['submitted'][$submittedCount] = $student;                    
                        $data['submitted'][$submittedCount]['button'] = $data['total'][$key]['button'] = __('teachers.grading.grade');
                        $data['submitted'][$submittedCount]['status'] = $data['total'][$key]['status'] = __('teachers.grading.due');
                        $submittedCount ++;
                    }
    
                    // Drafted
                    if($student['gradingStatus'] == config('constants.draft')) {
                        $data['draft'][$draftCount] = $student;
                        $data['draft'][$draftCount]['button'] = $data['total'][$key]['button'] = __('teachers.grading.grade');
                        $data['draft'][$draftCount]['status'] = $data['total'][$key]['status'] = __('teachers.grading.draft');
                        $draftCount++;
                    }
                }
    
                /* Upcoming Response Status */
                if($student['responseStatus'] == config('constants.upComing')) {
                    $data['total'][$key]['button'] = __('teachers.grading.disabled');
                    $data['total'][$key]['status'] = __('teachers.grading.upComing');
                }
    
                /* InProgress Response Status */
                if($student['responseStatus'] == config('constants.inProgress')) {
                    $data['total'][$key]['button'] = __('teachers.grading.grade');
                    $data['total'][$key]['status'] = __('teachers.grading.due');
                }
    
                /* Absent & Draft */
                if($student['responseStatus'] == config('constants.absent')) {
                    
                    if($student['gradingStatus'] == config('constants.due') || $student['gradingStatus'] == config('constants.overDue')) {
                        $data['total'][$key]['button'] =  __('teachers.grading.grade');
                        $data['total'][$key]['status'] = __('teachers.grading.missed');
                    }

                    if($student['gradingStatus'] == config('constants.graded')) {
                        $data['graded'][$gradedCount] = $student;
                        $data['graded'][$gradedCount]['button'] = $data['total'][$key]['button'] = __('teachers.grading.graded');
                        $data['graded'][$gradedCount]['status'] = $data['total'][$key]['status'] = __('teachers.grading.graded');
                        $gradedCount++;
                    }

                    if($student['gradingStatus'] == config('constants.draft')){
                        $data['draft'][$draftCount] = $student;
                        $data['draft'][$draftCount]['button'] = $data['total'][$key]['button'] = __('teachers.grading.grade');
                        $data['draft'][$draftCount]['status'] = $data['total'][$key]['status'] = __('teachers.grading.draft');
                        $draftCount++;
                    }
                }
    
            }
        }
        $submittedData = $data['total'];
        if(isset($data['gradingData']['dueDateTime']) && strtotime($data['gradingData']['dueDateTime']) > time()) {
            $submittedData = array_merge($data['graded'], $data['submitted'], $data['draft']);
        }
        $data['sortOrder'] = ["sortBy" => "", "orderBy" => "asc"];
        $data['gradeStudents'] = $gradeStudents;
        session()->put('submittedStudentList', $submittedData);
        session()->put('studentSortOrder', $data['sortOrder']);
        return view('teachers.pages.grading.board', $data);
    }

    /*
     * Preview PDF Paper data
     *
     */
    public function previewPDF(Request $request, $paperId) {
        $questionData = Questions::getQuestionPaper($paperId);
        $data['paperUrl'] = $questionData['questionPaperFileUrl'];
        return view('teachers.pages.questionReview.ajax.viewPDF', $data);
    }

    public function saveGrade(Request $request) {
        $contentType = "application/json-patch+json";
        $urlRoute = "save.student.grade";
        $postData = $request->all();

        $paperId    = $postData['assessmentId'];
        $updatedStudentId  = $postData['studentId'];
        $responseId = $postData['responseId'];
        $gradingStatus = $postData['gradingStatus'];

        if(!isset($postData['grades'])){
            $postData['grades'] = [];
        }
        $requestBody = json_encode($postData);
        $responseType = 'json';
        $response = patchCurl($contentType, $urlRoute, $requestBody, $responseType);
        if(isset($response['responseId']) && !empty($response['responseId'])) {
            updateStudentGradingStatus($updatedStudentId, $gradingStatus);
            if(strpos(url()->current(), 'localhost') !== false) {
                \URL::forceScheme('http');
            }
            $studentId = getNextUngradedStudent();
            if($studentId) {
                return response()->json(['status' => true, 'data' => $response, 'redirect_url' => route('grading.assessments.index', base64_encode($studentId.'_'.$paperId.'_'.$responseId))]);
            } else {
                return response()->json(['status' => true, 'data' => $response, 'redirect_url' => route('grading.assessments.board', base64_encode($paperId))]);
            }
        } else{
            return response()->json(['status' => false, 'data' => $response]);
        }
    }

    public function publishResult(Request $request){
        $postData = [];
        $postData['assessmentId']   = $request->paperId;
        $postData['teacherId']      = $request->teacherId;
        $contentType = "application/json-patch+json";
        $urlRoute = "publish.result";
        $responseType = 'json';
        $response = postCurl($contentType, $urlRoute,"", "", $postData);
        if($response->successful()) {
            return response()->json(['status' => true]);
        } else {
            return response()->json(['status' => false]);
        }
    }

    public function sortStudentList(Request $request) {
        $sessionData = session()->get('submittedStudentList');
        $studentData = [];
        foreach ($request['studentLists'] as $key => $studentid) {
            foreach ($sessionData as $key => $data) {
                if($data['profile']['id'] == $studentid) {
                    array_push($studentData, $data);
                }
            }
        }
        $request->session()->put('submittedStudentList', $studentData);
        $request->session()->put('studentSortOrder', ["sortBy" => $request['sortBy'], "orderBy" => $request['orderBy']]);
        return json_encode(['response' => 'success']);
    }

    public function gradeAll(Request $request) {
        $contentType = "application/json";
        $urlRoute = 'grade.all.api';
        $response = patchCurl($contentType, $urlRoute, '', 'json', $request->all());
        if($response) {
            return response()->json(['status'=>true, 'msg' => __('grading.allGradedSuccess')]);
        } else {
            return response()->json(['status'=>false, 'msg' => __('grading.allGradedfailed')]);
        }

    }

    public function gradingFeedback(Request $request) {
        return view('teachers.pages.grading.feedback');
    }
    
    public function studentListUrl(Request $request) {
        $data = [];
        $status = false;
        if(session::has('submittedStudentList')) {
            $status = true;
            $data['studentList'] = session::get('submittedStudentList');
            $data['paperId'] = $request->paperId;
        }
        $htmlView = view('teachers.pages.grading.ajax.studentList', $data)->render();
        return response()->json(['status' => $status, 'html' => $htmlView]);
    }

    public function classList(Request $request) {
        $data['classList'] = json_decode($request->classList, true);
        $data['assessmentId'] = $request->assessmentId;
        $htmlView = view('teachers.pages.grading.ajax.classList', $data)->render();
        return response()->json(['html' => $htmlView]);
    }

    private function getStudentList($students) {
        $data = [];
        $submittedCount = 0;
        $gradedCount = 0;
        $draftCount = 0;
        if(isset($students)) {
            foreach ($students as $key => $student) {
                $data['total'][$key] = $student;
                $data['total'][$key]['button'] = __('teachers.grading.disabled');
                $data['total'][$key]['status'] = __('teachers.grading.due');
    
                if($student['responseStatus'] == config('constants.submitted')) {
                    // Graded
                    if($student['gradingStatus'] == config('constants.graded')) {
                        $data['graded'][$gradedCount] = $student;                    
                        $data['graded'][$gradedCount]['button'] = $data['total'][$key]['button'] = __('teachers.grading.graded');
                        $data['graded'][$gradedCount]['status'] = $data['total'][$key]['status'] = __('teachers.grading.graded');
                        $gradedCount++;
                    }
    
                    /* Ungraded */
                    if($student['gradingStatus'] == config('constants.due') || $student['gradingStatus'] == config('constants.overDue')) {
                        $data['submitted'][$submittedCount] = $student;                    
                        $data['submitted'][$submittedCount]['button'] = $data['total'][$key]['button'] = __('teachers.grading.grade');
                        $data['submitted'][$submittedCount]['status'] = $data['total'][$key]['status'] = __('teachers.grading.due');
                        $submittedCount ++;
                    }
    
                    // Drafted
                    if($student['gradingStatus'] == config('constants.draft')) {
                        $data['draft'][$draftCount] = $student;
                        $data['draft'][$draftCount]['button'] = $data['total'][$key]['button'] = __('teachers.grading.grade');
                        $data['draft'][$draftCount]['status'] = $data['total'][$key]['status'] = __('teachers.grading.draft');
                        $draftCount++;
                    }
                }
    
                /* Upcoming Response Status */
                if($student['responseStatus'] == config('constants.upComing')) {
                    $data['total'][$key]['button'] = __('teachers.grading.disabled');
                    $data['total'][$key]['status'] = __('teachers.grading.upComing');
                }
    
                /* InProgress Response Status */
                if($student['responseStatus'] == config('constants.inProgress')) {
                    $data['total'][$key]['button'] = __('teachers.grading.grade');
                    $data['total'][$key]['status'] = __('teachers.grading.due');
                }
    
                /* Absent & Draft */
                if($student['responseStatus'] == config('constants.absent')) {
                    
                    if($student['gradingStatus'] == config('constants.due') || $student['gradingStatus'] == config('constants.overDue')) {
                        $data['total'][$key]['button'] =  __('teachers.grading.grade');
                        $data['total'][$key]['status'] = __('teachers.grading.missed');
                    }

                    if($student['gradingStatus'] == config('constants.graded')) {
                        $data['graded'][$gradedCount] = $student;
                        $data['graded'][$gradedCount]['button'] = $data['total'][$key]['button'] = __('teachers.grading.graded');
                        $data['graded'][$gradedCount]['status'] = $data['total'][$key]['status'] = __('teachers.grading.graded');
                        $gradedCount++;
                    }

                    if($student['gradingStatus'] == config('constants.draft')){
                        $data['draft'][$draftCount] = $student;
                        $data['draft'][$draftCount]['button'] = $data['total'][$key]['button'] = __('teachers.grading.grade');
                        $data['draft'][$draftCount]['status'] = $data['total'][$key]['status'] = __('teachers.grading.draft');
                        $draftCount++;
                    }
                }
    
            }
        }
        return $data['total'];
    }

}
