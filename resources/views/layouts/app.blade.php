<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ $title ?? config('app.name') }}</title>



  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('')}}plugins/fontawesome-free/css/all.min.css">
  {{-- latest v --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('')}}plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('')}}dist/css/adminlte.min.css">

  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{asset('')}}plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{asset('')}}plugins/toastr/toastr.min.css">

  @stack('css-link')

</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="{{ asset('') }}dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
        width="60">
    </div>

    <!-- Navbar -->
    @include('layouts.partials.navbar')
    <!-- /.navbar -->
    @guest
    @else
    @include('layouts.partials.sidebar')
    <!-- Main Sidebar Container -->
    @endguest


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      @yield('dashboard-content')

    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    @include('layouts.partials.footer')

    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{asset('')}}plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{asset('')}}plugins/bootstrap/js/bootstrap.bundle.min.js" defer></script>
    <!-- overlayScrollbars -->
    <script src="{{asset('')}}plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js" defer></script>
    <!-- AdminLTE App -->
    <script src="{{asset('')}}dist/js/adminlte.js" defer></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="{{asset('')}}plugins/jquery-mousewheel/jquery.mousewheel.js" defer></script>
    <script src="{{asset('')}}plugins/raphael/raphael.min.js"></script>
    <script src="{{asset('')}}plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="{{asset('')}}plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS -->
    <script src="{{asset('')}}plugins/chart.js/Chart.min.js" defer></script>


    <script src="{{asset('')}}dist/js/pages/dashboard2.js"></script>

    <!-- SweetAlert2 -->
    <script src="{{asset('')}}plugins/sweetalert2/sweetalert2.min.js" defer></script>
    <!-- Toastr -->
    <script src="{{asset('')}}plugins/toastr/toastr.min.js"></script>


    @stack('js-link')

    {{-- Swal message --}}
    @include('layouts.partials.swal')

    {{-- toastr message --}}
    @include('layouts.partials.toastr')


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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>
    <script src="{{ asset('') }}plugins/summernote/summernote-bs4.min.js"></script>
    <script>
      $(function () {
      // Summernote
      $('.textarea').summernote()
      })
    </script>
    {{-- <script src="{{ asset('') }}plugins/print_this/printThis.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js" defer></script>

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

    {{-- caching --}}
    {{-- don't cache this file --}}
    <script src="{{ asset('') }}dist/js/sw.js" defer> </script>

</body>

</html>