@extends('layouts.app', ['title' => 'Ecommerce Dashboard'])

@section('dashboard-content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2 justify-content-between">
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-left">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard v2</li>
        </ol>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <a href="{{route('page.create')}}" class="btn btn-primary"> + Add New</a>
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
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">All page list here</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="dataTable_example1" class="table table-bordered table-striped table-sm">
              <thead>
                <tr>
                  <th>SL</th>
                  <th>Page Name</th>
                  <th>Page Title</th>
                  <th>Page Slug</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                @foreach($page as $key=>$row)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $row->name }}</td>
                  <td>{{ $row->title }}</td>
                  <td>{{ $row->slug }}</td>
                  <td class="d-inline-flex">
                    <a href="{{route('page.edit',$row->id)}}" class="btn btn-info btn-sm edit"><i
                        class="fas fa-edit"></i></a>
                    <form action="{{route('page.destroy' , $row->id)}}" method="post">
                      @csrf
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" href="{{ route('page.destroy',$row->id) }}" class="btn btn-danger btn-sm"
                        id="delete">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
      {{-- your content end--}}
    </div>
    <!--/. container-fluid -->
</section>
<!-- /.content -->

@endsection