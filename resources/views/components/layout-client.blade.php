@include('/components/client/header')


@if (session()->has('success'))
    <div class="container container--narrow">
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    </div>
@endif

@if (session()->has('error'))
    <div class="container container--narrow">
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    </div>
@endif


<!-- header ends here -->
{{ $slot }}
<!-- footer begins -->
@include('/components/client/footer')
