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
                    <h5>Add New Employee</h5>
                </div>
                <div class="card-body">
                    <form method="post"  id="employeeform"  action="{{route('employees.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" value="{{old('firstName')}}">
                                @error('firstName')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" value="{{old('lastName')}}">
                                @error('lastName')
                                <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                       
                        <div class="mb-3">
                            <label for="company" class="form-label">Company</label>
                            <select name="company" id="company"  class="form-control" >
                                <option value="">--select--</option>
                                @foreach ($companies as $company)
                                <option value="{{$company->id}}">{{$company->name}}</option> 
                                @endforeach
                            </select>
                            @error('company')<span class="error-message">{{ $message }}</span>@enderror 
                          </div>
                          <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}">
                            @error('email')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                          </div>
                          <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="number" class="form-control" id="phone" name="phone" value="{{old('phone')}}">
                            @error('phone')
                            <span class="error-message">{{ $message }}</span>
                            @enderror
                          </div>
                          
                       <div class="mb-3">
                        <button type="submit" class="btn btn-primary btn-sm" >Submit</button>
                     </div>
                     
                      </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $("#employeeform").validate({
        rules: {
            firstName: {
                    required: true,
                    minlength: 2,
                    maxlength:50,
                },
                lastName: {
                    required: true,
                    maxlength:50,
                },
                email: {
                   
                    minlength: 4, 
                    maxlength:50,     
                },
                phone: {
                    minlength: 8, 
                    maxlength:20,  
                       
                },
               
               
            },
            messages: {
                firstName: {
                    required: "Please Enter First Name."
                },
                lastName: {
                    required: "Please Enter Last Name."
                }, 
            },



            });
        });
</script>
@endsection