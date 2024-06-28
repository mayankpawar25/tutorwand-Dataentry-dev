<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cache;
use Hamcrest\Type\IsInteger;

class BoardReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($assessmentId)
    {
        $postData = [];
        $postData['AssessmentId'] = base64_decode($assessmentId);
        $postData['UserId'] = getStudentUserId();
        $response = Cache::get($assessmentId.'_'.getStudentUserId());
        if(!Cache::has($assessmentId.'_'.getStudentUserId())) {
            $response = getCurl('api.global.assessment.reporting', 'json', $postData);
            Cache::put($assessmentId.'_'.getStudentUserId(), $response, config('constants.twoMinutes'));
        }
        $data = $response;
        if($response == false || is_int($response)) {
            abort(500);
        }
        $data['assessmentName'] = $response['assessment']['assessmentName'];
        $data['resultDate'] = $response['assessment']['resultDate'];
        $data['questionPDFUrl'] = route('get.question.pdf', $response['assessment']['assessmentId']);
        return view('teachers.pages.boardReport.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function studentReport($globalStudentId)
    {
        list($assessmentId, $studentId) = explode("_", base64_decode($globalStudentId));

        $postData = [];
        $postData['AssessmentId'] = $assessmentId;
        $postData['UserId'] = $studentId;
        $response = Cache::get($globalStudentId);
        if(!Cache::has($globalStudentId)) {
            $response = getCurl('api.global.student.assessment.reporting', 'json', $postData);
            Cache::put($globalStudentId, $response, config('constants.twoMinutes'));
        }
        $data = $response;
        $data['assessmentName'] = $response['studentAssessment']['assessmentName'];
        $data['submittedOn'] = $response['studentAssessment']['submittedOn'];;
        $data['questionPDFUrl'] = route('get.question.pdf', $response['studentAssessment']['assessmentId']);;
        return view('teachers.pages.boardReport.student', $data);
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
    public function edit($id)
    {
        //
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
}
