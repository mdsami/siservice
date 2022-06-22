<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DbSchamaController extends Controller
{
    public function index()
    {


            $companyinfo=DB::select('DESCRIBE companyinfo');
            $company_applicant=DB::select('DESCRIBE company_applicant');
            $company_attachments=DB::select('DESCRIBE company_attachments');
            $company_owner_infos=DB::select('DESCRIBE company_owner_infos');
            return response()->json([
                'status'=>'success',
                'companyinfo'=>$companyinfo,
                'company_applicant'=>$company_applicant,
                'company_attachments'=>$company_attachments,
                'company_owner_infos'=>$company_owner_infos
              ],200);



    }
}
