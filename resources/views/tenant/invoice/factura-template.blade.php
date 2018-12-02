<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ config('app.name') }}</title>
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
    <div class="container">
        <h3 class="text-center">{{ strtoupper( $branchOffice->name ) }}</h3>
        <p class="text-center"> {{ strtolower(optional($branchOffice->settings)['address']) }} </p>
        <div class="row">
            <div class="col-md-6 pull-left">
                Tel. {{ optional($branchOffice->settings)['phone'] }} <br>
                Factura #: {{ $invoice->id }}<br>
                Fecha: {{ $invoice->created_at->format('d/m/Y') }}
            </div>
            <div class="col-md-6 pull-right">
                <strong>{{ $invoice->student->full_name }}</strong><br />
                Cedula:  {{ $invoice->student->id_card }} <br>
                Teléfono:  {{ $invoice->student->phone }}
            </div>
        </div>
        <br>
        <table class="table table-condensed" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <th>Descripción</th>
                <th>Precio</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice->coursePeriod as $item)
                <tr>
                    <td>{{ 'Curso '. $item->course->name }} - {{ $item->course->typeCourse->name  }}</td>
                    <td>{{ number_format($item->price, 2, '.', ',') }}</td>
                </tr>
            @endforeach

            @foreach($invoice->resources as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ number_format($item->price, 2, '.', ',') }}</td>
                </tr>
            @endforeach
            <tr>
                <td><h4><b>Total: </b></h4></td>
                <td><h4><b>{{ number_format($invoice->total, 2, '.', ',') }}</b></h4></td>
            </tr>
            </tbody>
        </table>

        <table class="table table-condensed" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>Monto pagado</th>
            </tr>
            </thead>
            <tbody>
                @foreach($invoice->payments as $payment)
                    <tr class="item {{ $loop->last ? 'last' : '' }}">
                        <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                        <td>{{ $payment->payment_amount }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td><h4><b>Total pagado: </b></h4></td>
                    <td><h4><b>{{ number_format($invoice->balance, 2, '.', ',') }}</b></h4></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>