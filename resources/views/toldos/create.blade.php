@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Toldo')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Crear toldo</h4>
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\ToldosController@save', $order_id]]) !!}
                {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-6 col-sm-6" id="toldoForm">
                    <h4>Producto</h4>
                    <br>
                    <h6>Modelo</h6>
                    <div class="form-row">

                        <div class="col-md-12 col-sm-12">
                            <select class="form-control dynamic dynamic2" name="modelo_toldo_id" id="modelo_toldo_id" data-dependent="width" data-dependent2="projection">
                                @foreach($models as $model)
                                    <option value="{{$model->id}}">{{$model->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <br>
                    <h6>Cubierta</h6>
                    <div class="form-row">
                        <div class="col-md-12 col-sm-12">

                            <select class="form-control" name="cover_id" id="cover_id" >
                                @foreach($covers as $cover)
                                    <option value="{{$cover->id}}">{{$cover->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br>
                    <h6>Mecanismo</h6>
                    <div class="form-row">
                        <div class="col-md-12 col-sm-12">

                            <select class="form-control dynamic3 dynamic4" name="mechanism_id" id="mechanism_id" data-dependent3="control_id" data-dependent4="voice_id" >
                                @foreach($mechanisms as $mechanism)
                                    <option value="{{$mechanism->id}}">{{$mechanism->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br>
                    <h6>Datos</h6>
                    <div class="form-row">

                        <div class="col-md-6 col-sm-6">
                            {!! Form::label('width', 'Ancho:') !!}
                            <select class="form-control" name="width" id="width">
                                <option value="">Seleccionar ancho</option>
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            {!! Form::label('projection', 'Proyección:' )  !!}
                            <select class="form-control" name="projection" id="projection" >
                                <option value="">Seleccionar proyección</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <h6>Características</h6>
                    <div class="form-row">
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('handle_id', 'Manivela:' )  !!}
                            <select class="form-control" name="handle_id" id="handle_id" >
                                @foreach($handles as $handle)
                                    <option value="{{$handle->id}}">{{$handle->measure}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('handle_quantity', 'Cantidad:') !!}
                            {!! Form::number('handle_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"handle_quantity"]) !!}
                        </div>
                    </div>
                        <div class="form-row">
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('control_id', 'Control:' )  !!}
                            <select class="form-control" name="control_id" id="control_id">
                                <option value="">Seleccionar control</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('control_quantity', 'Cantidad:') !!}
                            {!! Form::number('control_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"control_quantity"]) !!}
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('sensor_id', 'Sensores:' )  !!}
                            <select class="form-control" name="sensor_id" id="sensor_id" >
                                @foreach($sensors as $sensor)
                                    <option value="{{$sensor->id}}">{{$sensor->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('sensor_quantity', 'Cantidad:') !!}
                            {!! Form::number('sensor_quantity', 0 , ['class'=>'form-control', 'id'=>'sensor_quantity']) !!}
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('voice_id', 'Voz:' )  !!}
                            <select class="form-control" name="voice_id" id="voice_id" >
                                    <option value="">Seleccionar control de voz</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('voice_quantity', 'Cantidad:') !!}
                            {!! Form::number('voice_quantity', 0 , ['class'=>'form-control', 'id'=>'voice_quantity']) !!}
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-sm-12">
                            {!! Form::label('canopy_id', 'Tejadillo:' )  !!}
                            <select class="form-control" name="canopy_id" id="canopy_id" >
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            {!! Form::label('bambalina', 'Bambalina Enrollable:' )  !!}
                            <select class="form-control" name="bambalina" id="bambalina" >
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                        <div class="col-md-12 col-sm-12">
                        {!! Form::label('quantity', 'Cantidad:') !!}
                        {!! Form::number('quantity', 1 , ['class'=>'form-control', 'id'=>'quantity']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="row" id="dynamicInfoT">

                    </div>
                    <hr>
                    <div class="row" id="dynamicInfoA">

                    </div>
                </div>
                </div>

                <div class="form-group text-right">

                        {!! Form::submit('Guardar', ['class'=>'btn btn-primary', 'id'=>'save_toldo', $order_id]) !!}
                        {!! Form::close() !!}

                </div>
            </div>

      </div>
    </div>
  </div>
</div>
</div>
    @endsection

