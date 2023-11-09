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
                            <div class="col-md-12">
                                <form method="POST" action="{{url('/test/upload')}}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="file_test">
                                    <button type="submit">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('plugin-page')
    {{-- <script src="{{ asset('assets') }}/vendors/prismjs/prism.js"></script>
    <script src="{{ asset('assets') }}/vendors/clipboard/clipboard.min.js"></script> --}}
@endpush
@push('custom-plug')
@endpush
@push('custom')
    {{-- <script>
        (function($) {
            'use strict';
            $(function() {

                if ($('.perfect-scrollbar-example').length) {
                    var scrollbarExample = new PerfectScrollbar('.perfect-scrollbar-example');
                }

            });
        })(jQuery);
    </script> --}}
    {{-- <script>
        // Get the container element
        const container = document.querySelector('.perfect-scrollbar-example');

        // Get the maximum scroll height based on the content height
        const maxScrollHeight = container.scrollHeight - container.clientHeight;

        // Set the initial scroll position to 0
        let scrollPosition = 0;

        // Scroll the container to the end and repeat
        function scrollToEndAndRepeat() {
            // Calculate the new scroll position
            scrollPosition = (scrollPosition + 1) % (maxScrollHeight + 1);

            // Set the scroll position of the container
            container.scrollTop = scrollPosition;

            // If the scroll position is at the maximum height, reset it to 0
            if (scrollPosition === maxScrollHeight) {
                scrollPosition = 0;
            }

            // Call this function again after a short delay to continue the animation
            setTimeout(scrollToEndAndRepeat, 10);
        }

        // Call the scrollToEndAndRepeat function to start the animation
        scrollToEndAndRepeat();
    </script> --}}
@endpush
