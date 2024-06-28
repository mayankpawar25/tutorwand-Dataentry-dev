<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use DB;

class CompetitionController extends Controller
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

        if(isset($data) && !empty($data) && count($data) && $data['datetimesrange'] != '/') {

            list($FromDate, $ToDate) = explode(' - ', $data['datetimesrange']);

            $response['datetimesrange'] = $data['datetimesrange'];
            
            $response['startDate'] = $FromDate;
            
            $response['endDate'] = $ToDate;
            
            $where = ' where created_at BETWEEN "' . date('Y-m-d H:i:s', strtotime($response['startDate'])) . '" AND "' .  date('Y-m-d H:i:s', strtotime($response['endDate'])) . '"';
        }

        $response['users'] = DB::select('select * from competition ' . $where );

        return view('admin.competition.index', $response);
    }

    public function dashboard(Request $request)
    {
        $data = $request->all();
        $response = [
            'datetimesrange' => date('01/m/Y').' - '.date('d/m/Y'),
            'startDate' => date('01/m/Y'),
            'endDate' => date('d/m/Y'),
            'resp' => [],
        ];

        if(isset($data) && !empty($data) && count($data) && $data['datetimesrange'] != '/') {
            list($FromDate, $ToDate) = explode(' - ', $data['datetimesrange']);
            $response['datetimesrange'] = $data['datetimesrange'];
            $response['startDate'] = $FromDate;
            $response['endDate'] = $ToDate;
        }
        list($startdate, $startmonth, $startyear) = explode('/', $response['startDate']);
        list($enddate, $endmonth, $endyear) = explode('/', $response['endDate']);
        $json['StartDate'] = $startmonth.'/'.$startdate.'/'.$startyear.' 00:00:00';
        $json['EndDate'] = $endmonth.'/'.$enddate.'/'.$endyear.' 23:59:59';
        $response['resp'] = Admin::getTelemerty($json);
        $teacherCount = [];
        $studentCount = [];
        $teacherDate = [];
        $studentDate = [];
        if($response) {
            foreach ($response['resp']['teacherTrends']  as $key => $teacherTrends) {
                array_push($teacherCount, $teacherTrends['userCount']);
                array_push($teacherDate, $teacherTrends['date']);
            }

            foreach ($response['resp']['studentTrends']  as $key => $studentTrends) {
                array_push($studentCount, $studentTrends['userCount']);
                array_push($studentDate, $studentTrends['date']);
            }
        }
        $response['resp']['teacherCount'] = $teacherCount;
        $response['resp']['teacherDate'] = $teacherDate;
        $response['resp']['studentCount'] = $studentCount;
        $response['resp']['studentDate'] = $studentDate;
        return view('admin.competition.dashboard', $response);
    }
}
