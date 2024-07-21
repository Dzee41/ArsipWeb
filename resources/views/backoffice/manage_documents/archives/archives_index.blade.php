@extends('layouts.app')
@section('content')
    @php
        $category_header = \App\Models\Category::latest()->get();
        $no = 1;
        $id_from_request = 1;
        $categories = \App\Models\Category::with('archives')->findOrFail($id_from_request ?? 1);
        $category = \App\Models\Category::findOrFail($id_from_request);
    @endphp
    <div class="col container">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Management Document /</span>
            Document Lainnya</h4>

        <div class="btn-group">
            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Filter by Category
            </button>
            <ul class="dropdown-menu">
                @foreach ($category_header as $index => $item)
                    <form action="{{ route('archive', $item->id) }}" method="POST">
                        @method('GET')
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <input type="hidden" name="category_name" value="{{ $item->category_name }}">
                        <li><button type="submit" class="dropdown-item">{{ $item->category_name }}</button></li>
                    </form>
                @endforeach
            </ul>
        </div>

        <a href="{{ route('new-document', $category->id) }}" class="btn btn-success btn-small">Input
            {{ $category->category_name }}</a>

        <div class="nav-align-top mb-4  pt-2">
            <div class="tab-content">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                {{-- <th>No</th> --}}
                                <th>Title</th>
                                <th>Description</th>
                                <th>Documents</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($categories['archives'] as $row)
                                <tr>
                                    {{-- <td>{{ $no++ }}</td> --}}
                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                        <strong>{{ $row->title }}</strong>
                                    </td>
                                    <td>{{ $row->description }}</td>
                                    <td>
                                        <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                            <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                                                class="avatar avatar-xs pull-up" title="{{ $row->title }}">
                                                <img src="../assets/img/avatars/5.png" alt="Avatar"
                                                    class="rounded-circle" />
                                            </li>
                                        </ul>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-label-primary me-1">{{ $row->category_id == $id_from_request ? $category->category_name : '' }}</span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-sm btn-warning"><i
                                                    class='bx bxs-edit-alt'></i>Edit</button>
                                            <button class="btn btn-sm btn-danger"><i
                                                    class='bx bxs-trash'></i>Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
