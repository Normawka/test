@extends('layouts.app')

@section('content')

    <div class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form class="form" action="" method="POST">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">New Company</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id">

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control input-sm">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control input-sm">
                        </div>
                        <div class="form-group">
                            <label for="logo">Logo</label>
                            <input type="text" name="logo" class="form-control input-sm">
                        </div>
                        <div class="form-group">
                            <label for="website">website</label>
                            <input type="text" name="website" class="form-control input-sm">
                        </div>
                        <div class="form-group">
                            <label for="dob">created_at</label>
                            <input type="date" name="created_at" class="form-control input-sm">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-save">Save</button>
                        <button type="button" class="btn btn-primary btn-update">Update</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection
