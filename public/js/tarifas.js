$(document).ready(function () {
    cargarTarifas();
});

function cargarTarifas() {
    $.ajax({
        url: '/tarifas/listar',
        type: 'GET',
        success: function (res) {
            let html = '';

            res.data.forEach(function (t, i) {
                let estado = t.estado == 1
                    ? '<span class="badge badge-success">Activa</span>'
                    : '<span class="badge badge-secondary">Inactiva</span>';

                let botonEstado = t.estado == 1
                    ? `<button class="btn btn-danger btn-sm btnEstado" data-id="${t.id}">Desactivar</button>`
                    : `<button class="btn btn-success btn-sm btnEstado" data-id="${t.id}">Activar</button>`;

                html += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${escapar(t.tipo_vehiculo.nombre)}</td>
                        <td>Bs ${t.precio_hora}</td>
                        <td>${t.minutos_fraccion}</td>
                        <td>Bs ${t.precio_mensualidad}</td>
                        <td>${estado}</td>
                        <td>
                            <button class="btn btn-warning btn-sm btnEditar"
                                data-id="${t.id}"
                                data-tipo="${t.tipo_vehiculo_id}"
                                data-precio="${t.precio_hora}"
                                data-minutos="${t.minutos_fraccion}"
                                data-mensualidad="${t.precio_mensualidad}">
                                Editar
                            </button>
                            ${botonEstado}
                        </td>
                    </tr>`;
            });

            llenarTabla('#tablaTarifas', html);
        }
    });
}

$(document).on('click', '#btnNuevo', function () {
    $('#formTarifa')[0].reset();
    $('#id').val('');
    $('#tituloModal').text('Nueva tarifa');
    $('#modalTarifa').modal('show');
});

$(document).on('click', '.btnEditar', function () {
    $('#id').val($(this).data('id'));
    $('#tipo_vehiculo_id').val($(this).data('tipo'));
    $('#precio_hora').val($(this).data('precio'));
    $('#minutos_fraccion').val($(this).data('minutos'));
    $('#precio_mensualidad').val($(this).data('mensualidad'));
    $('#tituloModal').text('Editar tarifa');
    $('#modalTarifa').modal('show');
});

$(document).on('submit', '#formTarifa', function (e) {
    e.preventDefault();
    let id = $('#id').val();

    $.ajax({
        url: id ? '/tarifas/' + id : '/tarifas',
        type: id ? 'PUT' : 'POST',
        data: $(this).serialize(),
        success: function (res) {
            $('#modalTarifa').modal('hide');
            mensajeAlert('¡Listo!', res.message, 'success');
            cargarTarifas();
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

$(document).on('click', '.btnEstado', function () {
    let id = $(this).data('id');

    $.ajax({
        url: '/tarifas/' + id + '/estado',
        type: 'PUT',
        success: function (res) {
            mensajeAlert('¡Listo!', res.message, 'success');
            cargarTarifas();
        },
        error: function (xhr) {
            mensajeAlert('Error', xhr.responseJSON.message, 'error');
        }
    });
});
