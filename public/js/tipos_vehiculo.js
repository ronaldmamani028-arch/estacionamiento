$(document).ready(function () {
    cargarTipos();
});

function cargarTipos() {
    $.ajax({
        url: '/tipos-vehiculo/listar',
        type: 'GET',
        success: function (res) {
            let html = '';

            res.data.forEach(function (t, i) {
                html += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${escapar(t.nombre)}</td>
                        <td>
                            <button class="btn btn-warning btn-sm btnEditar"
                                data-id="${t.id}"
                                data-nombre="${escapar(t.nombre)}">
                                Editar
                            </button>
                        </td>
                    </tr>`;
            });

            llenarTabla('#tablaTipos', html);
        }
    });
}

$(document).on('click', '#btnNuevo', function () {
    $('#formTipo')[0].reset();
    $('#id').val('');
    $('#tituloModal').text('Nuevo tipo de vehículo');
    $('#modalTipo').modal('show');
});

$(document).on('click', '.btnEditar', function () {
    $('#id').val($(this).data('id'));
    $('#nombre').val($(this).data('nombre'));
    $('#tituloModal').text('Editar tipo de vehículo');
    $('#modalTipo').modal('show');
});

$(document).on('submit', '#formTipo', function (e) {
    e.preventDefault();
    let id = $('#id').val();

    $.ajax({
        url: id ? '/tipos-vehiculo/' + id : '/tipos-vehiculo',
        type: id ? 'PUT' : 'POST',
        data: $(this).serialize(),
        success: function (res) {
            $('#modalTipo').modal('hide');
            mensajeAlert('¡Listo!', res.message, 'success');
            cargarTipos();
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
