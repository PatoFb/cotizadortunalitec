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
                <th class="border-right">Datos:</th>
                @for($i = 1; $i <= sizeof($order->curtains); $i++)
                    <th class="border-bottom">Sistema {{$i}}:</th>
                @endfor
            </tr>
        </thead>
        <tbody>
        <tr>
            <td class="border-right">Cantidad</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->quantity}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Modelo</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->model->name}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Mecanismo</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->mechanism->name}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Ancho</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->width}} m</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Caída</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->height}} m</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right"></td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->cover->id}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Cubierta</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->cover->name}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right"></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right"></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right"></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right"></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Manivela</td>
            @foreach($order->curtains as $curtain)
                @if($curtain->handle_id != 9999)
                    <td>{{$curtain->handle->measure}} m ({{$curtain->handle_quantity}})</td>
                @endif
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Control</td>
            @foreach($order->curtains as $curtain)
                @if($curtain->control_id != 9999)
                    <td>{{$curtain->control->name}} ({{$curtain->control_quantity}})</td>
                @endif
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Control voz</td>
            @foreach($order->curtains as $curtain)
                @if($curtain->voice_id != 9999)
                    <td>{{$curtain->voice->name}} ({{$curtain->voice_quantity}})</td>
                @endif
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Tejadillo</td>
            @foreach($order->curtains as $curtain)
                @if($curtain->canopy == 1)
                    <td>Si</td>
                @endif
            @endforeach
        </tr>
        <tr>
            <td class="border-right"></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right"></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right"></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right"></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Instalación</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->installation_type}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Lado del mecanismo</td>
            @foreach($order->curtains as $curtain)
                <td>{{$curtain->mechanism_side}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Precio</td>
            @foreach($order->curtains as $curtain)
                <td bgcolor="#808080">{{number_format($curtain->price,2)}}</td>
            @endforeach
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>

