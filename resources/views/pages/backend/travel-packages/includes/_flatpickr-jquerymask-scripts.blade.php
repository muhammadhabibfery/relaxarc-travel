<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"
    integrity="sha512-pHVGpX7F/27yZ0ISY+VVjyULApbDlD0/X0rgGbTqCE7WFW5MezNTWG/dnhtbBuICzsd0WQPgpE4REBLv+UqChw=="
    crossorigin="anonymous"></script>

<script>
    const dateDepartureInput = document.querySelector('#date_departure');

    flatpickr(".flatpickr", {
        locale: "id",
        wrap: true,
        allowInput: true,
        enableTime: true,
        // altInput: true,
        altFormat: "l, d-F-Y H:i",
        dateFormat: "Y-m-d H:i",
        minDate: new Date().fp_incr(1),
        time_24hr: true,
        defaultDate: "08:00",
        minTime: "07:00",
        maxTime: "23:00",
        disableMobile: "true",
    });

    $('#price').mask('00.000.000', {reverse: true, placeholder: "Rp. "});
</script>
