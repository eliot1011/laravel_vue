<?php

namespace App\Http\Controllers;
use App\Models\Employee;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function insert() {       //show the view to insert new employee
        return view('insert');     //insert ta view er nam...resourse thn views thn insert.blade.php te view ta pabe...bt kaj korbena routes thn web.php e giye route na likhle...
   }

   public function store(Request $request){   //variable ashtece name,roll...... tai Request nam er class nichi abong request er object
    $name = $request->name;             //dollar name nam e php variable...request obj er j name ta ache se name ta niye custom variable name e rakhbo
    $email = $request->email;
    $address = $request->address;
    $age = $request->age;
    
    
    echo 'Name is: '.$name;  //print kore dkhar jonno.....and dot ta concatanation er jonno
    echo '<br>';
    echo 'Email is: '.$email;  //print kore dkhar jonno
    echo '<br>';
    echo 'Address is: '.$address;  //print kore dkhar jonno
    echo '<br>';
    echo 'Age is: '.$age;  //print kore dkhar jonno
    echo '<br>';
    
    
    
    //insert to database table
    
    
    $obj = new Employee();  //new query insert er jonno
    $obj->name = $name ; //database e save korar jonno
    $obj->email = $email ;
    $obj->address = $address ;
    $obj->age = $age ;
    if($obj->save())
    {
        echo 'successfully inserted';
    }
    
    }
}
