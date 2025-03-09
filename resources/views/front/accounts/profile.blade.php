@extends('front.layouts.app')

@php
    $oldPasswordErr = $passwordErr = $passwordConfirmationErr = "";
    if ($errors->any()) {
        $oldPasswordErr = $errors->first('old_password');
        $passwordErr = $errors->first('password');
        $passwordConfirmationErr = $errors->first('password_confirmation');
    }
@endphp

@section('main')

<section class="section-5 bg-2">
    <div class="container py-5">
        <div class="row">
            <div class="col">
                <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Account Settings</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                @include('front.accounts.sidebar')
            </div>
            <div class="col-lg-9">
                <div class="card border-0 shadow mb-4">
                    <form action="" method="post" name="userForm" class="userForm" id="userForm">
                        <div class="card-body  p-4">
                            <h3 class="fs-4 mb-1">My Profile</h3>
                            <div class="mb-4">
                                <label for="" class="mb-2">Name*</label>
                                <input type="text" placeholder="Enter Name" name="name" id="name" class="form-control" value="{{ $user->name }}">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Email*</label>
                                <input type="text" placeholder="Enter Email" name="email" id="email" class="form-control" value="{{ $user->email }}">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Designation*</label>
                                <input type="text" placeholder="Enter designation" name="designation" id="designation" class="form-control" value="{{ $user->designation }}">
                                <p></p>
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Mobile*</label>
                                <input type="text" placeholder="Enter mobile" name="mobile" id="mobile" class="form-control" value="{{ $user->mobile }}">
                                <p></p>
                            </div>
                        </div>
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>

                <div class="card border-0 shadow mb-4">
                    <form action="{{ route('account.changePassword') }}" method="post"> @csrf
                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-1">Change Password</h3>
                            <div class="mb-4">
                                <label for="" class="mb-2">Old Password*</label>
                                <input type="password" placeholder="Old Password" name="old_password" class="form-control @if (!empty($oldPasswordErr)) {{'is-invalid'}} @endif">
                                @if (!empty($oldPasswordErr))<p class="text-danger form-text">{{ $oldPasswordErr }}</p>@endif
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">New Password*</label>
                                <input type="password" placeholder="New Password" name="password" class="form-control @if (!empty($passwordErr)) {{'is-invalid'}} @endif">
                                @if (!empty($passwordErr))<p class="text-danger form-text">{{ $passwordErr }}</p>@endif
                            </div>
                            <div class="mb-4">
                                <label for="" class="mb-2">Confirm Password*</label>
                                <input type="password" placeholder="Confirm Password" name="password_confirmation" class="form-control @if (!empty($passwordConfirmationErr)) {{'is-invalid'}} @endif">
                                @if (!empty($passwordConfirmationErr))<p class="text-danger form-text">{{ $passwordConfirmationErr }}</p>@endif
                            </div>
                        </div>
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customjs')

<script>
    $("#userForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route("account.updateProfile") }}',
            type: 'put',
            dataType: 'json',
            data: $("#userForm").serializeArray(),
            success: function(response) {
                if (response.status == false) {
                    var errors = response.errors;
                    if (errors.name) {
                        $("#name").addClass("is-invalid").siblings("p").addClass("is-invalid-feedback").html(errors.name);
                    } else {
                        $("#name").removeClass("is-invalid").siblings("p").removeClass("is-invalid-feedback").html("");
                    }

                    if (errors.email) {
                        $("#email").addClass("is-invalid").siblings("p").addClass("is-invalid-feedback").html(errors.email);
                    } else {
                        $("#email").removeClass("is-invalid").siblings("p").removeClass("is-invalid-feedback").html("");
                    }

                    if (errors.designation) {
                        $("#designation").addClass("is-invalid").siblings("p").addClass("is-invalid-feedback").html(errors.designation);
                    } else {
                        $("#designation").removeClass("is-invalid").siblings("p").removeClass("is-invalid-feedback").html("");
                    }

                    if (errors.mobile) {
                        $("#mobile").addClass("is-invalid").siblings("p").addClass("is-invalid-feedback").html(errors.mobile);
                    } else {
                        $("#mobile").removeClass("is-invalid").siblings("p").removeClass("is-invalid-feedback").html("");
                    }
                } else {
                    $("#name").removeClass("is-invalid").siblings("p").removeClass("is-invalid-feedback").html("");
                    $("#email").removeClass("is-invalid").siblings("p").removeClass("is-invalid-feedback").html("");
                    $("#designation").removeClass("is-invalid").siblings("p").removeClass("is-invalid-feedback").html("");
                    $("#mobile").removeClass("is-invalid").siblings("p").removeClass("is-invalid-feedback").html("");

                    window.location.reload();
                }
            }
        })
    });
</script>

@endsection