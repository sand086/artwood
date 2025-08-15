@php
    $message = \App\Helpers\MessageHelper::getMessage();
@endphp

@if ($message)
    <script src="{{ asset('js/helpers/messageHelper.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            showMessage('{{ $message['type'] }}', '{{ $message['message'] }}');
        });
    </script>
    @php
        \Illuminate\Support\Facades\Session::forget('message');
    @endphp
@endif
