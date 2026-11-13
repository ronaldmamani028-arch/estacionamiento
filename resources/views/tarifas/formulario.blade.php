<div class="modal fade" id="modalTarifa" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formTarifa">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Nueva tarifa</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="id">

                    <div class="form-group">
                        <label>Tipo de vehículo</label>
                        <select name="tipo_vehiculo_id" id="tipo_vehiculo_id" class="form-control">
                            <option value="">-- Seleccione --</option>
                            @foreach ($tipos as $tipo)
                                <option value="{{ $tipo->id }}">{{ $tipo->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Precio por hora (Bs)</label>
                        <input type="number" name="precio_hora" id="precio_hora" class="form-control" step="0.01">
                    </div>

                    <div class="form-group">
                        <label>Minutos por fracción</label>
                        <input type="number" name="minutos_fraccion" id="minutos_fraccion" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Precio de mensualidad (Bs)</label>
                        <input type="number" name="precio_mensualidad" id="precio_mensualidad" class="form-control" step="0.01">
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
