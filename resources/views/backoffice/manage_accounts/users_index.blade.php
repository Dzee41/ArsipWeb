@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Management User /</span> Users List</h4>

        <div class="row">
            <div class="col">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3" role="tablist">
                        <li class="nav-item">
                            <a href="{{ route('create-user') }}" class="btn btn-primary">Create New Users</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">Table Users</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Photo</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($get_user as $item)
                            <tr>
                                <td><strong>{{ $item->name }}</strong></td>
                                <td>{{ $item->email }}</td>
                                <td>
                                    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                            class="avatar avatar-xs pull-up" title="{{ $item->name }}">
                                            <img src="../assets/img/avatars/7.png" alt="Avatar" class="rounded-circle" />
                                        </li>
                                    </ul>
                                </td>

                                <td>
                                    <div class="btn-group">
                                        <button
                                            class="btn btn-{{ $item->role_id === 1 ? 'primary' : 'warning' }} btn-xs dropdown-toggle"
                                            type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ $item->role_id === 1 ? 'admin' : 'user' }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <form action="{{ route('change-role') }}" method="POST">
                                                    @method('POST')
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $item->id }}">
                                                    <button class="dropdown-item">
                                                        <input type="hidden" name="role_id"
                                                            value="{{ $item->role_id === 1 ? 0 : 1 }}">{{ $item->role_id === 1 ? 'user' : 'admin' }}</button>
                                                </form>

                                            </li>
                                        </ul>
                                    </div>
                                </td>

                                {{-- <td>{{ $item->role_id === 1 ? 'Admin' : 'User' }}</td> --}}
                                <td><span
                                        class="badge rounded-pill bg-label-{{ $item->is_active === 1 ? 'success' : 'danger' }} me-1">{{ $item->is_active === 1 ? 'Active' : 'Inactive' }}</span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <form action="{{ route('change-status') }}" method="post">
                                                @csrf
                                                @method('POST')
                                                <input name="id" type="hidden" value="{{ $item->id }}">
                                                <input name="is_active" type="hidden"
                                                    value="{{ $item->is_active === 1 ? 0 : 1 }}">
                                                <button type="submit" class="dropdown-item"><span
                                                        class="badge rounded-pill bg-{{ $item->is_active === 1 ? 'danger' : 'success' }}"><i
                                                            class="bx bx-{{ $item->is_active === 1 ? 'shield-x' : 'check-shield' }} me-1"></i>{{ $item->is_active === 1 ? 'Deactivate Account' : 'Activate Account' }}</span></button>
                                            </form>

                                            <a class="dropdown-item" href="{{ route('edit-user-profile', $item->id) }}"><i
                                                    class="bx bx-edit me-1"></i>
                                                Edit</a>

                                            <form action="{{ route('delete-user', $item->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button onclick="alert('sure to delete user?')" type="submit"
                                                    class="dropdown-item"><i class="bx bx-trash me-1"></i>
                                                    Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
@endsection
