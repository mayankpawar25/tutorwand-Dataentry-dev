<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cache;
class ClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('teachers.pages.class.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('teachers.pages.class.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request['ownerId'] = getStudentUserId();
        $postData = json_encode($request->all());
        $response = postCurl('application/json-patch+json', 'create.classroom', $postData);
        $status = false;
        $responseData = $response;
        $message = __('teachers.class.classCreateSuccessInvitationFailed');
        if ($response['error'] == null && $response['errorCode'] == null) {
            $status = true;
            $responseData = $response;
            $message = __('teachers.class.classCreateSuccess');
        } else if($response['id'] == null) {
            $responseData = $response;
            $message = $this->errorGCRMsg($response['errorCode']);
        }
        return response()->json(['status' => $status, 'response' => $responseData, 'message' => $message]);
    }

    public function errorGCRMsg($errorCode) {
        switch ($errorCode) {
            case '-2146233088':
                $msg = sprintf(__('teachers.class.classRoomError1'), config('constants.googleClassroomUrl'));
                break;
            
            default:
                $msg = __('teachers.class.classCreateFailure');
                break;
        }
        return $msg;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $data = [];
        $data['classRoomId'] = $id;
        $postData = [];
        $postData['classId'] = $id;
        $postData['teacherId'] = getStudentUserId();
        $URLroute = "class.student.lists";
        if(!Cache::has(getStudentUserId() . 'classStudentList:' . $id)) {
            $response = getCurl($URLroute, $responseType = 'json', $postData);
            if($response != 500) {
                $data['responseData'] = $response;
                Cache::put(getStudentUserId() . 'classStudentList:' . $id, $response, config('constants.CacheStoreTimeOut'));
            }
        } else {
            $responseData = Cache::get(getStudentUserId() . 'classStudentList:' . $id);
            $data['responseData'] = $responseData;
        }
        if(isset($data['responseData']) && !empty($data['responseData'])) {
            $data['inviteUrl'] = $data['responseData']['alternateLink'] . '?cjc=' . $data['responseData']['enrollmentCode'];
            return view('teachers.pages.class.view', $data);
        } else {
            abort('500');
        }
    }

    public function refreshClass($id) {
        $postData = [];
        $data = [];
        $data['classRoomId'] = $id;
        $postData['classId'] = $id;
        $postData['teacherId'] = getStudentUserId();
        $URLroute = "class.student.lists";
        $response = getCurl($URLroute, $responseType = 'json', $postData);
        if($response != 500) {
            $data['responseData'] = $response;
            Cache::put(getStudentUserId() . 'classStudentList:' . $id, $response, config('constants.CacheStoreTimeOut'));
            $data['inviteUrl'] = $data['responseData']['alternateLink'] . '?cjc=' . $data['responseData']['enrollmentCode'];
            $html = view('teachers.pages.class.ajax.classView', $data)->render();
            $message = "";
            if($response['status'] == "DECLINED") {
                $message = __('teachers.class.classActivationDeclined');
            }
            return response()->json(['status' => true, 'html' => $html, 'declined' => $message]);
        }
        return response()->json(['status' => false]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('teachers.pages.class.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $postData = json_encode($request->all());
        $response = patchCurl('application/json-patch+json', 'invite.students', $postData);
        $message = "";
        $status = false;
        $infoStatus = "info";
        if (isset($response['classId']) && !empty($response['studentInvitationResponseMap'])) {
            $responseData = $response;
            $status = true;
            $invitedStudent = 0;
            $invalidStudent = 0;
            $duplicateStudent = 0;
            $loggedId = 0;
            $emailId = "";
            $duplicateIds = "";
            $loggedIds = "";
            foreach ($response['studentInvitationResponseMap'] as $stdKey => $stdValue) {
                if($stdValue == 'Successful') {
                    $invitedStudent++;
                } else if($stdValue == 'Requested entity already exists') {
                    $duplicateStudent++;
                    $duplicateIds .= $request['students'][$stdKey]['emailId'].' ';
                }  else if($stdValue == 'Precondition check failed.'){
                    $loggedId++;
                    $loggedIds .= $request['students'][$stdKey]['emailId'].' ';
                } else {
                    $invalidStudent++;
                    $emailId .= $request['students'][$stdKey]['emailId'].' ';
                }
            }
            if($invitedStudent > 0) {
                $message .= "<p>". __('teachers.class.studentInvite') .": ".$invitedStudent."</p>";
            }

            if($loggedId > 0) {
                $message .= "<p>". __('teachers.class.loggedInUser') .": ".$loggedIds."</p>";
            }

            if($duplicateStudent > 0) {
                $message .= "<p>". __('teachers.class.alreadyExist') .": ".$duplicateIds."</p>";
            }

            if($invalidStudent > 0) {
                $message .= "<p>". __('teachers.class.invalidEmail') .": ".$invalidStudent."</p>";
                $message .= $emailId;
            }
        } else {
            $infoStatus = "error";
            $responseData = $response->json();
        }
        return response()->json(['status' => $status, 'infoStatus' => $infoStatus, 'response' => $responseData, "message" => $message]);
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
