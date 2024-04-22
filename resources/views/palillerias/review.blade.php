@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Palillería')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
      <div class="row">
          <div class="col-md-8 offset-md-2">
              <div class="card mt-3">
                  <div class="card-header card-header-primary">
                      <h4 class="card-title">Revisión de sistema (Paso 6 de 6)</h4>
                  </div>
                  <div class="card-body">
                      {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\PalilleriasController@reviewPost', $order_id]]) !!}
                      <h5 class="card-title">Configuración de sistema</h5>
                      <p class="card-text">
                          <strong>Modelo:</strong> {{$palilleria->model->name}}
                          <br>
                          <strong>Cubierta:</strong> {{$palilleria->cover->name}}
                          <br>
                          <strong>Mecanismo:</strong> {{$palilleria->mechanism->name}}
                          <br>
                          <strong>Ancho:</strong> {{$palilleria->width}} mts
                          <br>
                          <strong>Caída:</strong> {{$palilleria->height}} mts
                      </p>
                  </div>
              </div>

              <div class="card mt-3">
                  <div class="card-body">
                      <h5 class="card-title">Accesorios</h5>
                      <ul class="list-group">
                          @if($palilleria->sensor_id != 9999 && $palilleria->sensor_id != 999 && $palilleria->sensor_quantity > 0)
                              <li class="list-group-item"><strong>Manivela: </strong>{{$palilleria->sensor->measure}} mts ({{$palilleria->sensor_quantity}})</li>
                          @endif
                          @if($palilleria->control_id != 9999 && $palilleria->control_id != 999 && $palilleria->control_quantity > 0)
                              <li class="list-group-item"><strong>Control: </strong>{{$palilleria->control->name}} ({{$palilleria->control_quantity}})</li>
                          @endif
                          @if($palilleria->voice_id != 9999 && $palilleria->voice_id != 999 && $palilleria->voice_quantity > 0)
                              <li class="list-group-item"><strong>Control de voz: </strong>{{$palilleria->voice->name}} ({{$palilleria->voice_quantity}})</li>
                          @endif
                      </ul>
                  </div>
              </div>

              <div class="card mt-3">
                  <div class="card-body">
                      <h5 class="card-title">Refuerzos</h5>
                      <ul class="list-group">
                          @if($palilleria->guide == 1)
                              <li class="list-group-item"><strong>Guías: </strong>{{$guide_quantity}}</li>
                          @endif
                          @if($palilleria->goal == 1)
                              <li class="list-group-item"><strong>Porterías: </strong>{{$goal_quantity}}</li>
                          @endif
                          @if($palilleria->semigoal == 1)
                              <li class="list-group-item"><strong>Semiporterías: </strong>{{$semigoal_quantity}}</li>
                          @endif
                          @if($palilleria->trave == 1)
                              <li class="list-group-item"><strong>Traves: </strong>{{$trave_quantity}}</li>
                          @endif
                      </ul>
                  </div>
              </div>

              @if($order->activity == 'Pedido')
                  <div class="card mt-3">
                      <div class="card-body">
                          <h5 class="card-title">Datos para producción</h5>
                          <p class="card-text">
                              <strong>Inclinación:</strong> {{$palilleria->inclination}}
                              <br>
                              <strong>Altura de porterías:</strong> {{$palilleria->goal_height}}
                          </p>
                      </div>
                  </div>
              @endif

              <div class="card mt-3">
                  <div class="card-body">
                      <h5 class="card-title">Precio</h5>
                      <p class="card-text">
                          <strong>Precio unitario:</strong> ${{number_format($palilleria->systems_total/$palilleria->quantity, 2)}}
                          <br>
                          <strong>Cantidad:</strong> {{$palilleria->quantity}}
                          <br>
                          <strong>Accesorios:</strong> ${{number_format($palilleria->accessories_total, 2)}}
                          <br>
                          <strong>Total:</strong> ${{number_format($palilleria->price, 2)}}
                      </p>
                  </div>
              </div>
              <div class="mt-4 d-flex justify-content-between">
                  <a href="{{ route('palilleria.features', $order_id) }}" class="btn btn-danger">Anterior</a>
                  {!! Form::submit('Guardar', ['class'=>'btn btn-primary', $order_id]) !!}
                  {!! Form::close() !!}
              </div>
          </div>
      </div>
  </div>
</div>
    @endsection

