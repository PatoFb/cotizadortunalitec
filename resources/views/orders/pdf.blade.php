<!DOCTYPE html>
<html>
<head>
    <title>Detalles de orden</title>
    <link href="{{ asset('material') }}/css/pdf.css" rel="stylesheet" />
</head>
<body>
<div class="pdf-layout">
    <div class="pdf-section company-logo">
        <!-- Insert company logo here -->
        <img src="{{ asset('material') }}/img/logosolair.png" alt="Company Logo" width="200">
    </div>
    <div class="pdf-section client-data">
        @if($order->activity == 'Oferta')
            <h3>Oferta {{ $order->id }}</h3>
        @else
            <h3>Pedido {{ $order->id }}</h3>
        @endif
        <h3>{{ $order->project }}</h3>
        <!-- Insert client data here -->
        Contacto: &emsp;{{ $order->user->name }}<br>
        Socio: &emsp;&emsp;{{ $order->user->partner->description }}<br>
        Email: &emsp;&emsp;{{ $order->user->email }}<br>
        Teléfono: &emsp;{{ $order->user->phone }}<br>
        <div class="triangle"></div>
    </div>
    <table class="pdf-table">
        <thead>
            <tr>
                <th class="border-right">Datos de sistema:</th>
                @for($i = 1; $i <= sizeof($order->curtains); $i++)
                    <th class="border-bottom">Sistema {{$i}}:</th>
                @endfor
            </tr>
        </thead>
        <tbody>
        <tr>
            <td class="border-right">Cantidad</td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->quantity}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Modelo</td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->model->name}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Mecanismo</td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->mechanism->name}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Ancho</td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->width}} m</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Caída</td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->height}} m</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right"></td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->cover->id}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Cubierta</td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->cover->name}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right fixed-height-cell"></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Manivela</td>
            @foreach($order->curtains as $curtain)
                @if($curtain->handle_id != 9999 && $curtain->handle_id != 999)
                    <td class="text-right">{{$curtain->handle->measure}} m ({{$curtain->handle_quantity}})</td>
                @else
                    <td></td>
                @endif
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Control</td>
            @foreach($order->curtains as $curtain)
                @if($curtain->control_id != 9999 && $curtain->control_id != 999)
                    <td class="text-right">{{$curtain->control->name}} ({{$curtain->control_quantity}})</td>
                @else
                    <td></td>
                @endif
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Control voz</td>
            @foreach($order->curtains as $curtain)
                @if($curtain->voice_id != 9999 && $curtain->voice_id != 999)
                    <td class="text-right">{{$curtain->voice->name}} ({{$curtain->voice_quantity}})</td>
                @else
                    <td></td>
                @endif
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Tejadillo</td>
            @foreach($order->curtains as $curtain)
                @if($curtain->canopy == 1)
                    <td class="text-right">Si</td>
                @else
                    <td></td>
                @endif
            @endforeach
        </tr>
        <tr>
            <td class="border-right fixed-height-cell"></td>
            @foreach($order->curtains as $curtain)
                <td></td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Instalación</td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->installation_type}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Lado del mecanismo</td>
            @foreach($order->curtains as $curtain)
                <td class="text-right">{{$curtain->mechanism_side}}</td>
            @endforeach
        </tr>
        <tr>
            <td class="border-right">Precio</td>
            @foreach($order->curtains as $curtain)
                <td bgcolor="#d3d3d3" class="text-center">${{number_format($curtain->price,2)}}</td>
            @endforeach
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>

