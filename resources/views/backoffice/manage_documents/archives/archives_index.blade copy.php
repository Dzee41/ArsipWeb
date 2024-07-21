@extends('layouts.app')
@section('content')
    <div class="col container">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Management Document /</span>
            Document Lainnya</h4>

        <div class="btn-group">
            <button type="button" class="btn btn-info dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Filter by Category
            </button>
            <ul class="dropdown-menu">
                <form action="{{ route('tab-archives') }}" method="POST">
                    @method('POST')
                    @csrf
                    @foreach ($category as $index => $item)
                        <input type="hidden" name="id" value="{{ $item->id }}">
                        <input type="hidden" name="category_name" value="{{ $item->category_name }}">
                        <li><button type="submit" class="dropdown-item">{{ $item->category_name }}</button></li>
                    @endforeach
                </form>
            </ul>
        </div>

        <div class="nav-align-top mb-4  pt-2">
            <div class="tab-content">
                {{-- tab content --}}
                @yield('table-tabs')
            </div>
        </div>
        {{-- </form> --}}
    </div>
@endsection
