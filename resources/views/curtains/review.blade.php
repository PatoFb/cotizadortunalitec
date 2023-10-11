@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Cortina')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
      <div class="row">
          <div class="col-md-8 offset-md-2">
              <div class="card mt-3">
                  <div class="card-header card-header-primary">
                      <h4 class="card-title">Revisión de sistema (Paso 7 de 7)</h4>
                  </div>
                  <div class="card-body">
                      {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\CurtainsController@reviewPost', $order_id]]) !!}
                      <h5 class="card-title">Configuración de sistema</h5>
                      <p class="card-text">
                          <strong>Modelo:</strong> {{$curtain->model->name}}
                          <br>
                          <strong>Cubierta:</strong> {{$curtain->cover->name}}
                          <br>
                          <strong>Mecanismo:</strong> {{$curtain->mechanism->name}}
                          <br>
                          <strong>Ancho:</strong> {{$curtain->width}} mts
                          <br>
                          <strong>Caída:</strong> {{$curtain->height}} mts
                      </p>
                  </div>
              </div>

              <div class="card mt-3">
                  <div class="card-body">
                      <h5 class="card-title">Accesorios</h5>
                      <ul class="list-group">
                          @if($curtain->canopy == 1)
                              <li class="list-group-item"><strong>Tejadillo: </strong>Si</li>
                          @endif
                          @if($curtain->handle_id != 9999 && $curtain->handle_id != 999 && $curtain->handle_quantity > 0)
                              <li class="list-group-item"><strong>Manivela: </strong>{{$curtain->handle->measure}} mts ({{$curtain->handle_quantity}})</li>
                          @endif
                          @if($curtain->control_id != 9999 && $curtain->control_id != 999 && $curtain->control_quantity > 0)
                              <li class="list-group-item"><strong>Control: </strong>{{$curtain->control->name}} mts ({{$curtain->control_quantity}})</li>
                          @endif
                          @if($curtain->voice_id != 9999 && $curtain->voice_id != 999 && $curtain->voice_quantity > 0)
                              <li class="list-group-item"><strong>Control de voz: </strong>{{$curtain->voice->name}} mts ({{$curtain->voice_quantity}})</li>
                          @endif
                      </ul>
                  </div>
              </div>

              <div class="card mt-3">
                  <div class="card-body">
                      <h5 class="card-title">Precio</h5>
                      <p class="card-text">
                          <strong>Precio unitario:</strong> ${{number_format($curtain->price/$curtain->quantity, 2)}}
                          <br>
                          <strong>Cantidad:</strong> {{$curtain->quantity}}
                          <br>
                          <strong>Total:</strong> ${{number_format($curtain->price, 2)}}
                      </p>
                  </div>

              </div>
              <div class="mt-4 d-flex justify-content-between">
                  <a href="{{ route('curtain.features', $order_id) }}" class="btn btn-danger">Anterior</a>
                  {!! Form::submit('Guardar', ['class'=>'btn btn-primary', $order_id]) !!}
                  {!! Form::close() !!}
              </div>
          </div>
      </div>
    </div>
  </div>
    @endsection

