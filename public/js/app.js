$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function mensajeAlert(titulo, texto, icono) {
    Swal.fire({
        title: titulo,
        html: texto,
        icon: icono
    });
}

function escapar(texto) {
    if (texto == null) {
        return '';
    }
    return String(texto)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

$.extend(true, $.fn.dataTable.defaults, {
    order: [],
    language: {
        lengthMenu: 'Mostrar _MENU_ registros',
        search: 'Buscar:',
        info: 'Mostrando _START_ a _END_ de _TOTAL_ registros',
        infoEmpty: 'Mostrando 0 a 0 de 0 registros',
        infoFiltered: '(filtrado de _MAX_ registros)',
        emptyTable: 'No hay registros',
        zeroRecords: 'No se encontraron resultados',
        paginate: {
            first: 'Primero',
            last: 'Último',
            next: 'Siguiente',
            previous: 'Anterior'
        }
    }
});

$.fn.dataTable.ext.type.detect.unshift(function (dato) {
    return /^(\d{2}\/)?\d{2}\/\d{4}/.test(dato) ? 'fecha' : null;
});

$.fn.dataTable.ext.type.order['fecha-pre'] = function (dato) {
    let partes = dato.split(' ');
    return partes[0].split('/').reverse().join('/') + ' ' + (partes[1] || '');
};

function llenarTabla(idTabla, html) {
    if ($.fn.DataTable.isDataTable(idTabla)) {
        $(idTabla).DataTable().destroy();
    }
    $(idTabla + ' tbody').html(html);
    $(idTabla).DataTable();
}

$(document).ajaxError(function (evento, xhr) {
    if (xhr.status == 419 || xhr.status == 401) {
        window.location.href = '/login';
    }
});
