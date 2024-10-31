@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Toldo')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Características (Paso 5 de 6)</h4>
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\ToldosController@addFeaturesPost', $order_id]]) !!}


                <div class="form-row">
                    @if($toldo->handle_id == 9999)
                        {!! Form::number('handle_id', 9999, ['class'=>'form-control', "step"=>1, "id"=>"handle_id", 'hidden']) !!}
                        {!! Form::number('handle_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"handle_quantity", 'hidden']) !!}
                    @else
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('handle_id', 'Manivela (Medida en metros):' )  !!}
                            <select class="form-control" name="handle_id" id="handle_id" >
                                <option value="999" {{{ (isset($toldo->handle_id) && $toldo->handle_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                @foreach($handles as $handle)
                                    <option value="{{$handle->id}}" {{{ (isset($toldo->handle_id) && $toldo->handle_id == $handle->id) ? "selected=\"selected\"" : "" }}}>{{$handle->measure}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('handle_quantity', 'Cantidad:') !!}
                            {!! Form::number('handle_quantity', $toldo->handle_quantity ?? 0, ['class'=>'form-control', "step"=>1, "id"=>"handle_quantity"]) !!}
                        </div>
                    @endif
                </div>
                <div class="form-row">
                    @if($toldo->control_id == 9999)
                        {!! Form::number('control_id', 9999, ['class'=>'form-control', "step"=>1, "id"=>"control_id", 'hidden']) !!}
                        {!! Form::number('control_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"control_quantity", 'hidden']) !!}
                    @else
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('control_id', 'Control:' )  !!}
                            <select class="form-control" name="control_id" id="control_id">
                                <option value="999" {{{ (isset($toldo->control_id) && $toldo->control_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                @foreach($controls as $control)
                                    <option value="{{$control->id}}" {{{ (isset($toldo->control_id) && $toldo->control_id == $control->id) ? "selected=\"selected\"" : "" }}}>{{$control->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('control_quantity', 'Cantidad:') !!}
                            {!! Form::number('control_quantity', $toldo->control_quantity ?? 0, ['class'=>'form-control', "step"=>1, "id"=>"control_quantity"]) !!}
                        </div>
                    @endif
                </div>

                <div class="form-row">
                    @if($toldo->sensor_id == 9999)
                        {!! Form::number('sensor_id', 9999, ['class'=>'form-control', 'id'=>'sensor_id', 'hidden']) !!}
                        {!! Form::number('sensor_quantity', 0 , ['class'=>'form-control', 'id'=>'sensor_quantity', 'hidden']) !!}
                    @else
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('sensor_id', 'Sensores:' )  !!}
                            <select class="form-control" name="sensor_id" id="sensor_id" >
                                <option value="999" {{{ (isset($toldo->sensor_id) && $toldo->sensor_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                @foreach($sensors as $sensor)
                                    <option value="{{$sensor->id}}" {{{ (isset($toldo->sensor_id) && $toldo->sensor_id == $sensor->id) ? "selected=\"selected\"" : "" }}}>{{$sensor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('sensor_quantity', 'Cantidad:') !!}
                            {!! Form::number('sensor_quantity', $toldo->sensor_quantity ?? 0 , ['class'=>'form-control', 'id'=>'sensor_quantity']) !!}
                        </div>
                    @endif
                </div>
                <div class="form-row">
                    @if($toldo->voice_id == 9999)
                        {!! Form::number('voice_id', 9999, ['class'=>'form-control', 'id'=>'voice_id', 'hidden']) !!}
                        {!! Form::number('voice_quantity', 0, ['class'=>'form-control', 'id'=>'voice_quantity', 'hidden']) !!}
                    @else
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('voice_id', 'Voz:' )  !!}
                            <select class="form-control" name="voice_id" id="voice_id" >
                                <option value="999" {{{ (isset($toldo->voice_id) && $toldo->voice_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                @foreach($voices as $voice)
                                    <option value="{{$voice->id}}" {{{ (isset($toldo->voice_id) && $toldo->voice_id == $voice->id) ? "selected=\"selected\"" : "" }}}>{{$voice->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('voice_quantity', 'Cantidad:') !!}
                            {!! Form::number('voice_quantity', $toldo->voice_quantity ?? 0, ['class'=>'form-control', 'id'=>'voice_quantity']) !!}
                        </div>
                    @endif
                </div>
                <div class="form-row">
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('canopy', 'Tejadillo:' )  !!}
                        <select class="form-control" name="canopy" id="canopy" >
                            <option value="0" {{{ (isset($toldo->canopy) && $toldo->canopy == '0') ? "selected=\"selected\"" : "" }}}>No</option>
                            <option value="1" {{{ (isset($toldo->canopy) && $toldo->canopy == '1') ? "selected=\"selected\"" : "" }}}>Si</option>
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('bambalina', 'Bambalina enrollable:' )  !!}
                        <select class="form-control" name="bambalina" id="bambalina" >
                            <option value="0" {{{ (isset($toldo->bambalina) && $toldo->bambalina== '0') ? "selected=\"selected\"" : "" }}}>No</option>
                            <option value="1" {{{ (isset($toldo->bambalina) && $toldo->bambalina == '1') ? "selected=\"selected\"" : "" }}}>Si</option>
                        </select>
                    </div>
                </div>

                <br>
                @if($order->activity == 'Pedido')
                    <h6><strong>Datos para producción</strong></h6>
                    <div class="form-row">
                        <div class="col-12">
                            {!! Form::label('installation_type', 'Tipo de instalación:') !!}
                            <select class="form-control" name="installation_type">
                                <option value="">Selecciona tipo de instalacion</option>
                                <option {{{ (isset($toldo->installation_type) && $toldo->installation_type == 'A pared') ? "selected=\"selected\"" : "" }}}>A pared</option>
                                <option {{{ (isset($toldo->installation_type) && $toldo->installation_type == 'A techo') ? "selected=\"selected\"" : "" }}}>A techo</option>
                                <option {{{ (isset($toldo->installation_type) && $toldo->installation_type == 'Entre paredes') ? "selected=\"selected\"" : "" }}}>Entre paredes</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-12">
                            {!! Form::label('mechanism_side', 'Lado de mecanismo:') !!}
                            <select class="form-control" name="mechanism_side" >
                                <option value="">Lado del mecanismo</option>
                                <option {{{ (isset($toldo->mechanism_side) && $toldo->mechanism_side == 'Izquierdo') ? "selected=\"selected\"" : "" }}}>Izquierdo</option>
                                <option {{{ (isset($toldo->mechanism_side) && $toldo->mechanism_side == 'Derecho') ? "selected=\"selected\"" : "" }}}>Derecho</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-12">
                            {!! Form::label('bambalina_type', 'Tipo de bambalina:') !!}
                            <select class="form-control" name="bambalina_type" >
                                <option value="">Tipo de bambalina</option>
                                <option {{{ (isset($toldo->mechanism_side) && $toldo->mechanism_side == 'Recta') ? "selected=\"selected\"" : "" }}}>Recta</option>
                                <option {{{ (isset($toldo->mechanism_side) && $toldo->mechanism_side == 'Ondulada') ? "selected=\"selected\"" : "" }}}>Ondulada</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-12">
                            {!! Form::label('inclination', 'Tipo de instalación:') !!}
                            <select class="form-control" name="inclination">
                                <option value="">Selecciona inclinación</option>
                                <option {{ (isset($toldo->inclination) && $toldo->inclination == '5 y 5 grados') ? 'selected="selected"' : '' }}>5 y 5 grados</option>
                                <option {{ (isset($toldo->inclination) && $toldo->inclination == '10 y 10 grados') ? 'selected="selected"' : '' }}>10 y 10 grados</option>
                                <option {{ (isset($toldo->inclination) && $toldo->inclination == '15 y 15 grados') ? 'selected="selected"' : '' }}>15 y 15 grados</option>
                                <option value="20 y 20 grados" {{ (isset($toldo->inclination) && $toldo->inclination == '20 y 20 grados') ? 'selected="selected"' : '' }}>Estándar (20 y 20 grados)</option>
                                <option {{ (isset($toldo->inclination) && $toldo->inclination == '25 y 25 grados') ? 'selected="selected"' : '' }}>25 y 25 grados</option>
                                <option {{ (isset($toldo->inclination) && $toldo->inclination == '30 y 30 grados') ? 'selected="selected"' : '' }}>30 y 30 grados</option>
                                <option {{ (isset($toldo->inclination) && $toldo->inclination == '35 y 35 grados') ? 'selected="selected"' : '' }}>35 y 35 grados</option>
                                <option {{ (isset($toldo->inclination) && $toldo->inclination == '40 y 40 grados') ? 'selected="selected"' : '' }}>40 y 40 grados</option>
                                <option {{ (isset($toldo->inclination) && $toldo->inclination == '45 y 45 grados') ? 'selected="selected"' : '' }}>45 y 45 grados</option>
                                <option {{ (isset($toldo->inclination) && $toldo->inclination == '50 y 50 grados') ? 'selected="selected"' : '' }}>50 y 50 grados</option>
                                <option {{ (isset($toldo->inclination) && $toldo->inclination == '55 y 55 grados') ? 'selected="selected"' : '' }}>55 y 55 grados</option>
                                <option {{ (isset($toldo->inclination) && $toldo->inclination == '60 y 60 grados') ? 'selected="selected"' : '' }}>60 y 60 grados</option>
                                <option {{ (isset($toldo->inclination) && $toldo->inclination == '65 y 65 grados') ? 'selected="selected"' : '' }}>65 y 65 grados</option>
                                <option {{ (isset($toldo->inclination) && $toldo->inclination == '70 y 70 grados') ? 'selected="selected"' : '' }}>70 y 70 grados</option>
                                <option {{ (isset($toldo->inclination) && $toldo->inclination == '75 y 75 grados') ? 'selected="selected"' : '' }}>75 y 75 grados</option>
                            </select>
                        </div>
                    </div>
                    <br>
                @endif

                <div class="form-row text-center">
                    <div class="col-6 text-left">
                        <a href="{{ route('toldo.cover', $order_id) }}" class="btn btn-danger">Anterior</a>
                    </div>
                    <div class="col-6 text-right">
                        {!! Form::submit('Siguiente', ['class'=>'btn btn-primary', $order_id]) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

      </div>
    </div>
  </div>
</div>
</div>
    @endsection

