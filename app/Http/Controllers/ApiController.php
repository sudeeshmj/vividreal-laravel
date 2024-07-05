<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function login(){
        $user = User::where('email',request('email'))->first();
        if($user){
        if(Hash::check(request('password'),$user->password)){

            $token = $user->createToken('user-token')->plainTextToken;
            return response()->json([
                'status'=>200,
                'token'=>$token
            ]);
        }else{
            return response()->json([
                'status'=>401,
                'message'=>'Login failed,Invalid Credentials'
            ]);
        }
        }else{
            return response()->json([
                'status'=>401,
                'message'=>'Login failed,Invalid Credentials'
            ]);
        }
    }


    public function employeeList(){
        
        $employees = Employee::with('company')->latest()->get();
        if($employees->isEmpty()){
            return response()->json([
                'status'=>404,
                'message'=>"No record Found"
            ]);
        }else{
            return response()->json([
                'status'=>200,
                'employees'=>$employees
            ]);
        }
        
    }


    public function loggout(){
        $userId= auth()->user()->id;
        $user = User::find($userId);
        $user->tokens()->delete();
        return response()->json([
            'status'=>200,
            'message'=>'User loggedout successfully'
        ]);

    }
}
