<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="{{ asset('assets/frontend/libraries/jquery/jquery-3.3.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
    integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
    integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
</script>

<!-- Font Awesome library -->
<script src="https://kit.fontawesome.com/efd43ec33f.js" crossorigin="anonymous"></script>

<!-- Toastr JS Library-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script>
    @if(session('verifiedStatus'))
        toastr.closeButton = true,
        toastr.options.positionClass = "toast-top-center";
        toastr.options.progressBar = true;
        toastr.options.showDuration = 500;
        toastr.success("{!!  session('verifiedStatus')  !!}", 'Sukses');
    @endif

    @if(session('success'))
        toastr.closeButton = true,
        toastr.options.positionClass = "toast-top-center";
        toastr.options.progressBar = true;
        toastr.options.showDuration = 500;
        toastr.success("{!! session('success') !!}", "{{ __('Success') }}");
    @endif
    @if(session('failed'))
        toastr.closeButton = true,
        toastr.options.positionClass = "toast-top-center";
        toastr.options.progressBar = true;
        toastr.options.showDuration = 500;
        toastr.error("{!! session('failed') !!}", "{{ __('Failed') }}");
    @endif

    const submitted = (form) => {
        form.btnfr.innerHTML = "{{ __('Please Wait ...') }}";
        form.btnfr.style.fontWeight = 'bold';
        form.btnfr.style.color = 'black';
        form.btnfr.style.backgroundColor = '#b1b1b1';
        form.btnfr.style.cursor = 'not-allowed';
        form.btnfr.setAttribute('disable', 'disable');
        return true;
    };

</script>
