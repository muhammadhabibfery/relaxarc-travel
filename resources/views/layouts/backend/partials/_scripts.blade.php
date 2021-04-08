<!-- Bootstrap core JavaScript-->
<script src="{{ asset('assets/backend/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('assets/backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('assets/backend/js/sb-admin-2.min.js') }}"></script>

<!-- Toastr JS Library-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


<script>
    @if(session('status'))
        toastr.closeButton = true,
        toastr.options.positionClass = "toast-top-center";
        toastr.options.progressBar = true;
        toastr.options.showDuration = 500;
        toastr.success("{!! session('status') !!}", 'Sukses');
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
