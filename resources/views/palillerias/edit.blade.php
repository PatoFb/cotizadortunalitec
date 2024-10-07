@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Palilleria')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Selecciona una cubierta (Paso 4 de 6)</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                {!! Form::model($p, ['method'=>'PUT', 'action'=>['App\Http\Controllers\PalilleriasController@addData', $p->id]]) !!}
                <h6>Datos</h6>
                <div class="row">
                    <div class="col-12">
                        {!! Form::label('quantity', 'Cantidad de sistemas') !!}
                        {!! Form::number('quantity', $p->quantity ?? null, ['class'=>'form-control', "id"=>"quantity", "step"=>1, "min"=>1]) !!}
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('width', 'Ancho') !!}
                        {!! Form::number('width', $p->width ?? null , ['class'=>'form-control', "step"=>0.01, "min"=>1.01, "max"=>$p->model->max_width]) !!}
                    </div>

                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('height', 'Caida') !!}
                        {!! Form::number('height', $p->height ?? null, ['class'=>'form-control', "step"=>0.01, "min"=>1.01, "max"=>$p->model->max_height]) !!}
                    </div>
                </div>
                <br>
                <h6>Cubierta</h6>
                <div class="row">
                    <div class="col-12" id="coverFormP2{{$p->id}}">
                        <input name="palilleria_id" type="hidden" value="{{$p->id}}" id="palilleria_id">
                        {!! Form::label('cover_id', 'Clave (del 1 al 10 son estilos pendientes, no se aceptan pendientes para Pedidos)') !!}
                        {!! Form::number('cover_id', $p->cover_id ?? null, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12" id="coverDynamicP2{{$p->id}}">

                    </div>
                </div>
                <br>
                <h6>Accesorios</h6>
                <div class="row">
                    @if($p->sensor_id == 9999)
                        {!! Form::number('sensor_id', 9999, ['class'=>'form-control', "step"=>1, "id"=>"sensor_id", 'hidden']) !!}
                        {!! Form::number('sensor_quantity', 0, ['class'=>'form-control', "step"=>1, 'hidden']) !!}
                    @else
                        <div class="col-6">
                            {!! Form::label('sensor_id', 'Sensor (Precio por unidad)' )  !!}
                            <select class="form-control" name="sensor_id" id="sensor_id" >
                                <option value="999" {{{ (isset($p->sensor_id) && $p->sensor_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                @foreach($sensors as $sensor)
                                    <option value="{{$sensor->id}}" {{{ (isset($p->sensor_id) && $p->sensor_id == $sensor->id) ? "selected=\"selected\"" : "" }}}>{{$sensor->name}} mts - ${{number_format($sensor->price*1.16, 2)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            {!! Form::label('sensor_quantity', 'Cantidad (sensores):') !!}
                            {!! Form::number('sensor_quantity', $p->sensor_quantity ?? 0, ['class'=>'form-control', "step"=>1]) !!}
                        </div>
                    @endif
                </div>
                @if($p->sensor_id != 9999)
                    <br>
                @endif
                <div class="row">
                    @if($p->control_id == 9999)
                        {!! Form::number('control_id', 9999, ['class'=>'form-control', "step"=>1, "id"=>"control_id", 'hidden']) !!}
                        {!! Form::number('control_quantity', 0, ['class'=>'form-control', "step"=>1, 'hidden']) !!}
                    @else
                        <div class="col-6">
                            {!! Form::label('control_id', 'Control (Precio por unidad)' )  !!}
                            <select class="form-control" name="control_id" id="control_id">
                                <option value="999" {{{ (isset($p->control_id) && $p->control_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                @foreach($controls as $control)
                                    @if($control->mechanism_id == $p->mechanism_id)
                                        <option value="{{$control->id}}" {{{ (isset($p->control_id) && $p->control_id == $control->id) ? "selected=\"selected\"" : "" }}}>{{$control->name}} - ${{number_format($control->price*1.16, 2)}}</option>
                                    @elseif($p->mechanism_id == 3)
                                        @if($control->mechanism_id == 2)
                                            <option value="{{$control->id}}" {{{ (isset($p->control_id) && $p->control_id == $control->id) ? "selected=\"selected\"" : "" }}}>{{$control->name}} - ${{number_format($control->price*1.16, 2)}}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            {!! Form::label('control_quantity', 'Cantidad (controles):') !!}
                            {!! Form::number('control_quantity', $p->control_quantity ?? 0, ['class'=>'form-control', "step"=>1]) !!}
                        </div>
                    @endif
                </div>
                @if($p->control_id != 9999)
                    <br>
                @endif
                <div class="row">
                    @if($p->voice_id == 9999)
                        {!! Form::number('voice_id', 9999, ['class'=>'form-control', 'id'=>'voice_id', 'hidden']) !!}
                        {!! Form::number('voice_quantity', 0, ['class'=>'form-control', 'hidden']) !!}
                    @else
                        <div class="col-6">
                            {!! Form::label('voice_id', 'Voz (Precio por unidad)' )  !!}
                            <select class="form-control hidden" name="voice_id" id="voice_id" >
                                <option value="999" {{{ (isset($p->voice_id) && $p->voice_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                @foreach($voices as $voice)
                                    @if($voice->mechanism_id == $p->mechanism_id)
                                        <option value="{{$voice->id}}" {{{ (isset($p->voice_id) && $p->voice_id == $voice->id) ? "selected=\"selected\"" : "" }}}>{{$voice->name}} - ${{number_format($voice->price*1.16, 2)}}</option>
                                    @elseif($p->mechanism_id == 3)
                                        @if($voice->mechanism_id == 2)
                                            <option value="{{$voice->id}}" {{{ (isset($p->voice_id) && $p->voice_id == $voice->id) ? "selected=\"selected\"" : "" }}}>{{$voice->name}} - ${{number_format($voice->price*1.16, 2)}}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            {!! Form::label('voice_quantity', 'Cantidad (controles de voz):') !!}
                            {!! Form::number('voice_quantity', $p->voice_quantity ?? 0, ['class'=>'form-control']) !!}
                        </div>
                    @endif
                </div>

                <br>
                <h6>Datos para pedido</h6>
                <div class="row">
                    <div class="col-12">
                        {!! Form::label('inclination', 'Tipo de instalación:') !!}
                        <select class="form-control" name="inclination">
                            <option value="">Selecciona inclinación</option>
                            <option {{{ (isset($p->inclination) && $p->inclination == '30 y 60mm') ? "selected=\"selected\"" : "" }}}>30 y 60mm</option>
                            <option {{{ (isset($p->inclination) && $p->inclination == '60 y 90mm') ? "selected=\"selected\"" : "" }}}>60 y 90mm</option>
                            <option {{{ (isset($p->inclination) && $p->inclination == '30 y 90mm') ? "selected=\"selected\"" : "" }}}>30 y 90mm</option>
                            <option {{{ (isset($p->inclination) && $p->inclination == '30, 60 y 90mm') ? "selected=\"selected\"" : "" }}}>30, 60 y 90mm</option>
                            <option {{{ (isset($p->inclination) && $p->inclination == 'Recta 30mm') ? "selected=\"selected\"" : "" }}}>Recta 30mm</option>
                            <option {{{ (isset($p->inclination) && $p->inclination == 'Recta 60mm') ? "selected=\"selected\"" : "" }}}>Recta 60mm</option>
                            <option {{{ (isset($p->inclination) && $p->inclination == 'Recta 90mm') ? "selected=\"selected\"" : "" }}}>Recta 90mm</option>
                            <option {{{ (isset($p->inclination) && $p->inclination == 'Otro') ? "selected=\"selected\"" : "" }}}>Otro</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12">
                        {!! Form::label('goal_height', 'Altura de porterías:') !!}
                        {!! Form::number('goal_height', $p->goal_height ?? 0, ['class'=>'form-control', 'id'=>'goal_height', 'max'=>5, 'step'=>0.01]) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        {!! Form::submit('Guardar', ['class'=>'btn btn-primary', 'id'=>'toldo_add_data']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>

            </div>

      </div>
    </div>
  </div>
</div>
    @endsection

