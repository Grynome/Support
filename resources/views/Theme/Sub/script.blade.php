<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!-- core:js -->
<script src="{{ asset('assets') }}/vendors/core/core.js"></script>
<!-- endinject -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<!-- Plugin js for this page -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/es6-promise@4.2.8/dist/es6-promise.auto.min.js"></script>
@stack('plugin-page')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.10/dist/sweetalert2.all.js"></script>
<script src="{{ asset('assets') }}/vendors/datatables.net/jquery.dataTables.js"></script>
<script src="{{ asset('assets') }}/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
<script src="{{ asset('assets') }}/vendors/inputmask/jquery.inputmask.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="{{ asset('assets') }}/vendors/dropify/dist/dropify.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{ asset('assets') }}/vendors/feather-icons/feather.min.js"></script>
<script src="{{ asset('assets') }}/js/template.js"></script>
<script src="{{ asset('assets') }}/js/select2.js"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="{{ asset('assets') }}/js/sweet-alert.js"></script>
@stack('custom-plug')
<script src="{{ asset('assets') }}/js/flatpickr.js"></script>
<script src="{{ asset('assets') }}/js/inputmask.js"></script>
<script src="{{ asset('assets') }}/js/data-table.js"></script>
<script src="{{ asset('assets') }}/js/dropify.js"></script>
<script>
    (function($) {
        'use strict';
        $(function() {
            if ($('.perfect-scrollbar-example').length) {
                var scrollbarExample = new PerfectScrollbar('.perfect-scrollbar-example');
            }

        });
    })(jQuery);
</script>
<script>
    $('.log-out').on('click', function() {
        var getLink = $(this).attr('href');
        window.location.href = getLink;
        jQuery("#formLog").submit();
    });
</script>
<script>
    $(document).ready(function() {
        $(".modal").each(function() {
            var modalId = $(this).attr("id");
            $("#" + modalId + " select").each(function() {
                $(this).select2({
                    dropdownParent: $("#" + modalId),
                    modal: false
                });
            });
        });
    });
</script>
<script>
    $('input[name="sidebarThemeSettings"]').on('change', function() {
        var theme = $(this).val();

        $.ajax({
            url: '/theme',
            method: 'PATCH',
            data: {
                theme: theme,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status == 'success') {
                    // Tampilkan pesan sukses jika permintaan berhasil
                    alert('Tema berhasil diubah!');
                }
            }
        });
    });
</script>
<script>

</script>
<script>
    $(document).ready(function() {
        $('table#display').DataTable({
            "aLengthMenu": [
            [10, 30, 50, -1],
            [10, 30, 50, "All"]
            ],
            "iDisplayLength": 10,
            "language": {
            search: ""
            },
        });
        
        $('table#d-Monthly').DataTable({
            "aLengthMenu": [
            [10, 30, 50, -1],
            [10, 30, 50, "All"]
            ],
            "iDisplayLength": 10,
            "language": {
            search: ""
            },
            scrollX: true,
        });
        $('table#tblDash').DataTable({
            "aLengthMenu": [
                [-1],
                ["All"]
            ],
            "paging": false,
            searching: false,
            "info": false,
        });
        $('table#display').each(function() {
            var datatable = $(this);
            var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
            search_input.attr('placeholder', 'Search');
            search_input.removeClass('form-control-sm');
            var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
            length_sel.removeClass('form-control-sm');
        });
    });

    $(document).ready(function() {
        var sweetalert = "{{ session()->get('sweetalert') }}";
        var message = "{{ session()->get('message') }}";
        if (sweetalert) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: message
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    var modal = "{{ session()->get('modal') }}";
                    if (modal) {
                        $('#' + modal).modal('show');
                    }
                }
            });
        }
    });
</script>
<script src="{{ asset('assets') }}/js/myscript.js"></script>
@stack('custom')
