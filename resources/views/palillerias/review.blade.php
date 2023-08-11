@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Palillería')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Revisión de sistema (Paso 7 de 7)</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\PalilleriasController@reviewPost', $order_id]]) !!}
                <tr class="table-responsive">
                    <table class="table">
                        <tr>
                            <td class="text-center">Modelo:</td>
                            <td><strong>{{$palilleria->model->name}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Cubierta:</td>
                            <td><strong>{{$palilleria->cover->name}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Mecanismo:</td>
                            <td><strong>{{$palilleria->mechanism->name}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Ancho:</td>
                            <td><strong>{{$palilleria->width}} mts</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Salida:</td>
                            <td><strong>{{$palilleria->height}} mts</strong></td>
                        </tr>
                        @if($palilleria->control_id != 9999 && $palilleria->control_quantity > 0)
                            <tr>
                                <td class="text-center">
                                    Control:
                                    <br>
                                    Cantidad:
                                </td>
                                <td>
                                    <strong>{{$palilleria->control->name}}</strong>
                                    <br>
                                    <strong>{{$palilleria->control_quantity}}</strong>
                                </td>
                            </tr>
                        @endif
                        @if($palilleria->sensor_id != 9999 && $palilleria->sensor_quantity > 0)
                            <tr>
                                <td class="text-center">
                                    Sensor:
                                    <br>
                                    Cantidad:
                                </td>
                                <td>
                                    <strong>{{$palilleria->sensor->name}}</strong>
                                    <br>
                                    <strong>{{$palilleria->sensor_quantity}}</strong>
                                </td>
                            </tr>
                        @endif
                        @if($palilleria->voice_id != 9999 && $palilleria->voice_quantity > 0)
                            <tr>
                                <td class="text-center">
                                    Control de voz:
                                    <br>
                                    Cantidad:
                                </td>
                                <td>
                                    <strong>{{$palilleria->voice->name}}</strong>
                                    <br>
                                    <strong>{{$palilleria->voice_quantity}}</strong>
                                </td>
                            </tr>
                        @endif
                        @if($palilleria->reinforcement_id && $palilleria->reinforcement_quantity > 0)
                            <tr>
                                <td class="text-center">
                                    Guia+:
                                    <br>
                                    Cantidad:
                                </td>
                                <td>
                                    <strong>SI</strong>
                                    <br>
                                    <strong>{{$palilleria->reinforcement_quantity}}</strong>
                                </td>
                            </tr>
                        @endif
                        @if($palilleria->trave && $palilleria->trave_quantity > 0)
                            <tr>
                                <td class="text-center">
                                    Trave+:
                                    <br>
                                    Cantidad:
                                </td>
                                <td>
                                    <strong>SI</strong>
                                    <br>
                                    <strong>{{$palilleria->trave_quantity}}</strong>
                                </td>
                            </tr>
                        @endif
                        @if($palilleria->semigoal_id && $palilleria->semigoal_quantity > 0)
                            <tr>
                                <td class="text-center">
                                    Semiportería+:
                                    <br>
                                    Cantidad:
                                </td>
                                <td>
                                    <strong>SI</strong>
                                    <br>
                                    <strong>{{$palilleria->semigoal_quantity}}</strong>
                                </td>
                            </tr>
                        @endif
                        @if($palilleria->goal_id && $palilleria->goal_quantity > 0)
                            <tr>
                                <td class="text-center">
                                    Portería+:
                                    <br>
                                    Cantidad:
                                </td>
                                <td>
                                    <strong>SI</strong>
                                    <br>
                                    <strong>{{$palilleria->goal_quantity}}</strong>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td class="text-center">Precio unitario:</td>
                            <td><strong>${{number_format($palilleria->price/$palilleria->quantity, 2)}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Cantidad:</td>
                            <td><strong>{{$palilleria->quantity}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Total:</td>
                            <td><strong>${{number_format($palilleria->price, 2)}}</strong></td>
                        </tr>
                    </table>
                <div class="form-row text-center">
                    <div class="col-6 text-left">
                        <a href="{{ route('palilleria.features', $order_id) }}" class="btn btn-danger">Anterior</a>
                    </div>
                    <div class="col-6 text-right">
                        {!! Form::submit('Guardar', ['class'=>'btn btn-primary', $order_id]) !!}
                        {!! Form::close() !!}
                    </div>
                </div>

          </div>

</div>
            </div>
      </div>
    </div>
  </div>
</div>
    @endsection

