<!DOCTYPE html>
<html>
<head>
    <title>Detalles de orden</title>
    <link href="{{ asset('material') }}/css/pdf.css" rel="stylesheet" />
</head>
<body>
<h1>Orden {{ $order->id }}</h1>
<p>Customer Name: {{ $order->user->name }}</p>
<div>
    <table>
        <thead>
            <tr>
                <th>Datos:</th>
                @for($i = 1; $i <= sizeof($order->curtains); $i++)
                    <th>Sistema {{$i}}:</th>
                @endfor
            </tr>
        </thead>
        <tbody>
        <tr>
            <td>Cantidad</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->quantity}}</td>
            @endforeach
        </tr>
        <tr>
            <td>Modelo</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->model->name}}</td>
            @endforeach
        </tr>
        <tr>
            <td>Cubierta</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->cover->name}}</td>
            @endforeach
        </tr>
        <tr>
            <td>Mecanismo</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->mechanism->name}}</td>
            @endforeach
        </tr>
        <tr>
            <td>Ancho</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->width}} m</td>
            @endforeach
        </tr>
        <tr>
            <td>Caída</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->height}} m</td>
            @endforeach
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>

