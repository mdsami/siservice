<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nisc;
use Illuminate\Support\Facades\DB;

class NiscController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
           // $nisc = Nisc::whereNotNul('ubid');
            $nisc =  DB::table('companyinfo')->whereNotNull('ubid')->get();
            return $nisc ;
        } catch (\Throwable $th) {

            return response()->json([
                'result' => false,
                'message' => 'Sorry! Something went wrong!',
            ], 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
         //dd($request->all());
        //dd('ubid');
        // $nisc =  DB::table('companyinfo');
        $read = $request->all();
        $number = rand(100,10000);
        $t=time();
        $tracking_no = $number.''.substr($t,3);   

        // Application ID
        $application_id_DB = DB::table('companyinfo')->latest('application_id')->first();
        if(empty($application_id_DB->application_id)){
            $str = "420.0.0.0"; 
            // dd($str);           
        } else {
            $str = $application_id_DB->application_id;
        }

        $test = (explode(".",$str));
        $increment =  (((int)$test[3])+1);
        $application_id = 26 . '.' . 5683 .'.'.$t.'.'.$increment;

        $data=array();
        
        try{
            // dd($application_id);
            //dd($request->all());
            
            $data['citizen_id'] = "123";
            $data['community_member_radio_check'] = $read["community_member_radio_check"];
            $data['community_member'] = $read["community_member"];
            $data['community_member_number'] = $read["community_member_number"];
            $data['company_name_bangla'] = $read["company_name_bangla"];
            $data['company_name'] = $read["company_name"];
            $data['business_web_url'] = "www.sss.com";
            $data['facebook_url'] = $read["facebook_url"];
            $data['company_address_bangla'] = $read["company_address_bangla"];
            $data['company_address'] = $read["company_address"];
            $data['company_phone_no'] = $read["company_phone_no"];
            $data['company_mobile_no'] = $read["company_mobile_no"];
            $data['company_email'] = $read["company_email"];
            // $data['company_year'] = $read['form-13481635413101234'];
            $data['company_year'] = "form-13481635413101234";
            $data['ubid_business_category'] = $read["ubid_business_category"];
            //$data['ubid_business_type'] = $read["ubid_bisiness_type"];
            $data['ubid_business_type'] = "ubid_bisiness_type";
            $data['tracking_no'] = $tracking_no;
            $data['application_id'] = $application_id;
            $data['status'] = 1;

            $application_create = DB::table('companyinfo')->insert($data);

            //dd($application_create);
            return response()->json(['message'=>'Success']);
        } catch (\Throwable $e) {
             dd($e);
            return response()->json(['message'=>'Error']);
        }
        // return redirect()->route('citizen.dashboard')->with('success', 'Application submitted successfully!');


        

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
