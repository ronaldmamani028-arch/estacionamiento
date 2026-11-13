<div class="modal fade" id="modalMensualidad" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formMensualidad">
                <div class="modal-header">
                    <h5 class="modal-title">Cobrar mensualidad</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Cliente abonado</label>
                        <select name="cliente_id" id="cliente_id" class="form-control"></select>
                        <small class="text-muted">
                            Si la mensualidad está vigente, el mes nuevo empieza al día siguiente del vencimiento.
                            Si está vencida, empieza hoy.
                        </small>
                    </div>

                    <div class="form-group">
                        <label>Tarifa</label>
                        <select name="tarifa_id" id="tarifa_id" class="form-control">
                            <option value="" data-precio="0">-- Seleccione --</option>
                            @foreach ($tarifas as $tarifa)
                                <option value="{{ $tarifa->id }}" data-precio="{{ $tarifa->precio_mensualidad }}">
                                    {{ $tarifa->tipoVehiculo->nombre }} - Bs {{ $tarifa->precio_mensualidad }} al mes
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <hr>
                    @include('pagos.campos')
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Cobrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
