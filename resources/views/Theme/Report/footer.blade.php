   <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.0/sweetalert2.min.js"></script>
   <script src="{{ asset('assets-report') }}/js/core/bootstrap.min.js"></script>
   <!--   Core JS Files   -->
   <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
   <script src="{{ asset('assets-report') }}/js/plugins/perfect-scrollbar.min.js"></script>
   <script src="{{ asset('assets-report') }}/js/plugins/smooth-scrollbar.min.js"></script>
   <script src="{{ asset('assets-report') }}/js/plugins/flatpickr.min.js"></script>

   <script src="{{ asset('assets') }}/js/sweet-alert.js"></script>
   <script src="{{ asset('assets-report') }}/js/plugins/datatables.js"></script>
   <!-- Github buttons -->
   <script async defer src="https://buttons.github.io/buttons.js"></script>
   <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
   <script src="{{ asset('assets-report') }}/js/hgt-services.min.js?v=1.0.3"></script>
   <script>
       if (document.querySelector(".datepicker")) {
           flatpickr(".datepicker", {});
       }
   </script>
   <script>
       var win = navigator.platform.indexOf('Win') > -1;
       if (win && document.querySelector('#sidenav-scrollbar')) {
           var options = {
               damping: '0.5'
           }
           Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
       }
   </script>
   <script>
       const dataTableSearch = new simpleDatatables.DataTable("#datatable-search", {
           searchable: true
       });
       const dataTableBasic = new simpleDatatables.DataTable("#datatable-search1", {
           searchable: true
       });
   </script>
   @stack('script2')
   </body>

   </html>
