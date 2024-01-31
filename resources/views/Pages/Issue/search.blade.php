@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">

        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Issue</a></li>
                <li class="breadcrumb-item active" aria-current="page">Search</li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Search Ticket by Notiket & Case ID</h4>
                        <div class="search-wrapper">
                            <div class="input-holder">
                                <input type="text" name="valNotiket" class="search-input" placeholder="Type to search"/>
                                <button class="search-icon" onclick="searchToggle(this, event);"><span></span></button>
                            </div>
                            <span class="close" onclick="searchToggle(this, event);"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom')
    <script>
        function searchToggle(obj, evt) {
            var container = $(obj).closest('.search-wrapper');
            if (!container.hasClass('active')) {
                container.addClass('active');
                evt.preventDefault();
            } else if (container.hasClass('active') && $(obj).closest('.input-holder').length == 0) {
                container.removeClass('active');
                container.find('.search-input').val('');
            } else {
                var inputVal = container.find('.search-input').val();
                if (inputVal) {
                    var url = "{{ url('Data/Detil-Report') }}/" + inputVal;
                    window.open(url, '_blank');
                }
            }
        }
    </script>
@endpush
