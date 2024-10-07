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
            <h1 class="text-center">Pedido {{ $order->id }}</h1>
        @endif
        <h3>{{ $order->project }}</h3>
        <!-- Insert client data here -->
        Contacto: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $order->user->name }}<br>
        Socio: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $order->user->partner->description }}<br>
        Email: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $order->user->email }}<br>
        Teléfono: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $order->user->phone }}<br>
    </div>
    <div class="clear"></div>
    <br>
    <br>
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
            <td>${{number_format(($order->price - ($order->total_packages + $order->insurance))*(1+$order->discount/100),2)}}</td>
            <td>${{number_format($order->total_packages,2)}}</td>
            <td>${{number_format($order->insurance,2)}}</td>
            <td>${{number_format($order->price - ($order->total_packages + $order->insurance),2)}}</td>
            <td>${{number_format($order->price,2)}}</td>
        </tr>
        </tbody>
    </table>
    <br><br><br>
    <div class="pdf-section notes">
        <p class="red">Notas Adicionales</p>
        a) Vigencia válida por 10 dias hábiles o hasta agotar existencias<br>
        b) Precios sujetos a cambio sin previo aviso<br>
        c) Oferta de carácter informativo, no es válida como pedido de producción<br>
        d) Revisar "TÉRMINOS DE VENTA"<br>
        e) Confirmar disponibilidad de materiales con personal de ventas Solair antes de enviar pedido en firma para producción<br>
        @if($order->user->restricted == 0)
            f) Los precios mostrados en esta Oferta incluyen IVA<br>
        @endif

    </div>
    <div class="pdf-section company-logo">
        @if(sizeof($order->curtains) > 0)
        <img src="{{asset('storage')}}/images/{{$order->curtains[0]->model->photo}}" style="max-width: 300px" alt="Model">
        @elseif(sizeof($order->palillerias) > 0)
            <br> <br> <br>
            <img src="{{asset('storage')}}/images/{{$order->palillerias[0]->model->photo}}" style="max-width: 300px" alt="Model">
            <br> <br> <br>
            <br> <br> <br>
            @else
            <br> <br> <br>
            <img src="{{asset('storage')}}/images/{{$order->toldos[0]->model->photo}}" style="max-width: 300px" alt="Model">
            <br> <br> <br>
            <br> <br> <br>
            @endif
    </div>
    <div class="clear"></div>
    <br><br><br>
    <br><br><br>
    <br><br><br>
    @if(sizeof($order->curtains) > 0)
    @for($e = 1; $e <= ceil(sizeof($order->curtains)/6); $e++)
        @if($e % 2 == 1)
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
            <div class="clear"></div>
            <h3 class="text-center">Desglose de proyecto</h3>
            @endif
        <table class="pdf-table">
            <thead>
            <tr>
                <th class="border-right">Datos de sistema:</th>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-5); $i <= ($e*6); $i++)
                        <th class="border-bottom border-right-clear">Cortina {{$i}}:</th>
                    @endfor
                @else
                    @for($i = ($e*6-5); $i <= sizeof($order->curtains); $i++)
                        <th class="border-bottom border-right-clear">Cortina {{$i}}:</th>
                    @endfor
                @endif
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="border-right">Cantidad</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->quantity}}</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->quantity}}</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Modelo</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->model->name}}</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->model->name}}</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Mecanismo</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->mechanism->name}}</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->mechanism->name}}</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Ancho</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->width}} m</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->width}} m</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Caída</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->height}} m</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->height}} m</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right"></td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->cover->id}}</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->cover->id}}</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Cubierta</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->cover->name}}</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->cover->name}}</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right fixed-height-cell"></td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="border-right-clear"></td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="border-right-clear"></td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Manivela</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        @if($order->curtains[$i]->handle_id != 9999 && $order->curtains[$i]->handle_id != 999)
                            <td class="text-right border-right-clear">{{$order->curtains[$i]->handle->measure}} m ({{$order->curtains[$i]->handle_quantity}})</td>
                        @else
                            <td class="border-right-clear"></td>
                        @endif
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        @if($order->curtains[$i]->handle_id != 9999 && $order->curtains[$i]->handle_id != 999)
                            <td class="text-right border-right-clear">{{$order->curtains[$i]->handle->measure}} m ({{$order->curtains[$i]->handle_quantity}})</td>
                        @else
                            <td class="border-right-clear"></td>
                        @endif
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Control</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        @if($order->curtains[$i]->control_id != 9999 && $order->curtains[$i]->control_id != 999)
                            <td class="text-right border-right-clear">{{$order->curtains[$i]->control->name}} ({{$order->curtains[$i]->control_quantity}})</td>
                        @else
                            <td class="border-right-clear"></td>
                        @endif
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        @if($order->curtains[$i]->control_id != 9999 && $order->curtains[$i]->control_id != 999)
                            <td class="text-right border-right-clear">{{$order->curtains[$i]->control->name}} ({{$order->curtains[$i]->control_quantity}})</td>
                        @else
                            <td class="border-right-clear"></td>
                        @endif
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Control voz</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        @if($order->curtains[$i]->voice_id != 9999 && $order->curtains[$i]->voice_id != 999)
                            <td class="text-right border-right-clear">{{$order->curtains[$i]->voice->name}} ({{$order->curtains[$i]->voice_quantity}})</td>
                        @else
                            <td class="border-right-clear"></td>
                        @endif
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        @if($order->curtains[$i]->voice_id != 9999 && $order->curtains[$i]->voice_id != 999)
                            <td class="text-right border-right-clear">{{$order->curtains[$i]->voice->name}} ({{$order->curtains[$i]->voice_quantity}})</td>
                        @else
                            <td class="border-right-clear"></td>
                        @endif
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Tejadillo</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        @if($order->curtains[$i]->canopy == 1)
                            <td class="text-right border-right-clear">Si</td>
                        @else
                            <td class="border-right-clear"></td>
                        @endif
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        @if($order->curtains[$i]->canopy == 1)
                            <td class="text-right border-right-clear">Si</td>
                        @else
                            <td class="border-right-clear"></td>
                        @endif
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right fixed-height-cell"></td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="border-right-clear"></td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="border-right-clear"></td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Tipo de instalación</td>
                @if(sizeof($order->curtains) >= ($e*6)))
                @for($i = ($e*6-6); $i < ($e*6); $i++)
                    <td class="text-right border-right-clear">{{$order->curtains[$i]->installation_type}}</td>
                @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->installation_type}}</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Lado del mecanismo</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->mechanism_side}}</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td class="text-right border-right-clear">{{$order->curtains[$i]->mechanism_side}}</td>
                    @endfor
                @endif
            </tr>
            <tr>
                <td class="border-right">Precio</td>
                @if(sizeof($order->curtains) >= ($e*6))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td bgcolor="#d3d3d3" class="text-center border-right-clear">${{number_format($order->curtains[$i]->price,2)}}</td>
                    @endfor
                @else
                    @for($i = ($e*6-6); $i < sizeof($order->curtains); $i++)
                        <td bgcolor="#d3d3d3" class="text-center border-right-clear">${{number_format($order->curtains[$i]->price,2)}}</td>
                    @endfor
                @endif
            </tr>
            </tbody>
        </table>
            <br>
        @if($e % 2 == 1)
            <hr>
        @endif
    @endfor
        @endif
    @if(sizeof($order->palillerias) > 0)
        @for($e = 1; $e <= ceil(sizeof($order->palillerias)/6); $e++)
            @if(count($order->curtains) == 0)
            @if($e % 2 == 1)
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
                <div class="clear"></div>
                <h3 class="text-center">Desglose de proyecto</h3>
            @endif
            @endif
            <table class="pdf-table">
                <thead>
                <tr>
                    <th class="border-right">Datos de sistema:</th>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-5); $i <= ($e*6); $i++)
                            <th class="border-bottom border-right-clear">Palilleria {{$i}}:</th>
                        @endfor
                    @else
                        @for($i = ($e*6-5); $i <= sizeof($order->palillerias); $i++)
                            <th class="border-bottom border-right-clear">Palilleria {{$i}}:</th>
                        @endfor
                    @endif
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="border-right">Cantidad</td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="text-right border-right-clear">{{$order->palillerias[$i]->quantity}}</td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            <td class="text-right border-right-clear">{{$order->palillerias[$i]->quantity}}</td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Modelo</td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="text-right border-right-clear">{{$order->palillerias[$i]->model->name}}</td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            <td class="text-right border-right-clear">{{$order->palillerias[$i]->model->name}}</td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Mecanismo</td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="text-right border-right-clear">{{$order->palillerias[$i]->mechanism->name}}</td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            <td class="text-right border-right-clear">{{$order->palillerias[$i]->mechanism->name}}</td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Ancho</td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="text-right border-right-clear">{{$order->palillerias[$i]->width}} m</td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            <td class="text-right border-right-clear">{{$order->palillerias[$i]->width}} m</td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Salida</td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="text-right border-right-clear">{{$order->palillerias[$i]->height}} m</td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            <td class="text-right border-right-clear">{{$order->palillerias[$i]->height}} m</td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right"></td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="text-right border-right-clear">{{$order->palillerias[$i]->cover->id}}</td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            <td class="text-right border-right-clear">{{$order->palillerias[$i]->cover->id}}</td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Cubierta</td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="text-right border-right-clear">{{$order->palillerias[$i]->cover->name}}</td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            <td class="text-right border-right-clear">{{$order->palillerias[$i]->cover->name}}</td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right fixed-height-cell"></td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="border-right-clear"></td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            <td class="border-right-clear"></td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Guías extra</td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            @if($order->palillerias[$i]->guide != 9999 && $order->palillerias[$i]->guide != 0)
                                <td class="text-right border-right-clear">{{$order->palillerias[$i]->guide_quantity}}</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            @if($order->palillerias[$i]->guide != 9999 && $order->palillerias[$i]->guide != 0)
                                <td class="text-right border-right-clear">{{$order->palillerias[$i]->guide_quantity}}</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Porterías extra</td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            @if($order->palillerias[$i]->goal != 9999 && $order->palillerias[$i]->goal != 0)
                                <td class="text-right border-right-clear">{{$order->palillerias[$i]->goal_quantity}}</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            @if($order->palillerias[$i]->goal != 9999 && $order->palillerias[$i]->goal != 0)
                                <td class="text-right border-right-clear">{{$order->palillerias[$i]->goal_quantity}}</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Semiporterías extra</td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            @if($order->palillerias[$i]->semigoal != 9999 && $order->palillerias[$i]->semigoal != 0)
                                <td class="text-right border-right-clear">{{$order->palillerias[$i]->semigoal_quantity}}</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            @if($order->palillerias[$i]->semigoal != 9999 && $order->palillerias[$i]->semigoal != 0)
                                <td class="text-right border-right-clear">{{$order->palillerias[$i]->semigoal_quantity}}</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Traves extra</td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            @if($order->palillerias[$i]->trave != 9999 && $order->palillerias[$i]->trave != 0)
                                <td class="text-right border-right-clear">{{$order->palillerias[$i]->trave_quantity}}</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            @if($order->palillerias[$i]->trave != 9999 && $order->palillerias[$i]->trave != 0)
                                <td class="text-right border-right-clear">{{$order->palillerias[$i]->trave_quantity}}</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Control</td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            @if($order->palillerias[$i]->control_id != 9999 && $order->palillerias[$i]->control_id != 999)
                                <td class="text-right border-right-clear">{{$order->palillerias[$i]->control->name}} ({{$order->palillerias[$i]->control_quantity}})</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            @if($order->palillerias[$i]->control_id != 9999 && $order->palillerias[$i]->control_id != 999)
                                <td class="text-right border-right-clear">{{$order->palillerias[$i]->control->name}} ({{$order->palillerias[$i]->control_quantity}})</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Control voz</td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            @if($order->palillerias[$i]->voice_id != 9999 && $order->palillerias[$i]->voice_id != 999)
                                <td class="text-right border-right-clear">{{$order->palillerias[$i]->voice->name}} ({{$order->palillerias[$i]->voice_quantity}})</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            @if($order->palillerias[$i]->voice_id != 9999 && $order->palillerias[$i]->voice_id != 999)
                                <td class="text-right border-right-clear">{{$order->palillerias[$i]->voice->name}} ({{$order->palillerias[$i]->voice_quantity}})</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Sensores</td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            @if($order->palillerias[$i]->sensor_id != 9999 && $order->palillerias[$i]->sensor_id != 999)
                                <td class="text-right border-right-clear">{{$order->palillerias[$i]->sensor->name}} ({{$order->palillerias[$i]->sensor_quantity}})</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            @if($order->palillerias[$i]->sensor_id != 9999 && $order->palillerias[$i]->sensor_id != 999)
                                <td class="text-right border-right-clear">{{$order->palillerias[$i]->sensor->name}} ({{$order->palillerias[$i]->sensor_quantity}})</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right fixed-height-cell"></td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="border-right-clear"></td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            <td class="border-right-clear"></td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Inclinación</td>
                    @if(sizeof($order->palillerias) >= ($e*6)))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right border-right-clear">{{$order->palillerias[$i]->inclination}}</td>
                    @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            <td class="text-right border-right-clear">{{$order->palillerias[$i]->inclination}}</td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Altura de porterias</td>
                    @if(sizeof($order->palillerias) >= ($e*6)))
                    @for($i = ($e*6-6); $i < ($e*6); $i++)
                        <td class="text-right border-right-clear">{{$order->palillerias[$i]->goal_height}}</td>
                    @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            <td class="text-right border-right-clear">{{$order->palillerias[$i]->goal_height}}</td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Precio</td>
                    @if(sizeof($order->palillerias) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td bgcolor="#d3d3d3" class="text-center border-right-clear">${{number_format($order->palillerias[$i]->price,2)}}</td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->palillerias); $i++)
                            <td bgcolor="#d3d3d3" class="text-center border-right-clear">${{number_format($order->palillerias[$i]->price,2)}}</td>
                        @endfor
                    @endif
                </tr>
                </tbody>
            </table>
            <br>
            @if($e % 2 == 1)
                <hr>
            @endif
        @endfor
    @endif
    @if(sizeof($order->toldos) > 0)
        @for($e = 1; $e <= ceil(sizeof($order->toldos)/6); $e++)
            @if(count($order->curtains) == 0 && count($order->palillerias) == 0)
                @if($e % 2 == 1)
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
                    <div class="clear"></div>
                    <h3 class="text-center">Desglose de proyecto</h3>
                @endif
            @endif
            <table class="pdf-table">
                <thead>
                <tr>
                    <th class="border-right">Datos de sistema:</th>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-5); $i <= ($e*6); $i++)
                            <th class="border-bottom border-right-clear">Toldo {{$i}}:</th>
                        @endfor
                    @else
                        @for($i = ($e*6-5); $i <= sizeof($order->toldos); $i++)
                            <th class="border-bottom border-right-clear">Toldo {{$i}}:</th>
                        @endfor
                    @endif
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="border-right">Cantidad</td>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="text-right border-right-clear">{{$order->toldos[$i]->quantity}}</td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->toldos); $i++)
                            <td class="text-right border-right-clear">{{$order->toldos[$i]->quantity}}</td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Modelo</td>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="text-right border-right-clear">{{$order->toldos[$i]->model->name}}</td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->toldos); $i++)
                            <td class="text-right border-right-clear">{{$order->toldos[$i]->model->name}}</td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Mecanismo</td>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="text-right border-right-clear">{{$order->toldos[$i]->mechanism->name}}</td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->toldos); $i++)
                            <td class="text-right border-right-clear">{{$order->toldos[$i]->mechanism->name}}</td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Ancho</td>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="text-right border-right-clear">{{$order->toldos[$i]->width}} m</td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->toldos); $i++)
                            <td class="text-right border-right-clear">{{$order->toldos[$i]->width}} m</td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Salida</td>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="text-right border-right-clear">{{$order->toldos[$i]->projection}} m</td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->toldos); $i++)
                            <td class="text-right border-right-clear">{{$order->toldos[$i]->projection}} m</td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right"></td>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="text-right border-right-clear">{{$order->toldos[$i]->cover->id}}</td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->toldos); $i++)
                            <td class="text-right border-right-clear">{{$order->toldos[$i]->cover->id}}</td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Cubierta</td>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="text-right border-right-clear">{{$order->toldos[$i]->cover->name}}</td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->toldos); $i++)
                            <td class="text-right border-right-clear">{{$order->toldos[$i]->cover->name}}</td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right fixed-height-cell"></td>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="border-right-clear"></td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->toldos); $i++)
                            <td class="border-right-clear"></td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Manivelas</td>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            @if($order->toldos[$i]->handle_id != 9999 && $order->toldos[$i]->handle_id != 999)
                                <td class="text-right border-right-clear">{{$order->toldos[$i]->handle->name}} ({{$order->toldos[$i]->handle_quantity}})</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->toldos); $i++)
                            @if($order->toldos[$i]->handle_id != 9999 && $order->toldos[$i]->handle_id != 999)
                                <td class="text-right border-right-clear">{{$order->toldos[$i]->handle->name}} ({{$order->toldos[$i]->handle_quantity}})</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Control</td>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            @if($order->toldos[$i]->control_id != 9999 && $order->toldos[$i]->control_id != 999)
                                <td class="text-right border-right-clear">{{$order->toldos[$i]->control->name}} ({{$order->toldos[$i]->control_quantity}})</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->toldos); $i++)
                            @if($order->toldos[$i]->control_id != 9999 && $order->toldos[$i]->control_id != 999)
                                <td class="text-right border-right-clear">{{$order->toldos[$i]->control->name}} ({{$order->toldos[$i]->control_quantity}})</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Control voz</td>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            @if($order->toldos[$i]->voice_id != 9999 && $order->toldos[$i]->voice_id != 999)
                                <td class="text-right border-right-clear">{{$order->toldos[$i]->voice->name}} ({{$order->toldos[$i]->voice_quantity}})</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->toldos); $i++)
                            @if($order->toldos[$i]->voice_id != 9999 && $order->toldos[$i]->voice_id != 999)
                                <td class="text-right border-right-clear">{{$order->toldos[$i]->voice->name}} ({{$order->toldos[$i]->voice_quantity}})</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Sensores</td>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            @if($order->toldos[$i]->sensor_id != 9999 && $order->toldos[$i]->sensor_id != 999)
                                <td class="text-right border-right-clear">{{$order->toldos[$i]->sensor->name}} ({{$order->toldos[$i]->sensor_quantity}})</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->toldos); $i++)
                            @if($order->toldos[$i]->sensor_id != 9999 && $order->toldos[$i]->sensor_id != 999)
                                <td class="text-right border-right-clear">{{$order->toldos[$i]->sensor->name}} ({{$order->toldos[$i]->sensor_quantity}})</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Tejadillo</td>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            @if($order->toldos[$i]->canopy == 1)
                                <td class="text-right border-right-clear">Si</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->toldos); $i++)
                            @if($order->toldos[$i]->canopy == 1)
                                <td class="text-right border-right-clear">Si</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Bambalina</td>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            @if($order->toldos[$i]->bambalina == 1)
                                <td class="text-right border-right-clear">Si</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->toldos); $i++)
                            @if($order->toldos[$i]->bambalina == 1)
                                <td class="text-right border-right-clear">Si</td>
                            @else
                                <td class="border-right-clear"></td>
                            @endif
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right fixed-height-cell"></td>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td class="border-right-clear"></td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->toldos); $i++)
                            <td class="border-right-clear"></td>
                        @endfor
                    @endif
                </tr>
                <tr>
                    <td class="border-right">Precio</td>
                    @if(sizeof($order->toldos) >= ($e*6))
                        @for($i = ($e*6-6); $i < ($e*6); $i++)
                            <td bgcolor="#d3d3d3" class="text-center border-right-clear">${{number_format($order->toldos[$i]->price,2)}}</td>
                        @endfor
                    @else
                        @for($i = ($e*6-6); $i < sizeof($order->toldos); $i++)
                            <td bgcolor="#d3d3d3" class="text-center border-right-clear">${{number_format($order->toldos[$i]->price,2)}}</td>
                        @endfor
                    @endif
                </tr>
                </tbody>
            </table>
            <br>
            @if($e % 2 == 1)
                <hr>
            @endif
        @endfor
    @endif
</div>
</body>
</html>

