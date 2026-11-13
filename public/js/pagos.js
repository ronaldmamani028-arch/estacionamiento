$(document).on('change', '#metodo_pago_id', function () {
    if ($('#metodo_pago_id option:selected').text() == 'QR Yape') {
        $('#pagoEfectivo').hide();
        $('#pagoQr').show();
    } else {
        $('#pagoQr').hide();
        $('#pagoEfectivo').show();
    }
});

$(document).on('input', '#monto_recibido', function () {
    let total = parseFloat($('#total_pagar').val()) || 0;
    let recibido = parseFloat($(this).val()) || 0;

    if (recibido >= total) {
        $('#cambio').text('Bs ' + (recibido - total).toFixed(2));
    } else {
        $('#cambio').text('Falta Bs ' + (total - recibido).toFixed(2));
    }
});
