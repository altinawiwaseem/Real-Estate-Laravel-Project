@extends('admin.admin_dashboard')

@section('admin')



<div class="page-content  ">

    <div class="row profile-body  justify-content-center  ">

        <!-- right wrapper start -->
        <div class="col-md-8 col-xl-8 middle-wrapper ">
            <div class="row  ">
                <div class="card">
                    <div class="card-body ">

                        <h6 class="card-title">Edit Permission</h6>

                        <form method="POST" action="{{ route('update.permission', $permission->id) }}"
                            class="forms-sample">

                            @csrf
                            <div class="mb-3">
                                <label for="permission_name" class="form-label">Permission Name</label>
                                <input type="text" name="permission_name" value="{{ $permission->name }}"
                                    class="form-control" @error('permission_name') is-invalid @enderror>
                                @error('permission_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="group_name" class="form-label">Group Name</label>

                                <select name="group_name" class="form-select @error('group_name') is-invalid @enderror">

                                    <option value="" {{ $permission->group_name == '' ? 'selected' : '' }}>Select Group
                                    </option>
                                    <option value="type" {{ $permission->group_name == 'type' ? 'selected' : ''
                                        }}>Property type</option>
                                    <option value="amenities" {{ $permission->group_name == 'amenities' ? 'selected' :
                                        '' }}>Amenities</option>
                                    <option value="role" {{ $permission->group_name == 'role' ? 'selected' : '' }}>Role
                                        & Permission</option>

                                </select>


                                @error('group_name')
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