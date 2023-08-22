@extends('layouts.app', ['title' => 'Brand Home Page'])

@section('dashboard-content')
<!-- Content Header (Page header) -->
{{-- <div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2 justify-content-between">
      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-left">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard </li>
        </ol>
      </div><!-- /.col -->
      <div class="col-sm-4 text-capitalize">
        <ol class="breadcrumb float-sm-right ">
          <a href="{{route('brand.create')}}" class="btn btn-primary"> + Add New </a>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div> --}}
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header text-capitalize">
            <h3 class="card-title">All brands list here</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="dataTable_example1" class="table table-bordered table-striped table-sm">
              <thead class=" text-capitalize">
                <tr>
                  <th>SL</th>
                  <th>brand Name</th>
                  <th>brand Slug</th>
                  <th>image</th>
                  <th>Home Page</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                @foreach($data as $key=>$row)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $row->name }}</td>
                  <td>{{ $row->slug }}</td>
                  {{-- image --}}
                  <td>
                    @if (str_starts_with($row->logo, 'http://') || str_starts_with($row->logo, 'https://'))
                    <img src="{{ $row->logo }}" height="32" width="32" loading="lazy">
                    @else
                    <img src="{{ asset($row->logo) }}" height="32" width="32" loading="lazy">
                    @endif
                  </td>
                  <td>
                    @if( $row->front_page == 1 )
                    <span class="badge badge-success">Home Page</span>
                    @endif
                  </td>
                  <td class=" d-inline-flex">
                    <a href="{{route('brand.edit' , $row->id)}}" class="btn btn-info btn-sm edit"
                      data-id="{{ $row->id }}">
                      <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{route('brand.destroy' , $row->id)}}" method="post">
                      @csrf
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" href="{{ route('brand.destroy',$row->id) }}" class="btn btn-danger btn-sm"
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
    </div>

  </div>
  <!--/. container-fluid -->
</section>
<!-- /.content -->


{{-- Data Table --}}
<script>
  $(function () {
    $("#dataTable_example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#dataTable_example1_wrapper .col-md-6:eq(0)');
    $('#dataTable_example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>

@endsection