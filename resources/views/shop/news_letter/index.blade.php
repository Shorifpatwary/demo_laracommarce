@extends('layouts.app', ['title' => 'Product Page'])

@section('dashboard-content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Product</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <a href="{{route('product.create')}}" class="btn btn-primary"> + Add New </a>
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
        {{-- Now Hide this table --}}
        {{-- @livewire('product-table') --}}
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Products List</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered  table-sm ytable">
              <thead class="text-capitalize">
                <tr>
                  <th>SL</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>

          </div>
        </div>
      </div>
    </div>
    {{-- your content end--}}
  </div>
  <!--/. container-fluid -->
</section>
<!-- /.content -->

@push('css-link')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.rtl.min.css"
  integrity="sha384-PRrgQVJ8NNHGieOA1grGdCTIt4h21CzJs6SnWH4YMQ6G5F5+IEzOHz67L4SQaF0o" crossorigin="anonymous">

<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">


<link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
@endpush


@push('js-link')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>


<script type="text/javascript">
  $(document).ready(function() {
  var table = $('.ytable').DataTable({
     dom: 'lBfrtip', 
     processing:true,
			serverSide:true,
			ajax:"{{ route('news_letter.index') }}",
			columns:[
				{data:'DT_RowIndex',name:'DT_RowIndex'},
        // ,orderable:true, searchable:true
				{data:'email'  ,name:'email'},
			]
  });
});
</script>

@endpush
@endsection