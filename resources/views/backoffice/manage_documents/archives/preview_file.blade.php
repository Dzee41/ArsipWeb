@extends('layouts.app')
@section('content')
<div class="container mt-3">
    <div>
        <h4 class="fw-bold mb-3"><span class="text-muted fw-light">Preview /</span>
            {{ $archive->title }}</h4>

        <div class="mb-2">
            <a onclick="window.history.back()" class="btn btn-sm btn-primary text-white">
                <i class='bx bx-chevrons-left' ></i> Previous page 
            </a>
        </div>

        @if($fileType == 'pdf')
            <embed src="{{ $fileUrl }}" width="100%" height="600px" class="border border-1 rounded-1"/>
        @elseif($fileType == 'video')
            <video width="100%" height="600px" controls class="border border-1 rounded-1">
                <source src="{{ $fileUrl }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        @elseif($fileType == 'download')
            <p>No preview available. <a href="{{ $fileUrl }}" download>Download file</a></p>
        @endif
    </div>
</div>
@endsection