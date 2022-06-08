<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ubid;
use Illuminate\Support\Facades\DB;
class UbidController extends Controller
{
    public function index()
    {
        //
    }

    public function applicationStore(Request $request){
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
        $data2=array();
        $data3=array();
        $data4=array();
        $attachment_array=array();
        try{
            // dd($application_id);
            
            $data['citizen_id'] = session('user')->id;
            $data['community_member_radio_check'] = $read["community_member_radio_check"];
            $data['community_member'] = $read["community_member"];
            $data['community_member_number'] = $read["community_member_number"];
            $data['company_name_bangla'] = $read["company_name_bangla"];
            $data['company_name'] = $read["company_name"];
            $data['business_web_url'] = $read["business-web-url"];
            $data['facebook_url'] = $read["facebook_url"];
            $data['company_address_bangla'] = $read["company_address_bangla"];
            $data['company_address'] = $read["company_address"];
            $data['company_phone_no'] = $read["company_phone_no"];
            $data['company_mobile_no'] = $read["company_mobile_no"];
            $data['company_email'] = $read["company_email"];
            $data['company_year'] = $read['form-13481635413101234'];
            $data['ubid_business_category'] = $read["ubid_business_category"];
            $data['ubid_business_type'] = $read["ubid_bisiness_type"];
            $data['tracking_no'] = $tracking_no;
            $data['application_id'] = $application_id;
            $data['status'] = 1;

            $application_create = DB::table('companyinfo')->insert($data);
        } catch (\Exception $e) {
            // dd($e);
            return response()->json(['message'=>$e]);
        }
        return redirect()->route('citizen.dashboard')->with('success', 'Application submitted successfully!');

    }


}
