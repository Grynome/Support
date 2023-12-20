<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<!-- core:js -->
<script src="{{ asset('assets') }}/vendors/core/core.js"></script>
@stack('plugin-page')

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.10/dist/sweetalert2.all.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{ asset('assets') }}/vendors/feather-icons/feather.min.js"></script>
<script src="{{ asset('assets') }}/js/template.js"></script>
<!-- endinject -->
<!-- Custom js for this page -->
<script src="{{ asset('assets') }}/js/sweet-alert.js"></script>
@stack('custom-plug')
<script src="{{ asset('assets') }}/js/data-table.js"></script>

<script src="{{ asset('assets') }}/js/flatpickr.js"></script>
<script src="{{ asset('assets') }}/js/select2.js"></script>
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
{{-- <script src="{{ asset('assets') }}/js/myscript.js"></script> --}}
@stack('custom')
