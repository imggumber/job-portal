@extends('front.layouts.app')


@section('main')
<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">All Companies</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.accounts.sidebar')
            </div>
            <div class="col-lg-9">
                @include('front.messages.message')
                <div class="mb-3 row">
                    <div class="col-12 text-end">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCompanyModal">
                            Add Company
                        </button>
                    </div>
                </div>
                <table class="table">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Company Name</th>
                            <th scope="col">Website</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="border">
                        @if (count($companies) > 0)
                        @foreach ($companies as $key => $company)
                        <tr>
                            <td scope="col">{{$key + 1}}</td>
                            <td scope="col">{{$company['name']}}</td>
                            <td scope="col"><a class="text-success" target="_blank" href="{{$company['website']}}">Visit Website</a></td>
                            <td scope="col">
                                <button type="button" class="btn btn-outline-success view-company" data-id="{{$company['id']}}" data-bs-toggle="modal" data-bs-target="#viewCompanyDetails">
                                    View More
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="4">
                                <p class="mb-0 text-center">No company found</p>
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customjs')
<script>
    $('.view-company').off('click').on('click', function(e) {
        let company_id = $(this).attr('data-id');
        $.ajax({
            url: '{{ route("company.getCompany", ":id") }}'.replace(':id', company_id),
            type: 'get',
            dataType: 'json',
            success: function(response) {
                if (response.status == true) {
                    let data = response.data;
                    $("#modal-company-name").html(data.name);
                    $("#modal-company-location").html(data.location);
                    $("#modal-company-website").attr("href", data.website);
                } else {
                    $("#modal-company-name").html("");
                    $("#modal-company-location").html("");
                    $("#modal-company-website-btn").hide();

                }
            }
        });
    });
</script>
@endsection