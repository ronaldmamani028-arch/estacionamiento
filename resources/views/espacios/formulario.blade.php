<div class="modal fade" id="modalEspacio" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEspacio">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Nuevo espacio</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="id">

                    <div class="form-group">
                        <label>Piso</label>
                        <input type="number" name="piso" id="piso" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Sector <small class="text-muted">(ej. A, B)</small></label>
                        <input type="text" name="sector" id="sector" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Número</label>
                        <input type="number" name="numero" id="numero" class="form-control">
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
