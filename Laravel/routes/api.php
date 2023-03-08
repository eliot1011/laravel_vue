<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\LoginController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//test routes
Route::get('Test', [TestController::class, 'test']);
Route::any('createTest', [TestController::class, 'createTest']);
Route::get('getTest', [TestController::class, 'getTest']);
Route::get('editTest/{id}',[TestController::class,'editTest']);
Route::any('updateTest/{id}', [TestController::class, 'updateTest']);
Route::any('deleteTest/{id}',[TestController::class,'deleteTest']);

//login routes & get user route
Route::any('adminLogin', [LoginController::class, 'login']);
Route::get('get-user/{id}', [LoginController::class, 'getUserById']);

//patient routes
Route::any('patientLogin', [LoginController::class, 'patientlogin']);
Route::any('PatientEntry', [PatientController::class, 'PatientEntry']);
Route::get('getPatient', [PatientController::class, 'getPatient']);
Route::get('getPatientreportstatus', [PatientController::class, 'getPatientreportstatus']);
Route::get('patientDetails/{id}',[PatientController::class,'patientDetails']);
Route::get('patientInfo/{id}',[PatientController::class,'patientInfo']);
Route::any('updatePatientPayment/{id}',[PatientController::class,'updatePatientPayment']);
Route::get('latestPatient/{id}',[PatientController::class,'latestPatient']);
Route::get('latestPatientReport/{id}',[PatientController::class,'latestPatientReport']);

//patient result routes
Route::any('resultEntry', [PatientController::class, 'resultEntry']);
Route::get('reportResult/{id}', [PatientController::class, 'getPatientResult']);

//user entry/get route
Route::any('createUser', [TestController::class, 'createUser']);
Route::get('getUser', [TestController::class, 'getUser']);
Route::get('editUser/{id}',[TestController::class,'editUser']);
Route::any('updateUser/{id}', [TestController::class, 'updateUser']);
Route::any('deleteUser/{id}',[TestController::class,'deleteUser']);

//email
Route::any('/send/{email}', [PatientController::class,'sentMail']);

//Route::get('/send-email/{id}', [PatientController::class,'sentMail']);


Route::get('/verify/{name}',[PatientController::class, 'verifyName']);



