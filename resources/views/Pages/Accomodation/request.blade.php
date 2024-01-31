@push('css-plugin')
    <link rel="stylesheet" href="{{ asset('assets') }}/vendors/dropify/dist/dropify.min.css">
@endpush
@php
    if ($dsc == 'Add') {
        $title = "$dsc Request";
        $disabled = '';
    } elseif ($dsc == 'Refs') {
        $title = "Request $dsc to $id_dt";
        $disabled = 'disabled';
    } elseif ($dsc == 'Past') {
        $title = "Request $dsc Ticket";
        $disabled = '';
    } else {
        $title = 'Re-Create Request';
        $disabled = '';
    }

@endphp
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')

    <div class="page-content">
        @include('sweetalert::alert')
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Tables</a></li>
                <li class="breadcrumb-item active" aria-current="page">Request Accomodation</li>
            </ol>
        </nav>
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-baseline sv-tc">
                            <h6 class="card-title mb-0">
                                <span class="input-group-text">
                                    {{ $title }}
                                </span>
                            </h6>
                            <a class="cta btn-add-rqs-rmbrs" href="javascript:;">
                                <span>Send</span>
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
        <form action="{{ url("$dsc/$id_dt/Reqs-Reimburse/En") }}" method="post" id="fm-add-rqs-rmbrs"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-md-12 grid-margin strech-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                @if ($dsc != 'Re')
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="notiket-request">Notiket</label>
                                        <select class="js-example-basic-multiple form-select" name="val_id_tiket_reqs[]" id="notiket-request" 
                                            multiple="multiple" data-width="100%">
                                            @foreach ($data_tiket as $item)
                                                <option value="{{$item->notiket}}">{{$item->notiket}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3 grid-margin stretch-card" style="height: 100%">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h4 class="card-title">Additional</h4>
                                <hr>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Type of Request</label>
                                    <div class="d-flex justify-content-between">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="type_reqs" value="1" {{$dsc != 'Past' ? 'disabled' : 'checked'}}>
                                            <label class="form-check-label" for="sidebarLight">
                                            Reimburse
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" class="form-check-input" name="type_reqs" value="2" {{$dsc != 'Past' ? 'checked' : 'disabled'}}>
                                            <label class="form-check-label" for="sidebarDark">
                                            Estimation
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="type-of-trans">Type of Transportation</label>
                                    <select class="js-example-basic-single form-select" name="val_type_trans"
                                        id="type-of-trans" data-width="100%" {{ $disabled }}>
                                        <option value="">- Choose -</option>
                                        @foreach ($ttns as $t)
                                            <option value="{{ $t->id }}"
                                                {{ $t->id == @$top->id_type_trans ? 'selected' : '' }}>
                                                {{ $t->description }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                                <div>
                                    <h4 class="mb-md-0">Add Fields</h4>
                                </div>
                                <div class="d-flex align-items-center flex-wrap text-nowrap">
                                    <button class="btn btn-inverse-primary add-fields" type="button"><i
                                            class="btn-icon-append icon-lg" data-feather="plus"></i></button>
                                </div>
                            </div>
                            <div class="reimburse-records">
                                <hr>
                                <div class="row">
                                    <div class="col">
                                        <label class="form-label" for="ctgr-reqs">Category</label>
                                        <select class="js-example-basic-single form-select category-select"
                                            data-width="100%" id="ctgr-reqs" name="val_ctgr[]">
                                            <option value="">- Choose -</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="total-expenses">Total</label>
                                        <input name="nominal[]" id="total-expenses"
                                            class="form-control nominal-request mb-4 mb-md-0" placeholder="Rp0.00"
                                            data-inputmask="'alias': 'currency', 'prefix':'Rp'" />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label" for="attach-reqs">Attach Receipt</label>
                                        <div class="d-flex justify-content-between align-items-baseline att-rmv">
                                            <input type="file" class="file" id="attach-reqs" name="attach_file[]"
                                                accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" />
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="reimburse-records-multiple">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@push('plugin-page')
    <script src="{{ asset('assets') }}/vendors/inputmask/jquery.inputmask.min.js"></script>
    <script src="{{ asset('assets') }}/vendors/dropify/dist/dropify.min.js"></script>
@endpush
@push('custom-plug')
    <script src="{{ asset('assets') }}/js/inputmask.js"></script>
    <script src="{{ asset('assets') }}/js/dropify.js"></script>
@endpush
@push('custom')
    <script>
        var dsc = "{{ $dsc }}";
        $('.btn-add-rqs-rmbrs').on('click', function(event) {
            // Prevent the default form submission behavior
            event.preventDefault();

            // Validate fields before submitting the form
            if (validateForm()) {
                Swal.fire({
                    title: 'Send?',
                    text: 'It will forwarded to your Leader to confirm!',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#34a853',
                    confirmButtonText: 'yes',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        jQuery("#fm-add-rqs-rmbrs").submit();
                    }
                });
            }
        });

        // Function to validate the form
        function validateForm() {
            var notiketRequest = $('#notiket-request').val();
            var typeOfTrans = $('#type-of-trans').val();

            if (dsc == "Past") {
                if (notiketRequest === null || notiketRequest.length === 0) {
                    // Display SweetAlert error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please fill notiket fields.',
                    });
                    return false; // Validation failed
                }
            }
            // Validate required fields
            if (typeOfTrans === "") {
                // Display SweetAlert error message
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please select type of transport fields.',
                });
                return false; // Validation failed
            }

            // Validate fields inside each dynamically added field
            var allValid = true;

            $('.reimburse-records').each(function(index) {
                var ctgrReqs = $(this).find('.category-select').val();
                var totalExpenses = $(this).find('.nominal-request').val();
                if (dsc == "Past") {
                    var attachReqs = $(this).find('.att-rmv input[type="file"]').val();
                }

                if (ctgrReqs === "") {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please select a category in field ' + (index + 1) + '.',
                    });
                    allValid = false; // Validation failed
                    return false; // Exit each loop
                }

                if (totalExpenses === "") {
                    // Display SweetAlert error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please Fill a Nominal in field ' + (index + 1) + '.',
                    });
                    allValid = false; // Validation failed
                    return false; // Exit each loop
                }
                if (dsc == "Past") {
                    if (attachReqs === "") {
                        // Display SweetAlert error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            text: 'Please Attach a Proof of Payment in field ' + (index + 1) + '.',
                        });
                        allValid = false; // Validation failed
                        return false; // Exit each loop
                    }
                }
            });
            return allValid; // Return the result of all validations
        }

        // script Select Updated
        $(document).ready(function() {
            // Initialize Select2 for the original select element
            $('.category-select').select2();

            // Function to fetch and update categories for a select element
            function updateCategories(selectElement, categories) {
                selectElement.empty();
                selectElement.append('<option value="">- Choose -</option>');
                categories.forEach(function(category) {
                    selectElement.append('<option value="' + category.id + '">' + category.description +
                        '</option>');
                });
            }

            // Function to initialize input masks
            function initializeInputMasks() {
                $('.nominal-request').inputmask({
                    'alias': 'currency',
                    'prefix': 'Rp',
                });
            }

            // Fetch categories using Ajax
            function fetchCategories(callback) {
                $.ajax({
                    url: '{{ route('fetch.category.reqs') }}',
                    method: 'GET',
                    success: function(response) {
                        callback(response);
                    },
                    error: function(error) {
                        console.error('Error fetching categories:', error);
                    }
                });
            }

            // Function to add fields dynamically
            function addFields() {
                // Create a new set of fields dynamically
                var newFields = $('<div class="reimburse-records">' + $('.reimburse-records').html() + '</div>');

                // Remove existing Select2 instances and input masks in the new fields
                newFields.find('.category-select').each(function() {
                    $(this).next('.select2-container').remove();
                });

                // Fetch categories and update the options for the new select element
                fetchCategories(function(categories) {
                    // Update options for the new select element
                    var selectElement = newFields.find('.category-select');
                    var selectedCategories = [];

                    // Iterate over existing records and collect selected categories
                    $('.reimburse-records .category-select').each(function() {
                        var selectedCategory = $(this).val();
                        if (selectedCategory) {
                            selectedCategories.push(selectedCategory);
                        }
                    });

                    // Filter out selected categories from the options
                    var filteredCategories = categories.filter(function(category) {
                        return !selectedCategories.includes(category.id.toString());
                    });

                    updateCategories(selectElement, filteredCategories);

                    // Initialize input masks for the new fields
                    newFields.find('.nominal-request').inputmask({
                        'alias': 'currency',
                        'prefix': 'Rp',
                    });

                    // Append remove button
                    newFields.find('.att-rmv').append(
                        '<button class="btn btn-danger remove-fields" type="button"><i class="btn-icon-append icon-lg" data-feather="minus"></i></button>'
                    );

                    // Append new fields to reimburse-records-multiple
                    $('.reimburse-records-multiple').append(newFields);

                    // Reinitialize Select2 for the new select elements
                    $('.reimburse-records-multiple .category-select').select2();
                    feather.replace();

                    // Reinitialize input masks for the new fields
                    initializeInputMasks();
                });
            }

            fetchCategories(function(categories) {
                updateCategories($('.category-select'), categories);
            });

            $('.add-fields').on('click', addFields);

            $(document).on('change', '.category-select', function() {
                var selectedCategory = $(this).val();
                var selectedCategoryData = $(this).data('category-data');

                $('.reimburse-records .category-select').not(this).each(function() {
                    $(this).find('option[value="' + selectedCategory + '"]').remove();
                    if (selectedCategoryData) {
                        $(this).append('<option value="' + selectedCategory + '">' +
                            selectedCategoryData + '</option>');
                    }
                });
                $(this).data('category-data', $(this).find('option:selected').text());
            });

            $(document).on('click', '.remove-fields', function() {
                var removedCategory = $(this).closest('.reimburse-records').find('.category-select')
                    .val();
                var removedCategoryData = $(this).closest('.reimburse-records').find(
                    '.category-select').data('category-data');

                $('.reimburse-records .category-select').each(function() {
                    if (!$(this).find('option[value="' + removedCategory + '"]').length &&
                        removedCategoryData) {
                        $(this).append('<option value="' + removedCategory + '">' +
                            removedCategoryData + '</option>');
                    }
                });

                $(this).closest('.reimburse-records').remove();
            });
            initializeInputMasks();
        });
    </script>
@endpush
