@extends('admin.layouts.master')
@section('content')
    

<div class="container-fluid p-4">
    <div class="row">
        <div class="col-md-12">
            <div id="response_message"></div>
            <div class="card">
                <div class="card-header">
                    <h5>
                        Employees
                        <a class="btn btn-sm btn-success float-end" href="{{route('employees.create')}}">Add New</a>
                    </h5>
                </div>
                <div class="card-body">
                    <div id="response_message"></div>
                    @if (session()->has('message'))
                        <script>
                            toastr.options = {
                            closeButton: true,
                            progressBar: true,
                            positionClass: 'toast-bottom-right' 
                        }; 
                        toastr.success("{{session()->get('message')}}")</script>
                    @endif
                    @if (session()->has('error'))
                       <script> 
                       toastr.options = {
                        closeButton: true,
                        progressBar: true,
                        positionClass: 'toast-bottom-right' 
                    }; toastr.error("{{session()->get('error')}}")</script>
                      @endif
                    <table class="table table-sm table-striped table-bordered " id="productTable">
                        <thead>
                          <tr>
                            <th scope="col" style="width: 5%;" >#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company</th>
                            <th scope="col">email</th>
                            <th scope="col">Phone</th>
                            <th scope="col" style="width: 15%;" >Action</th>
                          </tr>
                        </thead>
                        <tbody id="tbody">
                        @if ($employees->isEmpty())
                            <tr><td colspan="6" class="text-center">No records found</td></tr>
                        @else 
                         @foreach ($employees as $employee)
                          <tr>
                            <td class="align-middle">{{$employees->firstItem()+$loop->index}}</td>
                            <td class="align-middle">{{$employee->first_name." ".$employee->last_name}}</td>
                            <td class="align-middle">{{$employee->company?$employee->company->name:''}}</td>
                            <td class="align-middle">{{$employee->email}}</td>
                            <td class="align-middle">{{$employee->phone}}</td>
                            <td class="align-middle">
                                <a class="btn btn-warning btn-sm" href="{{route('employees.edit' , encrypt($employee->id))}}">Edit</a>
                                <button class="btn btn-danger btn-sm" id="deletebtn" value="{{$employee->id}}" >Delete</button>

                            </td>
                          </tr>
                         @endforeach
                        @endif
                       
                        </tbody>
                      </table>
                      <div class="paginate float-end">
                        {{$employees->links()}}
                      </div>
                </div>
            </div>
        </div>
    </div>
</div>
    @include('admin.employee.delete')
<script>
$(document).ready(function(){
toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-bottom-right' 
            };  

    $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

$(document).on('click','#deletebtn',function(e){
            e.preventDefault();
            var emp_id = $(this).val();
            $('#delete_emp_id').val(emp_id);
            $('#deleteEmpModal').modal('show');
          
    });

//delete operation

        $(document).on('click','#delete_emp_btn',function(e){
        e.preventDefault();
        var delete_emp_id = $('#delete_emp_id').val();   
        $.ajax({
               type:'DELETE',
               url:"employees/"+delete_emp_id,
               dataType:'json',
               success:function(response) {
               if(response.status == 404){ 
                    $("#deleteEmpModal").modal('hide');
                    toastr.error(response.message)
                  
                    location.reload();
                }
                else{
                    $("#deleteEmpModal").modal('hide');
                    toastr.success(response.message)
                  
                    location.reload();
               }
                
               },
               error:function(err) {
                 console.log(err);
               }
            });


    });
});

</script>
@endsection