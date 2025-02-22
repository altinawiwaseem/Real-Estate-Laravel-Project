@extends('admin.admin_dashboard')

@section('admin')



<div class="page-content  ">

    <div class="row profile-body  justify-content-center  ">

        <!-- right wrapper start -->
        <div class="col-md-8 col-xl-8 middle-wrapper ">
            <div class="row  ">
                <div class="card">
                    <div class="card-body ">

                        <h6 class="card-title">Edit Role</h6>

                        <form method="POST" action="{{ route('update.role', $role->id) }}" class="forms-sample">

                            @csrf
                            <div class="mb-3">
                                <label for="role_name" class="form-label">Role Name</label>
                                <input type="text" name="role_name" value="{{ $role->name }}" class="form-control"
                                    @error('role_name') is-invalid @enderror>
                                @error('role_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary me-2">Save Changes</button>

                        </form>

                    </div>
                </div>

            </div>
        </div>




    </div>

</div>



@endsection