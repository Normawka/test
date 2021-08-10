@extends('layouts.app')

@section('content')
    <body>
    <div class="">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="col-sm-12 col-md-7">
                    <a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Create Company</a>
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
                    <th>Name</th>
                    <th>Email</th>
                    <th>Website</th>
                    <th>Logo</th>
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
                            <label for="name" class="col-sm-2 control-label">Company Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Company Name" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Company Email</label>
                            <div class="col-sm-12">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Company Email" maxlength="50" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Company website</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="website" name="website" placeholder="Enter Company website" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Company logo</label>
                            <div class="col-sm-12">
                                <input  id="logo" type="file" name="logo"  accept="image/*" onchange="readURL(this);">
                                <input type="hidden" name="hidden_image" id="hidden_image">
                            </div>
                        </div>
                        <img id="modal-preview" src="https://via.placeholder.com/150" alt="Preview" class="form-group hidden" width="100" height="100">
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
                ajax: "{{ url('ajax-crud-datatable') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'website', name: 'website'},
                    { data: 'logo', name: 'logo', orderable: false},
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
            $('#modal-preview').attr('src', 'https://via.placeholder.com/150');
        }
        function editFunc(id){
            $.ajax({
                type:"POST",
                url: "{{ url('edit-company') }}",
                data: { id: id },
                dataType: 'json',
                success: function(res){
                    $('#CompanyModal').html("Edit Company");
                    $('#company-modal').modal('show');
                    $('#id').val(res.id);
                    $('#name').val(res.name);
                    $('#email').val(res.email);
                    $('#website').val(res.website);
                    // $('#logo').val(res.logo);
                    $('#modal-preview').attr('alt', 'No image available');
                    if(data.logo){
                        $('#modal-preview').attr('src', SITEURL +'img/'+data.logo);
                        $('#hidden_image').attr('src', SITEURL +'img/'+data.logo);
                    }


                }
            });
        }
        function deleteFunc(id){
            if (confirm("Delete Record?") == true) {
                var id = id;
// ajax
                $.ajax({
                    type:"POST",
                    url: "{{ url('delete-company') }}",
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
                url: "{{ url('store-company')}}",
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
        function readURL(input, id) {
            id = id || '#modal-preview';
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function (e) {
                    $(id).attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
                $('#modal-preview').removeClass('hidden');
                $('#start').hide();
            }
        }
    </script>

@endsection


