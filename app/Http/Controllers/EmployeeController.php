<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Models\Company;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
    public function index()
    {
       
        $employees = Employee::with('company')->latest()->paginate(10);
        return view('admin.employee.list',compact('employees'));
    }
    public function create()
    {
        $companies = Company::orderby('name','asc')->get();
        return view('admin.employee.create',compact('companies'));
    }
    public function store(EmployeeRequest $request)
    {
       
        $employee = new Employee();
       
        $employee->first_name = $request->input('firstName');
        $employee->last_name = $request->input('lastName');
        $employee->company_id = $request->input('company');
        $employee->email = $request->input('email');
        $employee->phone = $request->input('phone');
        $employee->save();
       
        return redirect()->route('employees.index')->with('message','Employee Added Successfully');

    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $employee = Employee::find(decrypt($id));
        if($employee){
            $companies = Company::orderby('name','asc')->get();
          return view ('admin.employee.edit',compact('companies','employee'));
        }
        else{
           return redirect()->back()->with('error','Employee Not found');
        }
    }


    public function update(Request $request, $id)
    {
        $employee =  Employee::find(decrypt($id));
        if($employee){
            $employee->first_name = $request->input('firstName');
            $employee->last_name = $request->input('lastName');
            $employee->company_id = $request->input('company');
            $employee->email = $request->input('email');
            $employee->phone = $request->input('phone');
           $employee->update();
           return redirect()->route('employees.index')->with('message','Employee Updated Successfully');
        }
        else{
           return redirect()->route('employees.index')->with('error','Employee Not found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee =  Employee::find($id); 
        if($employee){
            $employee->delete();
           return response()->json(['status'=>200,'message'=>'Employee deleted Successfully']);
          }
          else{
             return response()->json(['status'=>404,'message'=>'Employee Not Found']);
          }
    }
}
