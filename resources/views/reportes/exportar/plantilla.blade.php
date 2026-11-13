<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        h2 { margin: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #999; padding: 4px; }
        th { background: #e9ecef; }
        .derecha { text-align: right; }
    </style>
</head>
<body>
    <h2>{{ config('app.name') }}</h2>
    <h3>@yield('titulo')</h3>
    <p>Generado el {{ date('d/m/Y H:i') }}</p>

    @yield('contenido')
</body>
</html>
