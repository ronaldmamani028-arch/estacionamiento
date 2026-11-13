<div class="modal fade" id="modalVehiculo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formVehiculo">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Nuevo vehículo</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="id">

                    <div class="form-group">
                        <label>Placa <small class="text-muted">(sin espacios ni guiones, ej. 1234ABC)</small></label>
                        <input type="text" name="placa" id="placa" class="form-control">
                    </div>

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
                        <label>Dueño <small class="text-muted">(opcional)</small></label>
                        <select name="cliente_id" id="cliente_id" class="form-control">
                            <option value="">-- Sin dueño (cliente ocasional) --</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">
                                    {{ $cliente->nombre }}
                                    {{ $cliente->ci ? '- CI ' . $cliente->ci : '' }}
                                    {{ $cliente->estado == 0 ? '(inactivo)' : '' }}
                                </option>
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

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
