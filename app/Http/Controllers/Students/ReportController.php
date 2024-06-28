<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Questions;
use App\Models\Students;
use Cache;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Report Home Page
     * classList Data
     */
    public function index(Request $request) {
        $data = [];
        return view('students.pages.report.index', $data);
    }

    public function ajaxHome(Request $request){
        $status = false;
        $data = [];
        $rearrangeClassData = [];
        $rearrangeGlobalClassData = [];
        if (!Cache::has(getStudentUserId() . ':courseStudentsSr') || Cache::get(getStudentUserId() . ':courseStudentsSr') == null) {
            $classList = Questions::studentAssigneeList("false");
        } else {
            $classList = Cache::get(getStudentUserId() . ':courseStudentsSr');
        }
        if(!empty($classList)){
            $totalAssessmentCount = 0;
            $totalAttemptedAssessmentCount = 0;
            foreach($classList as $classData) {
                if(!empty($classData['mbClasses'])) {
                    foreach($classData['mbClasses'] as $subjectData) {  
                        $dt['googleClassroomId'] = $classData['courseId'];
                        $dt['googleClassroomName'] = $classData['courseName'];
                        $dt['assessmentCount'] = $subjectData['assessmentCount'];
                        $dt['attemptedAssessmentCount'] = $subjectData['attemptedAssessmentCount'];
                        $dt['subjectData'] = $subjectData;
                        $dt['isGlobal'] = false;
                        // The combination of GC Classroom + board + Grade + subject will create a unique card in Reporting Home screen.
                        $dt['id'] = $classData['courseId'].'_'.$subjectData['board']['id'].'_'.$subjectData['grade']['id'].'_'.$subjectData['subject']['id'];
                        array_unshift($rearrangeClassData, $dt);
                    }
                }

                if (!empty($classData['globalClasses'])) {
                    foreach ($classData['globalClasses'] as $subjectData) {
                        $totalAssessmentCount = $totalAssessmentCount + $subjectData['assessmentCount'];
                        $totalAttemptedAssessmentCount = $totalAttemptedAssessmentCount + $subjectData['attemptedAssessmentCount'];
                        $dt['googleClassroomId'] = $classData['courseId'];
                        $dt['googleClassroomName'] = $subjectData['globalEventName'];
                        $dt['assessmentCount'] = $totalAssessmentCount;
                        $dt['attemptedAssessmentCount'] = $totalAttemptedAssessmentCount;
                        $dt['assessmentId'] = $subjectData['assessmentId'];
                        $dt['subjectData'] = $subjectData;
                        $dt['globalEventId'] = ($subjectData['globalEventId']) ? $subjectData['globalEventId'] : 'BKT_10_2021' ;
                        $dt['isGlobal'] = true;
                        // The combination of GC Classroom + board + Grade + subject will create a unique card in Reporting Home screen.
                        $dt['id'] = $subjectData['board']['id'] . '_' . $subjectData['grade']['id'];
                        array_push($rearrangeGlobalClassData, $dt);
                    }
                }
            }

            /* Re-Arrange Google ClassRoom Data */
            $data['classList'] = $rearrangeClassData;
            $data['globalClassList'] = !empty($rearrangeGlobalClassData) ? [end($rearrangeGlobalClassData)] : [];
            $request->session()->put('classList', $rearrangeClassData);
            if(!empty($rearrangeClassData)) { $status = true; }
            Cache::put(getStudentUserId() . ':classList', $data['classList'], config('constants.CacheStoreTimeOut'));
        }
        $html = view('students.pages.report.ajax.home', $data)->render();
        return response()->json(['status' => $status, 'html' => $html]);
    }

    // Scenerio 6
    public function classReport(Request $request, $googleClassRoomData = "") {
        $data = [];
        if($googleClassRoomData) {
            $googleClassRoomId = base64_decode($googleClassRoomData);
            $searchData = explode('_', $googleClassRoomId);
            list($ClassRoomId, $BoardId, $GradeId, $SubjectId) = $searchData;

            /* All Class Data */
            $allPublishedData = Cache::get(getStudentUserId() . ':classList');
            $courseData = [];
            if($allPublishedData) {
                foreach($allPublishedData as $fetchData) {
                    if($fetchData['id'] == $googleClassRoomId) {
                        $courseData = $fetchData;
                    }
                }
            }
            $data = $courseData;
            
            $data['ClassRoomId'] = $ClassRoomId;
            
            $data['studentData'] = session()->get('profile');

            /* Class Report By Subject */
            if(Cache::has(getStudentUserId() . '_' . $googleClassRoomData) && Cache::get(getStudentUserId() . '_' . $googleClassRoomData) != 500) {
                $classReportBySubject = Cache::get(getStudentUserId() . '_' . $googleClassRoomData);
            } else {
                /* Sending Curl Data */
                $postData = [];
                $postData['TeacherId'] = '';
                $postData['StudentId'] = getStudentUserId();
                $postData['isTeacherId'] = 'false';
                $postData['ClassRoomId'] = $ClassRoomId;
                $postData['Board.BoardId'] = $BoardId;
                $postData['Grade.GradeId'] = $GradeId;
                $postData['Subject.SubjectId'] = $SubjectId;
                $urlRoute = 'student.report.by.subject';
                $responseType = 'json';
                $classReportBySubject = getCurl($urlRoute, $responseType, $postData);
                Cache::put(getStudentUserId() . '_' . $googleClassRoomData, $classReportBySubject, config('constants.CacheStoreTimeOut'));
            }
            if($classReportBySubject != 500){
                /* Student Report By Subject */
                $data['studentReportBySubject'] = $classReportBySubject;
                return view('students.pages.report.report6', $data);
            }
        }
        abort(503);
    }

    // Scenerio 5
    public function studentReport(Request $request, $googleClassRoomData = ""){
        $data = [];
        list($assessmentId, $classRoomId) = explode('_', base64_decode($googleClassRoomData));

        $postData = [];
        $postData['ClassRoomId'] = $classRoomId;
        $postData['AssessmentId'] = $assessmentId;
        $postData['StudentId'] = getStudentUserId();
        $postData['TeacherId'] = "";
        $postData['IsTeacher'] = "false";
        $urlRoute = "student.assessment.report"; 

        $responseType= "json";
        $studentAssessmentReport = getCurl($urlRoute, $responseType, $postData);
        if($studentAssessmentReport != 500 && $studentAssessmentReport != false) {
            $data['studentAssessmentReport'] = $studentAssessmentReport;
            $data['assessmentReport']['totalStudent'] = 0;
            $data['assessmentReport']['attemptedStudentCount'] = $studentAssessmentReport['performance']['attemptedStudentCount'];
            $data['assessmentName'] = $studentAssessmentReport['assessment']['assessmentName'];
            $data['resultDate'] = $studentAssessmentReport['assessment']['submittedOn'];
            $data['questionPDFUrl'] = route('get.question.pdf', $studentAssessmentReport['assessment']['assessmentId']);
            return view('students.pages.report.report5', $data);
        }
        abort(503);
    }
     // Report result
     public function studentResult(Request $request, $questionPaperId = "") {
        $data = [];
        $questionPaperId = base64_decode($questionPaperId);

        if(Cache::has(getStudentUserId() .':assessments')) {
            $assessmentLists = Cache::get(getStudentUserId() .':assessments');
        } else {
            $postData['studentId'] = getStudentUserId();
            $list = getCurl('studentQuestionPaper', $responseType = 'json', $postData);
            $assessmentLists = $list['assessments'];
        }
        if(!empty($assessmentLists)) {
            $assessmentKey = array_search($questionPaperId, array_column($assessmentLists, 'id'));
            $questionData =  $assessmentLists[$assessmentKey]; // question paper Data
            
            /* Student Response with Solutions */
            $postData = [];
            $postData['StudentId'] = getStudentUserId();
            $postData['AssessmentId'] = $questionPaperId;
            $gradingData = getCurl('api.reporting.student.report', 'json', $postData);
            /* Student Response with Solutions */

            /** Grading response data */
            $data['studentResponse'] = $gradingData;
            $totalTakenTimeDuration = isset($gradingData['totalTimeTakenToSubmitExam']) ? $gradingData['totalTimeTakenToSubmitExam'] : 0;
            $maxDuration = $questionData['header']['testDuration'];
            $maxMarks = 0;
            $obtainedMarks = 0;
            $takenDuration = 0;
            if(isset($gradingData['responses']) && !empty($gradingData['responses'])) {
                foreach($gradingData['responses'] as $response) {
                    $maxMarks += isset($response['answer']['maximumMarks']) ? $response['answer']['maximumMarks'] : 0;
                    $obtainedMarks += isset($response['answer']['gradedMarks']) ? $response['answer']['gradedMarks'] : 0;
                    $takenDuration += isset($response['timeSpent']) ? $response['timeSpent'] : 0;
                }
            }
            /** Grading response data */

            /** Question paper set header data */
            $boardName = "";
            $gradeName = "";
            $subjectName = "";
            if(isset($questionData['header']) && !empty($questionData['header'])) {
                $boardName = isset($questionData['header']['board']['boardName']) ? $questionData['header']['board']['boardName'] : "";
                $gradeName = isset($questionData['header']['class']['gradeName']) ? $questionData['header']['class']['gradeName'] : "";
                $subjectName = isset($questionData['header']['subject']['subjectName']) ? $questionData['header']['subject']['subjectName'] : "";
            }
            $data['boardName'] = $boardName;
            $data['gradeName'] = $gradeName;
            $data['subjectName'] = $subjectName;
            $data['maxMarks'] = $maxMarks;
            $data['maxDuration'] = $maxDuration;
            $data['obtainedMarks'] = $obtainedMarks;
            if($totalTakenTimeDuration > 0) {
                $data['takenDuration'] = $totalTakenTimeDuration;
            } else {
                $data['takenDuration'] = $takenDuration;
            }
            $data['profile'] = session()->get('profile');
            $data['questionPDFUrl'] = route('get.question.pdf', $questionPaperId);
            $data['assessmentName'] = isset($questionData['assessmentName']) ? ucwords($questionData['assessmentName']) : '';
            $data['resultDate'] = utcToDate(date('d-m-Y', time()));
            /** Question paper set header data */
            if($gradingData == 500) {
                abort(500);
            }
            return view('students.pages.report.report-result', $data);
        }
        $message = ['message' => __("students.notifications.resultUnavailable")];
        return (new HomeController)->unAuthoriseStudent($message);
    }
    // Answer Sheet
    public function answerSheet(Request $request) {
        $data['ResponseId'] = $request['responseId'];
        $data['StudentId'] = $request['studentId'];
        $data['PaperId'] = $request['paperId'];

        $response = getCurl('get.student.response.solution', 'json', $data);
        if($response) {
            $data['studentResponse'] = $response;
            return view('teachers.pages.report.ajax.answerSheet', $data);
        } else {
            return view('errors.503');
        }
    }

}
