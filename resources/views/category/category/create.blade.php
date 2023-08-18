@extends('layouts.app', ['title' => 'Create Shop Category'])

@section('dashboard-content')
<!-- Content Header (Page header) -->

<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    {{-- your content start--}}
    <div class="row d-flex justify-content-center align-content-center">
      <!-- Center the row -->
      <div class="col-md-6">
        <!-- Adjust the column size as needed -->
        <div class="card">
          <div class="card-body">
            <form action="{{ route('category.store') }}" method="Post" enctype="multipart/form-data">
              @csrf
              {{-- category name --}}
              <div class="form-group">
                <label for="name">Category Name</label>
                <input type="text" class="form-control @error('name')  is-invalid @enderror" id="name" name="name"
                  value="{{old('name')}}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small id="emailHelp" class="form-text text-muted">This is your main category</small>
              </div>
              {{-- category icon --}}
              {{-- <div class="form-group">
                <label for="name">Category Icon</label>
                <input type="file" class="dropify" id="icon" name="icon" required>
              </div> --}}
              {{-- show on homepage --}}
              {{-- <div class="form-group">
                <label for="name">Show on Homepage</label>
                <select class="form-control" name="home_page">
                  <option value="1">Yes</option>
                  <option value="0">No</option>
                </select>
                <small id="emailHelp" class="form-text text-muted">If yes it will be shown on your home page</small>
              </div> --}}
              <button type="Submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    {{-- your content end--}}
  </div>
  <!--/. container-fluid -->
</section>

<!-- /.content -->

@endsection