$(document).ready(function () {
    cargarUsuarios();
});

function cargarUsuarios() {
    $.ajax({
        url: '/usuarios/listar',
        type: 'GET',
        success: function (res) {
            let html = '';

            res.data.forEach(function (u, i) {
                let estado = u.estado == 1
                    ? '<span class="badge badge-success">Activo</span>'
                    : '<span class="badge badge-secondary">Inactivo</span>';

                let botonEstado = u.estado == 1
                    ? `<button class="btn btn-danger btn-sm btnEstado" data-id="${u.id}">Desactivar</button>`
                    : `<button class="btn btn-success btn-sm btnEstado" data-id="${u.id}">Activar</button>`;

                html += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${escapar(u.name)}</td>
                        <td>${escapar(u.email)}</td>
                        <td>${escapar(u.rol.nombre)}</td>
                        <td>${estado}</td>
                        <td>
                            <button class="btn btn-warning btn-sm btnEditar"
                                data-id="${u.id}"
                                data-name="${escapar(u.name)}"
                                data-email="${escapar(u.email)}"
                                data-rol="${u.rol_id}">
                                Editar
                            </button>
                            ${botonEstado}
                        </td>
                    </tr>`;
            });

            llenarTabla('#tablaUsuarios', html);
        }
    });
}

$(document).on('click', '#btnNuevo', function () {
    $('#formUsuario')[0].reset();
    $('#id').val('');
    $('#tituloModal').text('Nuevo usuario');
    $('#modalUsuario').modal('show');
});

$(document).on('click', '.btnEditar', function () {
    $('#formUsuario')[0].reset();
    $('#id').val($(this).data('id'));
    $('#name').val($(this).data('name'));
    $('#email').val($(this).data('email'));
    $('#rol_id').val($(this).data('rol'));
    $('#tituloModal').text('Editar usuario');
    $('#modalUsuario').modal('show');
});

$(document).on('submit', '#formUsuario', function (e) {
    e.preventDefault();
    let id = $('#id').val();

    $.ajax({
        url: id ? '/usuarios/' + id : '/usuarios',
        type: id ? 'PUT' : 'POST',
        data: $(this).serialize(),
        success: function (res) {
            $('#modalUsuario').modal('hide');
            mensajeAlert('¡Listo!', res.message, 'success');
            cargarUsuarios();
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
        url: '/usuarios/' + id + '/estado',
        type: 'PUT',
        success: function (res) {
            mensajeAlert('¡Listo!', res.message, 'success');
            cargarUsuarios();
        },
        error: function (xhr) {
            mensajeAlert('Error', xhr.responseJSON.message, 'error');
        }
    });
});
