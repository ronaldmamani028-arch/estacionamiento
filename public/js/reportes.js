$(document).ready(function () {
    cargarReportes();
});

$(document).on('submit', '#formFiltro', function (e) {
    e.preventDefault();
    cargarReportes();
});

$(document).on('change', '#agrupar', function () {
    cargarIngresos();
});

$(document).on('click', '.btnExportar', function () {
    let reporte = $(this).data('reporte');
    let formato = $(this).data('formato');
    let desde = $('#desde').val();
    let hasta = $('#hasta').val();

    if (reporte != 'ocupacion-actual' && (desde == '' || hasta == '' || hasta < desde)) {
        mensajeAlert('Revisa las fechas', 'Elige las dos fechas. "Hasta" no puede ser anterior a "desde".', 'warning');
        return;
    }

    let url = '/reportes/' + reporte + '?' + $.param({
        formato: formato,
        desde: desde,
        hasta: hasta,
        agrupar: $('#agrupar').val()
    });

    if (formato == 'pdf') {
        window.open(url);
    } else {
        window.location.href = url;
    }
});

function cargarReportes() {
    cargarIngresos();
    cargarFrecuentes();
    cargarOcupacion();
    cargarOcupacionActual();
}

function mostrarError(xhr) {
    if (xhr.status == 422) {
        let errores = Object.values(xhr.responseJSON.errors).join('<br>');
        mensajeAlert('Revisa las fechas', errores, 'warning');
    } else {
        mensajeAlert('Error', xhr.responseJSON.message, 'error');
    }
}

function cargarIngresos() {
    $.ajax({
        url: '/reportes/ingresos',
        type: 'GET',
        data: { desde: $('#desde').val(), hasta: $('#hasta').val(), agrupar: $('#agrupar').val() },
        success: function (res) {
            let html = '';
            res.data.forEach(function (f) {
                let periodo = f.periodo.split('-').reverse().join('/');

                html += `
                    <tr>
                        <td>${periodo}</td>
                        <td class="text-right">${f.boletos}</td>
                        <td class="text-right">${f.mensualidades}</td>
                        <td class="text-right">${f.total}</td>
                    </tr>`;
            });
            llenarTabla('#tablaIngresos', html);

            $('#ingresosBoletos').text(res.total_boletos);
            $('#ingresosMensualidades').text(res.total_mensualidades);
            $('#ingresosTotal').text(res.total_general);
        },
        error: mostrarError
    });
}

function cargarFrecuentes() {
    $.ajax({
        url: '/reportes/frecuentes',
        type: 'GET',
        data: { desde: $('#desde').val(), hasta: $('#hasta').val() },
        success: function (res) {
            let html = '';
            res.data.forEach(function (b, i) {
                let duenio = b.vehiculo.cliente ? escapar(b.vehiculo.cliente.nombre) : '-';

                html += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${escapar(b.vehiculo.placa)}</td>
                        <td>${escapar(b.vehiculo.tipo_vehiculo.nombre)}</td>
                        <td>${duenio}</td>
                        <td class="text-right">${b.entradas}</td>
                    </tr>`;
            });
            llenarTabla('#tablaFrecuentes', html);
        },
        error: mostrarError
    });
}

function cargarOcupacion() {
    $.ajax({
        url: '/reportes/ocupacion',
        type: 'GET',
        data: { desde: $('#desde').val(), hasta: $('#hasta').val() },
        success: function (res) {
            let html = '';
            res.data.forEach(function (d) {
                let fecha = d.fecha.split('-').reverse().join('/');

                html += `
                    <tr>
                        <td>${fecha}</td>
                        <td class="text-right">${d.entradas}</td>
                    </tr>`;
            });
            llenarTabla('#tablaOcupacion', html);
            $('#totalEntradas').text(res.total_entradas);
        },
        error: mostrarError
    });
}

function cargarOcupacionActual() {
    $.ajax({
        url: '/reportes/ocupacion-actual',
        type: 'GET',
        success: function (res) {
            let html = '';
            res.data.forEach(function (s) {
                html += `
                    <tr>
                        <td>Piso ${s.piso}</td>
                        <td>${escapar(s.sector)}</td>
                        <td class="text-right">${s.total}</td>
                        <td class="text-right">${s.ocupados}</td>
                        <td class="text-right">${s.libres}</td>
                        <td class="text-right">${s.porcentaje} %</td>
                    </tr>`;
            });
            llenarTabla('#tablaOcupacionActual', html);

            $('#actualTotal').text(res.total);
            $('#actualOcupados').text(res.ocupados);
            $('#actualLibres').text(res.libres);
            $('#actualPorcentaje').text(res.porcentaje + ' %');
        },
        error: mostrarError
    });
}
