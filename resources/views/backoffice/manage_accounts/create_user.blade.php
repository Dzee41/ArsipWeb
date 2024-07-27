@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Management User /</span> Form New User</h4>

        <div class="row">
            <div class="col">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3" role="tablist">
                        <li class="nav-item">
                            <a href="{{ route('users-index') }}" class="btn btn-warning"><span
                                    class="bx bx-arrow-back"></span> Back to</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <h5 class="card-header">Create User</h5>
            <!-- Account -->

            <div class="card-body">
                <form id="formAccountSettings" method="POST" enctype="multipart/form-data"
                    action="{{ route('generate-new-user') }}">
                    @method('POST')
                    @csrf
            </div>
            <hr class="my-0" />
            <div class="card-body">

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">Full Name</label>
                        <input class="form-control" type="text" id="email" name="name"
                            placeholder="Input your name" />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">E-mail</label>
                        <input class="form-control" type="text" id="email" name="email"
                            placeholder="yourmail@gmail.com" />
                    </div>
                    <div class="mb-3 form-password-toggle form-group col-md-6">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password">Password</label>
                        </div>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="password" aria-describedby="password" required autocomplete="new-password" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>


                    <div class="mb-3 form-password-toggle form-group col-md-6">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password">Confirm Password</label>
                        </div>
                        <div class="input-group input-group-merge">
                            <input type="password" id="confirm-password"
                                class="form-control @error('confirm-password') is-invalid @enderror"
                                name="password_confirmation" placeholder="confirm password" required
                                autocomplete="password" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                            @error('confirm-password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
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
@endsection
