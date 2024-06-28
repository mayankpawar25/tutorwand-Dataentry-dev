<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BoardReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $groupEventId="", $boardGradeId="")
    {
        $data = [];
        list($boardId, $gradeId) = explode('_', base64_decode($boardGradeId));
        $postData = [];
        $postData['EventId'] = base64_decode($groupEventId);
        $postData['studentId'] = getStudentUserId();
        $postData['GradeId'] = $gradeId;
        $postData['BoardId'] = $boardId;
        $data = getCurl('api.subject.assessment', 'json', $postData);
        if($data == 500) {
            return abort('500');
        }
        if(isset($data['board'])){
            $totalMaxMarks = 0;
            $obtainMaxMarks = 0;
            if(isset($data['assessmentPerformanceMatrix']) && !empty($data['assessmentPerformanceMatrix'])) {
                foreach($data['assessmentPerformanceMatrix'] as $assment) {
                    if($assment['isAttempted']) {
                        $totalMaxMarks += $assment['totalMark'];
                        $obtainMaxMarks += $assment['optainedMark'];
                    }
                }
            }
            $data['totalMaxMarks'] = $totalMaxMarks;
            $data['obtainMaxMarks'] = $obtainMaxMarks;
            return view('students.pages.boardReport.index', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function subjectReport(Request $request, $assessmentId="")
    {
        $postData = [];
        $postData['AssessmentId'] = base64_decode($assessmentId);
        $postData['UserId'] = getStudentUserId();
        $response = getCurl('api.global.student.assessment.reporting', 'json', $postData);
        if($response == 500 || $response == false) {
            return abort(500);
        }
        $data = $response;
        $data['assessmentName'] = $response['studentAssessment']['assessmentName'];
        $data['resultDate'] = $response['studentAssessment']['submittedOn'];
        $data['questionPDFUrl'] = route('get.question.pdf', $response['studentAssessment']['assessmentId']);;        
        return view('students.pages.boardReport.subject', $data);
    }
}