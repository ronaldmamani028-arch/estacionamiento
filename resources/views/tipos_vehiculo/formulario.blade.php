<div class="modal fade" id="modalTipo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formTipo">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Nuevo tipo de vehículo</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="id">

                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej. Auto, Moto, Camioneta">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
