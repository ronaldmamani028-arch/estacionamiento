<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante {{ $boleto->codigo }}</title>
    <style>
        @page { margin: 12px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        .centro { text-align: center; }
        .total { font-size: 18px; font-weight: bold; }
        table { width: 100%; }
        td { padding: 2px 0; vertical-align: top; }
        td:first-child { width: 32%; }
        hr { border: 0; border-top: 1px dashed #000; }
    </style>
</head>
<body>
    <div class="centro">
        <strong style="font-size: 13px;">{{ config('app.name') }}</strong><br>
        COMPROBANTE DE SALIDA
    </div>

    <hr>

    <table>
        <tr>
            <td>Boleto:</td>
            <td><strong>{{ $boleto->codigo }}</strong></td>
        </tr>
        <tr>
            <td>Placa:</td>
            <td><strong>{{ $boleto->vehiculo->placa }}</strong> ({{ $boleto->vehiculo->tipoVehiculo->nombre }})</td>
        </tr>
        <tr>
            <td>Espacio:</td>
            <td>Piso {{ $boleto->espacio->piso }} - Sector {{ $boleto->espacio->sector }} - N° {{ $boleto->espacio->numero }}</td>
        </tr>
        <tr>
            <td>Entrada:</td>
            <td>{{ $boleto->hora_entrada->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>Salida:</td>
            <td>{{ $boleto->hora_salida->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <td>Tiempo:</td>
            <td>{{ intdiv($boleto->total_minutos, 60) }} h {{ $boleto->total_minutos % 60 }} min</td>
        </tr>
    </table>

    <hr>
    <div class="centro total">TOTAL: Bs {{ number_format($boleto->monto_total, 2) }}</div>
    <hr>

    @if ($boleto->es_abonado == 1)
        <div class="centro"><strong>CLIENTE ABONADO</strong><br>Cubierto por su mensualidad</div>
    @else
        <table>
            <tr>
                <td>Pago:</td>
                <td>{{ $boleto->metodoPago->nombre }}</td>
            </tr>
            @if ($boleto->numero_operacion)
                <tr>
                    <td>N° operación:</td>
                    <td>{{ $boleto->numero_operacion }}</td>
                </tr>
            @endif
        </table>
    @endif

    <hr>
    <div class="centro">Gracias por su visita.</div>
</body>
</html>
