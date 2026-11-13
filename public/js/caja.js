$(document).ready(function () {
    cargarCaja();
});

$(document).on('submit', '#formFiltro', function (e) {
    e.preventDefault();
    cargarCaja();
});

function cargarCaja() {
    $.ajax({
        url: '/caja/listar',
        type: 'GET',
        data: { desde: $('#desde').val(), hasta: $('#hasta').val() },
        success: function (res) {
            let html = '';
            res.boletos.forEach(function (b, i) {
                html += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${escapar(b.codigo)}</td>
                        <td>${escapar(b.vehiculo.placa)}</td>
                        <td>${b.hora_salida}</td>
                        <td>${escapar(b.metodo_pago.nombre)}</td>
                        <td>${b.numero_operacion ? escapar(b.numero_operacion) : '-'}</td>
                        <td class="text-right">${b.monto_total}</td>
                    </tr>`;
            });
            llenarTabla('#tablaBoletos', html);

            html = '';
            res.mensualidades.forEach(function (m, i) {
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
                    </tr>`;
            });
            llenarTabla('#tablaMensualidades', html);

            $('#totalEfectivo').text(res.total_efectivo);
            $('#totalQr').text(res.total_qr);
            $('#totalGeneral').text(res.total_general);
        },
        error: function (xhr) {
            if (xhr.status == 422) {
                let errores = Object.values(xhr.responseJSON.errors).join('<br>');
                mensajeAlert('Revisa las fechas', errores, 'warning');
            } else {
                mensajeAlert('Error', xhr.responseJSON.message, 'error');
            }
        }
    });
}
