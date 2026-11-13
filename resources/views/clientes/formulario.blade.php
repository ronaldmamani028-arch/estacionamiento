<div class="modal fade" id="modalCliente" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formCliente">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Nuevo cliente</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="id">

                    <div class="form-group">
                        <label>Nombre completo</label>
                        <input type="text" name="nombre" id="nombre" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>CI <small class="text-muted">(opcional)</small></label>
                        <input type="text" name="ci" id="ci" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Correo electrónico <small class="text-muted">(opcional)</small></label>
                        <input type="email" name="correo_electronico" id="correo_electronico" class="form-control">
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="es_abonado" id="es_abonado" value="1" class="form-check-input">
                        <label for="es_abonado" class="form-check-label">Es abonado (paga mensualidad)</label>
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
