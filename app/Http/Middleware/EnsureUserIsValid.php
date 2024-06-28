<?php

namespace App\Http\Middleware;

use Closure;

class EnsureUserIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role='')
    {
        $request->session()->put('redirectURL', url()->current());
        if($request->session()->has('profile')){
            $profileData = $request->session()->get('profile');
            foreach ($profileData['userRoles'] as $key => $user) {
                if ($user['roleId'] == 2) {
                    if (strpos(\Request::route()->getName(), 'students.') === false) {
                        return abort(401);
                    }
                }
            }
            return $next($request);
        } else {
            if (strpos(\Request::route()->getName(), 'students.') === false) {
                $request->session()->put('loginPageRedirect', '1');
            } else {
                $request->session()->put('loginPageRedirect', '2');
            }
            return redirect()->route('auth2');
        }
    } 
}
