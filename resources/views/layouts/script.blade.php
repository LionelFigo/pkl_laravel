<!-- jQuery -->
<script src="{{ asset('asset_web/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('asset_web/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('asset_web/dist/js/adminlte.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('asset_web/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('asset_web/plugins/toastr/toastr.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('asset_web/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('asset_web/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('asset_web/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- Page specific script -->
<script>
  $(function () {
    if ($("#example1").length) {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    }
    if ($('#example2').length) {
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    }

    var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    @if (session('success'))
      Toast.fire({
        icon: 'success',
        title: '{{ session('success') }}'
      });
    @endif

    @if (session('error'))
      Toast.fire({
        icon: 'error',
        title: '{{ session('error') }}'
      });
    @endif

    @if ($errors->any())
      Toast.fire({
        icon: 'error',
        title: '{{ $errors->first() }}'
      });
    @endif
  });
</script>
