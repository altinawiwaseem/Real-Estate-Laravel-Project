@extends('admin.admin_dashboard')

@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"> </script>

<div class="page-content  ">

  <div class="row profile-body  justify-content-center  ">

    <!-- right wrapper start -->
    <div class="col-md-8 col-xl-8 middle-wrapper ">
      <div class="row  ">
        <div class="card">
          <div class="card-body ">

            <h6 class="card-title">Add Roles in Permission</h6>

            <form id="myForm" method="POST" action="{{ route('store.role') }}" class="forms-sample">

              @csrf
              <div class="form-group mb-3">
                <label for="role_name" class="form-label">Role Name</label>
                <select name="role_id" class="form-select" @error('role_name') is-invalid @enderror>

                  <option selected="" value="" disabled="">Select Role</option>
                  @foreach ($roles as $role )

                  <option value={{ $role->id }}>{{ $role->name }}</option>
                  @endforeach

                </select>

                @error('role_name')
                <span class="text-danger">{{ $message }}</span>
                @enderror

              </div>

              <div class="mb-4">
                <div class="form-check mb-2">
                  <input type="checkbox" class="form-check-input" id="checkDefault">
                  <label class="form-check-label" for="checkDefault">
                    All Permissions
                  </label>
                </div>

              </div>

              <button type="submit" class="btn btn-primary me-2">Add Role</button>

            </form>

          </div>
        </div>

      </div>
    </div>




  </div>

</div>


<script type="text/javascript">
  $(document).ready(function (){
      $('#myForm').validate({
          rules: {
            amenity_name: {
                  required : true,
              }, 
              
          },
          messages :{
            amenity_name: {
                  required : 'Please Enter Role Name',
              }, 
               

          },
          errorElement : 'span', 
          errorPlacement: function (error,element) {
              error.addClass('invalid-feedback');
              element.closest('.form-group').append(error);
          },
          highlight : function(element, errorClass, validClass){
              $(element).addClass('is-invalid');
          },
          unhighlight : function(element, errorClass, validClass){
              $(element).removeClass('is-invalid');
          },
      });
  });
  
</script>


@endsection