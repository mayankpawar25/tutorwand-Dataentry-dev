<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Questions;
use Illuminate\Http\Request;
use Cache;

class DashboardController extends Controller
{
    public function index() {
        $data = [];
        return view('students.pages.dashboard.index', $data);
    }

    public function ajaxClassroom(Request $request){
        $status = false;
        $data = [];
        if (!Cache::has(getStudentUserId() . ':courseStudents') || Cache::get(getStudentUserId() . ':courseStudents') == null) {
            $getClassList = Questions::assigneeList("false");
        } else {
            $getClassList = Cache::get(getStudentUserId() . ':courseStudents');
        }
        $data['classList'] = $getClassList;
        if(!empty($getClassList)) { $status = true; }
        $html = view('students.pages.dashboard.ajax.classList', $data)->render();
        return response()->json(['status' => $status, 'html' => $html]);
    }

    public function ajaxAssessmentList(Request $request) {
        $data = [];
        $todayDueCount = 0;
        $resultCount = 0;
        $postData['studentId'] = getStudentUserId();
        $status = false;
        $gradingData = getCurl('studentQuestionPaper', $responseType = 'json', $postData);
        if(isset($gradingData['assessments'])) {
            $assessments = getStudentAssessments($gradingData['assessments']);
            if(isset($assessments['NotStarted']) && !empty($assessments['NotStarted'])) {
                foreach ($assessments['NotStarted'] as $key => $assessment) {
                    $oldDate = strtotime(localTimeZone($assessment['header']['dueByDateTime']));
                    $newDate = date('M j, Y', $oldDate);
                    $diff = date_diff(date_create($newDate), date_create(date("M j, Y")));
                    if((int)($diff->format('%R%a')) == 0 && $todayDueCount < 3) {
                        $data['todayDue'][] = $assessment;
                        $todayDueCount++;
                    }
                }
            }
            if(isset($assessments['Submitted']) && !empty($assessments['Submitted'])) {
                foreach ($assessments['Submitted'] as $key => $assessment) {
                    if($assessment['gradedMarks'] > 0 && $resultCount < 3) {
                        $data['result'][] = $assessment;
                        $resultCount++;
                    }
                }
            }
            $status = true;
        }

        $todayDue = view('students.pages.dashboard.ajax.todayDue', $data)->render();
        $resultData = view('students.pages.dashboard.ajax.previousDue', $data)->render();

        return response()->json(['status' => $status, 'todayDue' => $todayDue, 'previousDue' => $resultData]);

    }

}
