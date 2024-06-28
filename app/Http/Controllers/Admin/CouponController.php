<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $response = [];
        $userData = session()->get('user_session');
        /**
         * CouponType Enum values
         *  { Global, UsersWise}
         */
        $json = ['CouponType' => 'Global', 'UserId' => $userData['userId']];
        $response['couponLists'] = Admin::getCouponList($json);
        return view('admin.coupon.index', $response);
    }

    public function addCoupon(Request $request)
    {
        $userData = session()->get('user_session');
        switch ($request->range) {
            case '1 to 50 Attempts':
                $min = 1;
                $max = 50;
                break;
            case '51 to 200 Attempts':
                $min = 51;
                $max = 200;
                break;
            case '201 to 500 Attempts':
                $min = 201;
                $max = 500;
                break;
            case '500+':
                $min = 501;
                $max = 1000;
                break;
            default:
                $min = 1;
                $max = 50;
                break;
        }

        $request = json_encode([
            'createdBy' => $userData['userId'],
            'creatorEmailId' => $userData['email'],
            'couponType' => 'Global',
            'subscriptionType' => 'SAT',
            'minAttempts' => $min,
            'maxAttempts' => $max,
            'couponCode' => $request['name'],
            'discountPercentage' => $request['percentage'],
            'validity' => !empty($request['validity']) ? $request['validity'] : 10,
            'type' => $request['type'],
            'quantityAvailable' => $request['quantity'],
        ]); 
        
        $response = Admin::postCreateCoupon($request);
        if(isset($response['creadtedDate']) && !empty($response['creadtedDate'])) {
            session()->flash('message', 'Coupon Added');
        } else {
            session()->flash('message', 'Invalid Coupon Code');            
        }
        return  redirect()->route('admin.coupon');
        
    }
}
