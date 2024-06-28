<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teachers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\Questions;

class ReportController extends Controller
{

    /**
     * Report Home Page
     * classList Data
     */
    public function home(Request $request) {
        $data = [];
        return view('teachers.pages.report.home', $data);
    }

    public function ajaxHome(Request $request){
        $status = false;
        $data = [];
        $getClassList = getClassList();
        /* Re-Arrange Google ClassRoom Data */
        $data['classList'] = $getClassList;
        $data['globalClassList'] = Cache::get(getStudentUserId() . ':globalClassList');
        if(!empty($getClassList)) { 
            $status = true; 
        }

        $html = view('teachers.pages.report.ajax.home', $data)->render();
        return response()->json(['status' => $status, 'html' => $html, 'eventClass' => ""]);
    }

    // Scenario 1
    public function index(Request $request, $googleClassRoomId="") {
        $data = [];
        list($classRoomId, $assessmentId, $studentId) = explode('_', base64_decode($googleClassRoomId));

        /* Request Body */
        $postData = [];
        $postData['isTeacher'] = "true";
        $postData['ClassRoomId'] = $classRoomId;
        $postData['AssessmentId'] = $assessmentId;
        $postData['StudentId'] = $studentId;
        $postData['TeacherId'] = getStudentUserId();
        $urlRoute = "student.assessment.report";
        $responseType= "json";
        $studentAssessmentReport = getCurl($urlRoute, $responseType, $postData);

        /* Request Body */
        if(Cache::has($classRoomId . '_assessment_report')) {
            $assessmentReport = Cache::get($classRoomId . '_assessment_report');
        } else {
            $assessmentReport = Teachers::getAssessmentReport($assessmentId, $classRoomId);
        }
        $data['assessmentReport'] = $assessmentReport;
        $data['assessmentReport']['totalStudent']  = $assessmentReport['performance']['totalStudent'];
        $data['assessmentReport']['totalAttemptedStudent'] = $assessmentReport['performance']['attemptedStudent'];
        if(!empty($studentAssessmentReport) && $studentAssessmentReport != 500) {
            $data['studentAssessmentReport'] = $studentAssessmentReport;
            $data['assessmentName'] = $studentAssessmentReport['assessment']['assessmentName'];
            $data['submittedOn'] = $studentAssessmentReport['assessment']['submittedOn'];
            $data['questionPDFUrl'] = route('get.question.pdf', $studentAssessmentReport['assessment']['assessmentId']);
            return view('teachers.pages.report.studentAssessment', $data);
        }
        abort(503);
    }

    // Scenario 2
    public function assessment(Request $request, $urlData = "") {
        if($urlData) {
            $urlArr = base64_decode($urlData);
            list($assessmentId, $classId) = explode('_', $urlArr);
            $data = Teachers::getAssessmentReport($assessmentId, $classId);
            if($data) {
                /* Get Data From classList Cache */
                $data['resultDate']     = $data['assessment']['resultDate'];
                $data['assessmentName'] = $data['assessment']['assessmentName'];
                $data['questionPDFUrl'] = route('get.question.pdf', $data['assessment']['assessmentId']);

                $data['classRoomId']    = $data['performance']['classRoomId'];
                $data['classRoomName']  = $data['performance']['classRoomName'];

                $totalStudent           = $data['performance']['totalStudent'];
                $totalAttemptedStudent  = $data['performance']['attemptedStudent'];
                $data['totalStudent']   = $totalStudent;
                $data['totalAttemptedStudent'] = $totalAttemptedStudent;
                $assessmentPoints = $data['performance']['maximumMarks'];

                /* Average Marks & Time Calculations */
                $totalAttemptedDurations = 0;
                $totalAttemptedPoints = 0;
                $totalStudents = 0;
                foreach ($data['students'] as $key => $studentData) {
                    $data['students'][$key]['totalPointPercentage'] = $studentData['obtaionedMarks'];
                    if(isset($data['performance']['maximumMarks']) && $data['performance']['maximumMarks'] > 0) {
                        $data['students'][$key]['totalPointPercentage'] = ($studentData['obtaionedMarks'] * 100) / $data['performance']['maximumMarks'];
                    }
                    $data['students'][$key]['totalTimePercentage'] = ($studentData['timeTaken'] / 60);
                    if(isset($data['performance']['maximumExamDuration']) && $data['performance']['maximumExamDuration'] > 0){
                        $data['students'][$key]['totalTimePercentage'] = (($studentData['timeTaken']/60) * 100) / $data['performance']['maximumExamDuration'];
                    }
                    $totalAttemptedDurations    += $studentData['timeTaken'] / 60;
                    $totalAttemptedPoints       += $studentData['obtaionedMarks'];
                    if($studentData['isAttempted']){
                        $totalStudents++;
                    }
                }
                $data['assessmentDurations'] = $data['performance']['maximumExamDuration'];
                $data['averageTimeDuration'] = convertTimeFormat($data['performance']['averageExamDuration']);
                $data['assessmentPoints'] = $assessmentPoints;
                $data['averagePoints'] = $totalStudents > 0 ? $totalAttemptedPoints / $totalStudents : 0;
                Cache::put($data['performance']['classRoomId'] . "_assessment_report" , $data , config('constants.CacheStoreTimeOut'));

                /* Assessment Marks & Time Calculations */
                return view('teachers.pages.report2.index', $data);
            }
        }
        abort('404');
    }

    // Scenerio 3
    public function report3(Request $request, $studentGoogleClassRoomData = ""){
        if($studentGoogleClassRoomData){
            $data = [];
            $googleClassRoomId = base64_decode($studentGoogleClassRoomData);
            $searchData = explode('_', $googleClassRoomId);
            list($userId, $ClassRoomId, $BoardId, $GradeId, $SubjectId) = $searchData;
            
            if(Cache::has(getStudentUserId().$ClassRoomId."_classReportBySubject")) {
                $classReportBySubject = Cache::get(getStudentUserId().$ClassRoomId."_classReportBySubject");
            } else {
                /* Sending Curl Data */
                $postData = [];
                $postData['TeacherId'] = getStudentUserId();
                $postData['ClassRoomId'] = $ClassRoomId;
                $postData['Board.BoardId'] = $BoardId;
                $postData['Grade.GradeId'] = $GradeId;
                $postData['Subject.SubjectId'] = $SubjectId;
                $classReportBySubject = getClassReportBySubject($postData);
            }

            $data['classReportBySubject'] = $classReportBySubject;
            if(isset($classReportBySubject['students']) && !empty($classReportBySubject['students'])) {
                foreach ($classReportBySubject['students'] as $key => $student) {
                    if($student['studentId'] == $userId) {
                        $data['studentData'] = $student;
                    }
                }
            }

            $postData = [];
            $postData['IsTeacher'] = "true";
            $postData['TeacherId'] = getStudentUserId();
            $postData['StudentId'] = $data['StudentId'] = $userId;
            $postData['ClassRoomId'] = $data['ClassRoomId'] = $ClassRoomId;
            $postData['Board.BoardId'] = $data['BoardId'] = $BoardId;
            $postData['Grade.GradeId'] = $data['GradeId'] = $GradeId;
            $postData['Subject.SubjectId'] = $data['SubjectId'] = $SubjectId;
            $urlRoute = 'student.report.by.subject';
            $responseType = 'json';
            $studentReportBySubject = getCurl($urlRoute, $responseType, $postData);
            if(is_array($studentReportBySubject) && ($studentReportBySubject != 500 || $studentReportBySubject != false)) {
                $data['studentReportBySubject'] = $studentReportBySubject;
                Cache::put(getStudentUserId() .$ClassRoomId. '_studentReportBySubject', $studentReportBySubject, config('constants.CacheStoreTimeOut'));
                return view('teachers.pages.report3.index',$data);
            }
        }
        abort('503');
    }

    // Scenerio 4
    public function report4(Request $request, $googleClassRoomData = ""){
        $data = [];
        if($googleClassRoomData){
            $googleClassRoomId = base64_decode($googleClassRoomData);
            $searchData = explode('_', $googleClassRoomId);
            list($ClassRoomId, $BoardId, $GradeId, $SubjectId) = $searchData;

            /* All Class Data */
            /* Get Data From classList Cache */
            if(Cache::has(getStudentUserId() . ':classListTeacher')){
                $allPublishedData = Cache::get(getStudentUserId() . ':classListTeacher');
            } else {
                $allPublishedData = getClassList();
            }
            $courseData = "";
            foreach($allPublishedData as $fetchData) {
                if($fetchData['id'] == $googleClassRoomId) {
                    $courseData = $fetchData;
                }
            }
            $data = $courseData;

            $data['encryptedId'] = $ClassRoomId.'_'.$BoardId.'_'.$GradeId.'_'.$SubjectId;
            /* Class Report By Subject */

            if(Cache::has(getStudentUserId().$ClassRoomId."_classReportBySubject")) {
                $classReportBySubject = Cache::get(getStudentUserId().$ClassRoomId."_classReportBySubject");
            } else {
                /* Sending Curl Data */
                $postData = [];
                $postData['TeacherId'] = getStudentUserId();
                $postData['ClassRoomId'] = $ClassRoomId;
                $postData['Board.BoardId'] = $BoardId;
                $postData['Grade.GradeId'] = $GradeId;
                $postData['Subject.SubjectId'] = $SubjectId;
                $classReportBySubject = getClassReportBySubject($postData);
            }

            /* Class Report By Subject */
            if($classReportBySubject !== 500) {
                $data['classReportBySubject'] = $classReportBySubject;
                $data['ClassRoomId'] = $ClassRoomId;
                return view('teachers.pages.report4.index', $data);
            }
        }
        abort(503);
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
