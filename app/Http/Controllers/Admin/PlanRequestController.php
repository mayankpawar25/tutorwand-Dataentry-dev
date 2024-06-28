<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class PlanRequestController extends Controller
{
    //
    public function index(Request $request)
    {
        $data = $request->all();

        $response = [
            'datetimesrange' => '',
            'startDate' => '',
            'endDate' => '',
            'users' => '',
        ];
        
        $where = '';

        if(isset($data) && !empty($data) && count($data)) {

            list($FromDate, $ToDate) = explode(' - ', $data['datetimesrange']);

            $response['datetimesrange'] = $data['datetimesrange'];
            
            $response['startDate'] = $FromDate;
            
            $response['endDate'] = $ToDate;
            
            $where = ' where created_at BETWEEN "' . date('Y-m-d H:i:s', strtotime($response['startDate'])) . '" AND "' .  date('Y-m-d H:i:s', strtotime($response['endDate'])) . '"';
        }

        $response['users'] = DB::select('select * from plan_request ' . $where );

        return view('admin.planrequest.index', $response);
    }
}
