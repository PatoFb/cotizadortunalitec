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
    Números de cuenta disponibles para realizar su pago:<br>
    A nombre de Tunali Tec S de RL de CV:
    <table class="banks-table">
        <thead>
        <tr>
            <th>Banco</th>
            <th>Cuenta</th>
            <th class="text-center">Clabe</th>
            <th class="text-center">Sucursal</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>BANAMEX</td>
            <td>6358156</td>
            <td class="text-center">002540700863581560</td>
            <td class="text-center">7008</td>
        </tr>
        <tr>
            <td>SANTANDER</td>
            <td>92-00205823-4</td>
            <td class="text-center">014540920020582341</td>
            <td class="text-center">5244</td>
        </tr>
        <tr>
            <td>BBVA</td>
            <td>453268802</td>
            <td class="text-center">012540004532688020</td>
            <td class="text-center">0817</td>
        </tr>
        </tbody>
    </table>
    <br><br><br><br>
    <h3 class="text-center">Resumen de proyecto</h3>
    <br>
    <table class="summary">
        <thead>
        <tr>
            <th>Referencia</th>
            <th>Precio público sugerido</th>
            <th>Paquetería</th>
            <th>Seguro</th>
            <th>Costo socio</th>
            <th>Total proyecto</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$order->id}}</td>
            <td>${{number_format($order->price*(1+$order->discount/100),2)}}{{$order->discount}}</td>
            <td>$1750.00</td>
            <td>$1600.00</td>
            <td>${{number_format($order->price,2)}}</td>
            <td>${{number_format($order->price + 3350,2)}}</td>
        </tr>
        </tbody>
    </table>
    <br><br><br>
    <div class="notes">
        <p class="red">Notas Adicionales</p>
        a) Los precios mostrados en esta Oferta incluyen IVA<br>
        b) Vigencia valida por 10 dias habilies o hasta agotar existencias<br>
        c) Precios sujetos a cambio sin previo aviso<br>
        d) Oferta de carácter informtivo, no es valida como pedido de producción<br>
        e) Revisar "TERMINOS DE VENTA"<br>
        f) Confirmar disponibilidad de materiales con personal de ventas Tunali Tec antes de enviar pedido en firma para producción<br>

    </div>
    <div class="company-logo">
        <img src="{{asset('storage')}}/images/{{$order->curtains[0]->model->photo}}" style="max-width: 250px" alt="Model">
    </div>
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
    <br>
    @for($e = 1; $e <= ceil(sizeof($order->curtains)/6); $e++)
        <table class="pdf-table">
            <thead>
            <tr>
                <th class="border-right">Datos de sistema:</th>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-5); $i <= ($e*6); $i++)
                        <th class="border-bottom">Sistema {{$i}}:</th>
                    @endfor
                @else
                    @for($i = ($e*6-5); $i <= sizeof($order->curtains); $i++)
                        <th class="border-bottom">Sistema {{$i}}:</th>
                    @endfor
                @endif
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="border-right">Cantidad</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right">{{$order->curtains[$i]->quantity}}</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right">{{$order->curtains[$i]->quantity}}</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Modelo</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right">{{$order->curtains[$i]->model->name}}</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right">{{$order->curtains[$i]->model->name}}</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Modelo</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right">{{$order->curtains[$i]->mechanism->name}}</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right">{{$order->curtains[$i]->mechanism->name}}</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Mecanismo</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right">{{$order->curtains[$i]->mechanism->name}}</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right">{{$order->curtains[$i]->mechanism->name}}</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Ancho</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right">{{$order->curtains[$i]->width}} m</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right">{{$order->curtains[$i]->mechanism->width}} m</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Caída</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right">{{$order->curtains[$i]->height}} m</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right">{{$order->curtains[$i]->mechanism->height}} m</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right"></td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right">{{$order->curtains[$i]->cover->id}}</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right">{{$order->curtains[$i]->cover->id}}</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Cubierta</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right">{{$order->curtains[$i]->cover->name}}</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right">{{$order->curtains[$i]->cover->name}}</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right fixed-height-cell"></td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td></td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td></td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Manivela</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        @if($order->curtains[$i]->handle_id != 9999 && $order->curtains[$i]->handle_id != 999)
                            <td class="text-right">{{$order->curtains[$i]->handle->measure}} m ({{$order->curtains[$i]->handle_quantity}})</td>
                        @else
                            <td></td>
                        @endif
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
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
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        @if($order->curtains[$i]->control_id != 9999 && $order->curtains[$i]->control_id != 999)
                            <td class="text-right">{{$order->curtains[$i]->control->name}} m ({{$order->curtains[$i]->control_quantity}})</td>
                        @else
                            <td></td>
                        @endif
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
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
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        @if($order->curtains[$i]->voice_id != 9999 && $order->curtains[$i]->voice_id != 999)
                            <td class="text-right">{{$order->curtains[$i]->voice->name}} m ({{$order->curtains[$i]->voice_quantity}})</td>
                        @else
                            <td></td>
                        @endif
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
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
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        @if($order->curtains[$i]->canopy == 1)
                            <td class="text-right">Si</td>
                        @else
                            <td></td>
                        @endif
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
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
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td></td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td></td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Tipo de instalación</td>
                @if(sizeof($order->curtains) >= ($e*6)))
                @for($i = ($e*6-6); $i < ($e*6); $i++)
                    <td class="text-right">{{$order->curtains[$i]->installation_type}}</td>
                @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right">{{$order->curtains[$i]->installation_type}}</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Lado del mecanismo</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right">{{$order->curtains[$i]->mechanism_side}}</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right">{{$order->curtains[$i]->mechanism_side}}</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Precio</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td bgcolor="#d3d3d3" class="text-center">${{number_format($order->curtains[$i]->price,2)}}</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td bgcolor="#d3d3d3" class="text-center">${{number_format($order->curtains[$i]->price,2)}}</td>
                    @endfor
                @endif
            </tr>
            </tbody>
        </table>
        <br>
        <hr>
    @endfor
</div>
</body>
</html>

