@extends('layouts.app', ['title' => 'Create Shop Sub Category'])

@section('dashboard-content')
<!-- Content Header (Page header) -->

<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    {{-- your content start--}}
    <div class="row d-flex justify-content-center align-content-center">
      @if($errors->any())
      <div class="alert alert-danger">
        <ul>
          @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif

      <!-- Center the row -->
      <div class="col-md-6">
        <!-- Adjust the column size as needed -->
        <div class="card">
          <div class="card-body">
            <form action="{{ route('sub-category.store') }}" method="Post" enctype="multipart/form-data">
              @csrf
              {{-- category name --}}
              <div class="form-group">
                <label for="name" class=" text-capitalize">Sub Category Name</label>
                <input type="text" class="form-control @error('name')  is-invalid @enderror" id="name" name="name"
                  value="{{old('name')}}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small id="emailHelp" class="form-text  text-capitalizetext-muted">This is your sub category</small>
              </div>
              {{-- parent category --}}
              <div class="form-group">
                <label for="category_id">Category Name</label>
                <select class="form-control @error('category_id')  is-invalid @enderror" name="category_id"
                  value="{{old('category_id')}}" required>
                  <option value="">Select</option>
                  @foreach($data as $row)
                  <option value="{{ $row->id }}">{{ $row->name }}</option>
                  @endforeach
                </select>
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