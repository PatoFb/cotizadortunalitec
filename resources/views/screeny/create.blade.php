@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Cortina')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Crear cortina</h4>
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\ScreenyCurtainsController@save', $order_id]]) !!}
                {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-6 col-sm-6" id="screenyForm">
                    <h4>Producto</h4>
                    <br>
                    <h6>Modelo</h6>
                    <div class="form-row">
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('model_id', 'Modelo:') !!}
                            <select class="form-control" name="model_id" id="model_id" >
                                @foreach($models as $model)
                                    <option value="{{$model->id}}">{{$model->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('quantity', 'Cantidad de producto:') !!}
                            {!! Form::number('quantity', 1 , ['class'=>'form-control', 'id'=>'quantity']) !!}
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

                            <select class="form-control dynamic7 dynamic8" name="mechanism_id" id="mechanism_id" >
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
                                <option value="1.5">1.5</option>
                                <option value="2">2</option>
                                <option value="2.5">2.5</option>
                                <option value="3">3</option>
                                <option value="3.5">3.5</option>
                                <option value="4">4</option>
                                <option value="4.5">4.5</option>
                                <option value="5">5</option>
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-6">
                            {!! Form::label('height', 'Caida:') !!}
                            <select class="form-control" name="height" id="height">
                                <option value="1.5">1.5</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <h6>Características</h6>
                    <div class="form-row">
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('handle_id', 'Manivela (Medida en metros):' )  !!}
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
                        <div class="col-md-12 col-sm-12">
                            {!! Form::label('canopy_id', 'Tejadillo:' )  !!}
                            <select class="form-control" name="canopy_id" id="canopy_id" >
                                <option value="1">Si</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                    </div>
                    @if($order->activity == "Pedido")
                        <br>
                        <h6>Datos para producción (solo requeridos para pedidos)</h6>
                        <div class="form-row">
                            <div class="col-md-4 col-sm-12">
                                {!! Form::label('installation_type', 'Tipo de instalación:') !!}
                                <select class="form-control" name="installation_type">
                                    <option>Pared</option>
                                    <option>Techo</option>
                                    <option>Entre muros</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                {!! Form::label('mechanism_side', 'Lado de mecanismo:') !!}
                                <select class="form-control" name="mechanism_side" >
                                    <option>Izquierdo</option>
                                    <option>Derecho</option>
                                </select>
                            </div>

                            <div class="col-md-4 col-sm-12">
                                {!! Form::label('view_type', 'Tipo de vista:') !!}
                                <select class="form-control" name="view_type" >
                                    <option>Exterior</option>
                                    <option>Interior</option>
                                </select>
                            </div>

                        </div>
                    @endif
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="row" id="dynamicInfoST">

                    </div>
                    <hr>
                    <div class="row" id="dynamicInfoSA">

                    </div>
                </div>
                </div>

                <div class="form-group text-right">

                        {!! Form::submit('Guardar', ['class'=>'btn btn-primary', 'id'=>'save_curtain', $order_id]) !!}
                        {!! Form::close() !!}

                </div>
            </div>

      </div>
    </div>
  </div>
</div>
</div>
    @endsection
