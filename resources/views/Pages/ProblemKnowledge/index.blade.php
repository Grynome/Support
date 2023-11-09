@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Special pages</a></li>
                <li class="breadcrumb-item active" aria-current="page">Faq</li>
            </ol>
        </nav>

        <div class="row grid-margin">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button type="button" class="btn btn-inverse-primary btn-icon-text" data-bs-toggle="modal"
                                    data-bs-target="#filter-report-ticket">
                                    <i class="btn-icon-prepend" data-feather="search"></i>
                                    Filter Problem
                                </button>
                                <div class="modal fade" id="filter-report-ticket" tabindex="-1"
                                    aria-labelledby="sourceModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="sourceModalLabel">Filter
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="btn-close"></button>
                                            </div>
                                            <form action="{{ route('sorting.report') }}" method="post">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            <div class="mb-3">
                                                                <select class="js-example-basic-single form-select"
                                                                    data-width="100%" name="stats_report">
                                                                    <option value="">- Choose Status -</option>
                                                                    {{-- @foreach ($status as $item)
                                                                        <option value="{{ $item->status }}" {{ $sts == $item->status ? 'selected' : '' }}>
                                                                            {{ $item->dtStatus }}</option>
                                                                    @endforeach --}}
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-info sort">Sort</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Problem Knowledge</h6>
                        <div class="accordion">
                            <div class="accordion-item">
                                <button class="accordion-button" type="button">
                                    Why is the moon sometimes out during the day?
                                </button>
                            </div>
                            <div class="accordion-item">
                                <button class="accordion-button" type="button">
                                    Why is the sky blue?
                                </button>
                            </div>
                            <div class="accordion-item">
                                <button class="accordion-button" type="button">
                                    Will we ever discover aliens?
                                </button>
                            </div>
                            <div class="accordion-item">
                                <button class="accordion-button" type="button">
                                    How much does the Earth weigh?
                                </button>
                            </div>
                            <div class="accordion-item">
                                <button class="accordion-button" type="button">
                                    How do airplanes stay up?
                                </button>
                            </div>
                            <div class="accordion-item">
                                <button class="accordion-button" type="button">
                                    How can go to star?
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
