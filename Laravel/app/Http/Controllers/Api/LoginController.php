<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Patient;

use DB;

class LoginController extends Controller
{
    public function login(Request $r){
        $email =$r->email;
        $password =$r->password;
        $user = Admin::where('email','=',$email)->where('password','=',$password)->first();
        if($user) {
            return response()->json([
                'user'=> $user,
                'msg'=> 'Successfully Logged in',
                'flag'=> '1'
            ]);
        }
        else {
            return response()->json([
                'msg'=> 'Invalid Email or Password',
                'flag'=> '0'
            ]);
        }
    }
    public function getUserById($id){ 
        $user = User::find($id);
        return response()->json([
            'user'=> $user
        ]);
    }

    public function patientlogin(Request $r){
        $patient_id =$r->patient_id;
        $phone =$r->phone;
        $user = Patient::where('patient_id','=',$patient_id)->where('phone','=',$phone)->first();
        if($user) {
            return response()->json([
                'user'=> $user,
                'msg'=> 'Successfully Logged in',
                'flag'=> '1'
            ]);
        }
        else {
            return response()->json([
                'msg'=> 'Invalid Patient ID or Phone No.',
                'flag'=> '0'
            ]);
        }
    }
    public function getPatientById($id){ 
        $user = User::find($id);
        return response()->json([
            'user'=> $user
        ]);
    }
}