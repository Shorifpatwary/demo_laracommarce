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
        <div class="card card-primary">
          <div class="card-header text-capitalize">
            <h3 class="card-title">Your SEO Settings</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" action="{{route('seo.setting.update',$data->id)}}" method="Post">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="meta_title">Meta Title</label>
                <input type="text" id="meta_title" class="form-control" name="meta_title" value="{{$data->meta_title}}"
                  placeholder="Meta Title">
              </div>
              <div class="form-group">
                <label for="meta_author">Meta Author</label>
                <input type="text" id="meta_author" class="form-control" name="meta_author"
                  value="{{$data->meta_author}}" placeholder="Meta Author">
              </div>
              <div class="form-group">
                <label for="meta_tag">Meta Tags</label>
                <input type="text" id="meta_tag" class="form-control" name="meta_tag" value="{{$data->meta_tag}}"
                  placeholder="Meta Tags">
              </div>
              <div class="form-group">
                <label for="meta_keyword">Meta Keyword</label>
                <input type="text" id="meta_keyword" class="form-control" name="meta_keyword"
                  value="{{$data->meta_keyword}}" placeholder="Meta Keyword">
                <small>Example:ecommerce,online shop,online market</small>
              </div>
              <div class="form-group">
                <label for="meta_description">Meta Description</label>
                <textarea class="form-control" id="meta_description"
                  name="meta_description">{{$data->meta_description}}</textarea>
              </div>

              <strong class="text-center text-success"> -- Other Option -- </strong><br>

              <div class="form-group">
                <label for="google_verification">Google Verification</label>
                <input type="text" id="google_verification" class="form-control" name="google_verification"
                  value="{{$data->google_verification}}" placeholder="Google Verification">
                <small>Put here only verification code</small>
              </div>
              <div class="form-group">
                <label for="alexa_verification">Alexa verification </label>
                <input type="text" id="alexa_verification" class="form-control" name="alexa_verification"
                  value="{{$data->alexa_verification}}" placeholder="Alexa Verification">
                <small>Put here only verification code</small>
              </div>

              <div class="form-group">
                <label for="google_analytics">Google Analytics</label>
                <textarea class="form-control" id="google_analytics"
                  name="google_analytics">{{$data->google_analytics}}</textarea>
              </div>
              <div class="form-group">
                <label for="google_adsense">Google Adsense</label>
                <textarea class="form-control" id="google_adsense"
                  name="google_adsense">{{$data->google_adsense}}</textarea>
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
    {{-- your content end--}}
  </div>
  <!--/. container-fluid -->
</section>
<!-- /.content -->

@endsection