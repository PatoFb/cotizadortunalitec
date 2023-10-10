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
            <h1 class="text-center">Oferta {{ $order->id }}</h1>
        @else
            <h1 class="text-center">Pedido{{ $order->id }}</h1>
        @endif
        <h3>{{ $order->project }}</h3>
        <!-- Insert client data here -->
        Contacto: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $order->user->name }}<br>
        Socio: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $order->user->partner->description }}<br>
        Email: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $order->user->email }}<br>
        Teléfono: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $order->user->phone }}<br>
    </div>
    <table class="pdf-table">
        <thead>
            <tr>
                <th class="border-right">Datos de sistema:</th>
                @if(sizeof($order->curtains) >= 6)
                    @for($i = 1; $i <= 6; $i++)
                        <th class="border-bottom">Sistema {{$i}}:</th>
                    @endfor
                @else
                    @for($i = 1; sizeof($order->curtains); $i++)
                        <th class="border-bottom">Sistema {{$i}}:</th>
                    @endfor
                @endif
            </tr>
        </thead>
        <tbody>
        <tr>
            <td class="border-right">Cantidad</td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    <td class="text-right">{{$order->curtains[$i]->quantity}}</td>
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    <td class="text-right">{{$curtain->quantity}}</td>
                @endforeach
            @endif
        </tr>
        <tr>
            <td class="border-right">Modelo</td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    <td class="text-right">{{$order->curtains[$i]->model->name}}</td>
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    <td class="text-right">{{$curtain->model->name}}</td>
                @endforeach
            @endif
        </tr>
        <tr>
            <td class="border-right">Modelo</td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    <td class="text-right">{{$order->curtains[$i]->mechanism->name}}</td>
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    <td class="text-right">{{$curtain->mechanism->name}}</td>
                @endforeach
            @endif
        </tr>
        <tr>
            <td class="border-right">Mecanismo</td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    <td class="text-right">{{$order->curtains[$i]->mechanism->name}}</td>
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    <td class="text-right">{{$curtain->mechanism->name}}</td>
                @endforeach
            @endif
        </tr>
        <tr>
            <td class="border-right">Ancho</td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    <td class="text-right">{{$order->curtains[$i]->width}} m</td>
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    <td class="text-right">{{$curtain->mechanism->width}} m</td>
                @endforeach
            @endif
        </tr>
        <tr>
            <td class="border-right">Caída</td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    <td class="text-right">{{$order->curtains[$i]->height}} m</td>
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    <td class="text-right">{{$curtain->mechanism->height}} m</td>
                @endforeach
            @endif
        </tr>
        <tr>
            <td class="border-right"></td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    <td class="text-right">{{$order->curtains[$i]->cover->id}}</td>
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    <td class="text-right">{{$curtain->mechanism->cover->id}}</td>
                @endforeach
            @endif
        </tr>
        <tr>
            <td class="border-right">Cubierta</td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    <td class="text-right">{{$order->curtains[$i]->cover->name}}</td>
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    <td class="text-right">{{$curtain->mechanism->cover->name}}</td>
                @endforeach
            @endif
        </tr>
        <tr>
            <td class="border-right fixed-height-cell"></td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    <td></td>
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    <td></td>
                @endforeach
            @endif
        </tr>
        <tr>
            <td class="border-right">Manivela</td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    @if($order->curtains[$i]->handle_id != 9999 && $order->curtains[$i]->handle_id != 999)
                        <td class="text-right">{{$order->curtains[$i]->handle->measure}} m ({{$order->curtains[$i]->handle_quantity}})</td>
                    @else
                        <td></td>
                    @endif
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    @if($curtain->handle_id != 9999 && $curtain->handle_id != 999)
                        <td class="text-right">{{$curtain->handle->measure}} m ({{$curtain->handle_quantity}})</td>
                    @else
                        <td></td>
                    @endif
                @endforeach
            @endif
        </tr>
        <tr>
            <td class="border-right">Control</td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    @if($order->curtains[$i]->control_id != 9999 && $order->curtains[$i]->control_id != 999)
                        <td class="text-right">{{$order->curtains[$i]->control->name}} m ({{$order->curtains[$i]->control_quantity}})</td>
                    @else
                        <td></td>
                    @endif
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    @if($curtain->control_id != 9999 && $curtain->control_id != 999)
                        <td class="text-right">{{$curtain->control->name}} m ({{$curtain->control_quantity}})</td>
                    @else
                        <td></td>
                    @endif
                @endforeach
            @endif
        </tr>
        <tr>
            <td class="border-right">Control voz</td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    @if($order->curtains[$i]->voice_id != 9999 && $order->curtains[$i]->voice_id != 999)
                        <td class="text-right">{{$order->curtains[$i]->voice->name}} m ({{$order->curtains[$i]->voice_quantity}})</td>
                    @else
                        <td></td>
                    @endif
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    @if($curtain->voice_id != 9999 && $curtain->voice_id != 999)
                        <td class="text-right">{{$curtain->voice->name}} ({{$curtain->voice_quantity}})</td>
                    @else
                        <td></td>
                    @endif
                @endforeach
            @endif
        </tr>
        <tr>
            <td class="border-right">Tejadillo</td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    @if($order->curtains[$i]->canopy == 1)
                        <td class="text-right">Si</td>
                    @else
                        <td></td>
                    @endif
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    @if($curtain->canopy == 1)
                        <td class="text-right">Si</td>
                    @else
                        <td></td>
                    @endif
                @endforeach
            @endif
        </tr>
        <tr>
            <td class="border-right fixed-height-cell"></td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    <td></td>
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    <td></td>
                @endforeach
            @endif
        </tr>
        <tr>
            <td class="border-right">Tipo de instalación</td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    <td class="text-right">{{$order->curtains[$i]->installation_type}}</td>
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    <td class="text-right">{{$curtain->installation_type}}</td>
                @endforeach
            @endif
        </tr>
        <tr>
            <td class="border-right">Lado del mecanismo</td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    <td class="text-right">{{$order->curtains[$i]->mechanism_side}}</td>
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    <td class="text-right">{{$curtain->mechanism_side}}</td>
                @endforeach
            @endif
        </tr>
        <tr>
            <td class="border-right">Precio</td>
            @if(sizeof($order->curtains) >= 6)
                @for($i = 0; $i < 6; $i++)
                    <td bgcolor="#d3d3d3" class="text-center">${{number_format($order->curtains[$i]->price,2)}}</td>
                @endfor
            @else
                @foreach($order->curtains as $curtain)
                    <td bgcolor="#d3d3d3" class="text-center">${{number_format($curtain->price,2)}}</td>
                @endforeach
            @endif
        </tr>
        </tbody>
    </table>
    <br>
    <hr>
    <table class="pdf-table">
        <thead>
        <tr>
            <th class="border-right">Datos de sistema:</th>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 7; $i <= 12; $i++)
                    <th class="border-bottom">Sistema {{$i}}:</th>
                @endfor
            @else
                @for($i = 7; $i <= sizeof($order->curtains); $i++)
                    <th class="border-bottom">Sistema {{$i}}:</th>
                @endfor
            @endif
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="border-right">Cantidad</td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    <td class="text-right">{{$order->curtains[$i]->quantity}}</td>
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    <td class="text-right">{{$order->curtains[$i]->quantity}}</td>
                @endfor
            @endif
        </tr>
        <tr>
            <td class="border-right">Modelo</td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    <td class="text-right">{{$order->curtains[$i]->model->name}}</td>
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    <td class="text-right">{{$order->curtains[$i]->model->name}}</td>
                @endfor
            @endif
        </tr>
        <tr>
            <td class="border-right">Modelo</td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    <td class="text-right">{{$order->curtains[$i]->mechanism->name}}</td>
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    <td class="text-right">{{$order->curtains[$i]->mechanism->name}}</td>
                @endfor
            @endif
        </tr>
        <tr>
            <td class="border-right">Mecanismo</td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    <td class="text-right">{{$order->curtains[$i]->mechanism->name}}</td>
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    <td class="text-right">{{$order->curtains[$i]->mechanism->name}}</td>
                @endfor
            @endif
        </tr>
        <tr>
            <td class="border-right">Ancho</td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    <td class="text-right">{{$order->curtains[$i]->width}} m</td>
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    <td class="text-right">{{$order->curtains[$i]->mechanism->width}} m</td>
                @endfor
            @endif
        </tr>
        <tr>
            <td class="border-right">Caída</td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    <td class="text-right">{{$order->curtains[$i]->height}} m</td>
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    <td class="text-right">{{$order->curtains[$i]->mechanism->height}} m</td>
                @endfor
            @endif
        </tr>
        <tr>
            <td class="border-right"></td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    <td class="text-right">{{$order->curtains[$i]->cover->id}}</td>
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    <td class="text-right">{{$order->curtains[$i]->cover->id}}</td>
                @endfor
            @endif
        </tr>
        <tr>
            <td class="border-right">Cubierta</td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    <td class="text-right">{{$order->curtains[$i]->cover->name}}</td>
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    <td class="text-right">{{$order->curtains[$i]->cover->name}}</td>
                @endfor
            @endif
        </tr>
        <tr>
            <td class="border-right fixed-height-cell"></td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    <td></td>
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    <td></td>
                @endfor
            @endif
        </tr>
        <tr>
            <td class="border-right">Manivela</td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    @if($order->curtains[$i]->handle_id != 9999 && $order->curtains[$i]->handle_id != 999)
                        <td class="text-right">{{$order->curtains[$i]->handle->measure}} m ({{$order->curtains[$i]->handle_quantity}})</td>
                    @else
                        <td></td>
                    @endif
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    @if($order->curtains[$i]->handle_id != 9999 && $order->curtains[$i]->handle_id != 999)
                        <td class="text-right">{{$order->curtains[$i]->handle->measure}} m ({{$order->curtains[$i]->handle_quantity}})</td>
                    @else
                        <td></td>
                    @endif
                @endfor
            @endif
        </tr>
        <tr>
            <td class="border-right">Control</td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    @if($order->curtains[$i]->control_id != 9999 && $order->curtains[$i]->control_id != 999)
                        <td class="text-right">{{$order->curtains[$i]->control->name}} m ({{$order->curtains[$i]->control_quantity}})</td>
                    @else
                        <td></td>
                    @endif
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    @if($order->curtains[$i]->control_id != 9999 && $order->curtains[$i]->control_id != 999)
                        <td class="text-right">{{$order->curtains[$i]->control->name}} m ({{$order->curtains[$i]->control_quantity}})</td>
                    @else
                        <td></td>
                    @endif
                @endfor
            @endif
        </tr>
        <tr>
            <td class="border-right">Control voz</td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    @if($order->curtains[$i]->voice_id != 9999 && $order->curtains[$i]->voice_id != 999)
                        <td class="text-right">{{$order->curtains[$i]->voice->name}} m ({{$order->curtains[$i]->voice_quantity}})</td>
                    @else
                        <td></td>
                    @endif
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    @if($order->curtains[$i]->voice_id != 9999 && $order->curtains[$i]->voice_id != 999)
                        <td class="text-right">{{$order->curtains[$i]->voice->name}} ({{$order->curtains[$i]->voice_quantity}})</td>
                    @else
                        <td></td>
                    @endif
                @endfor
            @endif
        </tr>
        <tr>
            <td class="border-right">Tejadillo</td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    @if($order->curtains[$i]->canopy == 1)
                        <td class="text-right">Si</td>
                    @else
                        <td></td>
                    @endif
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    @if($order->curtains[$i]->canopy == 1)
                        <td class="text-right">Si</td>
                    @else
                        <td></td>
                    @endif
                @endfor
            @endif
        </tr>
        <tr>
            <td class="border-right fixed-height-cell"></td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    <td></td>
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    <td></td>
                @endfor
            @endif
        </tr>
        <tr>
            <td class="border-right">Tipo de instalación</td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    <td class="text-right">{{$order->curtains[$i]->installation_type}}</td>
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    <td class="text-right">{{$order->curtains[$i]->installation_type}}</td>
                @endfor
            @endif
        </tr>
        <tr>
            <td class="border-right">Lado del mecanismo</td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    <td class="text-right">{{$order->curtains[$i]->mechanism_side}}</td>
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    <td class="text-right">{{$order->curtains[$i]->mechanism_side}}</td>
                @endfor
            @endif
        </tr>
        <tr>
            <td class="border-right">Precio</td>
            @if(sizeof($order->curtains) >= 12)
                @for($i = 6; $i < 12; $i++)
                    <td bgcolor="#d3d3d3" class="text-center">${{number_format($order->curtains[$i]->price,2)}}</td>
                @endfor
            @else
                @for($i = 6; $i < sizeof($order->curtains); $i++)
                    <td bgcolor="#d3d3d3" class="text-center">${{number_format($order->curtains[$i]->price,2)}}</td>
                @endfor
            @endif
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>

