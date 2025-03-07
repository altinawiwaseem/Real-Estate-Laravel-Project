@extends('admin.admin_dashboard')

@section('admin')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"> </script>

<div class="page-content  ">

    <nav class="page-breadcrumb">
        <ol class="breadcrumb">

            <a href="{{ route('export')}}" class="btn btn-inverse-danger">Download Xlsx</a>

        </ol>
    </nav>

    <div class="row profile-body  justify-content-center  ">

        <!-- right wrapper start -->
        <div class="col-md-8 col-xl-8 middle-wrapper ">
            <div class="row  ">
                <div class="card">
                    <div class="card-body ">

                        <h6 class="card-title">Import Permission</h6>

                        <form id="myForm" method="POST" action="{{ route('import') }}" class="forms-sample"
                            enctype="multipart/form-data">

                            @csrf
                            <div class="form-group mb-3">
                                <label for="import_file" class="form-label">Xlsx File Import</label>
                                <input type="file" name="import_file" class="form-control" @error('import_file')
                                    is-invalid @enderror>

                                @error('import_file')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                            <button type="submit" class="btn btn-inverse-warning">Upload</button>

                        </form>

                    </div>
                </div>

            </div>
        </div>




    </div>

</div>





@endsection