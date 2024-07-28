@extends('layouts.app')
@section('content')
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Rekap Document</h4>

        <!-- Basic Layout & Basic with Icons -->
        <div class="row">
            <!-- Basic with Icons -->
            <div class="col-xxl">
                <div class="card mb-4">
                    <div class="card-body">
                        <form action="{{ route('update-archive.updateArchive') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input hidden type="text" name="update_arc_id" value="{{ $get_archive_value->id }}">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Title</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                                class='bx bx-captions'></i></span>
                                        <input value="{{ $get_archive_value->title }}" name="title" type="text"
                                            class="form-control" id="basic-icon-default-fullname"
                                            placeholder="Dokumen Perjanjian" aria-label="John Doe"
                                            aria-describedby="basic-icon-default-fullname2" autofocus />
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="exampleFormControlSelect1" class="col-sm-2 form-label">Category</label>
                                <div class="col-sm-10">
                                    <select name="category_id" class="form-select" id="exampleFormControlSelect1"
                                        aria-label="Default select example">
                                        <option selected>--Select Category--</option>
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id === $get_archive_value->category_id ? 'selected' : '' }}>
                                                {{ $item->category_name }}</option>
                                        @endforeach
                                    </select>
                                    {{-- <input disabled class="form-control" type="text" name="category_id"
                                        value="{{ $get_archive_value->category_id }}"> --}}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">File</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                                class='bx bxs-file'></i></span>
                                        <input name="file" type="file" class="form-control"
                                            id="basic-icon-default-fullname" placeholder="Dokumen Perjanjian"
                                            aria-label="John Doe" aria-describedby="basic-icon-default-fullname2" />
                                    </div>
                                    @if ($get_archive_value->file)
                                        <div class="row mb-3">
                                            <p class="col-sm-10 pt-1">
                                                Existing File/Document:
                                                <a href="{{ route('file.preview', ['id' => $get_archive_value->id, 'file' => $get_archive_value->file] ) }}">
                                                     {{$get_archive_value->file}}
                                                </a>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 form-label" for="basic-icon-default-message">Description</label>
                                <div class="col-sm-10">
                                    <div class="input-group input-group-merge">
                                        <span id="basic-icon-default-message2" class="input-group-text"><i
                                                class="bx bx-comment"></i></span>
                                        <textarea name="description" id="basic-icon-default-message" class="form-control"
                                            placeholder="Dokumen ini digunakan untuk apa?" aria-label="Hi, Do you have a moment to talk Joe?"
                                            aria-describedby="basic-icon-default-message2">{{ $get_archive_value->description }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row justify-content-end">
                                <div class="col-sm-10">
                                    <div class="btn-group">
                                        <button class="btn btn-primary">Save</button>             
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
@endsection
