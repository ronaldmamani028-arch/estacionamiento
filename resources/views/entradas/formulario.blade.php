<div class="modal fade" id="modalEntrada" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formEntrada">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar entrada</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Placa</label>
                        <input type="text" name="placa" id="placa" class="form-control" readonly>
                    </div>

                    <div id="datosVehiculo"></div>

                    <div id="seccionMensualidad" style="display: none;">
                        <div class="form-check mb-3">
                            <input type="checkbox" class="form-check-input" name="cobrar_mensualidad" id="cobrar_mensualidad" value="1">
                            <label class="form-check-label" for="cobrar_mensualidad">
                                <strong>Cobrar la mensualidad ahora (Bs <span id="precioMensualidad"></span>)</strong>
                            </label>
                        </div>
                        <div id="camposMensualidad" style="display: none;">
                            @include('pagos.campos')
                            <hr>
                        </div>
                    </div>

                    <div id="registroRapido">
                        <div class="alert alert-info">Vehículo nuevo: completa sus datos para registrarlo.</div>

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
                            <label>Marca</label>
                            <input type="text" name="marca" id="marca" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Modelo</label>
                            <input type="text" name="modelo" id="modelo" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Color</label>
                            <input type="text" name="color" id="color" class="form-control">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Espacio libre</label>
                        <select name="espacio_id" id="espacio_id" class="form-control"></select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Registrar entrada</button>
                </div>
            </form>
        </div>
    </div>
</div>
