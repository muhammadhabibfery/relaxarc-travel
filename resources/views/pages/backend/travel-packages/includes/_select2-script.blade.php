<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {
        $(".status-select2").select2({
            placeholder: "{{ __('Choose status') }}",
            allowClear: true,
            // width: 'resolve',
        });
    });
</script>
