<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ticket {{ $boleto->codigo }}</title>
    <style>
        @page { margin: 12px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 10px; }
        .centro { text-align: center; }
        .codigo { font-size: 20px; font-weight: bold; }
        table { width: 100%; }
        td { padding: 2px 0; vertical-align: top; }
        hr { border: 0; border-top: 1px dashed #000; }
    </style>
</head>
<body>
    <div class="centro">
        <strong style="font-size: 13px;">{{ config('app.name') }}</strong><br>
        TICKET DE ENTRADA
    </div>

    <hr>
    <div class="centro codigo">{{ $boleto->codigo }}</div>
    <hr>

    <table>
        <tr>
            <td>Placa:</td>
            <td><strong>{{ $boleto->vehiculo->placa }}</strong></td>
        </tr>
        <tr>
            <td>Tipo:</td>
            <td>{{ $boleto->vehiculo->tipoVehiculo->nombre }}</td>
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
            <td>Atendió:</td>
            <td>{{ $boleto->usuario->name }}</td>
        </tr>
    </table>

    @if ($boleto->es_abonado == 1)
        <hr>
        <div class="centro"><strong>CLIENTE ABONADO</strong><br>No paga al salir</div>
    @endif

    <hr>
    <div class="centro">Conserve este ticket: lo necesita para retirar su vehículo.</div>
</body>
</html>
