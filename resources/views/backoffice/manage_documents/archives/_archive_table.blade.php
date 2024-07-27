@extends('layouts.app')
@section('content')
    <div class="col container">

        @php
            $category_header = \App\Models\Category::get();
        @endphp

        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Management Document /</span>
            Document Lainnya</h4>
        <div class="btn-group">
            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Filter by Category
            </button>
            <ul class="dropdown-menu">
                @foreach ($category_header as $index => $item)
                    <form action="{{ route('documents.archiveShow', $item->id) }}" method="POST">
                        @method('GET')
                        @csrf
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <input type="hidden" name="category_name" value="{{ $item->category_name }}">
                        <li><button type="submit" class="dropdown-item">{{ $item->category_name }}</button></li>
                    </form>
                @endforeach
            </ul>
        </div>
        <a href="{{ route('new-document', $categories->id) }}" class="btn btn-success btn-small">Input
            {{ $category->category_name }}</a>

        <div class="nav-align-top mb-4  pt-2">
            <div class="tab-content">
                {{-- @include('backoffice.manage_documents.archives.archives_index') --}}
                {{-- tab content --}}
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
                            @foreach ($categories['archives'] as $idx => $row)
                                <tr>
                                    {{-- <td>{{ $no++ }}</td> --}}
                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                        <strong>{{ $row->title }}</strong>
                                    </td>
                                    <td>{{ $row->description }}</td>

                                    <td>
                                        @foreach ($files as $index => $file)
                                            @if ($file->getFilename() == $row->file)
                                                <a href="{{ route('file.download', $file->getFilename()) }}">Download</a>
                                                {{-- <a href="{{ route('file.preview', $file->getFilename()) }}">Preview</a> --}}
                                                <!-- Ini untuk fitur preview -->

                                                {{-- <ul
                                                    class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                                        data-bs-placement="top" class="avatar avatar-xs pull-up"
                                                        title="{{ $row->title }}">
                                                        <img src="../assets/img/avatars/5.png" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </li>
                                                </ul> --}}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-label-primary me-1">{{ $row->category_id == $id_from_request ? $category->category_name : '' }}</span>
                                    </td>

                                    <td>
                                        <div class="btn-group">
                                            @foreach ($category_for_edit as $item)
                                                @if ($item->id === $categories->id)
                                                    <form
                                                        action="{{ route('edit-archive.editArchive', [
                                                            'id' => $row->id,
                                                            // 'archive' => $item->id,
                                                        ]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('GET')
                                                        <input hidden name="input_req_edit" type="text"
                                                            value="{{ $row->id }}">
                                                        <button class="btn btn-warning btn-small">Edit</button>
                                                    </form>
                                                @endif
                                            @endforeach
                                            @foreach ($category_for_edit as $item)
                                                @if ($item->id === $categories->id)
                                                    <form
                                                        action="{{ route('destroy-archive.destroyArchive', [
                                                            'id' => $row->id,
                                                            // 'archive' => $item->id,
                                                        ]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input hidden name="input_req_edit" type="text"
                                                            value="{{ $row->id }}">
                                                        <button class="btn btn-danger btn-small">Delete</button>
                                                    </form>
                                                @endif
                                            @endforeach


                                            <!-- Tombol Preview -->
                                            <a href="{{ route('file.preview.pdf', $row->file) }}"
                                                class="btn btn-sm btn-info" target="_blank">
                                                <i class='bx bxs-file-pdf'></i> Preview PDF
                                            </a>
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
