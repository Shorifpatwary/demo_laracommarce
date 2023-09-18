@extends('layouts.app', ['title' => 'Create Product Attributes'])

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
            <h3 class="card-title">Create a attribute</h3>
          </div>
          <!-- /.card-header -->
          {{-- form start --}}
          <form action="{{ route('attribute.store') }}" method="POST" id="add-form">
            @csrf

            <div class="form-group">
              <label for="name">attribute Name</label>
              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required=""
                placeholder="attribute Name" value="{{ old('name') }}">
              @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="address">attribute Address</label>
              <input type="text" class="form-control @error('address') is-invalid @enderror" name="address" required=""
                placeholder="attribute Address" value="{{ old('address') }}">
              @error('address')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="phone">attribute Phone</label>
              <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" required=""
                placeholder="attribute Phone" value="{{ old('phone') }}">
              @error('phone')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary">
              <span class="submit_btn">Submit</span>
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
@push('script')
<wireui:scripts />
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
@endsection