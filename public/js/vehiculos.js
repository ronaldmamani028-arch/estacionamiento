$(document).ready(function () {
    cargarVehiculos();
});

function cargarVehiculos() {
    $.ajax({
        url: '/vehiculos/listar',
        type: 'GET',
        success: function (res) {
            let html = '';

            res.data.forEach(function (v, i) {
                let estado = v.estado == 1
                    ? '<span class="badge badge-success">Activo</span>'
                    : '<span class="badge badge-secondary">Inactivo</span>';

                let botonEstado = v.estado == 1
                    ? `<button class="btn btn-danger btn-sm btnEstado" data-id="${v.id}">Desactivar</button>`
                    : `<button class="btn btn-success btn-sm btnEstado" data-id="${v.id}">Activar</button>`;

                let duenio = v.cliente ? escapar(v.cliente.nombre) : '-';

                let botones = '';
                if (puedeEditar) {
                    botones = `
                        <button class="btn btn-warning btn-sm btnEditar"
                            data-id="${v.id}"
                            data-placa="${escapar(v.placa)}"
                            data-tipo="${v.tipo_vehiculo_id}"
                            data-cliente="${v.cliente_id || ''}"
                            data-marca="${escapar(v.marca)}"
                            data-modelo="${escapar(v.modelo)}"
                            data-color="${escapar(v.color)}">
                            Editar
                        </button>
                        ${botonEstado}`;
                }

                html += `
                    <tr>
                        <td>${i + 1}</td>
                        <td><strong>${escapar(v.placa)}</strong></td>
                        <td>${escapar(v.tipo_vehiculo.nombre)}</td>
                        <td>${escapar(v.marca)}</td>
                        <td>${escapar(v.modelo)}</td>
                        <td>${escapar(v.color)}</td>
                        <td>${duenio}</td>
                        <td>${estado}</td>
                        <td>${botones}</td>
                    </tr>`;
            });

            llenarTabla('#tablaVehiculos', html);
        }
    });
}

$(document).on('click', '#btnNuevo', function () {
    $('#formVehiculo')[0].reset();
    $('#id').val('');
    $('#tituloModal').text('Nuevo vehículo');
    $('#modalVehiculo').modal('show');
});

$(document).on('click', '.btnEditar', function () {
    $('#id').val($(this).data('id'));
    $('#placa').val($(this).data('placa'));
    $('#tipo_vehiculo_id').val($(this).data('tipo'));
    $('#cliente_id').val($(this).data('cliente'));
    $('#marca').val($(this).data('marca'));
    $('#modelo').val($(this).data('modelo'));
    $('#color').val($(this).data('color'));
    $('#tituloModal').text('Editar vehículo');
    $('#modalVehiculo').modal('show');
});

$(document).on('submit', '#formVehiculo', function (e) {
    e.preventDefault();
    let id = $('#id').val();

    $.ajax({
        url: id ? '/vehiculos/' + id : '/vehiculos',
        type: id ? 'PUT' : 'POST',
        data: $(this).serialize(),
        success: function (res) {
            $('#modalVehiculo').modal('hide');
            mensajeAlert('¡Listo!', res.message, 'success');
            cargarVehiculos();
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
        url: '/vehiculos/' + id + '/estado',
        type: 'PUT',
        success: function (res) {
            mensajeAlert('¡Listo!', res.message, 'success');
            cargarVehiculos();
        },
        error: function (xhr) {
            mensajeAlert('Error', xhr.responseJSON.message, 'error');
        }
    });
});
