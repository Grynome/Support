
<!DOCTYPE html>
<!--
Template Name: NobleUI - HTML Bootstrap 5 Admin Dashboard Template
Author: NobleUI
Website: https://www.nobleui.com
Portfolio: https://themeforest.net/user/nobleui/portfolio
Contact: nobleui123@gmail.com
Purchase: https://1.envato.market/nobleui_admin
License: For each use you must have a valid license purchased only from above link in order to legally use the theme for your project.
-->
<html lang="en">
    @include('Theme/Sub/head')
<body>
	<form action="{{ url('logout') }}" method="POST" id="log_out">
		{{ csrf_field() }}
	</form>
	@push('custom')
		<script>
			Swal.fire({
				title: "Your account has not been verified!!",
				text: "Pls Call Developer Contact Person!",
				icon: 'error',
				allowOutsideClick: false,
				showCancelButton: false,
				confirmButtonColor: '#d33',
				confirmButtonText: 'Back'
			}).then((result) => {
				jQuery("#log_out").submit();
			});
		</script>
	@endpush
	<div class="main-wrapper">
		<div class="page-wrapper full-page">
			<div class="page-content d-flex align-items-center justify-content-center">
				<div class="row w-100 mx-0 auth-page">
					<div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
						<img src="{{ asset('assets') }}/images/others/404.svg" class="img-fluid mb-2" alt="404">
					</div>
				</div>

			</div>
		</div>
	</div>

	@include('Theme/Sub/script')
</body>
</html>