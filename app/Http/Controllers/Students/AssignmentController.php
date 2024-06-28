<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    private $timeOut = 0;
    private $longTimeOut = 0;

    /**
     * Students Assignment constructor
     */
    public function __construct () {
        $this->timeout = config('constants.CacheTimeOut');
        $this->longTimeOut = config('constants.CacheStoreTimeOut');
    }

    /**
     * Students Assignment dashboard
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request) {
        $data = [];

        $postData['studentId'] = getStudentUserId();

        $data['studentQuestionPaper'] = getCurl('studentQuestionPaper', $responseType = 'json', $postData);

        $data['assessments'] = [];

        if(isset($data['studentQuestionPaper']['assessments'])) {

            $data['assessments'] = getStudentAssessments($data['studentQuestionPaper']['assessments']);

        }
        return view('students.pages.assessment.index', $data);
    }
}
