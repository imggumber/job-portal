@extends('front.layouts.app')



@section('main')

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Post a Job</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.accounts.sidebar')
            </div>
            <div class="col-lg-9">
                @if (count($data['companies']) == 0)
                    <p>Add a new company to list a job post.</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
                        Add Company
                    </button>
                @else
                    @include('front.partials.job-form')
                @endif
            </div>
        </div>
    </div>
</section>

@endsection