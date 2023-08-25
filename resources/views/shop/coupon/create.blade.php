@extends('layouts.app', ['title' => 'Create Coupon'])

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
            <h3 class="card-title">Create a coupon</h3>
          </div>
          <!-- /.card-header -->
          {{-- form start --}}
          <form action="{{ route('coupon.store') }}" method="POST">
            @csrf

            <div class="form-group">
              <label for="code">Coupon Code</label>
              <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" required=""
                value="{{ old('code') }}">
              @error('code')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="type">Coupon Type</label>
              <select class="form-control @error('type') is-invalid @enderror" name="type" required>
                <option value="" disabled>Select</option>
                <option value="1" {{ old('type')=='1' ? 'selected' : '' }}>Fixed</option>
                <option value="2" {{ old('type')=='2' ? 'selected' : '' }}>Percentage</option>
              </select>
              @error('type')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="amount">Amount</label>
              <input type="number" class="form-control @error('amount') is-invalid @enderror" name="amount" required=""
                value="{{ old('amount') }}">
              @error('amount')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="valid_date">Valid Date</label>
              <input type="date" id="valid_date" class="form-control @error('valid_date') is-invalid @enderror"
                name="valid_date" required="" value="{{ old('valid_date') }}">
              @error('valid_date')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-group">
              <label for="status">Coupon Status</label>
              <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                <option value="" disabled>Select</option>
                <option value="active" {{ old('status')=='active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status')=='inactive' ? 'selected' : '' }}>Inactive</option>
                <option value="expired" {{ old('status')=='expired' ? 'selected' : '' }}>Inactive</option>
              </select>
              @error('status')
              <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <button type="submit" class="btn btn-primary">
              Submit
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