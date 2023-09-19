{{-- toastr dynamic alert with laravel --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


@if (session('notification'))
<script>
    toastr.options = {
    "closeButton": true,       // Display a close button to close the alert
    "debug": false,            // Enable debug mode
    "newestOnTop": true,       // Display newest toast at the top
    "progressBar": true,       // Display a progress bar indicating time until the toast expires
    "positionClass": "toast-bottom-left",  // Position of the toast. Possible values: 'toast-top-right', 'toast-top-left', 'toast-bottom-right', 'toast-bottom-left', 'toast-top-full-width', 'toast-bottom-full-width', 'toast-top-center', 'toast-bottom-center'
    "preventDuplicates": false,   // Prevent duplicates of the same toast message
    "onclick": null,           // Function to execute when the toast is clicked
    "showDuration": "300",     // Duration of the toast show animation (milliseconds)
    "hideDuration": "1000",    // Duration of the toast hide animation (milliseconds)
    "timeOut": "5000",         // Time until the toast automatically closes (milliseconds)
    "extendedTimeOut": "1000", // Time to close the toast after a user hovers over it (milliseconds)
    "showEasing": "swing",     // Easing for the toast show animation
    "hideEasing": "linear",    // Easing for the toast hide animation
    "showMethod": "fadeIn",    // Method for the toast show animation. Possible values: 'show', 'fadeIn', 'slideDown', 'slideUp', etc.
    "hideMethod": "fadeOut"    // Method for the toast hide animation. Possible values: 'hide', 'fadeOut', 'slideUp', 'slideDown', etc.
};

        var alertType = "{{ session('notification.alert-type') }}";
        var message = "{{ session('notification.message') }}";

        switch (alertType) {
            case 'success':
                toastr.success(message);
                break;
            case 'warning':
                toastr.warning(message);
                break;
            case 'error':
                toastr.error(message);
                break;
            case 'info':
                toastr.info(message);
                break;
        }
</script>
@endif