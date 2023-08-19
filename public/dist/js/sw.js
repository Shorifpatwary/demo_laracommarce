// In your service worker file (sw.js)
// get the base url
const protocol = window.location.protocol || "http:"; // Default to "http:" if protocol is empty
const hostname = window.location.hostname || "localhost"; // Default to "localhost" if hostname is empty
const port = window.location.port || ""; // Default to empty string if port is empty
const baseURL = `${protocol}//${hostname}${port ? `:${port}` : ""}`;

self.addEventListener("install", (event) => {
  event.waitUntil(
    caches.open("my-cache").then((cache) => {
      return cache.addAll([
        "https://cdnjs.cloudflare.com/ajax/libs/printThis/1.15.0/printThis.min.js",
        "https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback",
        "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css",
        "http://bootstrap-tagsinput.github.io/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js",
        "https://cdn.ckeditor.com/4.16.0/full/ckeditor.js",
        baseURL + "/plugins/fontawesome-free/css/all.min.css",
        baseURL + "/plugins/overlayScrollbars/css/OverlayScrollbars.min.css",
        baseURL + "/dist/css/adminlte.min.css",
        baseURL + "/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css",
        baseURL + "/plugins/toastr/toastr.min.css",
        baseURL + "/plugins/jquery/jquery.min.js",
        baseURL + "/plugins/bootstrap/js/bootstrap.bundle.min.js",
        baseURL +
          "/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js",
        baseURL + "/dist/js/adminlte.js",
        baseURL + "/plugins/jquery-mousewheel/jquery.mousewheel.js",
        baseURL + "/plugins/raphael/raphael.min.js",
        baseURL + "/plugins/jquery-mapael/jquery.mapael.min.js",
        baseURL + "/plugins/jquery-mapael/maps/usa_states.min.js",
        baseURL + "/plugins/chart.js/Chart.min.js",
        baseURL + "/dist/js/demo.js",
        baseURL + "/dist/js/pages/dashboard2.js",
        baseURL + "/plugins/sweetalert2/sweetalert2.min.js",
        baseURL + "/plugins/toastr/toastr.min.js",
        // data table
        baseURL + "/plugins/datatables/jquery.dataTables.min.js",
        baseURL + "/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js",
        baseURL +
          "/plugins/datatables-responsive/js/dataTables.responsive.min.js",
        baseURL +
          "/plugins/datatables-responsive/js/responsive.bootstrap4.min.js",
        baseURL + "/plugins/datatables-buttons/js/dataTables.buttons.min.js",
        baseURL + "/plugins/datatables-buttons/js/buttons.bootstrap4.min.js",
        baseURL + "/plugins/jszip/jszip.min.js",
        baseURL + "/plugins/pdfmake/pdfmake.min.js",
        baseURL + "/plugins/pdfmake/vfs_fonts.js",
        baseURL + "/plugins/datatables-buttons/js/buttons.html5.min.js",
        baseURL + "/plugins/datatables-buttons/js/buttons.print.min.js",
        baseURL + "/plugins/datatables-buttons/js/buttons.colVis.min.js",
        baseURL + "/plugins/summernote/summernote-bs4.min.js",

        // Add other resources you want to cache
      ]);
    })
  );
});

self.addEventListener("fetch", (event) => {
  event.respondWith(
    caches.match(event.request).then((response) => {
      return response || fetch(event.request);
    })
  );
});
