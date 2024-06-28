<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Admin;

use Illuminate\Support\Facades\Http;


class AnalyticsController extends Controller
{
    //
    public function index(Request $request) {
        
        $data = $request->all();

        $response = [
            'datetimesrange' => '',
            'startDate' => '',
            'endDate' => '',
            'userType' => '',
            'users' => '',
        ];
        
        if(isset($data) && !empty($data) && count($data)) {

            list($FromDate, $ToDate) = explode(' - ', $data['datetimesrange']);

            $userType = $data['userType'];

            $RoleId[0] = 1;

            switch ($userType) {
                case 'All':
                    $RoleId[0] = 1;
                    $RoleId[1] = 2;
                    $RoleId[2] = 3;
                    break;
                case 'Teacher':
                    $RoleId[0] = 1;
                    break;
                case 'Student':
                    $RoleId[0] = 2;
                    break;
                case 'Undefined':
                    $RoleId[0] = 3;
                    break;
                default:
                    $RoleId[0] = 1;
                    $RoleId[1] = 2;
                    $RoleId[2] = 3;
                    break;
            };

            $response = Admin::getUsers(['FromDate' => date('m-d-Y h:i A', strToTime($FromDate)), 'ToDate' => date('m-d-Y h:i A', strToTime($ToDate)), 'RoleId' => $RoleId]);

            $response['datetimesrange'] = $data['datetimesrange'];
            
            $response['startDate'] = $FromDate;
            
            $response['endDate'] = $ToDate;
            
            $response['userType'] = $data['userType'];

        }

        return view('admin.analytics.index', $response);

    }

}
