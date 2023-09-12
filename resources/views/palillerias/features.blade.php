@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Palillería')])

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
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\PalilleriasController@addFeaturesPost', $order_id]]) !!}

                <div class="form-row">
                        @if($palilleria->control_id == 9999)
                            {!! Form::number('control_id', 9999, ['class'=>'form-control', "step"=>1, "id"=>"control_id", 'hidden']) !!}
                            {!! Form::number('control_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"control_quantity", 'hidden']) !!}
                        @else
                            <div class="col-md-9 col-sm-9">
                                {!! Form::label('control_id', 'Control:' )  !!}
                                <select class="form-control" name="control_id" id="control_id">
                                    <option value="999" {{{ (isset($palilleria->control_id) && $palilleria->control_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                    @foreach($controls as $control)
                                        <option value="{{$control->id}}" {{{ (isset($palilleria->control_id) && $palilleria->control_id == $control->id) ? "selected=\"selected\"" : "" }}}>{{$control->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 col-sm-3">
                                {!! Form::label('control_quantity', 'Cantidad:') !!}
                                {!! Form::number('control_quantity', $palilleria->control_quantity ?? 0, ['class'=>'form-control', "step"=>1, "id"=>"control_quantity"]) !!}
                            </div>
                        @endif
                    </div>

                <div class="form-row">
                    @if($palilleria->sensor_id == 9999)
                        {!! Form::number('sensor_id', 9999, ['class'=>'form-control', "step"=>1, "id"=>"sensor_id", 'hidden']) !!}
                        {!! Form::number('sensor_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"sensor_quantity", 'hidden']) !!}
                    @else
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('sensor_id', 'Sensor:' )  !!}
                            <select class="form-control" name="sensor_id" id="sensor_id">
                                <option value="999" {{{ (isset($palilleria->sensor_id) && $palilleria->sensor_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                @foreach($sensors as $sensor)
                                    <option value="{{$sensor->id}}" {{{ (isset($palilleria->sensor_id) && $palilleria->sensor_id == $sensor->id) ? "selected=\"selected\"" : "" }}}>{{$sensor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('sensor_quantity', 'Cantidad:') !!}
                            {!! Form::number('sensor_quantity', $palilleria->sensor_quantity ?? 0, ['class'=>'form-control', "step"=>1, "id"=>"sensor_quantity"]) !!}
                        </div>
                    @endif
                </div>
                <div class="form-row">
                    @if($palilleria->voice_id == 9999)
                        {!! Form::number('voice_id', 9999, ['class'=>'form-control', "step"=>1, "id"=>"voice_id", 'hidden']) !!}
                        {!! Form::number('voice_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"voice_quantity", 'hidden']) !!}
                    @else
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('voice_id', 'Voz:' )  !!}
                            <select class="form-control" name="voice_id" id="voice_id" >
                                <option value="999" {{{ (isset($palilleria->voice_id) && $palilleria->voice_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                @foreach($voices as $voice)
                                    <option value="{{$voice->id}}" {{{ (isset($palilleria->voice_id) && $palilleria->voice_id == $voice->id) ? "selected=\"selected\"" : "" }}}>{{$voice->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('voice_quantity', 'Cantidad:') !!}
                            {!! Form::number('voice_quantity', $palilleria->voice_quantity ?? 0, ['class'=>'form-control', 'id'=>'voice_quantity']) !!}
                        </div>
                    @endif
                </div>
                <br>
                <h6>Refuerzos</h6>
                <div class="form-row">
                    <div class="col-md-9 col-sm-9">
                        {!! Form::label('guide', 'Guía+:' )  !!}
                        <select class="form-control" name="guide" id="guide" >
                            <option value="0" {{{ (isset($palilleria->guide) && $palilleria->guide == '0') ? "selected=\"selected\"" : "" }}}>NO</option>
                            <option value="1" {{{ (isset($palilleria->guide) && $palilleria->guide == '1') ? "selected=\"selected\"" : "" }}}>SI</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        {!! Form::label('guide_quantity', 'Cantidad:') !!}
                        {!! Form::number('guide_quantity', $palilleria->guide_quantity ?? 0, ['class'=>'form-control', "step"=>1, "id"=>"reinforcement_quantity"]) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-9 col-sm-9">
                        {!! Form::label('trave', 'Trave+:' )  !!}
                        <select class="form-control" name="trave" id="trave" >
                            <option value="0" {{{ (isset($palilleria->trave) && $palilleria->trave == '0') ? "selected=\"selected\"" : "" }}}>NO</option>
                            <option value="1" {{{ (isset($palilleria->trave) && $palilleria->trave == '1') ? "selected=\"selected\"" : "" }}}>SI</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        {!! Form::label('trave_quantity', 'Cantidad:') !!}
                        {!! Form::number('trave_quantity', $palilleria->trave_quantity ?? 0, ['class'=>'form-control', "step"=>1, "id"=>"trave_quantity"]) !!}
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-9 col-sm-9">
                        {!! Form::label('semigoal', 'Semiportería+:' )  !!}
                        <select class="form-control" name="semigoal" id="semigoal" >
                            <option value="0" {{{ (isset($palilleria->semigoal) && $palilleria->semigoal == '0') ? "selected=\"selected\"" : "" }}}>NO</option>
                            <option value="1" {{{ (isset($palilleria->semigoal) && $palilleria->semigoal == '1') ? "selected=\"selected\"" : "" }}}>SI</option>
                        </select>
                    </div>

                    <div class="col-md-3 col-sm-3">
                        {!! Form::label('semigoal_quantity', 'Cantidad:') !!}
                        {!! Form::number('semigoal_quantity', $palilleria->semigoal_quantity ?? 0 , ['class'=>'form-control', 'id'=>'semigoal_quantity']) !!}
                    </div>

                </div>
                <div class="form-row">
                    <div class="col-md-9 col-sm-9">
                        {!! Form::label('goal', 'Portería+:' )  !!}
                        <select class="form-control" name="goal" id="goal" >
                            <option value="0" {{{ (isset($palilleria->goal) && $palilleria->goal == '0') ? "selected=\"selected\"" : "" }}}>NO</option>
                            <option value="1" {{{ (isset($palilleria->goal) && $palilleria->goal == '1') ? "selected=\"selected\"" : "" }}}>SI</option>
                        </select>
                    </div>

                    <div class="col-md-3 col-sm-3">
                        {!! Form::label('goal_quantity', 'Cantidad:') !!}
                        {!! Form::number('goal_quantity', $palilleria->goal_quantity ?? 0 , ['class'=>'form-control', 'id'=>'goal_quantity']) !!}
                    </div>

                </div>

                <br>

                <div class="form-row text-center">
                    <div class="col-6 text-left">
                        <a href="{{ route('palilleria.cover', $order_id) }}" class="btn btn-danger">Anterior</a>
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

