<?php



namespace App\Http\Controllers\Admin;



use App\DemoCall;

use Illuminate\Http\Request;

use DB;

use App\Http\Requests;

use App\Http\Controllers\Controller;



class DemoLeadsController extends Controller

{

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

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

            

            $where = ' where create_at BETWEEN "' . date('Y-m-d H:i:s', strtotime($response['startDate'])) . '" AND "' .  date('Y-m-d H:i:s', strtotime($response['endDate'])) . '"';

        }



        $response['users'] = DB::select('select * from users ' . $where );



        return view('admin.demoleads.index', $response);

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        //

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        //

    }



    /**

     * Display the specified resource.

     *

     * @param  \App\DemoCall  $demoCall

     * @return \Illuminate\Http\Response

     */

    public function show(DemoCall $demoCall)

    {

        //

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  \App\DemoCall  $demoCall

     * @return \Illuminate\Http\Response

     */

    public function edit(DemoCall $demoCall)

    {

        //

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  \App\DemoCall  $demoCall

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, DemoCall $demoCall)

    {

        //

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  \App\DemoCall  $demoCall

     * @return \Illuminate\Http\Response

     */

    public function destroy(DemoCall $demoCall)

    {

        //

    }

}

