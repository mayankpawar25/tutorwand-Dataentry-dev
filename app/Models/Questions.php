<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\GoogleAPIController;
use URL;
use Config;

class Questions extends Model
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

	static function getTeachersFastTrackConfig() {
		try {
			$data = [];
			if(! Cache::get(getStudentUserId() . ':fastrack') || Cache::get(getStudentUserId() . ':fastrack') == null) {
				$fastTrackData = getCurl('get.fastTrackConfiguration', 'json');
				$data['questionTypes'] = $data['questionVariationTypes'] = $fastTrackData['questionTypes'];
				Cache::put(getStudentUserId() . ':fastrack',  $fastTrackData, config('constants.CacheStoreTimeOut'));
			} else {
				$fastTrackData = Cache::get(getStudentUserId() . ':fastrack');
				$data['questionTypes'] = $data['questionVariationTypes'] = Cache::get(getStudentUserId() . ':questionTypes');
			}
			Cache::put(getStudentUserId() . ':questionTypes',  $fastTrackData['questionTypes'], config('constants.CacheStoreTimeOut'));
			Cache::put(getStudentUserId() . ':syllabus',  $fastTrackData['syllabus'], config('constants.CacheStoreTimeOut'));
			Cache::put(getStudentUserId() . ':questionIssueTypes',  $fastTrackData['questionIssueTypes'], config('constants.CacheStoreTimeOut'));
			Cache::put(getStudentUserId() . ':questionDifficulties',  $fastTrackData['questionDifficulties'], config('constants.CacheStoreTimeOut'));
			Cache::put(getStudentUserId() . ':questionIssueTypes',  $fastTrackData['questionIssueTypes'], config('constants.CacheStoreTimeOut'));
			Cache::put(getStudentUserId() . ':globalEvents',  $fastTrackData['globalEvents'], config('constants.CacheStoreTimeOut'));

			$data['savedQuestionTemplate'] = [];
			$myTemplates = HTTP::withHeaders(getAADHeader())->get(route('get.my.templates', ["userId" => getStudentUserId() ]));
			if($myTemplates->successful()){
				$data['savedQuestionTemplate'] = $myTemplates->json();
				$data['lastUsedTemplate'] = Session::get('profile')['settings']['assignmentFormatIdToSelect'];
				Cache::put(getStudentUserId() . ':savedQuestionTemplate', $data['savedQuestionTemplate'], config('constants.CacheTimeOut'));
				Cache::put(getStudentUserId() . ':lastUsedTemplate',  $data['lastUsedTemplate'], config('constants.CacheTimeOut'));
			}
			return $data;
		} catch (\Throwable $th) {
			if(config('app.debug') == true){
                $data['message'] = $th->getMessage();
                $data['code'] = $th->getCode();
                $data['file'] = $th->getFile();
                $data['line'] = $th->getLine();
                if($th->getCode() == '0' || $th->getCode() == '500'){
                    $data['code'] = '500';
                }
                return view('errors.ajax.' . $data['code'], ['error' => $data]);
            }
		}
	}

	static function getQuestionDropdownData() {
		if(!Cache::has(getStudentUserId() . ':syllabus')) {
			Questions::getTeachersFastTrackConfig();
		}
		return Cache::get(getStudentUserId() . ':syllabus');
    }

    static function question_dropdown()
    {
		try {
			//code...
			$data = [];
			$data['questionTemplate'] = [];
			if (! Cache::get(getStudentUserId() . ':questionTemplate') || Cache::get(getStudentUserId() . ':questionTemplate') == null) {
				$defaultTemplates = HTTP::withHeaders(getAADHeader())->get(route('get.default.templates'));
				if($defaultTemplates->successful()){
					$datas = $defaultTemplates->json();
					$data['questionTemplate'] = $datas;
					Cache::put(getStudentUserId() . ':questionTemplate',  $datas, config('constants.CacheTimeOut'));
				}        
			} else {
				$data['questionTemplate'] = Cache::get(getStudentUserId() . ':questionTemplate');
			}
			
			$data['savedQuestionTemplate'] = [];
			$myTemplates = HTTP::withHeaders(getAADHeader())->get(route('get.my.templates', ["userId" => getStudentUserId() ]));
			if($myTemplates->successful()){
				$datas = $myTemplates->json();
				$data['savedQuestionTemplate'] = $datas['formats'];
				$data['lastUsedTemplate']      = $datas['formatIdToSelect'];
				Cache::put(getStudentUserId() . ':savedQuestionTemplate',  $datas['formats'], config('constants.CacheTimeOut'));
				Cache::put(getStudentUserId() . ':lastUsedTemplate',  $datas['formatIdToSelect'], config('constants.CacheTimeOut'));
			}

			$data['questionTypes'] = [];
			if (! Cache::get(getStudentUserId() . ':questionTypes') || Cache::get(getStudentUserId() . ':questionTypes') == null) {
				$questionType = HTTP::withHeaders(getAADHeader())->get(route('get.question.types'));
				if($questionType->successful()){
					$datas = $questionType->json();
					$data['questionTypes'] = $datas;
					Cache::put(getStudentUserId() . ':questionTypes',  $datas, $seconds = 600);
				}        
			} else {
				$data['questionTypes'] = Cache::get(getStudentUserId() . ':questionTypes');
			}
			return $data;
		} catch (\Throwable $th) {
			if(config('app.debug') == true){
                $data['message'] = $th->getMessage();
                $data['code'] = $th->getCode();
                $data['file'] = $th->getFile();
                $data['line'] = $th->getLine();
                if($th->getCode() == '0' || $th->getCode() == '500'){
                    $data['code'] = '500';
                }
                return view('errors.ajax.' . $data['code'], ['error' => $data]);
            }
		}
    }

    static function questionTemplate($status = true) {
		$data = [];
		if ($status) {
			$myTemplates =  getCurl('get.my.templates', '',["userId" => getStudentUserId() ]);
			if($myTemplates->successful()){
				$data = $myTemplates->json();
				Cache::put(getStudentUserId() . ':savedQuestionTemplate', $data, $seconds = 600);
			}        
		} else {
			$data = Cache::get(getStudentUserId() . ':savedQuestionTemplate');
		}
        return $data;
    }

    static function setQuestionTemplate($body) {
		if(strpos(url()->current(), 'localhost') !== false) {
			URL::forceScheme('https');
		}
        $url = 'post.template';
        $resp = postCurl('application/json-patch+json', $url, json_encode($body), 'body');
		if($resp){
            return json_decode($resp, true);
        }
        return false;
    }

    static function getQuestionFilters() {
        return json_encode([
            'M.P. Board',
            '12th','English',
            'TutorWand question bank with my question bank',
            'difficulty level- 1',
        ]);
    }

    static function createGetQuestionsBody($request) {
		$previousYear = false;
		if(isset($request['data']['previousYear']) && ($request['data']['previousYear'] != '' || $request['data']['previousYear'] != 'undefined')) {
			$previousYear = true;
		}

		$requestData = [
                        'assignmentFormatId' => $request['data']['selectedTemplateId'],
						'questionPaperName' => isset($request['data']['inputTitle']) ? $request['data']['inputTitle'] : '',
                        'questionFormats' => null,
                        'teacherId' => getStudentUserId(),
                        'difficultyLevel' => $request['data']['difficultyLevel'],
                        'boardId' => $request['data']['selectBoard'],
                        'gradeId' => $request['data']['selectGrade'],
                        'subjectId' => $request['data']['selectSubject'],
                        'topicIds' => explode(',', $request['data']['selectTopic']),
                        'subTopicIds' => explode(',', $request['data']['selectSubTopic']),
                        'isPreviousYearQuestionOnly' =>  $previousYear,
                    ];

        if( $request['data']['isSkip'] != "false" ) {
            $requestData['assignmentFormatId'] = 0;
            $requestData['assignmentName'] = "";
        }

        if( $request['data']['isModified'] != 0) {   
            foreach ($request['data']['questionFormats'] as $key => $format) {
                $requestData['questionFormats'][$key]['groupId'] = 0;
                $requestData['questionFormats'][$key]['questionTypeId'] = $format['questionTypeId'];
                $requestData['questionFormats'][$key]['numberOfQuestion'] = $format['numberOfQuestion'];
                $requestData['questionFormats'][$key]['weightage'] = $format['weightage'];
            }
        }
        switch ($request['data']['questionBank']) {
            case 'TutorWand':
                $questionBankId = 1;
                # code...
                break;

            case 'myQuestionBank':
                $questionBankId = 2;
                # code...
                break;

            case 'previousYearQuestionPaper':
                $questionBankId = 3;
                # code...
                break;
            
            default:
                $questionBankId = 1;
                break;
        }
        $requestData['questionBankId'] = $questionBankId;
		return $requestData;
    }

	static function createStudentsData($data) {
		$res = [];
		foreach ($data as $key => $value) {
			$res[$key]['courseId'] =$value['courseData']['id'];
			$res[$key]['courseName'] =$value['courseData']['name'];
			$res[$key]['room'] =$value['courseData']['room'];
			$res[$key]['description'] =$value['courseData']['description'];
			$res[$key]['descriptionHeading'] =$value['courseData']['descriptionHeading'];
			$res[$key]['ownerId'] =$value['courseData']['ownerId'];
			$res[$key]['status'] ="ACTIVE";
			foreach ($value['studentData']['students'] as $k => $student) {
				$res[$key]['students'][$k]['googleId'] = $student['userId'];
				$res[$key]['students'][$k]['mbId'] = 0;
				$res[$key]['students'][$k]['emailId'] = $student['profile']['emailAddress'];
				$res[$key]['students'][$k]['givenName'] = $student['profile']['name']['givenName'];
				$res[$key]['students'][$k]['familyName'] = $student['profile']['name']['familyName'];
				$res[$key]['students'][$k]['photoUrl'] = $student['profile']['photoUrl'];
			}
			$res[$key]['courseId'] =$value['courseData']['id'];
		}
		if (! Cache::get(getStudentUserId() . ':courseStudents') || Cache::get(getStudentUserId() . ':courseStudents') == null) {
			Cache::put(getStudentUserId() . ':courseStudents', $res, config('constants.CacheTimeOut'));
		}
		return ($res);
	}

	static function assigneeList($isTeacher = "true") {
		$res = [];
		try {
			$url = 'get.getclassroom';
			$result = getCurl($url, 'json', ['userId' =>  getStudentUserId(), 'isTeacher' => $isTeacher]);
			if($result) {
				foreach ($result as $key => $value) {
					$res[$key]['courseId'] = $value['id'];
					$res[$key]['courseName'] = $value['name'];
					$res[$key]['section'] = "";
					$res[$key]['room'] = "";
					$res[$key]['status'] = $value['status'];
					$res[$key]['mbClasses'] = $value['mbClasses'];
					$res[$key]['globalClasses'] = $value['globalClasses'];
					if(isset($value['students']) && !empty($value['students'])) {
						foreach ($value['students'] as $k => $student) {
							$res[$key]['students'][$k]['googleId'] = $student['id'];
							$res[$key]['students'][$k]['mbId'] = 0;
							$res[$key]['students'][$k]['emailId'] = $student['emailId'];
							$res[$key]['students'][$k]['givenName'] = $student['name'];
							$res[$key]['students'][$k]['familyName'] = $student['name'];
							$res[$key]['students'][$k]['photoUrl'] = $student['photoUrl'];
						}
					}
				}
				if($isTeacher == "true") {
					Cache::put(getStudentUserId() . ':courseStudents', $res, config('constants.CacheTimeOut'));
				} else {
					Cache::put(getStudentUserId() . ':courseStudents', $res, config('constants.CacheTimeOut'));
				}
				return $res;
			}
		} catch (\Throwable $th) {
			return $res;
		}
	}

	static function studentAssigneeList($isTeacher = "true") {
		try {
			if (Cache::has(Session::get('profile')["emailId"] . ':courseStudentsSr') || Cache::get(Session::get('profile')["emailId"] . ':courseStudentsSr') != null) {
				return Cache::get(Session::get('profile')["emailId"] . ':courseStudentsSr');
			} else {
				$url = 'get.getclassroom';
				$result = getCurl($url, 'json', ['userId' =>  getStudentUserId(), 'isTeacher' => $isTeacher]);
				$res = [];
				if($result) {
					foreach ($result as $key => $value) {
						$res[$key]['courseId'] = $value['id'];
						$res[$key]['courseName'] = $value['name'];
						$res[$key]['section'] = "";
						$res[$key]['room'] = "";
						$res[$key]['status'] = "";
						$res[$key]['mbClasses'] = $value['mbClasses'];
						$res[$key]['globalClasses'] = $value['globalClasses'];
						if (isset($value['students']) && !empty($value['students'])) {
							foreach ($value['students'] as $k => $student) {
								$res[$key]['students'][$k]['googleId'] = $student['id'];
								$res[$key]['students'][$k]['mbId'] = 0;
								$res[$key]['students'][$k]['emailId'] = $student['emailId'];
								$res[$key]['students'][$k]['givenName'] = $student['name'];
								$res[$key]['students'][$k]['familyName'] = $student['name'];
								$res[$key]['students'][$k]['photoUrl'] = $student['photoUrl'];
							}
						}
					}
					Cache::put(getStudentUserId() . ':courseStudentsSr', $res, config('constants.twoMinutes'));
					return ($res);
				} else {
					(new GoogleAPIController)->token();
				}
			}
		} catch (\Throwable $th) {
			return false;
		}
	}

	static function reportQuestionRequest($request) {
		return json_encode(
			[
				"id" => 0,
				"questionId" => $request['questionId'],
				"userId" => $request['userId'],
				"feedbacks" => $request['feedbacks']
			]
		);
	}

	static function getClassName($id) {
		$classData = Cache::get(getStudentUserId() . ':select_grade');
		foreach ($classData as $key => $class) {
			if($class['id'] == $id) {
				return $class['name'];
			}
		}
	}

	static function getBoardName($id) {
		$boardData = Cache::get(getStudentUserId() . ':select_board');
		foreach ($boardData as $key => $board) {
			if($board['boardId'] == $id) {
				return $board['boardName'];
			}
		}
	}
	
	static function getSubjectName($id) {
		$subjectData = Cache::get(getStudentUserId() . ':select_subject');
		foreach ($subjectData as $key => $subject) {
			if($subject['id'] == $id) {
				return $subject['name'];
			}
		}
	}

	static function getUserProfile($userId) {
		$urlRoute = 'get.userprofile';
		$response = getCurl($urlRoute, $responseType = 'json', ['userId' => $userId]);
		if(!$response) {
			return $response;
		}
		Config::set('constants.ownerId', $response['emailId']);
		Session::put('profile', $response);
		return $response;
	}

	static function registerUserProfile($refreshtoken) {
		$urlRoute = 'set.refreshToken';
		$contentType = "application/json-patch+json";
        $header = ["refreshToken" => $refreshtoken];
        $responseType = "json";
		return (postCurlHeader($contentType, $urlRoute, $header, $responseType));
	}

	static function previouslyCreated(){
		return getCurl('get.previous.questions', 'json',["userId" => getStudentUserId() ]);
	}

	static function getOldPaper($paperId) {
		return getCurl('get.getQuestionPaperById', 'json',["questionPaperId" => $paperId ]);
	}

	static function getQuestionPaper($paperId) {
		return getCurl('get.QuestionPaper', 'json',["paperId" => $paperId ]);
	}
}
