@push('css-plugin')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
</style>
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
    <div id="ntGroup">
        <label for="input-desc-note" class="form-label fw-bolder">Description:</label>
        <textarea class="form-control txt-note" rows="3" id="input-desc-note" placeholder="Click the 'Record' button and speak"></textarea>
        <button id="recordButton"><i class="mdi mdi-microphone-outline"></i></button>
    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('plugin-page')
@endpush
@push('custom-plug')
@endpush
@push('custom')
    <script>
        const textarea = document.getElementById('input-desc-note');
        const recordButton = document.getElementById('recordButton');
        let recognition;

        // Check if SpeechRecognition is available
        if ('SpeechRecognition' in window || 'webkitSpeechRecognition' in window) {
            const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
            recognition = new SpeechRecognition();

            // Set language to Indonesian (id-ID)
            recognition.lang = 'id-ID';

            recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript;
                textarea.value += transcript + ' ';
            };

            recognition.onerror = (event) => {
                console.error('Speech recognition error', event.error);
            };

            recognition.onend = () => {
                console.log('Speech recognition ended');
                // Change the button style when recording ends
                recordButton.classList.remove('recording');
            };

            // Toggle recording when the button is clicked
            recordButton.addEventListener('click', () => {
                if (recognition && recognition.recognizing) {
                    recognition.stop();
                } else {
                    recognition.start();
                    // Change the button style when recording starts
                    recordButton.classList.add('recording');
                }
            });

        } else {
            console.error('Speech recognition not supported in this browser');
        }
    </script>
@endpush
