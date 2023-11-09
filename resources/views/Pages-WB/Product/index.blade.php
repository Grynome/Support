@push('css-plugin')
@endpush
@extends('Theme/header')
@section('getPage')
    @include('sweetalert::alert')
    <div class="page-content">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-10">
                                <h6 class="card-title">Data Product WEB</h6>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-inverse-primary btn-icon-text" data-bs-toggle="modal"
                                    data-bs-target="#add-wb-product">
                                    Add Data
                                    <i class="btn-icon-append" data-feather="plus"></i>
                                </button>

                                <div class="modal fade bd-example-modal-xl" id="add-wb-product" tabindex="-1" aria-labelledby="slaModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="slaModalLabel">Upload Product
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="btn-close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{ url('Add/data-Web=Product') }}" method="POST"
                                                    id="form-wb-add-product" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="edit_name"
                                                                    class="form-label">Product Name</label>
                                                                <input type="text" class="form-control"
                                                                    name="wb_product_name">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label for="sla_name" class="form-label">Category</label>
                                                                <select class="js-example-basic-single form-select"
                                                                    data-width="100%" name="wb_category_product"
                                                                    id="wb-category-product">
                                                                    <option value="">- Choose Category -</option>
                                                                    @foreach ($wb_category as $item)
                                                                        <option value="{{ $item->id }}">
                                                                            {{ $item->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label for="longer" class="form-label">File</label>
                                                                <div class="row">
                                                                    <div class="wb-image-input">
                                                                        <input type="file" accept="image/*" id="WBimageInput" name="wb_file_upload">
                                                                        <label for="WBimageInput" class="wb-image-button">
                                                                            <i class="link-icon" data-feather="image"></i> 
                                                                            Choose image
                                                                        </label>
                                                                        <img src="" class="wb-image-preview">
                                                                        <span class="wb-change-image">Choose different
                                                                            image</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="col-md-12">
                                                            <h4 class="card-title">Product Information</h4>
                                                            <textarea class="form-control" name="product_information" id="tinymceExample" rows="10"></textarea>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                                <button type="button"
                                                    class="btn btn-success btn-wb-add-product">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="dataTableExample" class="table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Product Name</th>
                                        <th>File Name</th>
                                        <th>Category</th>
                                        <th>Information</th>
                                        <th>Option</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = 1;
                                    @endphp
                                    @foreach ($wb_product as $item)
                                        <tr>
                                            <td>{{ $no }}</td>
                                            <td>{{ $item->product_name }}</td>
                                            <td>{{ $item->filename }}</td>
                                            <td>{{ $item->category_prd->name }}</td>
                                            <td>{!! $item->information !!}</td>
                                            <td>
                                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                                    <div class="btn-group me-2" role="group" aria-label="First group">
                                                        <button type="button"
                                                            class="btn btn-inverse-info btn-icon btn-sm updt-en-ticket">
                                                            <i data-feather="edit"></i>
                                                        </button>
                                                        &nbsp;
                                                        <button type="button"
                                                            class="btn btn-inverse-danger btn-icon btn-sm btn-remove-ticket">
                                                            <i data-feather="trash-2"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom')
<script>
    $('.btn-wb-add-product').on('click', function() {
        Swal.fire({
            title: 'Continue upload file?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#34a853',
            confirmButtonText: 'Yes',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {

                jQuery('#form-wb-add-product').submit();
            }
        });
        return false;
    });
</script>
    <script>
        $('#WBimageInput').on('change', function() {
            $input = $(this);
            if ($input.val().length > 0) {
                fileReader = new FileReader();
                fileReader.onload = function(data) {
                    $('.wb-image-preview').attr('src', data.target.result);
                }
                fileReader.readAsDataURL($input.prop('files')[0]);
                $('.wb-image-button').css('display', 'none');
                $('.wb-image-preview').css('display', 'block');
                $('.wb-change-image').css('display', 'block');
            }
        });

        $('.wb-change-image').on('click', function() {
            $control = $(this);
            $('#WBimageInput').val('');
            $preview = $('.wb-image-preview');
            $preview.attr('src', '');
            $preview.css('display', 'none');
            $control.css('display', 'none');
            $('.wb-image-button').css('display', 'block');
        });
    </script>
@endpush
