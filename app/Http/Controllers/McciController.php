<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class McciController extends Controller
{
    public function get_token()
    {
        while (1) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < 5; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $token_name = $randomString;

            $token = Str::random(30);

            $inserted = DB::connection('mysql4')->table('custom_tokens')->insert(
                [
                    'token_name' => $token_name,
                    'token' => $token,
                ]
            );
            if ($inserted) {
                return response()->json([
                    'success' => 'success',
                    'token' => $token,
                ]);
                break;
            }
        }
    }
    public function get_table_structure(Request $request)
    {

        date_default_timezone_set("Asia/Dhaka");

        $token = DB::connection('mysql4')->table('custom_tokens')->where('token', $request->token)->first();

        if (!$token) {
            return response()->json([
                'error' => 'error',
                'status' => 'Token missmatched',
            ]);
        }

        $datetime1 = $token->created_at;

        $datetime2 = date('y-m-d H:i:s'); //end time

        //return $datetime2.'  '.$datetime1;
        $difference_in_seconds = abs(strtotime($datetime2) - strtotime($datetime1));

        $difference_in_seconds = $difference_in_seconds / 60;

        if ($difference_in_seconds < 10) {
            $companyinfo = DB::connection('mysql4')->select('DESCRIBE companyinfo');
            $company_applicant = DB::connection('mysql4')->select('DESCRIBE company_applicant');
            $company_attachments = DB::connection('mysql4')->select('DESCRIBE company_attachments');
            $company_owner_infos = DB::connection('mysql4')->select('DESCRIBE company_owner_infos');
            return response()->json([
                'status' => 'success',
                'companyinfo' => $companyinfo,
                'company_applicant' => $company_applicant,
                'company_attachments' => $company_attachments,
                'company_owner_infos' => $company_owner_infos,
            ], 200);
        } else {
            $token = Str::random(30);
            DB::connection('mysql4')->table('custom_tokens')->where('token', $request->token)->delete();
            while (1) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 5; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                $token_name = $randomString;

                $token = Str::random(30);

                $inserted = DB::connection('mysql4')->table('custom_tokens')->insert(
                    [
                        'token_name' => $token_name,
                        'token' => $token,
                    ]
                );
                if ($inserted) {
                    return response()->json([
                        'success' => 'success',
                        'status' => 'previous token expired and new token below',
                        'token' => $token,
                    ]);
                    break;
                }
            }

        }
    }
    public function get_ubid(Request $request)
    {
        date_default_timezone_set("Asia/Dhaka");

        $token = DB::connection('mysql4')->table('custom_tokens')->where('token', $request->token)->first();

        if (!$token) {
            return response()->json([
                'error' => 'error',
                'status' => 'Token missmatched',
            ]);
        }

        $datetime1 = $token->created_at;

        $datetime2 = date('y-m-d H:i:s'); //end time

        //return $datetime2.'  '.$datetime1;
        $difference_in_seconds = abs(strtotime($datetime2) - strtotime($datetime1));

        $difference_in_seconds = $difference_in_seconds / 60;
        if ($difference_in_seconds < 10) {
            $read = $request->all();
            $number = rand(100, 10000);
            $t = time();
            $tracking_no = $number . '' . substr($t, 3);

            // Application ID

            $application_id_DB = DB::connection('mysql4')->table('companyinfo')->latest('application_id')->first();

            if (empty($application_id_DB->application_id)) {
                $str = "420.0.0.0";
                // dd($str);
            } else {
                $str = $application_id_DB->application_id;
            }

            $test = (explode(".", $str));
            $increment = (((int) $test[3]) + 1);
            $application_id = 26 . '.' . 5683 . '.' . $t . '.' . $increment;

            $data = array();

            try {
                // dd($application_id);
                //dd($request->all());

                $global_ubid = '';
                while (1) {

                    $ubid = random_int(1000000000, 9999999999);

                    $inserted = DB::table('all_ubid')->insert(
                        [
                            'ubid' => $ubid,
                        ]
                    );
                    if ($inserted) {
                        $global_ubid = $ubid;
                        break;
                    }
                }


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

                $data['ubid'] = $global_ubid;

                $data['others'] = $read["others"];

                //return $data;

                $application_create = DB::connection('mysql4')->table('companyinfo')->insert($data);

                //dd($application_create);

                if ($application_create) {
                    return response()->json(
                        [
                            'message' => 'Success',
                            'ubid' => $global_ubid,
                        ]);
                }

            } catch (\Throwable $e) {
                dd($e);
                return response()->json(['message' => 'Error']);
            }
        } else {
            $token = Str::random(30);
            DB::connection('mysql4')->table('custom_tokens')->where('token', $request->token)->delete();
            while (1) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < 5; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                $token_name = $randomString;

                $token = Str::random(30);

                $inserted = DB::connection('mysql4')->table('custom_tokens')->insert(
                    [
                        'token_name' => $token_name,
                        'token' => $token,
                    ]
                );
                if ($inserted) {
                    return response()->json([
                        'success' => 'success',
                        'status' => 'previous token expired and new token below',
                        'token' => $token,
                    ]);
                    break;
                }
            }

        }
    }
}
