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
            Abono #: {{ $payment->id }}<br>
            Fecha: {{ $payment->invoice->created_at->format('d/m/Y') }}
        </div>
        <div class="col-md-6 pull-right">
            <strong>{{ $payment->invoice->student->full_name }}</strong><br />
            Cedula:  {{ $payment->invoice->student->id_card }} <br>
            Teléfono:  {{ $payment->invoice->student->phone }}
        </div>
    </div>
    <br>
    <table class="table table-condensed" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <th>Descripción</th>
            <th>Monto pagado</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{ $payment->description }}</td>
            <td>{{ number_format($payment->payment_amount, 2, '.', ',') }}</td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>