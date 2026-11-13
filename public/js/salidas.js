function mostrarComprobante(id) {
    $('#iframeComprobante').attr('src', '/salidas/' + id + '/comprobante');
    $('#modalComprobante').modal('show');
}

$(document).on('submit', '#formBuscar', function (e) {
    e.preventDefault();

    $.ajax({
        url: '/salidas/buscar',
        type: 'GET',
        data: { buscar: $('#buscarBoleto').val() },
        success: function (res) {
            let b = res.boleto;

            $('#formSalida')[0].reset();
            $('#metodo_pago_id').trigger('change');
            $('#cambio').text('Bs 0.00');

            $('#boleto_id').val(b.id);
            $('#monto_mostrado').val(res.monto);
            $('#total_pagar').val(res.monto);

            let horas = Math.floor(res.total_minutos / 60);
            let minutos = res.total_minutos % 60;

            let espacio = 'Piso ' + b.espacio.piso + ' - Sector ' + escapar(b.espacio.sector) + ' - N° ' + b.espacio.numero;

            let aviso = b.es_abonado == 1
                ? '<div class="alert alert-success">Cliente abonado: está cubierto por su mensualidad y no paga.</div>'
                : '';

            $('#detalleBoleto').html(`
                <table class="table table-sm table-bordered">
                    <tr><th>Boleto</th><td>${escapar(b.codigo)}</td></tr>
                    <tr><th>Placa</th><td>${escapar(b.vehiculo.placa)} (${escapar(b.vehiculo.tipo_vehiculo.nombre)})</td></tr>
                    <tr><th>Espacio</th><td>${espacio}</td></tr>
                    <tr><th>Entrada</th><td>${b.hora_entrada}</td></tr>
                    <tr><th>Salida</th><td>${res.hora_salida}</td></tr>
                    <tr><th>Tiempo</th><td>${horas} h ${minutos} min</td></tr>
                    <tr><th>Cálculo</th><td>${res.fracciones} fracción(es) de ${res.tarifa.minutos_fraccion} min × Bs ${res.precio_fraccion}</td></tr>
                    <tr><th>Total a pagar</th><td><h4 class="mb-0">Bs ${res.monto}</h4></td></tr>
                </table>
                ${aviso}`);

            if (b.es_abonado == 1) {
                $('#seccionPago').hide();
            } else {
                $('#seccionPago').show();
            }

            $('#modalSalida').modal('show');
        },
        error: function (xhr) {
            if (xhr.status == 422) {
                let errores = Object.values(xhr.responseJSON.errors).join('<br>');
                mensajeAlert('Revisa los datos', errores, 'warning');
            } else {
                mensajeAlert('No encontrado', xhr.responseJSON.message, 'error');
            }
        }
    });
});

$(document).on('submit', '#formSalida', function (e) {
    e.preventDefault();
    let id = $('#boleto_id').val();

    $.ajax({
        url: '/salidas/' + id + '/cobrar',
        type: 'PUT',
        data: $(this).serialize(),
        success: function (res) {
            $('#buscarBoleto').val('');

            $('#modalSalida').one('hidden.bs.modal', function () {
                mostrarComprobante(res.id);
            });
            $('#modalSalida').modal('hide');
        },
        error: function (xhr) {
            if (xhr.status == 422) {
                let errores = Object.values(xhr.responseJSON.errors).join('<br>');
                mensajeAlert('Revisa los datos', errores, 'warning');
            } else {
                $('#modalSalida').modal('hide');
                mensajeAlert('No se pudo cobrar', xhr.responseJSON.message, 'error');
            }
        }
    });
});
