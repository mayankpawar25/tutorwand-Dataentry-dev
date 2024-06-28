<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    //
    public function index(Request $request) {
        if ($request->session()->has('profile') && $request->session()->has('redirect')) {
            Session::forget('redirect');
            $profileData = $request->session()->get('profile');
            if( isset($profileData['userRoles']) ){
                foreach ($profileData['userRoles'] as $key => $user) {
                    if ($user['roleId'] == 1) {
                        return redirect()->route('teacher.dashboard');
                    }

                    if ($user['roleId'] == 2) {
                        if (strpos(\Request::route()->getName(), 'students.') === false) {
                            return redirect()->route('students.dashboard');
                        }
                    }
                }
            } else {
                if(Session::has(getStudentUserId().'-onBoardResponse')) {
                    return (new HomeController)->chooseRole();
                }
                $message = "You don't have any class or you are not registered with Google Classroom";
                return $this->unAuthorise($message);
            }
        }
        return view('landing');
    }

    public function unAuthorise($message) {
        $data['message'] = $message;
        return view('unauthorise', $data);
    }

    public function unAuthoriseStudent($data) {
        return view('unauthoriseStudent', $data);
    }

    public function feedback() {
        return view('feedback');
    }

    public function chooseRole() {
        return view('chooseRole');
    }

}
