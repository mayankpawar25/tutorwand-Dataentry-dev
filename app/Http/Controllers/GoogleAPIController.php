<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use Google_Client;
use Google_Service_Classroom;
use Google_Service_Classroom_UserProfile;
use Google_Service_Oauth2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class GoogleAPIController extends Controller
{
    public function auth() {
        try {
            Session::put('redirect', ['isFirst' => true]);  
            $client = new Google_Client();
            $client->setRedirectUri(route('google.auth'));
            $client->setApplicationName('TutorWand');
            $client->setScopes([
                Google_Service_Classroom::CLASSROOM_COURSES_READONLY, 
                Google_Service_Classroom::CLASSROOM_ROSTERS_READONLY, 
                Google_Service_Classroom::CLASSROOM_PROFILE_PHOTOS, 
                Google_Service_Classroom::CLASSROOM_PROFILE_EMAILS,
                Google_Service_Classroom::CLASSROOM_COURSEWORK_STUDENTS,
                Google_Service_Classroom::CLASSROOM_COURSEWORK_ME,
                Google_Service_Classroom::CLASSROOM_COURSES,
                Google_Service_Classroom::CLASSROOM_ROSTERS
            ]);
            $client->setClientId(config('constants.googleClientId'));
            $client->setClientSecret(config('constants.googleClientSecret'));
            $client->setAccessType('offline');
            $client->setIncludeGrantedScopes(true);
            $client->setPrompt('select_account');

            // Load previously authorized token from a file, if it exists.
            // The file token.json stores the user's access and refresh tokens, and is
            // created automatically when the authorization flow completes for the first
            // time.
            if(Session::has('googleToken')) {
                $token = Session::get('googleToken');
                $client->setAccessToken($token);
            }
            
            // If there is no previous token or it's expired.
            if ($client->isAccessTokenExpired()) {

                // Refresh the token if possible, else fetch a new one.
                if ($client->getRefreshToken()) {
                    $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                } else {
                    // Request authorization from the user.
                    $authUrl = $client->createAuthUrl();
                    if(!isset($_GET['code'])) {
                        return ['redirecturl' => $authUrl];
                    }
                    
                    $stdin = fopen('php://stdin', 'r');
                    $authCode = trim(fgets($stdin));
                    if($authCode == "") {
                        $authCode = $_GET['code'];
                    }
                    
                    // Exchange authorization code for an access token.
                    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                    $client->setAccessToken($accessToken);
                    
                    // Check to see if there was an error.
                    if (array_key_exists('error', $accessToken)) {
                        throw new Exception(join(', ', $accessToken));
                    }
                }

                $oauth2 = new Google_Service_Classroom($client);
                $userInfo = $oauth2->userProfiles->get('me')->id;
                // Save the token to session.
                Session::put('googleToken', $client->getAccessToken());
                Session::put('profile', ['userId' => $userInfo]);
            }

            if(is_array($client) && isset($client['redirecturl']) && !empty($client['redirecturl'])) {
                return response()->json([$client]);
            } else {
                if(Session::has('googleToken')){
                    $googleToken = Session::get('googleToken');
                }

                $profile = Session::get('profile');
                if(isset($googleToken['refresh_token']) && !empty($googleToken['refresh_token'])) {

                    /* Register user first time accessing application */
                    Session::forget('loginPageRedirect');
                    $response = Questions::registerUserProfile($googleToken['refresh_token']);
                    if(is_array($response)) {
                        Session::forget('googleToken');
                        if($response['error'] != null ) {
                            Session::forget('googleToken');
                            $dt = $response->json();
                            return (new HomeController)->unAuthorise($response['error']);
                        } else if($response['role']['roleId'] == 3) {
                            /* if user role is not set or role id is 3 call choose Role page */
                            Session::put(getStudentUserId().'-onBoardResponse', $response);
                            return (new HomeController)->chooseRole();
                        }
                    }                    
                }

                Questions::getUserProfile($profile['userId']);
                $updatedProfile = Session::get('profile');
                $route = 'home_page';
                
                if(isset($updatedProfile['userRoles'])) {
                    foreach ($updatedProfile['userRoles'] as $key => $roles) {
                        if (Session::has('redirectURL')) {
                            $url = Session::get('redirectURL');
                            Session::forget('redirectURL');
                            return redirect($url);
                        } else if($roles['roleId'] == 3) {
                            /* if user role is not set or role id is 3 call choose Role page */
                            Session::put(getStudentUserId().'-onBoardResponse', $updatedProfile);
                            return redirect()->route('user.chooserole');

                        } else if ($roles['roleId'] == 2) {
                            return redirect()->route('students.dashboard');
                        } else if($roles['roleId'] == 1) {
                            return redirect()->route('teacher.dashboard');
                        } else {
                            /* Teacher */
                            $route = 'home_page';
                            return redirect()->route($route);
                        }
                    }
                } else {
                    /* For non gcr user */
                    $message = "You don't have any class or you are not registered with Google Classroom";
                    return (new HomeController)->unAuthorise($message);
                }
            } 
        } catch (\Throwable $th) {
            return abort(401);
        }

    }
    
    public function token($isRedirect = true) {
        $client = $this->auth();
        if(is_array($client) && isset($client['redirecturl']) && !empty($client['redirecturl'])) {
                return redirect()->to($client['redirecturl'])->send();
        } else {
            if($isRedirect) {
                $onBoardResponse = Session::get(getStudentUserId().'-onBoardResponse');
                $roleId = $onBoardResponse['userRoles'][0]['roleId'];
                switch ($roleId) {
                    case 3:
                        return redirect()->route('user.chooserole');
                        break;
                    case 2:
                        return redirect()->route('students.dashboard');
                        break;
                    case 1:
                        return redirect()->route('teacher.dashboard');
                        break;
                    default:
                        return redirect()->route('home_page');
                        break;
                }
            } else {
                return $client;
            }
        }
    }

    public function setRole($roleId) {
        $roleIdDecode = base64_decode($roleId);
        $onBoardResponse = Session::get(getStudentUserId().'-onBoardResponse');
        switch ($roleIdDecode) {
            case 1:
                $role = [
                    "roleId"=> $roleIdDecode,
                    "roleName"=> config('constants.teacher'),
                    "description"=> config('constants.teacherDesc')
                ];
                break;
            case 2: 
                $role = [
                    "roleId"=> $roleIdDecode,
                    "roleName"=> config('constants.student'),
                    "description"=> config('constants.studentDesc')
                ];
                break;
            default:
                $role = [
                    "roleId"=> $roleIdDecode,
                    "roleName"=> config('constants.teacher'),
                    "description"=> config('constants.teacherDesc')
                ];
                break;
        }
        $data = [
                    "userId" => isset($onBoardResponse['id']) ? $onBoardResponse['id'] : $onBoardResponse['userId'],
                    "role" => $role
                ];
        /* update user role */
        $urlRoute = "update.user.role";
        $contentType = "application/json-patch+json";
        $responseType = "Json";
        $response = patchCurl($contentType, $urlRoute, json_encode($data), $responseType);
        
        if ($response) {
            $profile = Session::get('profile');
            Questions::getUserProfile($profile['userId']);
            $updatedProfile = Session::get('profile');
            $route = 'home_page';
            if(isset($updatedProfile['userRoles'])) {
                foreach ($updatedProfile['userRoles'] as $key => $roles) {
                    if (Session::has('redirectURL')) {
                        $url = Session::get('redirectURL');
                        Session::forget('redirectURL');
                        return redirect($url);
                    } else {
                        /* Teacher */
                        $route = 'home_page';
                        return redirect()->route($route);
                    } 
                    
                    if ($roles['roleId'] == 2) {
                        /* Student */
                        if (Session::has('redirectURL')) {
                            $url = Session::get('redirectURL');
                            Session::forget('redirectURL');
                            return redirect($url);
                        } else {
                            $message = "You don't have any access to student";
                            return (new HomeController)->unAuthorise($message);
                        }
                    }
                }
            } else {
                /* For non gcr user */
                $message = "You don't have any class or you are not registered with Google Classroom";
                return (new HomeController)->chooseRole($message);
                // return (new HomeController)->unAuthorise($message);
            }
        }
    }
}
