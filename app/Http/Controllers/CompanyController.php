<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::latest()->paginate(10);
        return view('admin.company.list',compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('admin.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
    {
       

         $company = new Company();
         $company->name = $request->input('companyName');
         $company->email = $request->input('companyEmail');
         $company->website = $request->input('companyWebsite');
 
         if($request->hasFile('companyLogo')){
             $file = $request->file('companyLogo');
             $extension = $file->extension();
             $fileName = 'comany'.time().'.'. $extension;
             $file->storeAs('public/logos', $fileName );
             $company->logo= $fileName ;
         }
        
         $company->save();
         
         return redirect()->route('companies.index')->with('message','Company Added Successfully');



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $company = Company::find(decrypt($id));
        if($company){
          return view ('admin.company.edit',compact('company'));
        }
        else{
           return redirect()->back()->with('error','Company Not found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyRequest $request, $id)
    {
        $company =  Company::find(decrypt($id));
        if($company){
            $company->name = $request->input('companyName');
            $company->email = $request->input('companyEmail');
            $company->website = $request->input('companyWebsite');
  
           if($request->hasFile('companyLogo')){
            $oldPath = 'public/logos/' . $company->logo;
  
            if (Storage::exists($oldPath)) {
                Storage::delete($oldPath); 
            }
              $file = $request->file('companyLogo');
              $extension = $file->extension();
              $fileName = 'comany'.time().'.'. $extension;
              $file->storeAs('public/logos', $fileName );
              $company->logo= $fileName ;
          }
          
           $company->update();
           return redirect()->route('companies.index')->with('message','Company Updated Successfully');
        }
        else{
           return redirect()->route('companies.index')->with('error','Company Not found');
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
        $company =  Company::find($id); 
       if($company){
            $oldPath = 'public/logos/' . $company->logo;
            if (Storage::exists($oldPath)) {
                Storage::delete($oldPath); 
            }
           $company->employees()->update(['company_id' => null]);
           $company->delete();
          return response()->json(['status'=>200,'message'=>'Company deleted Successfully']);
         }
         else{
            return response()->json(['status'=>404,'message'=>'Company Not Found']);
         }
    }
}
