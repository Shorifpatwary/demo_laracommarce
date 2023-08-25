@extends('layouts.app', ['title' => 'Update Pickup Point'])

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
            <h3 class="card-title">Update Pickup Point</h3>
          </div>
          <!-- /.card-header -->
          {{-- form start --}}
          <form action="{{ route('pickup-point.update' , $pickupPoint->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="modal-body">
              <div class="form-group">
                <label for="name">Pickup Point Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                  value="{{ old('name', $pickupPoint->name) }}" name="name" id="name" required="" maxlength="255">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <input type="hidden" name="id" value="{{ $pickupPoint->id }}">
              </div>
              <div class="form-group">
                <label for="address">Address <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('address') is-invalid @enderror"
                  value="{{ old('address', $pickupPoint->address) }}" name="address" id="address" required=""
                  maxlength="255">
                @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <label for="phone">Phone <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                  value="{{ old('phone', $pickupPoint->phone) }}" name="phone" id="phone" required="" maxlength="25">
                @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <label for="phone_two">Another Phone</label>
                <input type="text" class="form-control @error('phone_two') is-invalid @enderror"
                  value="{{ old('phone_two', $pickupPoint->phone_two) }}" name="phone_two" id="phone_two"
                  maxlength="25">
                @error('phone_two')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Update</button>
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