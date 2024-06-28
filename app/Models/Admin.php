<?php



namespace App\Models;



use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\Session;

use URL;



class Admin extends Model

{



    static function getQuestionInjection($type = 'boards'){

        $data = [];

        $syllabusFilters = [];

        if(Cache::get('syllabusFilters')){

            $syllabusFilters = Cache::get('syllabusFilters');

        }

        if(isset($syllabusFilters['boards']) && $syllabusFilters['boards'] != null){

            $data = Cache::get('syllabusFilters');

        } else {

            $filterData  = Http::withHeaders(getAADHeader())->get(route("swagger.ingestion.filters"));

            $response = $filterData->json();

            $data['boards'] = [];

            $data['questionTypes'] = [];

            $data['questionDifficulties'] = [];

            if(isset($response['syllabus']) && !empty($response)){

                $data['boards'] = $response['syllabus']['boards'];

                $data['questionTypes'] = $response['questionTypes'];

                $data['questionDifficulties'] = $response['questionDifficulties'];

                Cache::put("syllabusFilters" , $data, $seconds = 6000);

                session()->put("syllabusFilters" , $data);

            }

        }

        return $data;

    }



    static function getQuestionTypes(){

        $data = [];

        if(Cache::get('questionTypes') && Cache::get('questionTypes') != null){

            $data = Cache::get('questionTypes');

        } else {

            $filterData  = Http::withHeaders(getAADHeader())->get(route("get.question.types"));

            $data = $filterData->json();

            Cache::put("questionTypes" , $data, $seconds = 6000);

        }

        return $data;

    }



    static function getGrades($boardId, $cacheVar = 'syllabusFilters') {

        if(!Cache:: get($cacheVar)) {

            $dropDownData = Admin::getQuestionInjection();

        } else {

            $dropDownData =  Cache::get($cacheVar);

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

    

    static function getSubject($boardId, $gradeId, $cacheVar = 'syllabusFilters') {

        if(!Cache:: get($cacheVar)) {

            $dropDownData = Admin::getQuestionInjection();

        } else {

            $dropDownData =  Cache::get($cacheVar);

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

    

    static function getTopics($boardId, $gradeId, $subjectId, $cacheVar = 'syllabusFilters') {

        if(!Cache:: get($cacheVar)) {

            $dropDownData = Admin::getQuestionInjection();

        } else {

            $dropDownData =  Cache::get($cacheVar);

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



    static function getSubTopics($boardId, $gradeId, $subjectId, $topicId, $cacheVar = 'syllabusFilters'){

        if(!Cache:: get($cacheVar)) {

            $dropDownData = Admin::getQuestionInjection();

        } else {

            $dropDownData =  Cache::get($cacheVar);

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



    static public function getReviewFilters(){

        $data = [];

        $reviewFilters = [];

        if(Cache::get('reviewFilters')){

            $reviewFilters = Cache::get('reviewFilters');

        }

        if(isset($reviewFilters['boards']) && $reviewFilters['boards'] != null){

            $data = Cache::get('reviewFilters');

        } else {

            $filterData  = Http::withHeaders(getAADHeader())->get(route("get.review.filters"));

            $response = $filterData->json();

            $data['boards'] = [];

            $data['questionTypes'] = [];

            $data['dataEntryUsers'] = [];

            $data['questionStatus'] = [];

            $data['questionDifficulties'] = [];

            if(!empty($response)){

                $data['boards'] = $response['syllabus']['boards'];

                $data['questionTypes'] = $response['questionTypes'];

                $data['dataEntryUsers'] = $response['dataEntryUsers'];

                $data['questionStatus'] = $response['questionStatus'];

                $data['questionDifficulties'] = $response['questionDifficulties'];

                Cache::put("reviewFilters" , $data, $seconds = 6000);

            }

        }

        return $data;

    }



    static public function getFilterBody($request) {

        $data = [];



        $data['questionId'] = ($request['questionId']) ? $request['questionId'] : "";

        $data['creatorId'] = ($request['creatorId']) ? $request['creatorId'] : "";

        $data['reviewerId'] = "MB0002";

        $data['statusId'] = ($request['statusId']) ? $request['statusId'] : "";

        $data['typeId'] = ($request['questionTypeId']) ? $request['questionTypeId'] : "";



        $data['boardId'] = isset($request['boardId']) ? $request['boardId'] : "";

        $data['gradeId'] = isset($request['gradeId']) ? $request['gradeId'] : "";

        $data['subjectId'] = isset($request['subjectId']) ? $request['subjectId'] : "";

        if(isset($request['difficultyLevel']) && !empty($request['difficultyLevel'])){
            $data['difficultyLevel'] = ($request['difficultyLevel']) ? $request['difficultyLevel'] : "";
        }

        $data['topicIds'] = isset($request['topicId']) ? [$request['topicId']] : [];

        $data['subTopicIds'] = isset($request['subTopicId']) ? [$request['subTopicId']] : [];



        $data['source']     = ($request['sourceUrl']) ? $request['sourceUrl'] : "";

        $data['fromDate']       = ($request['fromDate']) ? $request['fromDate'] : null;

        $data['toDate']     = ($request['toDate']) ? $request['toDate'] : null;

        $data['Parameter.QuestionNumber'] = isset($request['QuestionNumber']) ? $request['questionNumber'] : 1;

        $data['FetchCount'] = isset($request['QuestionNumber']) && $request['questionNumber'] > 1 ? "false" : "true";



        return $data;

    }



    static public function getQuestionTypeNameById($id, $cacheVar = 'syllabusFilters'){

        if(!Cache:: get($cacheVar)) {

            $dropDownData = Admin::getQuestionInjection();

        } else {

            $dropDownData =  Cache::get($cacheVar);

        }

        if(isset($dropDownData['questionTypes']) && !empty($dropDownData['questionTypes'])){

            foreach ($dropDownData['questionTypes'] as $key => $types) {

                if($types['questionTypeId'] == $id){

                    return $types['questionTypeName'];

                }

            }

        }

    }



    static function getSearchResultDashboard($data) {
        
		return getCurl('review.dashboard.count', 'json', $data);

    }

    static function getUsers($data){

        return getCurl('api.get.users', 'json', $data);

    }

    static function getTelemerty($data){
        return getCurl('api.get.telemetry', 'json', $data);
        // $resp = Http::withHeaders(getAADHeader())->get(route('api.get.telemetry', $data));
        // if($resp->successful()){
        //     return $resp->json();
        // }
        // return false;
    }

    static function getCouponList($data) {
        return getCurl('api.get.coupon', 'json', $data);
    }

    static function postCreateCoupon($data) {
        $contentType = "application/json-patch+json";
        $responseType = "json";
        $urlRoute = 'api.add.coupon';
        return postCurl($contentType, $urlRoute, $data, $responseType);
        
    }

}

