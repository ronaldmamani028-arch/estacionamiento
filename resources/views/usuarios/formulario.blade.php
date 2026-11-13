<div class="modal fade" id="modalUsuario" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formUsuario">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Nuevo usuario</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="id">

                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email" name="email" id="email" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Rol</label>
                        <select name="rol_id" id="rol_id" class="form-control">
                            <option value="">-- Seleccione --</option>
                            @foreach ($roles as $rol)
                                <option value="{{ $rol->id }}">{{ $rol->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Contraseña <small class="text-muted">(al editar, déjala vacía para no cambiarla)</small></label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
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
