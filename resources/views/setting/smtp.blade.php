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
    <div class="row justify-content-center">
      <div class="col-6">
        <div class="col-sm-6">
          <h1 class="m-0">Admin Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
            <li class="breadcrumb-item active">SMTP Mail</li>
          </ol>
        </div><!-- /.col -->
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
              <h3 class="card-title">SMTP Mail Settings</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" action="{{route('smtp.setting.update')}}" method="Post">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="mail_meiler">Mail Mailer</label>
                  <input type="hidden" name="types[]" value="MAIL_MAILER">
                  <input type="text" id="mail_meiler" class="form-control" name="MAIL_MAILER"
                    value="{{env('MAIL_MAILER')}}" placeholder="Mail Lailer Example: smtp">
                </div>
                <div class="form-group">
                  <label for="mail_host">Mail Host</label>
                  <input type="hidden" id="mail_host" name="types[]" value="MAIL_HOST">
                  <input type="text" class="form-control" name="MAIL_HOST" value="{{env('MAIL_HOST')}}"
                    placeholder="Mail Host">
                </div>
                <div class="form-group">
                  <label for="mail_port">Mail Port</label>
                  <input type="hidden" id="mail_port" name="types[]" value="MAIL_PORT">
                  <input type="text" class="form-control" name="MAIL_PORT" value="{{env('MAIL_PORT')}}"
                    placeholder="Mail Port Example: 2525">
                </div>
                <div class="form-group">
                  <label for="mail_username">Mail Username</label>
                  <input type="hidden" id="mail_username" name="types[]" value="MAIL_USERNAME">
                  <input type="text" class="form-control" name="MAIL_USERNAME" value="{{env('MAIL_USERNAME')}}"
                    placeholder="Mail Username">
                </div>
                <div class="form-group">
                  <label for="mail_password">Mail Password</label>
                  <input type="hidden" id="mail_password" name="types[]" value="MAIL_PASSWORD">
                  <input type="text" class="form-control" name="MAIL_PASSWORD" value="{{env('MAIL_PASSWORD')}}"
                    placeholder="Mail Password">
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