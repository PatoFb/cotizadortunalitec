@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Toldo')])

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
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\ToldosController@reviewPost', $order_id]]) !!}
                <h5 class="card-title">Configuración de sistema</h5>
                <p class="card-text">
                    <strong>Modelo:</strong> {{$toldo->model->name}}
                    <br>
                    <strong>Cantidad:</strong> {{$toldo->quantity}}
                    <br>
                    <strong>Cubierta:</strong> {{$toldo->cover->name}}
                    <br>
                    <strong>Mecanismo:</strong> {{$toldo->mechanism->name}}
                    <br>
                    <strong>Ancho:</strong> {{$toldo->width}} mts
                    <br>
                    <strong>Caída:</strong> {{$toldo->projection}} mts
                </p>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Accesorios</h5>
                <ul class="list-group">
                    @if($toldo->canopy == 1)
                        <li class="list-group-item"><strong>Tejadillo: </strong>Si</li>
                    @endif
                        @if($toldo->bambalina == 1)
                            <li class="list-group-item"><strong>Bambalina enrollable: </strong>Si</li>
                        @endif
                    @if($toldo->handle_id != 9999 && $toldo->handle_id != 999 && $toldo->handle_quantity > 0)
                        <li class="list-group-item"><strong>Manivela: </strong>{{$toldo->handle->measure}} mts ({{$toldo->handle_quantity}})</li>
                    @endif
                    @if($toldo->control_id != 9999 && $toldo->control_id != 999 && $toldo->control_quantity > 0)
                        <li class="list-group-item"><strong>Control: </strong>{{$toldo->control->name}} ({{$toldo->control_quantity}})</li>
                    @endif
                    @if($toldo->voice_id != 9999 && $toldo->voice_id != 999 && $toldo->voice_quantity > 0)
                        <li class="list-group-item"><strong>Control de voz: </strong>{{$toldo->voice->name}} ({{$toldo->voice_quantity}})</li>
                    @endif
                    @if($toldo->sensor_id != 9999 && $toldo->sensor_id != 999 && $toldo->sensor_quantity > 0)
                        <li class="list-group-item"><strong>Control de voz: </strong>{{$toldo->sensor->name}} ({{$toldo->sensor_quantity}})</li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <h5 class="card-title">Precio</h5>
                <p class="card-text">
                    <strong>Precio unitario:</strong> ${{number_format($toldo->systems_total/$toldo->quantity, 2)}}
                    <br>
                    <strong>Accesorios:</strong> ${{number_format($toldo->accessories_total, 2)}}
                    <br>
                    <strong>Total:</strong> ${{number_format($toldo->price, 2)}}
                </p>
            </div>
        </div>
        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('toldo.features', $order_id) }}" class="btn btn-danger">Anterior</a>
            {!! Form::submit('Guardar', ['class'=>'btn btn-primary', $order_id]) !!}
            {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
  </div>
</div>
    @endsection

