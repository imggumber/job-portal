<!DOCTYPE html>
<html class="no-js" lang="en_AU">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>{{ env("APP_NAME") }}</title>
	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />
	<meta name="HandheldFriendly" content="True" />
	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="pinterest" content="nopin" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css')}}" />
	<!-- Fav Icon -->
	<link rel="shortcut icon" type="image/x-icon" href="#" />

	<style>
		.toast {
			transition: opacity 4s ease-in-out;
		}

		.toast.fade {
			opacity: 0 !important;
		}

		#confirm-delete-modal {
			display: none;
		}

		#confirm-delete-modal.show {
			display: block;
		}

		body.modal-open {
			overflow: hidden;
			pointer-events: none;
		}
	</style>
</head>

<body data-instant-intensity="mousedown">
	<header>
		<nav class="navbar navbar-expand-lg navbar-light bg-white shadow py-3">
			<div class="container">
				<a class="navbar-brand" href="{{ route('home') }}">{{ env("APP_NAME") }}</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav ms-0 ms-sm-0 me-auto mb-2 mb-lg-0 ms-lg-4">
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="{{ route('home') }}">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" aria-current="page" href="jobs.html">Find Jobs</a>
						</li>
					</ul>
					@if (!Auth::check())
					<a class="btn btn-outline-primary me-2" href="{{ route('account.login') }}" type="submit">Login</a>
					@else
					<a class="btn btn-outline-primary me-2" href="{{ route('account.profile') }}" type="submit">Profile</a>
					@endif
					<a class="btn btn-primary" href="{{ route('job.job') }}" type="submit">Post a Job</a>
				</div>
			</div>
		</nav>
	</header>

	<main class="position-relative">
		@include('front.messages.message')

		@yield('main')

		<!-- Add profile picture model -->
		@include('front.partials.modals.add-profile')

		<!-- Add company modal -->
		@include('front.partials.modals.add-company')

		<!-- View Company modal -->
		@include('front.partials.modals.view-company')

		<!-- View delete modal -->
		@include('front.partials.modals.confirm-delete')

	</main>

	<footer class="bg-dark py-3 bg-2">
		<div class="container">
			<p class="text-center text-white pt-3 fw-bold fs-6">&copy; @php echo date('Y') ."-". (date('Y') + 1) @endphp {{ env("APP_NAME") }} - All Right Reserved</p>
		</div>
	</footer>
	<script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
	<script src="{{ asset('assets/js/bootstrap.bundle.5.1.3.min.js') }}"></script>
	<script src="{{ asset('assets/js/instantpages.5.1.0.min.js') }}"></script>
	<script src="{{ asset('assets/js/lazyload.17.6.0.min.js') }}"></script>
	<script src="{{ asset('assets/js/custom.js') }}"></script>

	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		// Update profile pic modal
		$("#proficPicForm").submit(function(e) {
			e.preventDefault();

			var formData = new FormData(this);

			$.ajax({
				url: '{{ route("account.updateProfilePic") }}',
				type: 'post',
				data: formData,
				dataType: 'json',
				contentType: false,
				processData: false,
				success: function(response) {
					if (response.status == false) {
						var errors = response.errors;
						if (errors.image) {
							$("#image").addClass("is-invalid").siblings("p").addClass("text-danger").html(errors.image);
						} else {
							$("#image").removeClass("is-invalid").siblings("p").removeClass("text-danger").html("");
						}
					} else {
						$("#image").removeClass("is-invalid").siblings("p").removeClass("text-danger").html("");
						window.location.reload();
					}
				}
			});
		});

		// Add new company
		$("#addCompanyForm").submit(function(e) {
			e.preventDefault();

			$.ajax({
				url: '{{ route("company.addCompany") }}',
				type: 'post',
				data: $("#addCompanyForm").serializeArray(),
				dataType: 'json',
				success: function(response) {
					if (response.status == false) {
						var errors = response.errors;
						if (errors.companyName) {
							$("#companyName").addClass("is-invalid").siblings("p").addClass("is-invalid-feedback").html(errors.companyName);
						} else {
							$("#companyName").removeClass("is-invalid").siblings("p").removeClass("is-invalid-feedback").html("");
						}
						if (errors.companyAddress) {
							$("#companyAddress").addClass("is-invalid").siblings("p").addClass("is-invalid-feedback").html(errors.companyAddress);
						} else {
							$("#companyAddress").removeClass("is-invalid").siblings("p").removeClass("is-invalid-feedback").html("");
						}
						if (errors.companyWebsite) {
							$("#companyWebsite").addClass("is-invalid").siblings("p").addClass("is-invalid-feedback").html(errors.companyWebsite);
						} else {
							$("#companyWebsite").removeClass("is-invalid").siblings("p").removeClass("is-invalid-feedback").html("");
						}
						if (errors.slug) {
							$("#company-exists").addClass("is-invalid").html(errors.slug);
						} else {
							$("#company-exists").removeClass("is-invalid").html("");
						}
					} else {
						$("#companyName").removeClass("is-invalid").siblings("p").removeClass("is-invalid-feedback").html("");
						$("#companyAddress").removeClass("is-invalid").siblings("p").removeClass("is-invalid-feedback").html("");
						$("#companyWebsite").removeClass("is-invalid").siblings("p").removeClass("is-invalid-feedback").html("");
						$("#company-exists").removeClass("is-invalid").html("");

						window.location.reload();
					}
				}
			});
		});

		// Expire job
		$(".expire-job, .close-del-modal").off("click").on("click", function() {
			let jobId = $(this).attr("data-job-id");
			let confirmDelModal = $("#confirm-delete-modal");

			if (confirmDelModal.hasClass("show")) {
				$("#del-job-btn").attr("delete-job", "");
				confirmDelModal.removeClass("show");
				$("body").removeClass("modal-open");
			} else {
				$("#del-job-btn").attr("delete-job", jobId);
				confirmDelModal.addClass("show");
				$("body").addClass("modal-open");
			}
		});

		// Change job status from active to expire 
		$("#del-job-btn").on("click", function(e){
			let jobId = $(this).attr("delete-job");
			if (jobId != "" || jobId != undefined) {
				$.ajax({
					url: '{{ route("job.expireJob", ["id" => "__jobId__"]) }}'.replace('__jobId__', jobId),
					type: 'post',
					success: function(response) {
						let status = response.status;
						if (status == true) {
							window.location.reload();
						}
					}
				});
			}
		});


		// Toaster
		var toastElList = [].slice.call(document.querySelectorAll('.toast'));
		var toastList = toastElList.map(function(toastEl) {
			var toast = new bootstrap.Toast(toastEl);
			toast.show();

			setTimeout(function() {
				toastEl.classList.add('fade');
				setTimeout(function() {
					toast.hide();
				}, 5000);
			}, 3000);

			return toast;
		});
	</script>

	@yield('customjs')

</body>

</html>