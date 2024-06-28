<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;

class LoginController extends Controller
{

    public function index(Request $request) {
        $user_array = [];
        $authResp = User::authUser($request['username'], $request['password']);
        
        if($authResp['userId'] == null) {
            session()->flash('message', 'Invalid Email ID or Password');
            return redirect()->route('admin.login');
        } else {
            if($authResp['isAuthorized'] && $authResp['isActive']) {
                session()->put('user_session', $authResp);
                session()->flash('message', 'LoggedIn Success!');
                return redirect()->route('admin.dashboard');
            }
            session()->flash('message', 'Your account is not active.');
            return redirect()->route('admin.login');
        }
    }


    public function logout(Request $request) {
        Auth::guard('admin')->logout();
        session()->flush();
        Session::flush();
        Cache::flush();
        session()->flash('message', 'Just Logged Out!');
        return redirect()->route('admin.login');
    }
}