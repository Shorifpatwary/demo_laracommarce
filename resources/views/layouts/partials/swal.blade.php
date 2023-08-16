<!-- SweetAlert2 CSS -->
{{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.css"> --}}

<!-- SweetAlert2 JS (including Swal.fire) -->
{{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.min.js" defer></script> --}}


<script>
  document.getElementById('logout').addEventListener('click', function (event) {
      event.preventDefault();

      Swal.fire({
          title: 'Are you sure?',
          text: "You will be logged out.",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, log me out!',
          cancelButtonText: 'Cancel'
      }).then((result) => {
          if (result.isConfirmed) {
              // User confirmed, submit the form
              document.getElementById('logout-form').submit();
          }
      });
  });
</script>
