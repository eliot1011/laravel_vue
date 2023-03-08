<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Result;
use App\Models\Test;


use DB;
use App\Mail\TestMail;
use Mail;

class PatientController extends Controller
{
     //patient entry
     public function PatientEntry(Request $request)
     {
         //$uniqueID = uniqid();
         $uniqueID = floor(time()- 999999999);
         foreach($request->selected as $s) {
            $obj = new Patient();
            $obj->test_id = $s['id'] ;
            $obj->test_name = $s['name'] ;
            $obj->patient_id = $uniqueID ;
            $obj->name = $request->name;
            $obj->email = $request->email ;
            $obj->age = $request->age ;
            $obj->gender = $request->gender ;
            $obj->phone = $request->phone ;
            $obj->total = $request->total_price ;
            $obj->advance = $request->advance ;
            $obj->due = $request->due ;
            if($obj->due==0) 
            {
                $obj->status = 1 ;
            }
            else
            $obj->status = 0 ;
            $obj->report_status = 0;
            $obj->role = 'patient';
            $obj->save();
         }
         //$obj->save();
         return response()->json([
             'msg' => 'success'
         ]);
     }

    // get patients
    public function getPatient(){ 
        $patient = DB::table('patients')
        ->select('patient_id','name','due')
        ->distinct()
        ->get();

        return response()->json([
            'patient'=> $patient,
            'msg' => 'data received'
        ]);
    }

    public function getPatientreportstatus(){ 
        $patient = DB::table('patients')
        ->select('patient_id','name','due')
        ->where('report_status','=', 0)
        ->distinct()
        ->get();

        return response()->json([
            'patient'=> $patient,
            'msg' => 'data received'
        ]);
    }


    // public function patientDetails($id) {
    //     return $obj =DB::table('patients')->where('patient_id','=',$id)->select('patient_id','name','test_name')
    //     ->distinct()->get();  
    // }


    public function patientDetails($id){
        $patient = DB::table('patients')
        ->join('tests', 'patients.test_id', '=', 'tests.id')
        ->where('patient_id','=',$id)
                    ->get();

        return response()->json([
            'patient'=> $patient,
            'msg' => 'data retrived'
        ]);
    }

    public function patientInfo($id) {
        return $obj =DB::table('patients')->where('patient_id','=',$id)->first();  
    }

    // public function updatePatientPayment($id, Request $request)
    // {
    //     $updateTest = Patient::find($id);
    //     $updateTest->update($request->input('pay'));
    //   return response()->json(['successfully updated']);
    // }

    public function updatePatientPayment($id, Request $request)
    { 
        $obj = DB::table('patients')
        ->where('patient_id', '=', $request->id)
        ->increment('advance', $request->input('pay'));

        $obj1 = DB::table('patients')
        ->where('patient_id', '=', $request->id)
        ->decrement('due',  $request->input('pay'));

        DB::table('patients')->where('due', '=', 0)->update(['status' => 1]);
        return response()->json(['successfully updated']);
    }

    //print er jonno krsilam(apatoto useless)
    public function latestPatient($id)
    {
       return  $data =  DB::table('patients')->latest('created_at')->first();
    }

    public function resultEntry(Request $request)
    {
        foreach($request->test as $t){
         foreach($request->result as $s) {
        //for($i=0; $i <count($request->result) ;$i++) {
        // foreach($request->test as $t){
        $obj = new Result();
        $obj->test_id = $t['test_id'];
        $obj->test_name = $t['test_name'];
        $obj->patient_id = $request->patient_id;
        $obj->result = $s;
        $obj->save();
        break;
        } 
    }
    $obj = DB::table('patients')
    ->where('patient_id', '=', $request->patient_id)
    ->update(['report_status' => '1']);


        return response()->json([
            'msg' => 'success'
        ]);
    }

    public function getResult($id){
        $result = DB::table('results')
        ->where('patient_id','=',$id)
                    ->get();

        return response()->json([
            'patient'=> $patient,
            'msg' => 'data retrived'
        ]);
    }

    public function getPatientResult($id){
        $result = DB::table('results')
        ->join('tests', 'results.test_id', '=', 'tests.id')
        ->join('patients', 'results.patient_id', '=', 'patients.patient_id')
        ->where('results.patient_id','=',$id)
        ->where('patients.status','=',1)
        ->where('patients.report_status','=',1)
        ->select('results.patient_id','results.test_id','results.result','tests.name')
        ->distinct()
        ->get();

        return response()->json([
            'result'=> $result,
            'msg' => 'data retrived'
        ]);
    }

    public function latestPatientReport($id)
    {
       return  $data =  DB::table('patients')
       ->join('tests', 'patients.test_id', '=', 'tests.id')
       ->latest('patients.created_at')->get();
    }

    


    public function sentMail(Request $request)
    {
        Mail::send([],['name', 'Chittagong Diagnostic Center'], function($message) use ($request){
            $message->to($request->email);
            $message->subject('Your Report is ready! Visit http://127.0.0.1:8080/ResultEntry  to view the report.');
            $message->from('testmail@gmail.com', 'Chittagong Diagnostic Center');
        });
        return response()->json(['success'=>true]);
    }


}
