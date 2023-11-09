@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item" aria-current="page"><a href="#">Reimburse Engineer</a></li>
                <li class="breadcrumb-item active" aria-current="page">Preview Image</li>
            </ol>
        </nav>
        @foreach ($attachEN as $item)
            <div class="row mb-2">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="position-relative">
                            <figure class="overflow-hidden mb-0 d-flex justify-content-center">
                                <img src="{{ asset("$item->path") }}" class="img-fluid" alt="attachment reimburse">
                            </figure>
                            <div
                                class="d-flex justify-content-between align-items-center position-absolute top-90 w-100 px-2 px-md-4 mt-n4">
                                <div>
                                    <span class="h4 ms-3 text-dark">{{$item->filename}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
@push('custom')
@endpush
