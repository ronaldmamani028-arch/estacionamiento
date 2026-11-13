$(document).ready(function () {
    cargarMensualidades();
});

function cargarMensualidades() {
    $.ajax({
        url: '/mensualidades/listar',
        type: 'GET',
        success: function (res) {
            let html = '';

            res.data.forEach(function (m, i) {
                let desde = m.fecha_inicio.split('-').reverse().join('/');
                let hasta = m.fecha_fin.split('-').reverse().join('/');

                html += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${escapar(m.cliente.nombre)}</td>
                        <td>${m.created_at}</td>
                        <td>${desde} al ${hasta}</td>
                        <td>${escapar(m.metodo_pago.nombre)}</td>
                        <td>${m.numero_operacion ? escapar(m.numero_operacion) : '-'}</td>
                        <td class="text-right">${m.monto}</td>
                        <td>${escapar(m.usuario.name)}</td>
                    </tr>`;
            });

            llenarTabla('#tablaMensualidades', html);
        }
    });
}

function cargarClientesAbonados() {
    $.ajax({
        url: '/clientes/listar',
        type: 'GET',
        success: function (res) {
            let html = '<option value="">-- Seleccione --</option>';
            let cantidad = 0;

            res.data.forEach(function (c) {
                if (c.es_abonado == 1 && c.estado == 1) {
                    let ci = c.ci ? ' - CI ' + escapar(c.ci) : '';
                    let vence = c.fecha_vencimiento
                        ? 'vence el ' + c.fecha_vencimiento.split('-').reverse().join('/')
                        : 'sin pagar';

                    html += `<option value="${c.id}">${escapar(c.nombre)}${ci} (${vence})</option>`;
                    cantidad++;
                }
            });

            if (cantidad == 0) {
                html = '<option value="">-- No hay clientes abonados activos --</option>';
            }

            $('#cliente_id').html(html);
        }
    });
}

$(document).on('click', '#btnNuevo', function () {
    $('#formMensualidad')[0].reset();
    $('#metodo_pago_id').trigger('change');
    $('#total_pagar').val(0);
    $('#cambio').text('Bs 0.00');
    cargarClientesAbonados();
    $('#modalMensualidad').modal('show');
});

$(document).on('change', '#tarifa_id', function () {
    $('#total_pagar').val($('#tarifa_id option:selected').data('precio'));
    $('#monto_recibido').trigger('input');
});

$(document).on('submit', '#formMensualidad', function (e) {
    e.preventDefault();

    $.ajax({
        url: '/mensualidades',
        type: 'POST',
        data: $(this).serialize(),
        success: function (res) {
            $('#modalMensualidad').modal('hide');
            mensajeAlert('¡Listo!', res.message, 'success');
            cargarMensualidades();
        },
        error: function (xhr) {
            if (xhr.status == 422) {
                let errores = Object.values(xhr.responseJSON.errors).join('<br>');
                mensajeAlert('Revisa los datos', errores, 'warning');
            } else {
                mensajeAlert('Error', xhr.responseJSON.message, 'error');
            }
        }
    });
});
