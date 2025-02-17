@extends('layouts.app')
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Management Accounts /</span> Account</h4>

        <div class="row">
            <div class="col-md-12">
                {{-- sub menu tab --}}
                @include('backoffice.manage_accounts._sub_page_tab')
                <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->

                    <div class="card-body">

                        <form method="POST" action="{{ route('update-user-profile', $user->id) }}" id="formAccountSettings"
                            enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="role_id" value="{{ $user->role_id }}">
                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                @if ($user->photo)
                                    <img src="{{ asset('storage/photos/' . $user->photo) }}" alt="user-avatar"
                                        class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
                                @else
                                    <img src="{{ asset('storage/photos/no_photo/photo_not_available.png') }}"
                                        alt="user-avatar" class="d-block rounded" height="100" width="100"
                                        id="uploadedAvatar" />
                                @endif
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                        <input name="photo" type="file" id="upload" class="account-file-input"
                                            hidden accept="image/png, image/jpeg" />
                                    </label>
                                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                                        <i class="bx bx-reset d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>
                                    </button>

                                    <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                </div>
                            </div>
                    </div>
                    <hr class="my-0" />
                    <div class="card-body">

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="firstName" class="form-label">Full Name</label>
                                <input class="form-control" type="text" id="firstName" name="name"
                                    value="{{ $user->name }}" autofocus />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">E-mail</label>
                                <input class="form-control" type="text" id="email" name="email"
                                    value="{{ $user->email }}" placeholder="yourmail@example.com" />
                            </div>
                            <div class="mb-3 col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address"
                                    placeholder="Address" value="{{ $user->address }}" />
                            </div>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-primary me-2">Save changes</button>
                            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
                        </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection
