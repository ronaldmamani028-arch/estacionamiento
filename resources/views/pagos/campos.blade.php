<input type="hidden" id="total_pagar">

<div class="form-group">
    <label>Método de pago</label>
    <select name="metodo_pago_id" id="metodo_pago_id" class="form-control">
        @foreach ($metodos as $metodo)
            <option value="{{ $metodo->id }}">{{ $metodo->nombre }}</option>
        @endforeach
    </select>
</div>

<div id="pagoEfectivo">
    <div class="form-group">
        <label>Monto recibido (Bs)</label>
        <input type="number" step="0.01" min="0" name="monto_recibido" id="monto_recibido" class="form-control">
    </div>
    <p class="mb-0">Cambio: <strong id="cambio">Bs 0.00</strong></p>
</div>

<div id="pagoQr" style="display: none;">
    <div class="text-center mb-2">
        <img src="{{ asset('img/qr-yape.png') }}" alt="QR Yape" style="max-width: 220px;">
    </div>
    <div class="form-group">
        <label>Número de operación</label>
        <input type="text" name="numero_operacion" id="numero_operacion" class="form-control" autocomplete="off">
    </div>
</div>
