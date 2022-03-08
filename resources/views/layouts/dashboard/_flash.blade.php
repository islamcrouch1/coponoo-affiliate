@if (session()->has('success'))
    <script>
        new Noty({
            type: 'alert alert-danger p-3',
            layout: 'topRight',
            text: "{{session()->get('success')}}",
            timeout: 5000,
            killer: true
        }).show();
    </script>

    @php
        session()->forget('success');
    @endphp


@endif
