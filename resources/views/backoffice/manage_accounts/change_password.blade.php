@extends('layouts.app')
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Management Accounts /</span> Change Password</h4>

        <div class="row">
            <div class="col-md-12">
                {{-- sub menu tab --}}
                @include('backoffice.manage_accounts._sub_page_tab')
                <div class="card mb-4">
                    <h5 class="card-header">Change Password Form</h5>
                    <!-- Account -->


                    <form id="formAccountSettings" method="POST" enctype="multipart/form-data"
                        action="{{ route('change-password.changePassword') }}">
                        @method('POST')
                        @csrf
                        <hr class="my-0" />
                        <div class="card-body">

                            <div class="row">

                                <div class="mb-3 form-password-toggle form-group col-md-6">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="password">Current Password</label>
                                    </div>

                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password"
                                            class="form-control @error('current_password') is-invalid @enderror"
                                            name="current_password" placeholder="current password"
                                            aria-describedby="password" autofocus required
                                            autocomplete="current-password" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        @error('current_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="mb-3 form-password-toggle form-group col-md-6">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="new_password">New Password</label>
                                    </div>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="new_password"
                                            class="form-control @error('new_password') is-invalid @enderror"
                                            name="new_password" placeholder="new password" aria-describedby="password"
                                            required autocomplete="new-password" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                        @error('new_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 form-password-toggle form-group col-md-6">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="new_password">New Confirm Password</label>
                                    </div>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="new_confirm_password" class="form-control"
                                            name="new_confirm_password" placeholder="new confirm password"
                                            aria-describedby="confirm new password" required autocomplete="new-password" />
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    </div>
                                </div>

                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2"
                                    onclick="alert('are you sure you updated your password!')">Save changes</button>
                                <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                            </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
            <div class="card">
                <h5 class="card-header">Delete Account</h5>
                <div class="card-body">
                    <div class="mb-3 col-12 mb-0">
                        <div class="alert alert-warning">
                            <h6 class="alert-heading fw-bold mb-1">Are you sure you want to delete your account?</h6>
                            <p class="mb-0">Once you delete your account, there is no going back. Please be certain.
                            </p>
                        </div>
                    </div>
                    <form id="formAccountDeactivation" onsubmit="return false">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="accountActivation"
                                id="accountActivation" />
                            <label class="form-check-label" for="accountActivation">I confirm my account
                                deactivation</label>
                        </div>
                        <button type="submit" class="btn btn-danger deactivate-account">Deactivate Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- / Content -->
@endsection
