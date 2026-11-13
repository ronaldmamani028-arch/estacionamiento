$(document).ready(function () {
    cargarEspacios();
});

function cargarEspacios() {
    $.ajax({
        url: '/espacios/listar',
        type: 'GET',
        success: function (res) {
            let html = '';

            res.data.forEach(function (e, i) {
                let ocupacion = e.esta_ocupado == 1
                    ? '<span class="badge badge-danger">Ocupado</span>'
                    : '<span class="badge badge-success">Libre</span>';

                let estado = e.estado == 1
                    ? '<span class="badge badge-success">Activo</span>'
                    : '<span class="badge badge-secondary">Inactivo</span>';

                let botonEstado = e.estado == 1
                    ? `<button class="btn btn-danger btn-sm btnEstado" data-id="${e.id}">Desactivar</button>`
                    : `<button class="btn btn-success btn-sm btnEstado" data-id="${e.id}">Activar</button>`;

                html += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${e.piso}</td>
                        <td>${escapar(e.sector)}</td>
                        <td>${e.numero}</td>
                        <td>${ocupacion}</td>
                        <td>${estado}</td>
                        <td>
                            <button class="btn btn-warning btn-sm btnEditar"
                                data-id="${e.id}"
                                data-piso="${e.piso}"
                                data-sector="${escapar(e.sector)}"
                                data-numero="${e.numero}">
                                Editar
                            </button>
                            ${botonEstado}
                        </td>
                    </tr>`;
            });

            llenarTabla('#tablaEspacios', html);
        }
    });
}

$(document).on('click', '#btnNuevo', function () {
    $('#formEspacio')[0].reset();
    $('#id').val('');
    $('#tituloModal').text('Nuevo espacio');
    $('#modalEspacio').modal('show');
});

$(document).on('click', '.btnEditar', function () {
    $('#id').val($(this).data('id'));
    $('#piso').val($(this).data('piso'));
    $('#sector').val($(this).data('sector'));
    $('#numero').val($(this).data('numero'));
    $('#tituloModal').text('Editar espacio');
    $('#modalEspacio').modal('show');
});

$(document).on('submit', '#formEspacio', function (e) {
    e.preventDefault();
    let id = $('#id').val();

    $.ajax({
        url: id ? '/espacios/' + id : '/espacios',
        type: id ? 'PUT' : 'POST',
        data: $(this).serialize(),
        success: function (res) {
            $('#modalEspacio').modal('hide');
            mensajeAlert('¡Listo!', res.message, 'success');
            cargarEspacios();
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
        url: '/espacios/' + id + '/estado',
        type: 'PUT',
        success: function (res) {
            mensajeAlert('¡Listo!', res.message, 'success');
            cargarEspacios();
        },
        error: function (xhr) {
            mensajeAlert('Error', xhr.responseJSON.message, 'error');
        }
    });
});
