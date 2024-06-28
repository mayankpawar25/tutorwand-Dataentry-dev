<?php

namespace App\Http\Controllers\Teacher;

use App\Models\Teachers;
use App\Models\Questions;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Session;

class DashboardController extends Controller
{
    public function index() {
        $status = false;
        $data = [];
        if(Cache::has(getStudentUserId() . ':globalEvents')) {
            $data['globalEvents'] = Cache::get(getStudentUserId() . ':globalEvents');
        } else {
            Questions::getTeachersFastTrackConfig();
            $data['globalEvents'] = Cache::get(getStudentUserId() . ':globalEvents');
        }
        return view('teachers.pages.dashboard.index', $data);
    }

    public function ajaxClassroom(Request $request){
        $status = false;
        $data = [];
        /* Re-Arrange Google ClassRoom Data */
        $data['classList'] = dashboardClassList();
        if(!empty($data['classList'])) { 
            $status = true; 
        }
        $html = view('teachers.pages.dashboard.ajax.classList', $data)->render();
        return response()->json(['status' => $status, 'html' => $html]);
    }

    public function ajaxAssessmentList(Request $request) {
        $data = [];
        $gradingData = Teachers::getGradingAssessments();
        $todayDueCount = 0;
        $previousDueCount = 0;
        $status = false;
        if($gradingData) {
            if(isset($gradingData['assessments']) && !empty($gradingData['assessments'])) {
                foreach ($gradingData['assessments'] as $key => $assessments) {
                    if(!$assessments['isResultPublished']) {
                        $oldDate = strtotime(localTimeZone($assessments['dueDateTime']));
                        $newDate = date('M j, Y', $oldDate);
                        $diff = date_diff(date_create($newDate), date_create(date("M j, Y")));
                        if((int)($diff->format('%R%a')) == 0 && $todayDueCount < 3) {
                            $data['todayDue'][] = $assessments;
                            $todayDueCount++;
                        }
                        if((int)($diff->format('%R%a')) > 0 && $previousDueCount < 3) {
                            $data['previousDue'][] = $assessments;
                            $previousDueCount++;
                        }
                    }
                }
                $status = true;
            }
        }

        $todayDue = view('teachers.pages.dashboard.ajax.todayDue', $data)->render();
        $previousDue = view('teachers.pages.dashboard.ajax.previousDue', $data)->render();

        return response()->json(['status' => $status, 'todayDue' => $todayDue, 'previousDue' => $previousDue]);
    }

    public function refreshClassList() {
        $getClassList = dashboardClassList();
        $data['classList'] = $getClassList;
        $status = false; 
        if(!empty($getClassList)) { 
            $status = true; 
        }
        $html = view('teachers.pages.dashboard.ajax.classList', $data)->render();
        return response()->json(['status' => $status, 'html' => $html]);
    }
}
