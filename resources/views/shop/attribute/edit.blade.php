@extends('layouts.app', ['title' => 'Create Attribute'])

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
      <div class="col-8">
        <div class="card card-primary p-2">
          <div class="card-header">
            <h3 class="card-title">Create a Attribute</h3>
          </div>
          <!-- /.card-header -->
          {{-- form start --}}
          <form action="{{ route('attribute.update', $attribute->id) }}" method="POST" id="edit-form">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div class="form-group">
                <label for="type">Attribute Type</label>
                <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required="">
                  <option disabled {{ old('type')==='' ? 'selected' : '' }}>Select an option</option>
                  @foreach($enumOptions as $option)
                  <option value="{{ $option }}" {{ old('type', $attribute->type)===$option ? 'selected' : '' }}>{{
                    ucfirst($option) }}
                  </option>
                  @endforeach
                </select>
                @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="name">attribute name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required=""
                  placeholder="attribute name" value="{{ old('name', $attribute->name) }}">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>s
                @enderror
              </div>
              <button type="submit" class="btn btn-primary">
                <span class="submit_btn">Update</span>
              </button>
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