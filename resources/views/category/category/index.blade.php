@extends('layouts.app', ['title' => 'Category Home Page'])

@section('dashboard-content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2 justify-content-between">
      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-left">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Dashboard v2</li>
        </ol>
      </div><!-- /.col -->
      <div class="col-sm-4 text-capitalize">
        <ol class="breadcrumb float-sm-right ">
          <a href="{{route('category.create')}}" class="btn btn-primary"> + Add New </a>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
  <div class="container-fluid">

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header text-capitalize">
            <h3 class="card-title">All categories list here</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="dataTable_example1" class="table table-bordered table-striped table-sm">
              <thead class=" text-capitalize">
                <tr>
                  <th>SL</th>
                  <th>Category Name</th>
                  <th>Category Slug</th>
                  {{-- <th>Icon</th>
                  <th>Home Page</th> --}}
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                @foreach($data as $key=>$row)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ $row->name }}</td>
                  <td>{{ $row->slug }}</td>
                  {{-- <td><img src="{{ asset($row->icon) }}" height="32" width="32"></td> --}}
                  {{-- <td>
                    @if($row->home_page==1)
                    <span class="badge badge-success">Home Page</span>
                    @endif
                  </td> --}}
                  <td class=" d-inline-flex">
                    <a href="#" class="btn btn-info btn-sm edit" data-id="{{ $row->id }}" data-toggle="modal"
                      data-target="#editModal"><i class="fas fa-edit"></i></a>
                    <form action="{{route('category.destroy' , $row->id)}}" method="post">
                      @csrf
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" href="{{ route('category.destroy',$row->id) }}"
                        class="btn btn-danger btn-sm" id="delete">
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



{{-- edit modal --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal_body">

      </div>
    </div>
  </div>
</div>

@push('css-link')

<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('') }}plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('') }}plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="{{ asset('') }}plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

@endpush

@push('js-link')

{{-- <script src="{{ asset('') }}plugins/datatables/jquery.dataTables.min.js"></script>
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
<script src="{{ asset('') }}plugins/datatables-buttons/js/buttons.colVis.min.js"></script> --}}


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




{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.js"></script>

<script type="text/javascript">
  $('.dropify').dropify();

</script>

<script type="text/javascript">
  document.body.addEventListener('click', function(event) {
    if (event.target.classList.contains('edit')) {
        let cat_id = event.target.getAttribute('data-id');
        let xhr = new XMLHttpRequest();
        
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById('modal_body').innerHTML = xhr.responseText;
            }
        };
        
        xhr.open('GET', "category/edit/" + cat_id, true);
        xhr.send();

        // with fetch 

        // fetch("category/edit/" + cat_id)
        // .then(response => response.text())
        // .then(data => {
        //     document.getElementById('modal_body').innerHTML = data;
        // })
        // .catch(error => {
        //     console.error('Error:', error);
        // });

    }
});


</script>
@endpush

@endsection