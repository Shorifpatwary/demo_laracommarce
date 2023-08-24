@extends('layouts.app', ['title' => 'Ecommerce Dashboard'])

@section('dashboard-content')
<!-- Content Header (Page header) -->
<div class="content-header text-capitalize">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard v2</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">settings</li>
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
    <div class="row ">

      <div class="col-sm-6 float-sm-left">
        <h1 class="m-0 ">Admin Dashboard</h1>
      </div><!-- /.col -->
      <div class="col-sm-6 float-sm-right">
        <ol class="breadcrumb ">
          <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
          <li class="breadcrumb-item active">SMTP Mail</li>
        </ol>
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Info boxes -->
      <div class="row justify-content-center">
        <div class="col-6">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Website Setting</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{route('website.setting.update',$setting->id)}}" method="Post"
              enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                {{-- currency --}}
                <div class="form-group">
                  <label for="currency">Currency</label>
                  <select class="form-control @error('currency') is-invalid @enderror" name="currency">
                    <option value="৳" {{ old('currency', $setting->currency) === '৳' ? 'selected' : '' }}>Taka (৳)
                    </option>
                    <option value="$" {{ old('currency', $setting->currency) === '$' ? 'selected' : '' }}>USD ($)
                    </option>
                    <option value="₹" {{ old('currency', $setting->currency) === '₹' ? 'selected' : '' }}>Rupee (₹)
                    </option>
                  </select>
                  @error('currency')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                </div>
                {{-- phone one --}}
                <div class="form-group">
                  <label for="phone_one">Phone One</label>
                  <input type="text" class="form-control @error('phone_one') is-invalid @enderror" name="phone_one"
                    value="{{ old('phone_one', $setting->phone_one) }}" required>
                  @error('phone_one')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                </div>
                {{-- phone tow --}}
                <div class="form-group">
                  <label for="phone_two">Phone Two</label>
                  <input type="text" class="form-control @error('phone_two') is-invalid @enderror" name="phone_two"
                    value="{{ old('phone_two', $setting->phone_two) }}" required>
                  @error('phone_two')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                </div>
                {{-- main email --}}
                <div class="form-group">
                  <label for="main_email">Main Email</label>
                  <input type="email" class="form-control @error('main_email') is-invalid @enderror" name="main_email"
                    value="{{ old('main_email', $setting->main_email) }}">
                  @error('main_email')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                </div>
                {{-- support email --}}
                <div class="form-group">
                  <label for="support_email">Support Email</label>
                  <input type="email" class="form-control @error('support_email') is-invalid @enderror"
                    name="support_email" value="{{ old('support_email', $setting->support_email) }}">
                  @error('support_email')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                </div>
                {{-- address --}}
                <div class="form-group">
                  <label for="address">Address</label>
                  <input type="text" class="form-control @error('address') is-invalid @enderror" name="address"
                    value="{{ old('address', $setting->address) }}">
                  @error('address')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                </div>

                <strong class="text-info">Social Link</strong>
                {{-- facebook url --}}
                <div class="form-group">
                  <label for="facebook">Facebook</label>
                  <input type="text" class="form-control @error('facebook') is-invalid @enderror" name="facebook"
                    value="{{ old('facebook', $setting->facebook) }}">
                  @error('facebook')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                </div>
                {{-- twitter url --}}
                <div class="form-group">
                  <label for="twitter">Twitter</label>
                  <input type="text" class="form-control @error('twitter') is-invalid @enderror" name="twitter"
                    value="{{ old('twitter', $setting->twitter) }}">
                  @error('twitter')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                </div>
                {{-- instagram url --}}
                <div class="form-group">
                  <label for="instagram">Instagram</label>
                  <input type="text" class="form-control @error('instagram') is-invalid @enderror" name="instagram"
                    value="{{ old('instagram', $setting->instagram) }}">
                  @error('instagram')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                </div>
                {{-- Linkedin url --}}
                <div class="form-group">
                  <label for="linkedin">Linkedin</label>
                  <input type="text" class="form-control @error('linkedin') is-invalid @enderror" name="linkedin"
                    value="{{ old('linkedin', $setting->linkedin) }}">
                  @error('linkedin')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                </div>
                {{-- You Tube url --}}
                <div class="form-group">
                  <label for="youtube">Youtube</label>
                  <input type="text" class="form-control @error('youtube') is-invalid @enderror" name="youtube"
                    value="{{ old('youtube', $setting->youtube) }}">
                  @error('youtube')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                </div>

                <strong class="text-info">Logo & Favicon</strong>
                {{-- main logo --}}
                <div class="form-group">
                  <label for="logo">Main Logo</label>
                  <input type="file" class="form-control-file @error('logo') is-invalid @enderror" name="logo">
                  <input type="hidden" name="old_logo" value="{{ $setting->logo }}">
                  @error('logo')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                </div>
                {{-- favicon --}}
                <div class="form-group">
                  <label for="favicon">Favicon</label>
                  <input type="file" class="form-control-file @error('favicon') is-invalid @enderror" name="favicon">
                  <input type="hidden" name="old_favicon" value="{{ $setting->favicon }}">
                  @error('favicon')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                  @enderror
                </div>

              </div>
              <!-- /.card-body -->

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
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