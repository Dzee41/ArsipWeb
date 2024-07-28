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
            Semua Dokumen</h4>

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

        <a href="{{ route('new-document', $category->id) }}" class="btn btn-success btn-small">Input Dokumen</a>

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
                                <th>Timestamp</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($archives as $row)
                                <tr>
                                    {{-- <td>{{ $no++ }}</td> --}}
                                    <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                        <strong>{{ $row->title }}</strong>
                                    </td>
                                    <td>{{ $row->description }}</td>
                                    <td>
                                        @php
                                            $fileName = basename($row->file);
                                        @endphp
                                        @if ($row->file != "") 
                                            <p>Unduh:<br><a href="{{ route('file.download', $fileName) }}">{{$fileName}}</a></p>
                                        
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
                                                <button class="btn btn-warning btn-sm">Edit</button>
                                            </form>
                                            {{-- <button class="btn btn-sm btn-warning"><i
                                                    class='bx bxs-edit-alt'></i>Edit</button> --}}

                                            
                                            {{-- Delete --}}
                                            <form class="mx-1" 
                                                id="formDelete"                                                 
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm btnDelete"
                                                    data-action="{{ route('destroy-archive.destroyArchive', $row->id) }}"
                                                    >Delete
                                                </button>
                                            </form>
                                            {{-- <button class="btn btn-sm btn-danger"><i
                                                    class='bx bxs-trash'></i>Delete</button> --}}
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
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
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

</script>
@endsection
