<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use URL;
use CURLFILE;

class Students extends Model
{   
    static function getStudentsFastTrackConfig(){
        $data = [];
        if(! Cache::get(Session::get('profile')['userId'] . ':questionTypes') || Cache::get(Session::get('profile')['userId'] . ':questionTypes') == null) {
            $fastTrackData = getCurl('get.fastTrackConfiguration', 'json'); 
            $data['questionTypes'] = $fastTrackData['questionTypes'];
            Cache::put(Session::get('profile')['userId'] . ':questionTypes',  $fastTrackData['questionTypes'], config('constants.CacheStoreTimeOut'));
        } else {
            $data['questionTypes'] = Cache::get(Session::get('profile')['userId'] . ':questionTypes');
        }
        return $data;
    }

    static function getStudent($questionPaperId = "", $studentId = "") {
        
        if($studentId==""){
            $studentId = Session::get('profile')['userId'];
        }
        $myQuestion = getCurl('get.getQuestionPaper', 'json', ["questionPaperId" => $questionPaperId, "studentId" => $studentId]);
        if($myQuestion){
            return $myQuestion;
        }
        return false;
    }

    static function uploadFile($files, $paperId, $questionId, $studentId, $globalUpload="false", $questionNumber = "") {
        $url = 'post.upload.file';
        $body = [];
        foreach($files as $file){
            $fileMime   = $file->getMimeType();
            $extension  = $file->getClientOriginalExtension();
            $fileName   = str_replace(" ", "_", $file->getClientOriginalName()).'_Q'.$questionNumber .'.' . $extension;
            $file->name = $fileName;
            $body['Files'][] = $file;
        }

        $param = [
                    'PaperId' => $paperId, 
                    'QuestionId' => $questionId, 
                    'StudentId' => $studentId, 
                    'IsGlobalUpload' => $globalUpload,
                ];

        $resp = postCurlWithMedia('multipart/form-data', $url, $body, $param, 'json', $questionNumber);
        if(isset($resp['Success']) && !empty($resp['Success'])) {
            return $resp['Success'];
        }
        if(isset($resp['failure']) && !empty($resp['failure'])) {
            return $resp['failure'];
        }
        return $resp;
    }

    static function removeFile($body) {
        $url = 'post.remove.file';
        $contentType = "application/json-patch+json";
        return deleteCurl($contentType, $url, $body, 'json');
    }

    static function uploadGlobalFile($files, $paperId, $studentId, $IsGlobalUpload="false", $questionId = ""){
        $url = 'post.upload.file';
        $body = [];
        $param = [
            'PaperId' => $paperId, 
            'StudentId' => $studentId, 
            'IsGlobalUpload' => $IsGlobalUpload,
        ];
        if($questionId !=""){
            $param['QuestionId'] = $questionId;
        }
        foreach($files as $key => $file){
            $fileMime   = $file->getMimeType();
            $extension  = $file->getClientOriginalExtension();
            if($extension == ""){
                $extension = "png";
            }
            $fileName   = $studentId.'_G_'.rand(000,999).'.' . $extension;
            $file->name = $fileName;
            $fileData[] = $file;
        }
        return postCurlWitGlobalhMedia($url, $fileData, $param);
    }

    static function clearExamQuestion($data) {
		if(strpos(url()->current(), 'localhost') !== false) {
			URL::forceScheme('https');
		}
        $url = 'clear.question';
        $contentType = "application/json-patch+json";
        $responseType = "body";
        $param = "studentId=$data[studentId]&paperId=$data[paperId]&questionId=$data[questionId]";
        $body = '';
        $resp = patchCurl($contentType, $url, $body, $responseType = 'body', $param);
        if($resp){
            return $resp;
        }
        return false;
    }
}
?>