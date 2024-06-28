<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\GoogleAPIController;
use URL;
use Config;

class Teachers extends Model
{
    // public static $timeout;
    // public static $longTimeOut;

    public function __construct() {
        if(strpos(url()->current(), 'localhost') !== false) {
			URL::forceScheme('https');
		}
		
        // self::$timeout = config('constants.CacheTimeOut');
        // self::$longTimeOut = config('constants.CacheStoreTimeOut');
    }

	static function getGradingAssessments() {
        $myGrading =  getCurl('get.grading.assessments', '',["teacherId" => getStudentUserId() ]);
        if($myGrading->successful()){
            return $myGrading->json();
        }        
    }

    static function getGradeStudents($paperId) {
        $myGrading =  getCurl('get.student.response.status', '',["paperId" => $paperId, "teacherId" => getStudentUserId() ]);
        if($myGrading->successful()){
            return $myGrading->json();
        }
    }

    static function getStudentReport() {
        $report =  getCurl('get.student.report', '', []);
        if($report->successful()){
            return $report->json();
        }
    }

    static function getAssessmentReport($assessmentId="", $classId=""){
        $param = ["AssessmentId" => $assessmentId, "TeacherId" => getStudentUserId(), "ClassRoomId" => $classId];
        $assessmentReport =  getCurl('get.assessment.report', '', $param);
        if($assessmentReport->successful()) {
            return $assessmentReport->json();
        } 
        if($assessmentReport->failed()) {
            return false;
        }
    }

}
