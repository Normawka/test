@extends('layouts.app')

@section('content')
    <body>
    <div class="">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="col-sm-12 col-md-7">
                    <a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Create Employee</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="card-body">
            <table class="table table-bordered" id="ajax-crud-datatable">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>First name</th>
                    <th>Last name</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Created at</th>
                    <th width="150" class="text-center">Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
    <!-- boostrap company model -->
    <div class="modal fade" id="company-modal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="CompanyModal"></h4>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" id="CompanyForm" name="CompanyForm" class="form-horizontal" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id">
                        <div class="form-group">
                            <label for="first_name" class="col-sm-2 control-label">First name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First name" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-sm-2 control-label">Last name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last name" maxlength="50" required="">
                            </div>
                        </div>

{{--                        <div class ="form-group">--}}
{{--                            <label class="col-sm-2 control-label">company</label>--}}
{{--                            <select class="form-select form-control" name="select" id="select" aria-label="select">--}}

{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Company Email" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter  phone" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">company</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="select" name="select" placeholder="Enter  company" value="" required="">
                            </div>
                        </div>



                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="btn-save">Save changes
                            </button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <!-- end bootstrap model -->
    </body>
    <script type="text/javascript">
        $(document).ready( function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('#ajax-crud-datatable').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                searching: true,
                ajax: "{{ url('ajax-crud-datatable-employee') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'first_name', name: 'first_name' },
                    { data: 'last_name', name: 'last_name' },
                    { data: 'company', name: 'companies.name' },
                   // { data: 'company', name: 'company.id' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone'},
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false},
                ],
                order: [[0, 'desc']]
            });
        });
        function add(){
            $('#CompanyForm').trigger("reset");
            $('#CompanyModal').html("Add Company");
            $('#company-modal').modal('show');
            $('#id').val('');
        }
        function editFunc(id){
            $.ajax({
                type:"POST",
                url: "{{ url('edit-employee') }}",
                data: { id: id },
                dataType: 'json',
                success: function(res){
                    $('#CompanyModal').html("Edit Company");
                    $('#company-modal').modal('show');
                    $('#id').val(res.id);
                    $('#first_name').val(res.first_name);
                    $('#last_name').val(res.last_name);
                    $('#email').val(res.email);
                    $('#phone').val(res.phone);
                    $('#select').val(res.company.name);
                    val(res.company.id);
                 //   $('#select2').val(res.company.id);
                   //$('#company_id').val(res.company_id);
                   //    $('#select').empty();
                   //
                   //    $.each(  ,function (key,value){
                   //        $('#select').append('<option value="' +key+'">' + value +'</option>');
                   //    })



                }
            });
        }
        function deleteFunc(id){
            if (confirm("Delete Record?") == true) {
                var id = id;
// ajax
                $.ajax({
                    type:"POST",
                    url: "{{ url('delete-employee') }}",
                    data: { id: id },
                    dataType: 'json',
                    success: function(res){
                        var oTable = $('#ajax-crud-datatable').dataTable();
                        oTable.fnDraw(false);
                    }
                });
            }
        }
        $('#CompanyForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: "{{ url('store-employee')}}",
                data: formData,
                cache:false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#company-modal").modal('hide');
                    var oTable = $('#ajax-crud-datatable').dataTable();
                    oTable.fnDraw(false);
                    $("#btn-save").html('Submit');
                    $("#btn-save"). attr("disabled", false);
                },
                error: function(data){
                    console.log(data);
                }
            });
        });

    </script>



@endsection
