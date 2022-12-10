<!doctype html>
<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Factura: #{{ $sale->invoice_number }}</title>
    <style type="text/css">
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }

        .logo {
            width: 150px;
        }
    </style>
</head>

<body>
    <table width="100%">
        <tr>
            <td valign="top">
                <img src="img/logo.png" class="logo" />
            </td>
            <td align="right">
                <h3>Factura: #{{ $sale->invoice_number }}</h3>
                <pre>
                    Nombre: {{ $sale->name }}
                    Nit: {{ $sale->nit }}
                    Fecha: {{ date('j F, Y', strtotime($sale->sale_date)) }}
                </pre>
            </td>
        </tr>
    </table>
    <br />
    <br />
    <br />
    <table width="100%">
        <thead style="background-color: lightgray;">
            <tr>
                <th>#</th>
                <th>Descricion</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $total = 0 ?>
            @foreach($sale->details as $detail)
            <tr>
                <th scope="row">{{ $loop->index + 1 }}</th>
                <td>{{ $detail->product->name }}</td>
                <td align="right">{{ $detail->quantity }}</td>
                <td align="right">{{ $detail->price }}</td>
                <?php $subtotal = $detail->quantity * $detail->price ?>
                <td align="right">{{ $subtotal }}</td>
                <?php $total += $subtotal ?>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3"></td>
                <td align="right">Total</td>
                <td align="right" class="gray">{{ $total }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>