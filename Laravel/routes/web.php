<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\EmployeeController;

Route::get('/',[LayoutController::class,'home']);
Route::get('insert',[EmployeeController::class,'insert']); 
Route::post('store-employee',[EmployeeController::class,'store']); 