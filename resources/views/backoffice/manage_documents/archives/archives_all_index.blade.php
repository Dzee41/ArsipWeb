@extends('layouts.app')
@section('content')
    @php
        $category_header = \App\Models\Category::latest()->get();
        $no = 1;
        $id_from_request = 1;
        $categories = \App\Models\Category::with('archives')->findOrFail($id_from_request ?? 1);
        $category = \App\Models\Category::findOrFail($id_from_request);
    @endphp
    @if (session('error'))
        <script>
            toastr.error('{{ session('error') }}', 'Error', { "positionClass": "toast-top-right" });
        </script>
    @endif
    <div class="col container">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Management Document /</span>
            Semua Dokumen</h4>

        <div class="btn-group pe-1">
            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class='bx bx-filter-alt text-sm-end' ></i> Filter
            </button>
            <ul class="dropdown-menu">
                <form action="{{ route('documents.archivesIndexAll') }}" method="POST">
                    @method('GET')
                    @csrf
                    <li 
                    >
                        <button type="submit" class="dropdown-item">Semua Kategori</button>
                    </li>
                </form>
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

        <a href="{{ route('new-document', $category->id) }}" class="btn btn-success btn-small">
            <i class='bx bx-folder-plus text-sm-end' ></i> Input Dokumen
        </a>

        <div class="nav-align-top mb-4 pt-3">
            <div class="tab-content">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Documents</th>
                                <th>Category</th>
                                <th>Timestamp</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($archives as $row)
                                <tr>
                                    <td>{{ $no++ }}.</td>
                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                        <strong>{{ $row->title }}</strong>
                                    </td>
                                    <td>{{ $row->description }}</td>
                                    <td>
                                        @php
                                            $fileName = basename($row->file);
                                            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                                            $previewableExtensions = ['pdf', 'mp4'];
                                        @endphp
                                        @if ($row->file != "") 
                                            @if (in_array($fileExtension, $previewableExtensions))
                                                <button class="btn btn-primary btn-sm">
                                                    <a class="text-white" href="{{ route('file.preview', ['id' => $row->id, 'file' => $fileName]) }}">
                                                        @if ($fileExtension === "pdf")
                                                        <i class='bx bxs-file-pdf'></i>
                                                        @elseif ($fileExtension === "mp4")
                                                        <i class='bx bxs-videos' ></i>
                                                        @endif
                                                        Preview 
                                                        {{ $fileExtension }}
                                                    </a>
                                                </button>
                                            @else
                                                <a class="text-decoration-underline" href="javascript:void(0);" onclick="checkAndDownloadFile('{{ $fileName }}')">
                                                    No-Preview {{ $fileExtension }}
                                                </a>
                                            @endif
                                        @else 
                                            <p>-</p>
                                        @endif
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-label-primary me-1">
                                            {{ $row->category->category_name }}
                                        </span>
                                    </td>
                                    <td>
                                        {{ $row->formatted_updated_at }}
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            {{-- Edit --}}
                                            <form 
                                                action="{{ route('edit-archive.editArchive', [
                                                    'id' => $row->id,
                                                ]) }}"
                                                method="post">
                                                @csrf
                                                @method('GET')
                                                <input hidden name="input_req_edit" type="text"
                                                    value="{{ $row->id }}">
                                                <button class="btn btn-warning btn-sm"><i class='bx bx-edit-alt text-sm-end' ></i> Edit</button>
                                            </form>

                                            {{-- Download --}}
                                            <a class="btn btn-sm btn-info mx-1 rounded-1" href="javascript:void(0);" onclick="checkAndDownloadFile('{{ $fileName }}')">
                                                <i class='bx bxs-download text-sm-end' ></i> Save
                                            </a>
                                            
                                            {{-- Delete --}}
                                            <form id="formDelete"                                                 
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm btnDelete"
                                                    data-action="{{ route('destroy-archive.destroyArchive', $row->id) }}"
                                                    ><i class='bx bx-trash text-sm-end' ></i> Delete
                                                </button>
                                            </form>                                                
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

@section('sweetalert2')
<script type="text/javascript">

    $('body').on('click', '.btnDelete', function(e) {
        e.preventDefault();
        var action = $(this).data('action');
        Swal.fire({
            title: 'Yakin ingin menghapus data ?',
            text: "Data yang sudah dihapus tidak bisa dikembalikan lagi",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            cancelButtonText: 'Batal',
            confirmButtonText: 'Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#formDelete').attr('action', action);
                $('#formDelete').submit();
            }
        })
    })

    @if ($errors->all())
    {
        Swal.fire({
        title: 'Gagal Hapus file',
        html: 
            [
                @foreach ($errors->all() as $error)
                    '- {{$error}}<br>',
                @endforeach
            ],
        icon: 'error',
        showConfirmButton: true
        });
    }
    @endif

    function checkAndDownloadFile(fileName, id) {
        $.ajax({
            url: '{{ url("/file/check") }}/' + fileName,
            method: 'GET',
            success: function(response) {
                if (response.exists) {
                    toastr.info('Process to download ' + fileName, 'Downloading...', { "positionClass": "toast-top-right" });
                    setTimeout(function() {
                        window.location.href = '{{ url("/download") }}/' + fileName;
                    }, 2000);
                } else {
                    toastr.error('File not found', 'Error', { "positionClass": "toast-top-right" });
                }
            },
            error: function() {
                toastr.error('File not found', 'Error', { "positionClass": "toast-top-right" });
            }
        });
    }

</script>
@endsection
