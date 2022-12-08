<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .rojo {
            color: #0000ff;
        }

        .otrafuente {
            font-family: sans-serif;
        }

        .tabla {
            width: 100%;
            border: 1px solid #bbb;
        }

        .titulo {
            text-align: left;
            background: gray;
            color: #fff;
        }

        .celda {
            border: 1px solid #bbb;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1 class="center" style="color:red">Venta</h1>
    <p class="center rojo">Numero factura {{ $sale->invoice_number }}</p>
    <p class="center otrafuente">Nit {{ $sale->nit }}</p>
    <p class="center">Nombre {{ $sale->name }}</p>
    <p class="center">Fecha {{ $sale->sale_date }}</p>

    <table class="tabla">
        <tr class="titulo">
            <th>Cantidad</th>
            <th>Precio</th>
        </tr>
        @foreach($sale->details as $detail)
        <tr>
            <td class="celda">{{ $detail->quantity }}</td>
            <td class="celda">{{ $detail->price }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>