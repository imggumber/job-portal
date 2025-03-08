@include('front.messages.message')

@php
    $titleErr = $categoryErr = $vacancyErr = $descriptionErr = $companyErr = $jobtypeErr = $salaryErr = "";
    if ($errors->any()) {
        $titleErr = $errors->first('title');
        $categoryErr = $errors->first('category');
        $vacancyErr = $errors->first('vacancy');
        $descriptionErr = $errors->first('description');
        $companyErr = $errors->first('company');
        $jobtypeErr = $errors->first('job_type');
        $salaryErr = $errors->first('salary');
    }
@endphp


<div class="card border-0 shadow mb-4 ">
    <div class="card-body card-form p-4">
        <h3 class="fs-4 mb-1">Job Details</h3>
        <form action="{{ route('job.createJob') }}" method="post"> @csrf
            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="" class="mb-2">Title<span class="req">*</span></label>
                    <input type="text" placeholder="Job Title" value="{{old('title')}}" id="title" name="title" class="form-control @if (!empty($titleErr)) {{'is-invalid'}} @endif">
                    @if (!empty($titleErr))<p class="text-danger form-text">{{ $titleErr }}</p>@endif
                </div>
                <div class="col-md-6  mb-4">
                    <label for="" class="mb-2">Category<span class="req">*</span></label>
                    <select name="category" id="category" class="form-control">
                        <option value="">Select a Category</option>
                        @if (count($data['categories']) > 0)
                            @foreach ($data['categories'] as $catgory)
                                <option value="{{ $catgory['id'] }}">{{ $catgory['name'] }}</option>
                            @endforeach
                        @endif
                    </select>
                    @if (!empty($categoryErr))<p class="text-danger form-text">{{ $categoryErr }}</p>@endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-4">
                    <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                    <select class="form-select" name="job_type">
                        <option value="">Select a job nature</option>
                        @if (count($data['job_types']) > 0)
                            @foreach ($data['job_types'] as $job_type)
                                <option value="{{ $job_type['id'] }}">{{ $job_type['name'] }}</option>
                            @endforeach
                        @endif
                    </select>
                    @if (!empty($jobtypeErr))<p class="text-danger form-text">{{ $jobtypeErr }}</p>@endif
                </div>
                <div class="col-md-6  mb-4">
                    <label for="" class="mb-2">Vacancy<span class="req">*</span></label>
                    <input type="number" min="1" placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control @if (!empty($vacancyErr)) {{'is-invalid'}} @endif">
                    @if (!empty($vacancyErr))<p class="text-danger form-text">{{ $vacancyErr }}</p>@endif
                </div>
            </div>

            <div class="row">
                <div class="mb-4 col-md-6">
                    <label for="" class="mb-2">Salary</label>
                    <input type="text" placeholder="Salary" id="salary" name="salary" class="form-control @if (!empty($salaryErr)) {{'is-invalid'}} @endif">
                    @if (!empty($salaryErr))<p class="text-danger form-text">{{ $salaryErr }}</p>@endif
                </div>

                <div class="mb-4 col-md-6">
                    <label for="" class="mb-2">Location<span class="req">*</span></label>
                    <input type="text" placeholder="location" id="location" name="Location" class="form-control">
                </div>
            </div>

            <div class="mb-4">
                <label for="" class="mb-2">Description<span class="req">*</span></label>
                <textarea class="form-control @if (!empty($descriptionErr)) {{'is-invalid'}} @endif" name="description" id="description" cols="5" rows="5" placeholder="Description"></textarea>
                @if (!empty($descriptionErr))<p class="text-danger form-text">{{ $descriptionErr }}</p>@endif
            </div>
            <div class="mb-4">
                <label for="" class="mb-2">Benefits</label>
                <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits"></textarea>
            </div>
            <div class="mb-4">
                <label for="" class="mb-2">Responsibility</label>
                <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5" placeholder="Responsibility"></textarea>
            </div>
            <div class="mb-4">
                <label for="" class="mb-2">Qualifications</label>
                <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5" placeholder="Qualifications"></textarea>
            </div>

            <div class="mb-4">
                <label for="" class="mb-2">Keywords</label>
                <input type="text" placeholder="keywords" id="keywords" name="keywords" class="form-control">
                <div id="keywordHelp" class="form-text">Use comma to add multiple keywords</div>
            </div>

            <div class="mb-4">
                <label for="" class="mb-2">Experience</label>
                <input type="number" placeholder="experience" min="0" max="50" id="experience" name="experience" class="form-control">
            </div>

            <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Select Company</h3>
            <div class="row">
                <div class="col-12 mb-4">
                    <select class="form-select company" id="company" name="company">
                        <option value="">Select company</option>
                        @if (count($data['companies']) > 0)
                            @foreach ($data['companies'] as $company)
                                <option value="{{ $company['id'] }}">{{ $company['name'] }}</option>
                            @endforeach
                        @endif
                    </select>
                    @if (!empty($companyErr))<p class="text-danger form-text">{{$companyErr}}</p>@endif
                </div>
            </div>
            <div class="card-footer p-4">
                <button type="submit" class="btn btn-primary">Save Job</button>
            </div>
        </form>
    </div>
</div>