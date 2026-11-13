$(document).ready(function () {
    cargarMapa();
    setInterval(cargarMapa, 10000);
});

function cargarMapa() {
    $.ajax({
        url: '/espacios/listar',
        type: 'GET',
        success: function (res) {
            let grupos = {};
            res.data.forEach(function (e) {
                let nombre = 'Piso ' + e.piso + ' - Sector ' + e.sector;
                if (!grupos[nombre]) {
                    grupos[nombre] = [];
                }
                grupos[nombre].push(e);
            });

            let html = '';
            for (let nombre in grupos) {
                let celdas = '';

                grupos[nombre].forEach(function (e) {
                    let color = 'bg-success';
                    let texto = 'Libre';
                    if (e.estado == 0) {
                        color = 'bg-secondary';
                        texto = 'Inactivo';
                    } else if (e.esta_ocupado == 1) {
                        color = 'bg-danger';
                        texto = e.boleto_abierto ? escapar(e.boleto_abierto.vehiculo.placa) : 'Ocupado';
                    }

                    celdas += `
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="small-box ${color}">
                                <div class="inner">
                                    <h3>${e.numero}</h3>
                                    <p>${texto}</p>
                                </div>
                            </div>
                        </div>`;
                });

                html += `
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">${escapar(nombre)}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">${celdas}</div>
                        </div>
                    </div>`;
            }

            if (html == '') {
                html = '<div class="alert alert-info">No hay espacios registrados.</div>';
            }

            $('#mapaEspacios').html(html);
            $('#horaActualizacion').text(new Date().toLocaleTimeString());
        }
    });
}
