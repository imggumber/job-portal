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
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">My Jobs</h3>
                            </div>
                            <div style="margin-top: -10px;">
                                <a href="{{ route('job.job') }}" class="btn btn-primary">{{__('Post a Job')}}</a>
                                <a href="#" class="btn btn-primary">{{__('Archived')}}</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Job Created</th>
                                        <th scope="col">Applicants</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if (count($jobs) > 0)
                                        @foreach ($jobs as $job)
                                        <tr class="active">
                                            <td>
                                                <div class="job-name fw-500">{{ $job['title'] }}</div>
                                                <div class="info1">{{ $job['job_type'] }}  {{ !empty($job['location']) ? ". " . $job['location'] : "" }}</div>
                                            </td>
                                            <td>{{ $job['created_at'] }}</td>
                                            <td>130 Applications</td>
                                            <td>
                                                <div class="action-dots float-end">
                                                    <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="{{ $job['id'] }}"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                        <li><a class="dropdown-item" href="{{ $job['id'] }}"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                        <li><a class="dropdown-item expire-job" href="javascript:void(0)" data-job-id="{{ $job['id'] }}"><i class="fa fa-ban" aria-hidden="true"></i> Expire Job</a></li>
                                                        <li>
                                                            <form action="{{ route('job.delJob', ['id' => $job['id']]) }}" method="post"> @csrf
                                                                @method('delete')
                                                                <button class="btn btn-danger w-100 rounded-0"><i class="fa fa-trash me-1" aria-hidden="true"></i> Remove</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach

                                        @else
                                        <tr class="text-center">
                                            <td colspan="4">No job found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <div class="pagination">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection