@extends('admin.layouts.master')
@section('content')
    
<style>
  
</style>
<div class="container-fluid p-4">
    <div class="row">
        <div class="col-md-12">
            <div id="response_message"></div>
            <div class="card">
                <div class="card-header">
                    <h5>Update Company</h5>
                </div>
                <div class="card-body">
                    <form  method="POST"  id="companyform" action="{{route('companies.update',encrypt($company->id))}}" enctype="multipart/form-data">
                       @csrf
                       @method('PUT')
                        <div class="mb-3">
                          <label for="companyName" class="form-label">Name</label>
                          <input type="text" class="form-control" id="companyName" name="companyName" value="{{$company->name}}">
                          @error('companyName')
                          <span class="error-message">{{ $message }}</span>
                          @enderror
                        </div>
                        <div class="mb-3">
                            <label for="companyEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="companyEmail" name="companyEmail" value="{{$company->email}}">
                            @error('companyEmail')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="mb-3">
                            <label for="companyWebsite" class="form-label">Website</label>
                            <input type="text" class="form-control" id="companyWebsite" name="companyWebsite" value="{{$company->website}}">
                            @error('companyWebsite')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                          </div>
                         <div class="mb-3">
                            <label for="companyLogo" class="form-label">Logo</label>
                            <input type="file" class="form-control" id="companyLogo"  name="companyLogo" accept="image/*">
                            @error('companyLogo')
                            <span class="error-message">{{ $message }}</span>
                            @enderror  
                        </div>
                          
                       <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-sm" >Update</button>
                     </div>
                     
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $("#companyform").validate({
        rules: {
            companyName: {
                    required: true,
                    minlength: 2,
                    maxlength:50,
                },
                companyEmail: {
                    minlength: 2, 
                    maxlength:50,   
                },
                companyWebsite: {
                    minlength: 2, 
                    maxlength:50,   
                },
              
               
            },
            messages: {
                companyName: {
                    required: "Please enter Company Name."
                },            
               
               
            },



            });
        });
</script>
@endsection