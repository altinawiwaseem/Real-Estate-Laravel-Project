@extends('admin.admin_dashboard')

@section('admin')



<div class="page-content  ">

    <div class="row profile-body  justify-content-center  ">

        <!-- right wrapper start -->
        <div class="col-md-8 col-xl-8 middle-wrapper ">
            <div class="row  ">
                <div class="card">
                    <div class="card-body ">

                        <h6 class="card-title">Edit Amenity</h6>

                        <form method="POST" action="{{ route('update.amenity', $amenity->id) }}" class="forms-sample">

                            @csrf
                            <div class="mb-3">
                                <label for="amenity_name" class="form-label">Amenity Name</label>
                                <input type="text" name="amenity_name" value="{{ $amenity->amenities_name }}"
                                    class="form-control" @error('amenity_name') is-invalid @enderror>
                                @error('amenity_name')
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