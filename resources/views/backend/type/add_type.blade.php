@extends('admin.admin_dashboard')

@section('admin')



<div class="page-content  ">
  <?php 
   // dd("profileData",$profileData->photo)
    ?>

  <div class="row profile-body  justify-content-center  ">

    <!-- right wrapper start -->
    <div class="col-md-8 col-xl-8 middle-wrapper ">
      <div class="row  ">
        <div class="card">
          <div class="card-body ">

            <h6 class="card-title">Add Property Type</h6>

            <form method="POST" action="{{ route('store.type') }}" class="forms-sample">

              @csrf
              <div class="mb-3">
                <label for="type_name" class="form-label">Type Name</label>
                <input type="text" name="type_name" class="form-control" @error('type_name') is-invalid @enderror>
                @error('type_name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <div class="mb-3">
                <label for="type_icon" class="form-label">Type Icon</label>
                <input type="text" name="type_icon" icon="type_icon" class="form-control" @error('type_icon') is-invalid
                  @enderror>
                @error('type_icon')
                <span class="text-danger">{{ $message }}</span>
                @enderror
              </div>

              <button type="submit" class="btn btn-primary me-2">Add Property</button>

            </form>

          </div>
        </div>

      </div>
    </div>




  </div>

</div>



@endsection