<div class="modal fade" id="modalSalida" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formSalida">
                <div class="modal-header">
                    <h5 class="modal-title">Cobrar salida</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="boleto_id">

                    <input type="hidden" name="monto_mostrado" id="monto_mostrado">

                    <div id="detalleBoleto"></div>

                    <div id="seccionPago">
                        @include('pagos.campos')
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Cobrar y dar salida</button>
                </div>
            </form>
        </div>
    </div>
</div>
