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
    <div class="row justify-content-center">
      <div class="col-12">
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Update Page</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" action="{{ route('page.update', $data->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
              <div class="form-group">
                <label for="position">Page Position</label>
                <select class="form-control @error('position') is-invalid @enderror" name="position" id="position">
                  <option value="1" {{ old('position', $data->position) == 1 ? 'selected' : '' }}>Line One</option>
                  <option value="2" {{ old('position', $data->position) == 2 ? 'selected' : '' }}>Line Two</option>
                </select>
                @error('position')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="name">Page Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                  value="{{ old('name', $data->name) }}">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="title">Page Title</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title"
                  value="{{ old('title', $data->title) }}">
                @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="description">Page Description</label>
                <textarea class="form-control textarea @error('description') is-invalid @enderror" rows="4"
                  name="description" id="description">{{ old('description', $data->description) }}</textarea>
                <small>This data will show on your webpage.</small>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">Update Page</button>
            </div>
          </form>

          {{-- form end --}}
        </div>
      </div>
    </div>
    {{-- your content end--}}
  </div>
  <!--/. container-fluid -->
</section>
<!-- /.content -->

@endsection