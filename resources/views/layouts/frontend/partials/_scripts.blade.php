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
<script>
    document.addEventListener('click', function(e){
        if(e.target.id = 'btnfr'){
            const form = document.querySelector('#myfr');
            form.addEventListener('submit', function(ev){
                const btn = document.querySelector('#btnfr');
                btn.innerHTML = 'Please Wait ...';
                btn.style.fontWeight = 'bold';
                btn.style.color = 'black';
                btn.setAttribute('disable', 'disable');
                return true;
            });
        }
    });
</script>
