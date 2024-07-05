@extends('admin.layouts.master')
@section('content')

<div class="container-fluid p-4">
    <div class="row">
        <div class="col-md-12">
            <div id="response_message"></div>
            <div class="card">
                <div class="card-header">
                    <h5>
                        Companies
                        <a class="btn btn-sm btn-success float-end" href="{{route('companies.create')}}">Add New</a>
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
                    <table class="table table-sm table-striped table-bordered hover" id="myDataTable">
                        <thead>
                          <tr>
                            <th scope="col" style="width: 5%;" >#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Logo</th>
                            <th scope="col">Website</th>
                            <th scope="col" style="width: 15%;" >Action</th>
                          </tr>
                        </thead>
                        <tbody id="tbody">
                           @if ($companies->isEmpty())
                               <tr><td colspan="6" class="text-center">No records found</td></tr>
                           @else
                               
                          
                         @foreach ($companies as $company)
                         <tr>
                            <td class="align-middle">{{$companies->firstItem()+$loop->index}}</td>
                            <td class="align-middle">{{$company->name}}</td>
                            <td class="align-middle">{{$company->email}}</td>
                            <td class="align-middle">
                                @if($company->logo)
                                <img src="{{asset('storage/logos/'.$company->logo)}}" alt="logo" width="50px" height="50px"></td>
                                @endif
                            <td class="align-middle">{{$company->website}}</td>
                            <td class="align-middle">
                                <a class="btn btn-warning btn-sm" href="{{route('companies.edit' , encrypt($company->id))}}">Edit</a>
                                <button class="btn btn-danger btn-sm" id="deletebtn" value="{{$company->id}}" >Delete</button>

                            </td>
                          </tr>
                         @endforeach
                         @endif
                       
                        </tbody>
                      </table>
                      <div class="paginate float-end">
                        {{$companies->links()}}
                      </div>
                      
                </div>
            </div>
        </div>
    </div>
</div>
    @include('admin.company.delete')
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
            var comp_id = $(this).val();
            $('#delete_company_id').val(comp_id);
            $('#deleteCompModal').modal('show');
          
    });

//delete operation

        $(document).on('click','#delete_company_btn',function(e){
        e.preventDefault();
        var delete_company_id = $('#delete_company_id').val();   
        $.ajax({
               type:'DELETE',
               url:"companies/"+delete_company_id,
               dataType:'json',
               success:function(response) {
               if(response.status == 404){ 
                    $("#deleteCompModal").modal('hide');
                    toastr.error(response.message)
                  
                    location.reload();
                }
                else{
                    $("#deleteCompModal").modal('hide');
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