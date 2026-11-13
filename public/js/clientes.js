$(document).ready(function () {
    cargarClientes();
});

function cargarClientes() {
    $.ajax({
        url: '/clientes/listar',
        type: 'GET',
        success: function (res) {
            let html = '';

            res.data.forEach(function (c, i) {
                let estado = c.estado == 1
                    ? '<span class="badge badge-success">Activo</span>'
                    : '<span class="badge badge-secondary">Inactivo</span>';

                let botonEstado = c.estado == 1
                    ? `<button class="btn btn-danger btn-sm btnEstado" data-id="${c.id}">Desactivar</button>`
                    : `<button class="btn btn-success btn-sm btnEstado" data-id="${c.id}">Activar</button>`;

                let botones = '';
                if (puedeEditar) {
                    botones = `
                        <button class="btn btn-warning btn-sm btnEditar"
                            data-id="${c.id}"
                            data-nombre="${escapar(c.nombre)}"
                            data-ci="${escapar(c.ci)}"
                            data-telefono="${escapar(c.telefono)}"
                            data-correo="${escapar(c.correo_electronico)}"
                            data-abonado="${c.es_abonado}">
                            Editar
                        </button>
                        ${botonEstado}`;
                }

                html += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${escapar(c.nombre)}</td>
                        <td>${escapar(c.ci) || '-'}</td>
                        <td>${escapar(c.telefono)}</td>
                        <td>${escapar(c.correo_electronico) || '-'}</td>
                        <td>${c.es_abonado == 1 ? 'Sí' : 'No'}</td>
                        <td>${c.fecha_vencimiento || '-'}</td>
                        <td>${estado}</td>
                        <td>${botones}</td>
                    </tr>`;
            });

            llenarTabla('#tablaClientes', html);
        }
    });
}

$(document).on('click', '#btnNuevo', function () {
    $('#formCliente')[0].reset();
    $('#id').val('');
    $('#tituloModal').text('Nuevo cliente');
    $('#modalCliente').modal('show');
});

$(document).on('click', '.btnEditar', function () {
    $('#id').val($(this).data('id'));
    $('#nombre').val($(this).data('nombre'));
    $('#ci').val($(this).data('ci'));
    $('#telefono').val($(this).data('telefono'));
    $('#correo_electronico').val($(this).data('correo'));
    $('#es_abonado').prop('checked', $(this).data('abonado') == 1);
    $('#tituloModal').text('Editar cliente');
    $('#modalCliente').modal('show');
});

$(document).on('submit', '#formCliente', function (e) {
    e.preventDefault();
    let id = $('#id').val();

    $.ajax({
        url: id ? '/clientes/' + id : '/clientes',
        type: id ? 'PUT' : 'POST',
        data: $(this).serialize(),
        success: function (res) {
            $('#modalCliente').modal('hide');
            mensajeAlert('¡Listo!', res.message, 'success');
            cargarClientes();
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
        url: '/clientes/' + id + '/estado',
        type: 'PUT',
        success: function (res) {
            mensajeAlert('¡Listo!', res.message, 'success');
            cargarClientes();
        },
        error: function (xhr) {
            mensajeAlert('Error', xhr.responseJSON.message, 'error');
        }
    });
});
