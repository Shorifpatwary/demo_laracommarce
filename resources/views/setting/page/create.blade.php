@extends('layouts.app', ['title' => 'Ecommerce Dashboard'])

@section('dashboard-content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard v2</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard v2</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    {{-- your content start--}}
    <!-- Info boxes -->
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Create a new page</h3>
          </div>
          <!-- /.card-header -->

          <!-- form start -->
          <form role="form" action="{{ route('page.store') }}" method="POST">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="position">Page Position</label>
                <select class="form-control @error('position') is-invalid @enderror" id="position" name="position">
                  <option value="">Select</option>
                  <option value="1" {{ old('position')=='1' ? 'selected' : '' }}>Line One</option>
                  <option value="2" {{ old('position')=='2' ? 'selected' : '' }}>Line Two</option>
                </select>
                @error('position')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="name">Page Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                  placeholder="Page Name" value="{{ old('name') }}">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="title">Page Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
                  placeholder="Page Title" value="{{ old('title') }}">
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="description">Page Description</label>
                <textarea class="form-control textarea @error('description') is-invalid @enderror" id="description"
                  rows="4" name="description">{{ old('description') }}</textarea>
                <small>This data will show on your webpage.</small>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Create Page</button>
            </div>

          </form>
          {{-- form end --}}
        </div>
      </div>
      {{-- your content end--}}
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->
@endsection