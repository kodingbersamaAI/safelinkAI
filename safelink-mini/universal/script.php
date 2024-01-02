<!-- jQuery -->
<script src="../../adminlte/plugins/jquery/jquery.min.js"></script>
<script src="../../adminlte/plugins/jquery/jquery.link.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../../adminlte/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="../../adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../../adminlte/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="../../adminlte/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="../../adminlte/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="../../adminlte/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="../../adminlte/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../../adminlte/plugins/moment/moment.min.js"></script>
<script src="../../adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="../../adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="../../adminlte/plugins/summernote/summernote-bs4.min.js"></script>
<!-- BS-Stepper -->
<script src="../../adminlte/plugins/bs-stepper/js/bs-stepper.min.js"></script>
<!-- overlayScrollbars -->
<script src="../../adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="../../adminlte/js/adminlte.js"></script>
<!-- SweetAlert2 -->
<script src="../../adminlte/plugins/sweetalert2/sweetalert2.min.js"></script>
<script>
  $(document).ready(function() {
    var successMessages = {
      'register': 'Successfully registered.',
      'delete': 'Successfully deleted data.',
      'upgrade': 'Successfully upgraded to premium member. Please re-login.',
      'safelink': 'Successfully created a safelink.'
    };

    var errorMessages = {
      'access': 'You do not possess access.',
      'safelink': 'Failed to create a safelink.',
      'quota': 'Quota exceeded.',
      'register': 'Registration failed.',
      'delete': 'Failed to delete data.',
      'password': 'The passwords do not match.',
      'user': 'User not found.',
      'database': 'Database Error.',
      'terms': 'You have not agreed to the Terms of Service yet.',
      'upgrade': 'Email or Code do no match.',
      'email': 'The email is already registered.'
    };

    var successParam = new URLSearchParams(window.location.search).get('success');
    var errorParam = new URLSearchParams(window.location.search).get('error');

    // Menampilkan pesan sukses jika ada
    if (successParam && successMessages[successParam]) {
      Swal.fire({
        icon: 'success',
        title: 'Seccess',
        text: successMessages[successParam]
      });
    }

    // Menampilkan pesan kesalahan jika ada
    if (errorParam && errorMessages[errorParam]) {
      Swal.fire({
        icon: 'error',
        title: 'Error',
        text: errorMessages[errorParam]
      });
    }
  });
</script>
<!-- DataTables  & Plugins -->
<script src="../../adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../adminlte/plugins/jszip/jszip.min.js"></script>
<script src="../../adminlte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../adminlte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Select2 -->
<script src="../../adminlte/plugins/select2/js/select2.min.js"></script>
<script src="../../adminlte/plugins/select2/js/select2.full.min.js"></script>

<!-- Parameter Remover -->
<script>
  // Mendeteksi event sebelum halaman dimuat ulang
  window.addEventListener('load', function (event) {
    // Lakukan sesuatu saat halaman dimuat ulang (misalnya refresh)
    console.log('Halaman dimuat ulang');
    // Hapus parameter dari URL jika dibutuhkan
    if (window.history.replaceState) {
        var newUrl = window.location.href.split('?')[0];
        window.history.replaceState({ path: newUrl }, '', newUrl);
    }
});
</script>