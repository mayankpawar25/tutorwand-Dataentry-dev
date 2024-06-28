<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $timeOut = 0;
    private $longTimeOut = 0;

    public function __construct () {
        $this->timeout = config('constants.CacheTimeOut');
        $this->longTimeOut = config('constants.CacheStoreTimeOut');
    }
    
    public function index(Request $request) {
        $data = [];
        $previouslyCreated = Questions::previouslyCreated();
        $data['previouslyCreated'] = $previouslyCreated;
        if(Cache::has(getStudentUserId() . ':globalEvents')) {
            $data['globalEvents'] = Cache::get(getStudentUserId() . ':globalEvents');
        } else {
            Questions::getTeachersFastTrackConfig();
            $data['globalEvents'] = Cache::get(getStudentUserId() . ':globalEvents');
        }
        $reassignKey = [];
        if (! empty($previouslyCreated['assignments'])) {
            foreach ($previouslyCreated['assignments'] as $paperKey => $paperData) {
                $reassignKey[$paperData['paperId']] = $paperData;
            }
        }
        session()->put('oldQuestionHeader', $reassignKey);
        return view('teachers.pages.assignment.index', $data);
    }

    public function reviewPaper(Request $request, $paperId) {
        $paperId = base64_decode($paperId);
        $data = [];
        $headerData = session()->get('oldQuestionHeader');
        $data['canvasData'] = Questions::getOldPaper($paperId);
        if (isset($headerData[$paperId]) && ! empty($headerData[$paperId])) {
            $data['canvasData']['board'] = $headerData[$paperId]['board'];
            $data['canvasData']['grade'] = $headerData[$paperId]['grade'];
            $data['canvasData']['subject'] = $headerData[$paperId]['subject'];
            $data['canvasData']['maximumMarks'] = $headerData[$paperId]['maximumMarks'];
            $data['canvasData']['testDuration'] = $headerData[$paperId]['testDuration'];

            $data['restrictResult'] = 'false';
            $allowedUntimed = [config("constants.longQuesId"), config("constants.shortQuesId")];
            if(isset($data['canvasData']['formatModels'])) {
                foreach ($data['canvasData']['formatModels'] as $key => $questionFormat) {
                    if(in_array($questionFormat['questionTypeId'], $allowedUntimed)) {
                        $data['restrictResult'] = 'true';
                    }
                }
            }
            return view('teachers.pages.assignment.paper', $data);
        }
        abort(404);
    }

    public function getCourseStudentList(Request $request) {
        try {
            $res = [];
            if (!Cache::has(getStudentUserId() . ':courseStudents') || Cache::get(getStudentUserId() . ':courseStudents') == null) {
                $res = Questions::assigneeList();
            } else {
                $res = Cache::get(getStudentUserId() . ':courseStudents');
            }
            if (!empty($res)) {
                Cache::put(getStudentUserId() . ':courseStudents', $res);
                return "true"; 
            } else {
                return "false";
            }
        } catch (\Throwable $th) {
            return $th;
        }
		
    }

}
