@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Ordenes')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Revisión de producto</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\ToldosController@reviewPost', $order_id]]) !!}
                <tr class="table-responsive">
                    <table class="table">
                        <tr>
                            <td class="text-center">Modelo:</td>
                            <td><strong>{{$toldo->model->name}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Cubierta:</td>
                            <td><strong>{{$toldo->cover->name}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Mecanismo:</td>
                            <td><strong>{{$toldo->mechanism->name}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Ancho:</td>
                            <td><strong>{{$toldo->width}} mts</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Proyección:</td>
                            <td><strong>{{$toldo->projection}} mts</strong></td>
                        </tr>
                        @if($toldo->canopy_id == 1)
                            <tr>
                                <td class="text-center">
                                    Tejadillo:
                                </td>
                                <td>
                                    <strong>SI</strong>
                                </td>
                            </tr>
                        @endif
                        @if($toldo->bambalina == 1)
                            <tr>
                                <td class="text-center">
                                    Bambalina:
                                </td>
                                <td>
                                    <strong>SI</strong>
                                </td>
                            </tr>
                        @endif
                        @if($toldo->handle && $toldo->handle_quantity > 0)
                            <tr>
                                <td class="text-center">
                                    Manivela:
                                    <br>
                                    Cantidad:
                                </td>
                                <td>
                                    <strong>{{$toldo->handle->measure}} mts</strong>
                                    <br>
                                    <strong>{{$toldo->handle_quantity}}</strong>
                                </td>
                            </tr>
                        @endif
                        @if($toldo->control && $toldo->control_quantity > 0)
                            <tr>
                                <td class="text-center">
                                    Control:
                                    <br>
                                    Cantidad:
                                </td>
                                <td>
                                    <strong>{{$toldo->control->name}}</strong>
                                    <br>
                                    <strong>{{$toldo->control_quantity}}</strong>
                                </td>
                            </tr>
                        @endif
                        @if($toldo->voice_id && $toldo->voice_quantity > 0)
                            <tr>
                                <td class="text-center">
                                    Control de voz:
                                    <br>
                                    Cantidad:
                                </td>
                                <td>
                                    <strong>{{$toldo->voice->name}}</strong>
                                    <br>
                                    <strong>{{$toldo->voice_quantity}}</strong>
                                </td>
                            </tr>
                        @endif
                        @if($toldo->sensor_id && $toldo->sensor_quantity > 0)
                            <tr>
                                <td class="text-center">
                                    Sensor:
                                    <br>
                                    Cantidad:
                                </td>
                                <td>
                                    <strong>{{$toldo->sensor->name}}</strong>
                                    <br>
                                    <strong>{{$toldo->sensor_quantity}}</strong>
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <td class="text-center">Precio unitario:</td>
                            <td><strong>${{number_format($toldo->price/$toldo->quantity, 2)}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Cantidad:</td>
                            <td><strong>{{$toldo->quantity}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Total:</td>
                            <td><strong>${{number_format($toldo->price, 2)}}</strong></td>
                        </tr>
                    </table>
                <div class="form-row text-center">
                    <div class="col-6 text-left">
                        <a href="{{ route('toldo.features', $order_id) }}" class="btn btn-danger">Anterior</a>
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

