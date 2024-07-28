@extends('layouts.app')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Management User /</span> Users List</h4>

        <div class="row">
            <div class="col">
                <div class="nav-align-top mb-4">
                    <ul class="nav nav-pills mb-3" role="tablist">
                        <li class="nav-item">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#inputCategory">Input
                                Category</button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">Table Category</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Categories</th>
                            <th>Used For</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    {{-- table --}}
                    <tbody>
                        @foreach ($categories as $item)
                            <tr>
                                <td>{{ $item->category_name }}</td>
                                <td>{{ $item->used_for }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">

                                            <button data-id="{{ $item->id }}" data-bs-toggle="modal"
                                                data-bs-target="#modalEditCategory{{ $item->id }}"
                                                class="dropdown-item"><i class="bx bx-edit-alt me-1"></i> Edit</button>
                                            <form id="formDelete" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button data-action="{{ route('category-delete', $item->id) }}"
                                                    class="dropdown-item btnDelete"><i class="bx bx-trash me-1"></i>
                                                    Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>


                            <!-- Modal Edit Category-->
                            <div class="modal fade" id="modalEditCategory{{ $item->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    @include('backoffice.manage_documents.categories._modal_edit')
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>

    <!-- Modal Input Category -->
    <div class="modal fade" id="inputCategory" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            @include('backoffice.manage_documents.categories._modal_create')
        </div>
    </div>

    @push('scripts')
        <script>
            $('body').on('click', '[data-bs-toggle="modal"]', function(event) {
                var button = $(event.currentTarget); // Tombol yang membuka modal
                var id = button.data('id'); // Ambil data-id dari tombol
                var modal = $('#modalEditCategory' + id); // Pilih modal yang sesuai berdasarkan ID

                // Update isi modal dengan ID arsip yang sesuai
                modal.find('.body-jquery-edit #item-id').val(id);
            });
        </script>
    @endpush
@endsection

@section('sweetalert2')
<script type="text/javascript">

    $('body').on('click', '.btnDelete', function(e) {
        e.preventDefault();
        var action = $(this).data('action');
        Swal.fire({
            title: 'Yakin ingin menghapus kategori ?',
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

    // @if ($errors->all())
    // {
    //     Swal.fire({
    //     title: 'Gagal Hapus kategori',
    //     html: 
    //         [
    //             @foreach ($errors->all() as $error)
    //                 '- {{$error}}<br>',
    //             @endforeach
    //         ],
    //     icon: 'error',
    //     showConfirmButton: true
    //     });
    // }
    // @endif

</script>
@endsection
