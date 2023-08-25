@extends('layouts.app', ['title' => 'Create Warehouse'])

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
            <h3 class="card-title">Create a warehouse</h3>
          </div>
          <!-- /.card-header -->
          {{-- form start --}}
          <form action="{{ route('warehouse.update', $warehouse->id) }}" method="POST" id="edit-form">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div class="form-group">
                <label for="name">Warehouse Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required=""
                  value="{{ old('name', $warehouse->name) }}">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="address">Warehouse Address</label>
                <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                  required="" value="{{ old('address', $warehouse->address) }}">
                @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              <div class="form-group">
                <label for="phone">Warehouse Phone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" required=""
                  value="{{ old('phone', $warehouse->phone) }}">
                @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
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