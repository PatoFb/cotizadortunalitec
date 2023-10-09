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
        <tr>
            <td></td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->cover->id}}</td>
            @endforeach
        </tr>
        <tr>
            <td>Cubierta</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->cover->name}}</td>
            @endforeach
        </tr>
        <tr>
            <td></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td>Manivela</td>
            @foreach($order->curtains as $curtain)
                @if($curtain->handle_id != 9999)
                    <td>{{$curtain->handle->measure}} m ({{$curtain->handle_quantity}})</td>
                @endif
            @endforeach
        </tr>
        <tr>
            <td>Control</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->control->name}} ({{$curtain->control_quantity}})</td>
            @endforeach
        </tr>
        <tr>
            <td>Control voz</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->voice->name}} ({{$curtain->voice_quantity}})</td>
            @endforeach
        </tr>
        <tr>
            <td>Tejadillo</td>
            @foreach($order->curtains as $curtain)
                @if($curtain->canopy == 1)
                    <td>Si</td>
                @endif
            @endforeach
        </tr>
        <tr>
            <td></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td>Instalación</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->installation_type}}</td>
            @endforeach
        </tr>
        <tr>
            <td>Lado del mecanismo</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->mechanism_side}}</td>
            @endforeach
        </tr>
        <tr>
            <td>Precio</td>
            @foreach($order->curtains as $curtain)
                <td bgcolor="#808080">{{number_format($curtain->price,2)}}</td>
            @endforeach
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>

