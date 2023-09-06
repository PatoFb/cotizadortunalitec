@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Toldo')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Características (Paso 6 de 7)</h4>
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\ToldosController@addFeaturesPost', $order_id]]) !!}


                <div class="form-row">
                    <div class="col-md-9 col-sm-9">
                        @if($toldo->handle_id == 9999)
                            {!! Form::number('handle_id', 9999, ['class'=>'form-control', "step"=>1, "id"=>"handle_id", 'hidden']) !!}
                        @else
                            {!! Form::label('handle_id', 'Manivela (Medida en metros):' )  !!}
                            <select class="form-control" name="handle_id" id="handle_id" >
                                @foreach($handles as $handle)
                                    <option value="{{$handle->id}}" {{{ (isset($toldo->handle_id) && $toldo->handle_id == $handle->id) ? "selected=\"selected\"" : "" }}}>{{$handle->measure}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="col-md-3 col-sm-3">
                        @if($toldo->handle_id == 9999)
                            {!! Form::number('handle_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"handle_quantity", 'hidden']) !!}
                        @else
                            {!! Form::label('handle_quantity', 'Cantidad:') !!}
                            {!! Form::number('handle_quantity', $toldo->handle_quantity ?? 0, ['class'=>'form-control', "step"=>1, "id"=>"handle_quantity"]) !!}
                        @endif
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-9 col-sm-9">
                        @if($toldo->control_id == 9999)
                            {!! Form::number('control_id', 9999, ['class'=>'form-control', "step"=>1, "id"=>"control_id", 'hidden']) !!}
                        @else
                            {!! Form::label('control_id', 'Control:' )  !!}
                            <select class="form-control" name="control_id" id="control_id">
                                @foreach($controls as $control)
                                    <option value="{{$control->id}}" {{{ (isset($toldo->control_id) && $toldo->control_id == $control->id) ? "selected=\"selected\"" : "" }}}>{{$control->name}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="col-md-3 col-sm-3">
                        @if($toldo->control_id == 9999)
                            {!! Form::number('control_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"control_quantity", 'hidden']) !!}
                        @else
                            {!! Form::label('control_quantity', 'Cantidad:') !!}
                            {!! Form::number('control_quantity', $toldo->control_quantity ?? 0, ['class'=>'form-control', "step"=>1, "id"=>"control_quantity"]) !!}
                        @endif
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-9 col-sm-9">
                        @if($toldo->sensor_id == 9999)
                            {!! Form::number('sensor_id', 9999, ['class'=>'form-control', 'id'=>'sensor_id', 'hidden']) !!}
                        @else
                            {!! Form::label('sensor_id', 'Sensores:' )  !!}
                            <select class="form-control" name="sensor_id" id="sensor_id" >
                                @foreach($sensors as $sensor)
                                    <option value="{{$sensor->id}}" {{{ (isset($toldo->sensor_id) && $toldo->sensor_id == $sensor->id) ? "selected=\"selected\"" : "" }}}>{{$sensor->name}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <div class="col-md-3 col-sm-3">
                        @if($toldo->sensor_id == 9999)
                            {!! Form::number('sensor_quantity', 0 , ['class'=>'form-control', 'id'=>'sensor_quantity', 'hidden']) !!}
                        @else
                            {!! Form::label('sensor_quantity', 'Cantidad:') !!}
                            {!! Form::number('sensor_quantity', $toldo->sensor_quantity ?? 0 , ['class'=>'form-control', 'id'=>'sensor_quantity']) !!}
                        @endif
                    </div>

                </div>
                <div class="form-row">
                    <div class="col-md-9 col-sm-9">
                        @if($toldo->voice_id == 9999)
                            {!! Form::number('voice_id', 9999, ['class'=>'form-control', 'id'=>'voice_id', 'hidden']) !!}
                        @else
                            {!! Form::label('voice_id', 'Voz:' )  !!}
                            <select class="form-control" name="voice_id" id="voice_id" >
                                <option value="{{$voice->id}}" {{{ (isset($toldo->voice_id) && $toldo->voice_id == $voice->id) ? "selected=\"selected\"" : "" }}}>{{$voice->name}}</option>
                                @foreach($voices as $voice)
                                    <option value="{{$voice->id}}" {{{ (isset($toldo->voice_id) && $toldo->voice_id == $voice->id) ? "selected=\"selected\"" : "" }}}>{{$voice->name}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <div class="col-md-3 col-sm-3">
                        @if($toldo->voice_id == 9999)
                            {!! Form::number('voice_quantity', 0, ['class'=>'form-control', 'id'=>'voice_quantity', 'hidden']) !!}
                        @else
                            {!! Form::label('voice_quantity', 'Cantidad:') !!}
                            {!! Form::number('voice_quantity', $toldo->voice_quantity ?? 0, ['class'=>'form-control', 'id'=>'voice_quantity']) !!}
                        @endif
                    </div>

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

