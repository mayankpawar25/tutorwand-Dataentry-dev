<?php

use App\Models\Teachers;

use App\Models\Questions;

use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Session;

function getTemplateName($key) {
    $uid = config('constants.ownerId');
    if(Session::has('profile')) {
        $uid = Session::get('profile')["userId"];
    }
    if(!Cache::has($uid.':questionTypes')){
        $questionType = Http::withHeaders(getAADHeader())->get(route('swagger.ingestion.filters'));
        if($questionType->successful()){
            $response = $questionType->json();
            $data = $response['questionTypes'];
            Cache::put($uid.':questionTypes',  $response['questionTypes'], $seconds = 600);
        }  

    } else {
        $data = Cache::get($uid.':questionTypes');
    }
    foreach($data as $type){
        if($type['questionTypeId'] == $key) {
            return $type['questionTypeName'];
        }

    }
    return false;
}

function postCurl($contentType, $urlRoute, $body, $responseType = 'json', $param=null) {
    if(strpos(url()->current(), 'localhost') !== false) {
        \URL::forceScheme('https');
    }
    if( $param == null ) {
        $url = route($urlRoute);
        $resp =  Http::withHeaders(getAADHeader())->withBody($body, $contentType)->post($url);
    } else {
        $url = route($urlRoute, $param);
        $resp =  Http::withHeaders(getAADHeader())->post($url);
    }
    if(empty($responseType)) {
        return $resp;
    }
    if($resp->successful()){
        return $resp->$responseType();
    }
    if($resp->failed()){
        return $resp->$responseType();
    }
    return $resp;
}

function postCurlHeader($contentType, $urlRoute, $header, $responseType = 'json', $param=null) {
    if(strpos(url()->current(), 'localhost') !== false) {
        \URL::forceScheme('https');
    }
    if( $param == null ) {
        $url = route($urlRoute);
    } else {
        $url = route($urlRoute) . '?' . $param;



    }



    



    $headerArr = getAADHeader();



    if(!empty($header) && isset($header)) {



        foreach ($header as $key => $head) {



            $headerArr[$key] = $head;



        }



    }



    $resp =  Http::withHeaders($headerArr)



                ->post($url);



    if(empty($responseType)) {



        return $resp;



    }



    if($resp->successful()){



        return $resp->$responseType();



    }



    return $resp;



}







function postCurlWithoutJson($contentType, $urlRoute, $body, $responseType = 'json') {



    if(strpos(url()->current(), 'localhost') !== false) {



        \URL::forceScheme('https');



    }



    $url = route($urlRoute);



    $resp =  Http::withHeaders(getAADHeader())->withBody($body, $contentType)->post($url);



    if($resp->successful()){



        return $resp;



    }



    return $resp;



}







function postCurlWithMedia($contentType, $urlRoute, $body, $param, $responseType = 'json', $questionNumber = "") {



    if(strpos(url()->current(), 'localhost') !== false) {



        \URL::forceScheme('https');



    }



    if(!empty($param)) {



        $url = route($urlRoute) . '?PaperId='.$param['PaperId'].'&QuestionId='.$param['QuestionId'].'&StudentId='.$param['StudentId'].'&IsGlobalUpload='.$param['IsGlobalUpload'];



    } else {



        $url = route($urlRoute);



    }







    $response = Http::withHeaders(getAADHeader())->accept('multipart/form-data');



    foreach ($body['Files'] as $key => $value) {



        $extension = $value->getClientOriginalExtension();



        $filePath = $value->path();



        $fileData = fopen($filePath, 'r');



        $response = $response->attach('Files', $fileData, $value->getClientOriginalName());



    }



    $resp = $response->post($url);



    if($resp->successful()){



        return ['Success' => $resp->$responseType()];



    } else {



        return ['failure' => $resp->json()];



    }



    return $resp;



}







function postCurlWitGlobalhMedia($urlRoute, $fileData, $param){



    if(strpos(url()->current(), 'localhost') !== false) {



        \URL::forceScheme('https');



    }



    $url = route($urlRoute, $param);



    $response = Http::withHeaders(getAADHeader())->accept('multipart/form-data');



    foreach ($fileData as $key => $file) {



        $filePath = $file->path();



        $fileData = fopen($filePath, 'r');



        $response = $response->attach('Files', $fileData, $file->getClientOriginalName());



    }



    $curlResponse = $response->post($url);



    if($curlResponse->successful()){



        return $curlResponse->json();



    } else {



        return false;



    }



}







function patchCurl($contentType, $urlRoute, $body, $responseType = 'json', $param='') {



    if(strpos(url()->current(), 'localhost') !== false) {



        \URL::forceScheme('https');



    }



    if(!empty($param)) {



        $url = route($urlRoute, $param);



    } else {



        $url = route($urlRoute);



    }



    if($body == ''){



        $resp =  Http::withHeaders(getAADHeader())->patch($url);



    } else {



        $resp =  Http::withHeaders(getAADHeader())->withBody($body, $contentType)->patch($url);



    }



    if($resp->successful()){



        return $resp->$responseType();



    }



    return $resp;



}







function getCurl($urlRoute, $responseType = 'json', $data=null) {



    if(strpos(url()->current(), 'localhost') !== false) {



        \URL::forceScheme('https');



    }



    if($data != null) {



        $url = route($urlRoute, $data);



    } else {



        $url = route($urlRoute);



    }



    $resp =  Http::withHeaders(getAADHeader())->get($url);



    if($responseType == '') {



        return $resp;



    }







    if($resp->status() == 500) {



       return $resp->status();



    }



    



    if($resp->successful()) {



        return $resp->$responseType();



    }







    return false;



}







function getCurlSendHeader($urlRoute, $responseType = 'json', $header=[], $data=null) {



    if(strpos(url()->current(), 'localhost') !== false) {



        // \URL::forceScheme('https');



    }



    if($data == null) {



        $url = route($urlRoute);



    } else {



        $url = route($urlRoute, $data);



    }



    $resp =  Http::withHeaders(getAADHeader())



                ->get($url);



    if($responseType == '') {



        return $resp;



    }



    if($resp->successful()){



        return $resp->$responseType();



    }



    return false;



}







function putCurl($urlRoute, $data, $responseType="json") {



    if(strpos(url()->current(), 'localhost') !== false) {



        \URL::forceScheme('https');



    }



    if(is_array($data)){



        $url = route($urlRoute, $data);



    } else {



        $url = route($urlRoute);



    }



    $resp = Http::withHeaders(getAADHeader())->put($url);



    if($responseType == ""){



        return $resp;



    }



    if($resp->successful()){



        return $resp->$responseType();



    }



    return false;



}







function deleteCurl($contentType, $urlRoute, $body, $responseType = 'json') {



    if(strpos(url()->current(), 'localhost') !== false) {



        \URL::forceScheme('https');



    }



    $url = route($urlRoute);



    $resp = Http::withHeaders(["Content-Type" => $contentType, 'Authorization' => 'Bearer ' . GetAADBearer(), "Ocp-Apim-Subscription-Key" => config('constants.apimSubKey'), "Ocp-Apim-Trace" => true])->delete($url, $body);



    if($resp->successful()){



        return true;



    }



    return $resp->json();



}







function createBoardStructure($data) {



    $boardArr = [];



    $gradeArr = [];



    $subjectArr = [];



    $topicArr = [];



    $oldNode = 0;



    if(isset($data['boards']) && !empty($data['boards'])) {



        foreach ($data['boards'] as $key => $board) {



            array_push($boardArr, ['boardId' => $board['boardId'], 'boardName' => $board['boardName']]);



        }



    }



    return $boardArr;



}







function getGrades($boardId) {



    $uid = config('constants.ownerId');



    if(Session::has('profile')) {



        $uid = Session::get('profile')["userId"];



    }



    if(!Cache::has($uid.':dropDownFilterData') || Cache::get($uid.':dropDownFilterData') == null) {



        $dropDownData = Questions::getQuestionDropdownData();



        Cache::put($uid.':dropDownFilterData',$dropDownData, config('constants.CacheStoreTimeOut'));



    } else {



        $dropDownData =  Cache::get($uid.':dropDownFilterData');



    }



    $gradeArr = [];



    foreach ($dropDownData['boards'] as $key => $boardData) {



        if($boardData['boardId'] == $boardId) {



            foreach ($boardData['grades'] as $key => $grade) {



                array_push($gradeArr, ["id" => $grade["gradeId"], "name" => $grade["gradeName"]]);



            }



            break;



        }



    }



    return $gradeArr;



}







function getSubject($boardId, $gradeId) {



    $uid = config('constants.ownerId');



    if(Session::has('profile')) {



        $uid = Session::get('profile')["userId"];



    }



    if(!Cache::has($uid.':dropDownFilterData') || Cache::get($uid.':dropDownFilterData') == null) {



        $dropDownData = Questions::getQuestionDropdownData();



        Cache::put($uid.':dropDownFilterData',$dropDownData, config('constants.CacheStoreTimeOut'));



    } else {



        $dropDownData =  Cache::get($uid.':dropDownFilterData');



    }



    $subjectArr = [];



    foreach ($dropDownData['boards'] as $key => $boardData) {



        if($boardData['boardId'] == $boardId) {



            foreach ($boardData['grades'] as $key => $grade) {



                if($grade['gradeId'] == $gradeId) {



                    foreach ($grade['subjects'] as $key => $subject) {



                        array_push($subjectArr, ["id" => $subject["topicId"], "name" => $subject["topicName"]]);



                    }



                    break;



                }



            }



        }



    }



    return $subjectArr;



}







function getTopics($boardId, $gradeId, $subjectId) {



    $uid = config('constants.ownerId');



    if(Session::has('profile')) {



        $uid = Session::get('profile')["userId"];



    }



    if(!Cache::has($uid.':dropDownFilterData') || Cache::get($uid.':dropDownFilterData') == null) {



        $dropDownData = Questions::getQuestionDropdownData();



        Cache::put($uid.':dropDownFilterData',$dropDownData, config('constants.CacheStoreTimeOut'));



    } else {



        $dropDownData =  Cache::get($uid.':dropDownFilterData');



    }



    $topicArr = [];



    foreach ($dropDownData['boards'] as $key => $boardData) {



        if($boardData['boardId'] == $boardId) {



            foreach ($boardData['grades'] as $key => $grade) {



                if($grade['gradeId'] == $gradeId) {



                    $oldSubjectId = '';



                    foreach ($grade['subjects'] as $key => $subject) {



                        if($subject['topicId'] == $subjectId) {



                            foreach($subject['topics'] as $topic){



                                array_push($topicArr, ["id" => $topic["topicId"], "name" => $topic["topicName"], "topics" => $topic['subTopics']]);



                            }



                            break;



                        }



                    }



                }



            }



        }



    }



    return $topicArr;



}







function getSubTopics($boardId, $gradeId, $subjectId, $topicId){



    $uid = config('constants.ownerId');



    if(Session::has('profile')) {



        $uid = Session::get('profile')["userId"];



    }



    if(!Cache::has($uid.':dropDownFilterData') || Cache::get($uid.':dropDownFilterData') == null) {



        $dropDownData = Questions::getQuestionDropdownData();



        Cache::put($uid.':dropDownFilterData',$dropDownData, config('constants.CacheStoreTimeOut'));



    } else {



        $dropDownData =  Cache::get($uid.':dropDownFilterData');



    }



    $topicArr = [];



    foreach ($dropDownData['boards'] as $key => $boardData) {



        if($boardData['boardId'] == $boardId) {



            foreach ($boardData['grades'] as $key => $grade) {



                if($grade['gradeId'] == $gradeId) {



                    $oldSubjectId = '';



                    foreach ($grade['subjects'] as $key => $subject) {



                        if($subject['topicId'] == $subjectId) {



                            foreach($subject['topics'] as $topic){



                                if($topic['topicId'] == $topicId){



                                    foreach($topic['subTopics'] as $subtopic){



                                        array_push($topicArr, ["id" => $subtopic["topicId"], "name" => $subtopic["topicName"]]);



                                    }



                                    break;



                                }



                            }



                        }



                    }



                }



            }



        }



    }



    return $topicArr;



}







function getFormatStructure($formatId) {



    $data = Questions::getTeachersFastTrackConfig();



    foreach($data['savedQuestionTemplate'] as $type){



        if($type['id'] == $formatId) {



            return $type;



        }



    }



    return false;



}







function getQuestionTypeById($id) {



    $fastTrackData = getCurl('get.fastTrackConfiguration', 'json'); 



    $data = $fastTrackData['questionTypes'];



    foreach($data as $type){



        if($type['questionTypeId'] == $id) {



            return $type['questionTypeName'];



        }



    }



    return false;



}







function encryptBlobUrl($textString){



    $search = config('constants.blobUrl');



    $replace = "{{blobUrl}}";



    return str_replace($search, $replace, $textString);



}







function decryptBlobUrl($textString){



    $search = "{{blobUrl}}";



    $replace = config('constants.blobUrl');



    return str_replace($search, $replace, $textString);



}







function decryptBlobData($arrayData){



    $search = "{{blobUrl}}";



    $replace = config('constants.blobUrl');



    $arrayData['questionText'] = str_replace($search, $replace, removeSpace($arrayData['questionText']));



    if(isset($arrayData['answerBlock']['answer']) && !empty($arrayData['answerBlock']['answer'])) {



        $arrayData['answerBlock']['answer'] = str_replace($search, $replace, removeSpace($arrayData['answerBlock']['answer']));



    }



    if(isset($arrayData['answerBlock']['hint']) && !empty($arrayData['answerBlock']['hint'])) {



        $arrayData['answerBlock']['hint'] = str_replace($search, $replace, removeSpace($arrayData['answerBlock']['hint']));



    }



    if(isset($arrayData['answerBlock']['extendedSolution']) && !empty($arrayData['answerBlock']['extendedSolution'])) {



        $arrayData['answerBlock']['extendedSolution'] = str_replace($search, $replace, removeSpace($arrayData['answerBlock']['extendedSolution']));



    }



    if(isset($arrayData['answerBlock']['options']) && !empty($arrayData['answerBlock']['options'])){



        foreach ($arrayData['answerBlock']['options'] as $optionKey => $option) {



            $arrayData['answerBlock']['options'][$optionKey]['optionText'] = str_replace($search, $replace, removeSpace($option['optionText']));



        }



    }



    if(isset($arrayData['options']) && !empty($arrayData['options'])){



        foreach ($arrayData['options'] as $optionKey => $option) {



            $arrayData['options'][$optionKey]['optionText'] = str_replace($search, $replace, removeSpace($option['optionText']));



        }



    }







    if(isset($arrayData['answer']['options']) && !empty($arrayData['answer']['options'])){



        foreach ($arrayData['answer']['options'] as $optionKey => $option) {



            $arrayData['answer']['options'][$optionKey]['optionText'] = str_replace($search, $replace, removeSpace($option['optionText']));



        }



    }







    if(isset($arrayData['solution']['options']) && !empty($arrayData['solution']['options'])){



        foreach ($arrayData['solution']['options'] as $optionKey => $option) {



            $arrayData['solution']['options'][$optionKey]['optionText'] = str_replace($search, $replace, removeSpace($option['optionText']));



        }



    }







    if(isset($arrayData['answer']['answer']) && !empty($arrayData['answer']['answer'])){



        $arrayData['answer']['answer'] = str_replace($search, $replace, removeSpace($arrayData['answer']['answer']));



    }



    if(isset($arrayData['solution']['answer']) && !empty($arrayData['solution']['answer'])){



        $arrayData['solution']['answer'] = str_replace($search, $replace, removeSpace($arrayData['solution']['answer']));



    }



    return $arrayData;



}







function encryptBlobData($arrayData){



    $search = config('constants.blobUrl');



    $replace = "{{blobUrl}}";



    $arrayData['questionText'] = str_replace($search, $replace, removeSpace($arrayData['questionText']));







    if(isset($arrayData['answerBlock']['answer']) && !empty($arrayData['answerBlock']['answer'])) {



        $arrayData['answerBlock']['answer'] = str_replace($search, $replace, removeSpace($arrayData['answerBlock']['answer']));



    }



    if(isset($arrayData['answerBlock']['hint']) && !empty($arrayData['answerBlock']['hint'])) {



        $arrayData['answerBlock']['hint'] = str_replace($search, $replace, removeSpace($arrayData['answerBlock']['hint']));



    }



    if(isset($arrayData['answerBlock']['extendedSolution']) && !empty($arrayData['answerBlock']['extendedSolution'])) {



        $arrayData['answerBlock']['extendedSolution'] = str_replace($search, $replace, removeSpace($arrayData['answerBlock']['extendedSolution']));



    }







    if(!empty($arrayData['answerBlock']['options'])){



        foreach ($arrayData['answerBlock']['options'] as $optionKey => $option) {



            $arrayData['answerBlock']['options'][$optionKey]['optionText'] = str_replace($search, $replace, removeSpace($option['optionText']));



        }



    }



    return $arrayData;



}







function getEnvironment(){



    if(strpos(config('constants.ExtAPIUrl'), 'magicband-dev-api') !== false ){



        return '<span style="margin-top: 20px;color: #f00;display: inline-block;">Test Enviroment</span>';



    }



}







function createQuestion($contentType, $urlRoute, $body){



    if(strpos(url()->current(), 'localhost') !== false) {



        \URL::forceScheme('https');



    }



    $url = route($urlRoute);



    $resp =  Http::withHeaders(getAADHeader())->withBody($body, $contentType)->post($url);



    return $resp;



}







function updateQuestion($contentType, $urlRoute, $body){



    if(strpos(url()->current(), 'localhost') !== false) {



        \URL::forceScheme('https');



    }



    $url = route($urlRoute);



    $resp =  Http::withHeaders(getAADHeader())->withBody($body, $contentType)->patch($url);



    return $resp;



}







function uploadCkeditorImage($urlRoute,$fileData, $fileName) {



    if(strpos(url()->current(), 'localhost') !== false) {



        \URL::forceScheme('https');



    }



    $url = route($urlRoute);



    $resp =  Http::withHeaders(getAADHeader())->accept('multipart/form-data')->attach('file', $fileData, $fileName)->post($url);



    return $resp;   



}







function getStudentUserId() {



    $profile = session()->get('profile');



    return isset($profile['userId']) ? $profile['userId'] : "" ;



}







function getStudentUserEmail() {



    $profile = session()->get('profile');



    return isset($profile['emailId']) ? $profile['emailId'] : "" ;



}







function getStudentName(){



    $profile = session()->get('profile');



    $firstName = isset($profile['firstName']) ? $profile['firstName'] : "" ;



    $lastName = isset($profile['lastName']) ? $profile['lastName'] : "" ;



    return $firstName." ".$lastName;



}







function getStudentProfileImage(){



    $profile = session()->get('profile');



    $image = isset($profile['profilePicUrl']) ? handleProfilePic($profile['profilePicUrl']) : asset('assets/images/teachers/user-icon.jpg');



    return $image;



}







function getStudentAssessments($assessments){



    $dataArray = [];



    foreach($assessments as $assessment){



        if($assessment['examStatus'] == "Submitted" || $assessment['examStatus'] == 'TimeOver'){



            $dataArray['Submitted'][] = $assessment;



        }



        if($assessment['examStatus'] == "NotStarted" || $assessment['examStatus'] == "InProgress"){



            $dataArray['NotStarted'][] = $assessment;



        }



        if($assessment['examStatus'] == "UpComing"){



            $dataArray['UpComing'][] = $assessment;



        }



        if($assessment['examStatus'] == "Expired" || $assessment['examStatus'] == "Absent"){



            $dataArray['Expired'][] = $assessment;



        }



    }



    // Sort the array 



    if(isset($dataArray['NotStarted']) && !empty($dataArray['NotStarted'])) {



        usort($dataArray['NotStarted'], 'studentDueDateCompare');



    }



    Cache::put(getStudentUserId() .':assessments', $assessments, config('constants.CacheStoreTimeOut'));



    return $dataArray;



}







function getRemainingTime($dateTime, $returnType=''){



    $date1 = strtotime($dateTime); 



    $date2 = time(); 



      



    // Formulate the Difference between two dates



    $diff = abs($date2 - $date1);







    $years = floor($diff / (365*60*60*24)); 



                                                          



                                                          



    // To get the month, subtract it with years and



    // divide the resultant date into



    // total seconds in a month (30*60*60*24)



    $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 



      



      



    // To get the day, subtract it with years and 



    // months and divide the resultant date into



    // total seconds in a days (60*60*24)



    $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));



      



    // To get the hour, subtract it with years, 



    // months & seconds and divide the resultant



    // date into total seconds in a hours (60*60)



    $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)



                                       / (60*60)); 



      



      



    // To get the minutes, subtract it with years,



    // months, seconds and hours and divide the 



    // resultant date into total seconds i.e. 60



    $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 



                              - $hours*60*60)/ 60); 



    switch ($returnType) {



        case 'days':



            if($days > 0){



                return $days;



            } else {



                return false;



            }



            break;



        case 'hours':



            if($days > 0){



                return $days;



            } else {



                return false;



            }



            break;



        case 'minutes':



            if($days > 0){



                return $days;



            } else {



                return false;



            }



            break;



        



        default:



            if($days > 0){



                return ['days' => $days];



            }







            if($hours > 0){



                return ['hours' => $hours];



            }







            if($minutes > 0){



                return ['minutes' => $minutes];



            }



            break;



    }











    return false;



}







function handleProfilePic($url) {



    $profileData = explode('//', $url);



    return "https://" . end($profileData);



}







function removeSpace($textData){



    /* Remove space from question text */



    $textData = trim($textData);



    $textData = preg_replace("/\<p\>\&nbsp\;\<\/p\>/", "", $textData);



    $textData = preg_replace("/\<strong\>\&nbsp\;\<\/strong\>/", "", $textData);



    $textData = preg_replace("/\<p\>\&nbsp\;/", "</p>", $textData);



    return $textData;



}







function getNextUngradedStudent(){



    $gradeStudents = session()->get('submittedStudentList');



    if(!empty($gradeStudents)) {



        foreach($gradeStudents as $student) {



            if($student['responseStatus'] == config('constants.submitted') && $student['gradingStatus'] == config('constants.due')) {



                return $student['profile']['id'];



            }



            if($student['responseStatus'] == config('constants.submitted') && $student['gradingStatus'] == config('constants.draft')){



                return $student['profile']['id'];



            }



        }



    }



    return false;



}







function updateStudentGradingStatus($studentId, $gradingStatus) {



    $gradeStudents = session()->get('submittedStudentList');



    if(!empty($gradeStudents)){



        foreach($gradeStudents as $keyVal => $student) {



            if($studentId == $student['profile']['id']) {



                $gradeStudents[$keyVal]['gradingStatus'] = $gradingStatus;



                $gradeStudents[$keyVal]['status'] = $gradingStatus;



            }



        }



    }



    session()->put('submittedStudentList', $gradeStudents);



    return true;



}







function pointText($point){



    return ($point > 1) ? __('teachers.assessment.pointsValue') : __('teachers.assessment.pointValue');



}







function getAdminUserId(){



    if(session()->has('user_session')){



        return session()->get('user_session')['userId'];



    }



    return false;



}







function utcToDateTime($date) {



    return date('d M Y h:i A', strtotime($date));



}







function utcToDate($date) {



    return date('d M Y', strtotime($date));



}







function utcToDateMonth($date) {



    return date('d M', strtotime($date));



}







function localTimeZone($date) {



    $timezone = 'Asia/Kolkata';



    if(isset($_COOKIE['timezoneOffset'])) {



        $timezone = timezone_name_from_abbr('', abs($_COOKIE['timezoneOffset']) * 60, false);



    }



    $dt = new DateTime($date);



    $tz = new DateTimeZone($timezone); // or whatever zone you're after



    $dt->setTimezone($tz);



    return $dt->format('d M Y h:i A');



}







function getClassReportBySubject($postData) {



    $urlRoute = 'class.report.by.subject';



    $responseType = 'json';



    $classReportBySubject = getCurl($urlRoute, $responseType, $postData);



    Cache::put(getStudentUserId()."_classReportBySubject", $classReportBySubject, config('constants.CacheStoreTimeOut'));



    return $classReportBySubject;



}







function getClassList() {



    $data = [];



    $rearrangeClassData = [];



    $rearrangeGlobalData = [];



    if (!Cache::has(getStudentUserId() . ':courseStudents') || Cache::get(getStudentUserId() . ':courseStudents') == null) {



        $classList = Questions::assigneeList();



    } else {



        $classList = Cache::get(getStudentUserId() . ':courseStudents');



    }







    /* Re-Arrange Google ClassRoom Data */



    $indexValue = 0;



    $globalIndexValue = 0;



    foreach($classList as $classData) {



        if(!empty($classData['globalClasses'])) {



            foreach($classData['globalClasses'] as $globalSubjectData) {



                $rearrangeGlobalData[$globalIndexValue]['assessmentId'] = $globalSubjectData['assessmentId'];



                $rearrangeGlobalData[$globalIndexValue]['googleClassroomId'] = $globalSubjectData['assessmentId'];



                $rearrangeGlobalData[$globalIndexValue]['googleClassroomName'] = $globalSubjectData['globalEventName'];



                $rearrangeGlobalData[$globalIndexValue]['students'] = isset($classData['students']) ? $classData['students'] : [];



                $rearrangeGlobalData[$globalIndexValue]['totalStudents'] = !empty($classData['students']) ? count($classData['students']) : 0;



                $rearrangeGlobalData[$globalIndexValue]['assessmentCount'] = $globalSubjectData['assessmentCount'];



                $rearrangeGlobalData[$globalIndexValue]['attemptedAssessmentCount'] = $globalSubjectData['attemptedAssessmentCount'];



                $rearrangeGlobalData[$globalIndexValue]['subjectData'] = $globalSubjectData;



                $rearrangeGlobalData[$globalIndexValue]['isGlobal'] = true;







                // The combination of GC Classroom + board + Grade + subject will create a unique card in Reporting Home screen.



                $rearrangeGlobalData[$globalIndexValue]['id'] = $classData['courseId'].'_'.$globalSubjectData['board']['id'].'_'.$globalSubjectData['grade']['id'].'_'.$globalSubjectData['subject']['id'];



                $globalIndexValue++;



            }



        }



        if(!empty($classData['mbClasses'])) {



            foreach($classData['mbClasses'] as $subjectData) {



                $rearrangeClassData[$indexValue]['googleClassroomId'] = $classData['courseId'];



                $rearrangeClassData[$indexValue]['googleClassroomName'] = $classData['courseName'];



                $rearrangeClassData[$indexValue]['students'] = isset($classData['students']) ? $classData['students'] : [];



                $rearrangeClassData[$indexValue]['totalStudents'] = !empty($classData['students']) ? count($classData['students']) : 0;



                $rearrangeClassData[$indexValue]['assessmentCount'] = $subjectData['assessmentCount'];



                $rearrangeClassData[$indexValue]['attemptedAssessmentCount'] = $subjectData['attemptedAssessmentCount'];



                $rearrangeClassData[$indexValue]['subjectData'] = $subjectData;



                $rearrangeClassData[$indexValue]['isGlobal'] = false;



                // The combination of GC Classroom + board + Grade + subject will create a unique card in Reporting Home screen.



                $rearrangeClassData[$indexValue]['id'] = $classData['courseId'].'_'.$subjectData['board']['id'].'_'.$subjectData['grade']['id'].'_'.$subjectData['subject']['id'];



                $indexValue++;



            }



        }



    }



    /* Re-Arrange Google ClassRoom Data */



    $data['classList'] = $rearrangeClassData;



    session()->put('classListTeacher', $rearrangeClassData);



    Cache::put(getStudentUserId() . ':globalClassList', $rearrangeGlobalData, config('constants.twoMinutes'));



    Cache::put(getStudentUserId() . ':classListTeacher', $data['classList'], config('constants.twoMinutes'));



    return $rearrangeClassData;



}







function starRatingKeys() {



    return ['5' => 'Amazing','4' => 'Good','3' => 'Average','2' => 'Not Good','1' => 'Bad' ];



}









function GetAADBearer() {
        $microsoftonlineUrl = config('constants.microsoftonlineUrl');
        $tenantId = config('constants.tenantId');
        $curlUrl = $microsoftonlineUrl . $tenantId.'/oauth2/token';

        $body = [
            'client_id' => config('constants.clientId'),
            'resource' => config('constants.resource'),
            'grant_type' => config('constants.grantType'),
            'client_secret' => config('constants.clientSecret')
        ];

        $headers = array(
            "Content-Type" => 'application/x-www-form-urlencoded',
            "Ocp-Apim-Subscription-Key" => config('constants.apimSubKey'),
            "Ocp-Apim-Trace" => true
        );

        if(!Cache::has(getStudentUserId() . ':access_token')) {
            /* Post Curl for token generate */
            $curl = curl_init();
            curl_setopt_array($curl, array(

                CURLOPT_URL => $curlUrl,

                CURLOPT_RETURNTRANSFER => true,

                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

                CURLOPT_CUSTOMREQUEST => 'POST',

                CURLOPT_POSTFIELDS => $body,

                CURLOPT_HTTPHEADER => $headers,

            ));
            $response = curl_exec($curl);
            curl_close($curl);


            /* Post Curl for token generate */

            $tokenData = json_decode($response, true);

            Cache::put(getStudentUserId() . ':access_token', $tokenData['access_token'], $tokenData['expires_in']);

            return $tokenData['access_token'];

        }

    return Cache::get(getStudentUserId() . ':access_token');
}

function convertTimeFormat($seconds) {
    $minutes = floor($seconds/60);
    $secondsleft = $seconds%60;
    if($minutes < 10){
        $minutes = '0'.$minutes;
    }

    if($secondsleft < 10) {



        $secondsleft = '0'.$secondsleft;



    }



    return $minutes.":".$secondsleft;



}







function mobileView() {



    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){



        return true;



    }



    return false;



}







function getAADHeader() {



    return ['Authorization' => 'Bearer ' . GetAADBearer(), "Ocp-Apim-Subscription-Key" => config('constants.apimSubKey'), "Ocp-Apim-Trace" => true];



}







// Comparison function



function dueDateCompare($element1, $element2) {



    $datetime1 = strtotime($element1['dueDateTime']);



    $datetime2 = strtotime($element2['dueDateTime']);



    return $datetime1 - $datetime2;



}







// Comparison function



function resultDateCompare($element1, $element2) {



    $datetime1 = strtotime($element2['resultDateTime']);



    $datetime2 = strtotime($element1['resultDateTime']);



    return $datetime1 - $datetime2;



}







// Comparison function



function studentResultDateCompare($element1, $element2) {



    $datetime1 = strtotime($element2['resultPublishedOn']);



    $datetime2 = strtotime($element1['resultPublishedOn']);



    return $datetime1 - $datetime2;



}







// Comparison function



function studentDueDateCompare($element1, $element2) {



    $datetime1 = strtotime($element1['header']['dueByDateTime']);



    $datetime2 = strtotime($element2['header']['dueByDateTime']);



    return $datetime1 - $datetime2;



}







// Comparison function



function studentCreationDateCompare($element1, $element2) {



    $datetime1 = strtotime($element2['header']['creationDate']);



    $datetime2 = strtotime($element1['header']['creationDate']);



    return $datetime1 - $datetime2;



}







function setKey($data, $keyValue, $textValue) {



    $newArray = [];



    if(is_array($data)) {



        foreach($data as $option) {



            $newArray[$option[$keyValue]] = $option[$textValue];



        }



    }



    return $newArray;



}







function dashboardClassList() {



    $data = [];



    $rearrangeClassData = [];



    $classList = Questions::assigneeList();



    $newArray = [];



    if(!empty($classList)) {



        foreach($classList as $dataKey => $class) {



            $newArray[$dataKey] = $class;



            $newArray[$dataKey]['googleClassroomId'] = $class['courseId'];



            $newArray[$dataKey]['googleClassroomName'] = $class['courseName'];



            $newArray[$dataKey]['students'] = isset($class['students']) ? $class['students'] : [];



            $newArray[$dataKey]['totalStudents'] = isset($class['students']) && !empty($class['students']) ? count($class['students']) : 0;



        }



        /* Re-Arrange Google ClassRoom Data */



        $data['classList'] = $newArray;



        session()->put('dashboardClassList', $newArray);



        Cache::put(getStudentUserId() . ':dashboardClassList', $newArray, config('constants.CacheStoreTimeOut'));



    }



    return $newArray;



}







function decimalHandler($value, $decimalPlace=2) {



    if(is_float($value)) {



        return round($value, $decimalPlace);



    } else {



        return $value;



    } 



}



?>



