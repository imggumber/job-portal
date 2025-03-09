<div class="modal fade" id="addCompanyModal" tabindex="-1" aria-labelledby="addCompanyModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title pb-0" id="addCompanyModalLabel">Add New Company</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form method="post" id="addCompanyForm" name="addCompanyForm" class="form addCompanyForm">
						<div class="row">
							<div class="col-12">
								<label for="companyName" class="companyName form-label">Name<span class="req">*</span></label>
								<input type="text" placeholder="Enter company name" class="companyName form-control" id="companyName" name="companyName">
								<p></p>
							</div>
							<div class="col-12">
								<label for="companyAddress" class="companyAddress form-label">Address</label>
								<input type="text" placeholder="Enter company address" class="companyAddress form-control" id="companyAddress" name="companyAddress">
								<p></p>
							</div>
							<div class="col-12">
								<label for="companyWebsite" class="companyWebsite form-label">Website</label>
								<input type="text" placeholder="Enter company website" class="companyWebsite form-control" id="companyWebsite" name="companyWebsite">
								<p></p>
							</div>
							<span id="company-exists" class="fs-6 text-danger mb-2"></span>
						</div>
						<div class="d-flex justify-content-end">
							<button type="submit" class="btn btn-primary mx-3">Add Company</button>
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>