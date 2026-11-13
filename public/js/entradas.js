$(document).ready(function () {
    cargarEntradas();
});

function cargarEntradas() {
    $.ajax({
        url: '/entradas/listar',
        type: 'GET',
        success: function (res) {
            let html = '';

            res.data.forEach(function (b) {
                let abonado = b.es_abonado == 1
                    ? '<span class="badge badge-success">Sí</span>'
                    : '<span class="badge badge-secondary">No</span>';

                let espacio = 'Piso ' + b.espacio.piso + ' - Sector ' + escapar(b.espacio.sector) + ' - N° ' + b.espacio.numero;

                html += `
                    <tr>
                        <td><strong>${escapar(b.codigo)}</strong></td>
                        <td>${escapar(b.vehiculo.placa)}</td>
                        <td>${escapar(b.vehiculo.tipo_vehiculo.nombre)}</td>
                        <td>${espacio}</td>
                        <td>${b.hora_entrada}</td>
                        <td>${abonado}</td>
                        <td>${escapar(b.usuario.name)}</td>
                        <td>
                            <button class="btn btn-info btn-sm btnTicket" data-id="${b.id}">
                                <i class="fas fa-ticket-alt"></i> Ver ticket
                            </button>
                        </td>
                    </tr>`;
            });

            llenarTabla('#tablaEntradas', html);
        }
    });
}

function cargarEspaciosLibres() {
    $.ajax({
        url: '/espacios/listar',
        type: 'GET',
        success: function (res) {
            let html = '<option value="">-- Seleccione --</option>';
            let libres = 0;

            res.data.forEach(function (e) {
                if (e.estado == 1 && e.esta_ocupado == 0) {
                    html += `<option value="${e.id}">Piso ${e.piso} - Sector ${escapar(e.sector)} - N° ${e.numero}</option>`;
                    libres++;
                }
            });

            if (libres == 0) {
                html = '<option value="">-- No hay espacios libres --</option>';
            }

            $('#espacio_id').html(html);
        }
    });
}

function mostrarTicket(id) {
    $('#iframeTicket').attr('src', '/entradas/' + id + '/ticket');
    $('#modalTicket').modal('show');
}

$(document).on('submit', '#formBuscar', function (e) {
    e.preventDefault();

    $.ajax({
        url: '/entradas/buscar',
        type: 'GET',
        data: { placa: $('#buscarPlaca').val() },
        success: function (res) {
            $('#formEntrada')[0].reset();
            $('#metodo_pago_id').trigger('change');
            $('#cambio').text('Bs 0.00');
            $('#seccionMensualidad').hide();
            $('#camposMensualidad').hide();
            $('#placa').val(res.placa);

            if (res.existe) {
                let v = res.vehiculo;
                let duenio = v.cliente ? escapar(v.cliente.nombre) : 'Sin dueño (cliente ocasional)';

                let aviso = '';
                if (res.abonado == 'vigente') {
                    let fecha = v.cliente.fecha_vencimiento.split('-').reverse().join('/');
                    aviso = `<div class="alert alert-success">Abonado: mensualidad vigente hasta el ${fecha}. No paga al salir.</div>`;
                } else if (res.abonado == 'vencido') {
                    let fecha = v.cliente.fecha_vencimiento
                        ? 'venció el ' + v.cliente.fecha_vencimiento.split('-').reverse().join('/')
                        : 'todavía no pagó su primera mensualidad';
                    aviso = `<div class="alert alert-warning">Abonado con la mensualidad vencida (${fecha}).
                        Puede pagar la mensualidad ahora o entrar como cliente normal y pagar por tiempo.</div>`;

                    $('#precioMensualidad').text(res.precio_mensualidad);
                    $('#total_pagar').val(res.precio_mensualidad);
                    $('#seccionMensualidad').show();
                }

                $('#datosVehiculo').html(`
                    <table class="table table-sm table-bordered">
                        <tr><th>Tipo</th><td>${escapar(v.tipo_vehiculo.nombre)}</td></tr>
                        <tr><th>Marca y modelo</th><td>${escapar(v.marca)} ${escapar(v.modelo)}</td></tr>
                        <tr><th>Color</th><td>${escapar(v.color)}</td></tr>
                        <tr><th>Dueño</th><td>${duenio}</td></tr>
                    </table>
                    ${aviso}`);
                $('#registroRapido').hide();
            } else {
                $('#datosVehiculo').html('');
                $('#registroRapido').show();
            }

            cargarEspaciosLibres();
            $('#modalEntrada').modal('show');
        },
        error: function (xhr) {
            if (xhr.status == 422) {
                let errores = Object.values(xhr.responseJSON.errors).join('<br>');
                mensajeAlert('Revisa los datos', errores, 'warning');
            } else {
                mensajeAlert('No puede entrar', xhr.responseJSON.message, 'error');
            }
        }
    });
});

$(document).on('submit', '#formEntrada', function (e) {
    e.preventDefault();

    $.ajax({
        url: '/entradas',
        type: 'POST',
        data: $(this).serialize(),
        success: function (res) {
            $('#buscarPlaca').val('');
            cargarEntradas();

            $('#modalEntrada').one('hidden.bs.modal', function () {
                mostrarTicket(res.id);
            });
            $('#modalEntrada').modal('hide');
        },
        error: function (xhr) {
            if (xhr.status == 422) {
                let errores = Object.values(xhr.responseJSON.errors).join('<br>');
                mensajeAlert('Revisa los datos', errores, 'warning');
            } else {
                mensajeAlert('Error', xhr.responseJSON.message, 'error');
                cargarEspaciosLibres();
            }
        }
    });
});

$(document).on('change', '#cobrar_mensualidad', function () {
    if ($(this).is(':checked')) {
        $('#camposMensualidad').show();
    } else {
        $('#camposMensualidad').hide();
    }
});

$(document).on('click', '.btnTicket', function () {
    mostrarTicket($(this).data('id'));
});
