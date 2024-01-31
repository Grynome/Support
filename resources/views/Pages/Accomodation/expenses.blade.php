@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')

    <div class="page-content">
        @include('sweetalert::alert')
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Financial Outlay</li>
            </ol>
        </nav>
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-baseline sv-tc">
                            <h6 class="card-title mb-0">
                                <span class="input-group-text">
                                    Financial Outlay
                                </span>
                            </h6>
                            <a class="cta btn-str-xps" href="javascript:;">
                                <span>Save</span>
                                <span>
                                    <svg width="33px" height="18px" viewBox="0 0 66 43" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <g id="arrow" stroke="none" stroke-width="1" fill="none"
                                            fill-rule="evenodd">
                                            <path class="one"
                                                d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z"
                                                fill="#FFFFFF"></path>
                                            <path class="two"
                                                d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z"
                                                fill="#FFFFFF"></path>
                                            <path class="three"
                                                d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z"
                                                fill="#FFFFFF"></path>
                                        </g>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('store.expenses', $id_dt) }}" method="post" id="fm-str-xps">
            @csrf
            <div class="row">
                <div class="col grid-margin grid-margin-xl-0 stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12">
                                <div class="row mb-3">
                                    <div class="col">
                                        <label class="form-label" for="desc-expenses">Description</label>
                                        <input id="desc-expenses" class="form-control form-expenses" name="desc_xps"
                                            type="text" placeholder="e.g. Engineer Onsite">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="ctgr-expenses">Category</label>
                                        <select class="js-example-basic-single form-select" data-width="100%"
                                            name="category_xps" id="ctgr-expenses">
                                            <option value="">- Choose -</option>
                                            @foreach ($category_expanses as $item)
                                                <option value="{{ $item->id }}">
                                                    {{ $item->description }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="flatpickr-exps" class="form-label">Expense Date</label>
                                        <div class="input-group flatpickr" id="flatpickr-dtc">
                                            <input type="text" class="form-control dt-xps"
                                                placeholder="Select Date/Time" name="date_xps" id="flatpickr-dtc"
                                                data-input>
                                            <span class="input-group-text input-group-addon" data-toggle><i
                                                    data-feather="calendar"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="form-label" for="total-expenses">Total</label>
                                        <p class="text-muted mb-3">Total Nominal Engineer Request :
                                            <b>{{ 'Rp ' . number_format($get_total->total_reqs, 0, ',', '.') }}</b></p>
                                    </div>
                                    <div class="col-md-4 col-offset-8">
                                        <input name="total_xps" id="total-expenses"
                                            class="form-control form-expenses mb-4 mb-md-0" placeholder="Rp0.00"
                                            data-inputmask="'alias': 'currency', 'prefix':'Rp'" value="{{$get_total->total_reqs}}" readonly/>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 col-offset-6">
                                        <label class="form-label" for="way-paid-xps">Paid By</label>
                                        <fieldset id="way-paid-xps">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="paid_by_xps"
                                                    id="Employee" value="1">
                                                <label class="form-check-label" for="Employee">
                                                    Employee (to reimburse)
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="paid_by_xps"
                                                    id="Company" value="2">
                                                <label class="form-check-label" for="Company">
                                                    Company
                                                </label>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label class="form-label" for="note-expenses">Notes (Optional)</label>
                                        <textarea id="note-expenses" name="note_xps" class="form-control form-expenses" rows="2"
                                            placeholder="Notes...."></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- </form> --}}
    </div>
@endsection
@push('plugin-page')
    <script src="{{ asset('assets') }}/vendors/inputmask/jquery.inputmask.min.js"></script>
@endpush
@push('custom-plug')
    <script src="{{ asset('assets') }}/js/inputmask.js"></script>
@endpush
@push('custom')
    <script>
        $('.btn-str-xps').on('click', function() {
            var way_paid = document.getElementById("way-paid-xps").getElementsByTagName('input');
            var checked_way_paid = false;
            for (var i = 0; i < way_paid.length; i++) {
                if (way_paid[i].checked) {
                    checked_way_paid = true;
                    break;
                }
            }
            if ($('#desc-expenses').val() === "" || $('#ctgr-expenses').val() === "" 
                || $('.dt-xps').val() === "" || $('#total-expenses').val() === ""
                 || !checked_way_paid) {
                if ($('#desc-expenses').val() === "" && $('#ctgr-expenses').val() === "" 
                    && $('.dt-xps').val() === "" && $('#total-expenses').val() === ""
                    && !checked_way_paid) {
                    Swal.fire({
                        title: "Your form still empty!!",
                        text: "Please fill out the form!!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                } else if ($('#desc-expenses').val() === "") {
                    Swal.fire({
                        title: "Description must be fill!!",
                        text: "Please fill the text of description!!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                } else if ($('#ctgr-expenses').val() === "") {
                    Swal.fire({
                        title: "Category can't be null!!",
                        text: "Please select the category!!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                } else if ($('.dt-xps').val() === "") {
                    Swal.fire({
                        title: "The Date can't be null!!",
                        text: "Please select for the date!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                } else if ($('#total-expenses').val() === "") {
                    Swal.fire({
                        title: "Total must be fill!!",
                        text: "Please fill out the total!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                } else if (!checked_way_paid) {
                    Swal.fire({
                        title: "Paid Option must be check out!!",
                        text: "Please checked the Paid Option!",
                        icon: "warning",
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                }
            }else{
                Swal.fire({
                    title: 'Save?',
                    text: 'It will forwarded to your Leader Accounting for confirm!',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'yes',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery("#fm-str-xps").submit();
                    }
                });
            }
        });
    </script>
@endpush
