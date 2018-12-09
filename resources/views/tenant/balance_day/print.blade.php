<!DOCTYPE html>
<html lang="en">
<head>
    <title>Print Table</title>
    <meta charset="UTF-8">
    <meta name=description content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <style>
        body {margin: 20px}
    </style>
</head>
<body>
<table class="table table-striped" id="balance_day">
    <thead>
    <tr>
        <th>Numero de factura</th>
        <th>Cuadre</th>
        <th>Sub total</th>
        <th>Fecha</th>
    </tr>
    </thead>
    <tbody>
    @forelse($balanceDay as $object)
        <tr>
            <td>No. {{ $object['factura'] }}</td>
            <td>{{ $object['cuadre'] }}</td>
            <td>RD$ {{ number_format($object['precio'], 2, '.', ',') }}</td>
            <td>{{ $object['fecha'] }}</td>
        </tr>
    @empty
        <tr><td colspan="4" style="text-align: center">No hay datos en esta tabla</td></tr>
    @endforelse
    @if(count($balanceDay))
        <tr>
            <td colspan="4" style="text-align: right">
                <h3>
                    <strong>Total: </strong>
                    RD$ {{ number_format(collect($balanceDay)->sum('precio'), 2, '.', ',') }}
                </h3>
            </td>
        </tr>
    @endif
    </tbody>
</table>
<script>window.print();</script>
</body>
</html>
