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
            <table id="attribute_data_table" class="table table-bordered table-striped table-sm">
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
                    <a href="{{route('brand.edit' , $row->id)}}" class="btn btn-info btn-sm edit mr-2"
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


@pushOnce('css-link')
<link rel="stylesheet" href="{{ asset('') }}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('') }}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('') }}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endPushOnce
@pushOnce('js-link')
{{-- data table cdn links --}}

<script src="{{ asset('') }}plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('') }}plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('') }}plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('') }}plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{ asset('') }}plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{ asset('') }}plugins/jszip/jszip.min.js"></script>
<script src="{{ asset('') }}plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{ asset('') }}plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
{{-- Data Table --}}
<script>
  $(function () {
    $("#attribute_data_table").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#attribute_data_table_wrapper .col-md-6:eq(0)');
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
@endPushOnce

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>

@endsection