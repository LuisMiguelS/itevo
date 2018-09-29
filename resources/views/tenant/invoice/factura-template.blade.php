<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name') }}</title>

    <style>
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
           /* border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, .15);*/
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2) {
            text-align: right;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td{
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }
    </style>
</head>

<body>
<div class="invoice-box">

    <table cellpadding="0" cellspacing="0">
        <tr class="top">
            <td colspan="2">
                <table>
                    <tr>
                        <td class="title">
                            {{--<img src="https://www.sparksuite.com/images/logo.png" style="width:100%; max-width:300px;">--}}
                            {{ strtoupper(config('app.name')) }}
                        </td>

                        <td>
                            Factura #: {{ $invoice->id }}<br>
                            Fecha: {{ $invoice->created_at->format('d/m/Y') }}<br>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                            {{ $branchOffice->name }}, Inc. <br>
                            {{ optional($branchOffice->settings)['phone'] }} <br>
                            Teléfono: {{ optional($branchOffice->settings)['address'] }}
                        </td>

                        <td>
                            A, <br>
                            <strong>{{ $invoice->student->full_name }}</strong><br />
                            {!! str_replace(',',', <br>', $invoice->student->address) !!} <br>
                            Cedula:  {{ $invoice->student->id_card }} <br>
                            Teléfono:  {{ $invoice->student->phone }}
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class="heading">
            <td>Descripción</td>
            <td>Precio</td>
        </tr>

        @foreach($invoice->coursePeriod as $item)
            <tr class="item">
                <td>{{ $item->course->name }} ({{ $item->course->typeCourse->name  }})</td>
                <td>{{ number_format($item->price, 2, '.', ',') }}</td>
            </tr>
        @endforeach

        @foreach($invoice->resources as $item)
            <tr class="item {{ $loop->last ? 'last' : '' }}">
                <td>{{ $item->name }}</td>
                <td>{{ number_format($item->price, 2, '.', ',') }}</td>
            </tr>
        @endforeach

        <tr class="total">
            <td></td>
            <td>Total: {{ number_format($invoice->total, 2, '.', ',') }}</td>
        </tr>

    </table>



    <table cellpadding="0" cellspacing="0">

        <tr class="top">
            <h1 style="text-align: center">Historial de pagos</h1>
        </tr>

        <tr class="heading">
            <td>Fecha</td>
            <td>Monto pagado</td>
        </tr>

        @foreach($invoice->payments as $payment)
            <tr class="item {{ $loop->last ? 'last' : '' }}">
                <td>{{ $payment->created_at->format('d/m/Y') }}</td>
                <td>{{ $payment->payment_amount }}</td>
            </tr>
        @endforeach

        <tr class="total">
            <td></td>
            <td>Total pagado: {{ number_format($invoice->balance, 2, '.', ',') }}</td>
        </tr>

    </table>
</div>
</body>
</html>