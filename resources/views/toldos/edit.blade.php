@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Toldo')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Editar toldo</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                {!! Form::model($toldo, ['method'=>'PUT', 'action'=>['App\Http\Controllers\ToldosController@addData', $toldo->id]]) !!}
                <h6>Datos</h6>
                <div class="row">
                    <div class="col-12">
                        {!! Form::label('quantity', 'Cantidad de sistemas') !!}
                        {!! Form::number('quantity', $toldo->quantity ?? null, ['class'=>'form-control', "step"=>1, "min"=>1]) !!}
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('width', 'Ancho') !!}
                        {!! Form::number('width', $toldo->width ?? null , ['class'=>'form-control dynamicPro', "step"=>0.01, "data-dependent2"=>"projection", "min"=>$toldo->model->min_width, "max"=>$toldo->model->max_width]) !!}
                    </div>

                    <div class="col-md-6 col-sm-12">
                        {!! Form::label('projection', 'Proyección:' )  !!}
                        <select class="form-control" name="projection" id="projection" >
                            <option value={{$toldo->projection ?? ""}}>{{$toldo->projection ?? "Seleccionar proyección"}}</option>
                        </select>
                    </div>
                </div>
                <br>
                <h6>Cubierta</h6>
                <div class="row">
                    <div class="col-12" id="coverFormT2{{$toldo->id}}">
                        <input name="toldo_id" type="hidden" value="{{$toldo->id}}" id="toldo_id">
                        {!! Form::label('cover_id', 'Clave (del 1 al 10 son estilos pendientes, no se aceptan pendientes para Pedidos)') !!}
                        {!! Form::number('cover_id', $toldo->cover_id ?? null, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-12" id="coverDynamicT2{{$toldo->id}}">

                    </div>
                </div>
                <br>
                <h6>Accesorios</h6>
                <div class="row">
                    @if($toldo->handle_id == 9999)
                        {!! Form::number('handle_id', 9999, ['class'=>'form-control', "step"=>1, "id"=>"handle_id", 'hidden']) !!}
                        {!! Form::number('handle_quantity', 0, ['class'=>'form-control', "step"=>1, 'hidden']) !!}
                    @else
                        <div class="col-6">
                            {!! Form::label('handle_id', 'Manivela (Medida en metros) (Precio por unidad)' )  !!}
                            <select class="form-control" name="handle_id" id="handle_id" >
                                <option value="999" {{{ (isset($toldo->handle_id) && $toldo->handle_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                @foreach($handles as $handle)
                                    <option value="{{$handle->id}}" {{{ (isset($toldo->handle_id) && $toldo->handle_id == $handle->id) ? "selected=\"selected\"" : "" }}}>{{$handle->measure}} mts - ${{number_format($handle->price*1.16, 2)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            {!! Form::label('handle_quantity', 'Cantidad (manivelas):') !!}
                            {!! Form::number('handle_quantity', $toldo->handle_quantity ?? 0, ['class'=>'form-control', "step"=>1]) !!}
                        </div>
                    @endif
                </div>
                <div class="row">
                    @if($toldo->sensor_id == 9999)
                        {!! Form::number('sensor_id', 9999, ['class'=>'form-control', "step"=>1, "id"=>"sensor_id", 'hidden']) !!}
                        {!! Form::number('sensor_quantity', 0, ['class'=>'form-control', "step"=>1, 'hidden']) !!}
                    @else
                        <div class="col-6">
                            {!! Form::label('sensor_id', 'Sensor (Precio por unidad)' )  !!}
                            <select class="form-control" name="sensor_id" id="sensor_id" >
                                <option value="999" {{{ (isset($toldo->sensor_id) && $toldo->sensor_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                @foreach($sensors as $sensor)
                                    <option value="{{$sensor->id}}" {{{ (isset($toldo->sensor_id) && $toldo->sensor_id == $sensor->id) ? "selected=\"selected\"" : "" }}}>{{$sensor->name}} mts - ${{number_format($sensor->price*1.16, 2)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            {!! Form::label('sensor_quantity', 'Cantidad (sensores):') !!}
                            {!! Form::number('sensor_quantity', $toldo->sensor_quantity ?? 0, ['class'=>'form-control', "step"=>1]) !!}
                        </div>
                    @endif
                </div>
                @if($toldo->sensor_id != 9999)
                    <br>
                @endif
                <div class="row">
                    @if($toldo->control_id == 9999)
                        {!! Form::number('control_id', 9999, ['class'=>'form-control', "step"=>1, "id"=>"control_id", 'hidden']) !!}
                        {!! Form::number('control_quantity', 0, ['class'=>'form-control', "step"=>1, 'hidden']) !!}
                    @else
                        <div class="col-6">
                            {!! Form::label('control_id', 'Control (Precio por unidad)' )  !!}
                            <select class="form-control" name="control_id" id="control_id">
                                <option value="999" {{{ (isset($toldo->control_id) && $toldo->control_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                @foreach($controls as $control)
                                    @if($control->mechanism_id == $toldo->mechanism_id)
                                        <option value="{{$control->id}}" {{{ (isset($toldo->control_id) && $toldo->control_id == $control->id) ? "selected=\"selected\"" : "" }}}>{{$control->name}} - ${{number_format($control->price*1.16, 2)}}</option>
                                    @elseif($toldo->mechanism_id == 3)
                                        @if($control->mechanism_id == 2)
                                            <option value="{{$control->id}}" {{{ (isset($toldo->control_id) && $toldo->control_id == $control->id) ? "selected=\"selected\"" : "" }}}>{{$control->name}} - ${{number_format($control->price*1.16, 2)}}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            {!! Form::label('control_quantity', 'Cantidad (controles):') !!}
                            {!! Form::number('control_quantity', $toldo->control_quantity ?? 0, ['class'=>'form-control', "step"=>1]) !!}
                        </div>
                    @endif
                </div>
                @if($toldo->control_id != 9999)
                    <br>
                @endif
                <div class="row">
                    @if($toldo->voice_id == 9999)
                        {!! Form::number('voice_id', 9999, ['class'=>'form-control', 'id'=>'voice_id', 'hidden']) !!}
                        {!! Form::number('voice_quantity', 0, ['class'=>'form-control', 'hidden']) !!}
                    @else
                        <div class="col-6">
                            {!! Form::label('voice_id', 'Voz (Precio por unidad)' )  !!}
                            <select class="form-control hidden" name="voice_id" id="voice_id" >
                                <option value="999" {{{ (isset($toldo->voice_id) && $toldo->voice_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                @foreach($voices as $voice)
                                    @if($voice->mechanism_id == $toldo->mechanism_id)
                                        <option value="{{$voice->id}}" {{{ (isset($toldo->voice_id) && $toldo->voice_id == $voice->id) ? "selected=\"selected\"" : "" }}}>{{$voice->name}} - ${{number_format($voice->price*1.16, 2)}}</option>
                                    @elseif($toldo->mechanism_id == 3)
                                        @if($voice->mechanism_id == 2)
                                            <option value="{{$voice->id}}" {{{ (isset($toldo->voice_id) && $toldo->voice_id == $voice->id) ? "selected=\"selected\"" : "" }}}>{{$voice->name}} - ${{number_format($voice->price*1.16, 2)}}</option>
                                        @endif
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            {!! Form::label('voice_quantity', 'Cantidad (controles de voz):') !!}
                            {!! Form::number('voice_quantity', $toldo->voice_quantity ?? 0, ['class'=>'form-control']) !!}
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-12">
                        {!! Form::label('canopy', 'Tejadillo:' )  !!}
                        <select class="form-control" name="canopy" id="canopy" >
                            <option value="1" {{{ (isset($toldo->canopy) && $toldo->canopy == '1') ? "selected=\"selected\"" : "" }}}>Si</option>
                            <option value="0" {{{ (isset($toldo->canopy) && $toldo->canopy == '0') ? "selected=\"selected\"" : "" }}}>No</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        {!! Form::label('bambalina', 'Bambalina:' )  !!}
                        <select class="form-control" name="bambalina" id="bambalina" >
                            <option value="1" {{{ (isset($toldo->bambalina) && $toldo->bambalina == '1') ? "selected=\"selected\"" : "" }}}>Si</option>
                            <option value="0" {{{ (isset($toldo->bambalina) && $toldo->bambalina == '0') ? "selected=\"selected\"" : "" }}}>No</option>
                        </select>
                    </div>
                </div>
                <br>
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

