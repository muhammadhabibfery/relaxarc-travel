<!-- Bootstrap core JavaScript-->
<script src="{{ asset('assets/backend/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('assets/backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('assets/backend/js/sb-admin-2.min.js') }}"></script>

<script>
    document.addEventListener('click', function(e){
        if(e.target.id == 'btnfr'){
            const form = document.querySelector('#myfr');
            form.addEventListener('submit', function(ev){
                const btn = document.querySelector('#btnfr');
                btn.innerHTML = 'Please Wait ...';
                btn.style.fontWeight = 'bold';
                btn.style.color = 'black';
                btn.setAttribute('disable', 'disable');
                console.log('hmm');
                return true;
            });
        }
    });
</script>
