@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Palillería')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Crear palillería</h4>
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\PalilleriasController@save', $order_id]]) !!}
                {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-6 col-sm-6" id="palilleriaForm">
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

                            <select class="form-control dynamicP1 dynamicP2" name="mechanism_id" id="mechanism_id" data-dependentP1="control_id" data-dependentP2="voice_id" >
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
                            {!! Form::number('width', 2 , ['class'=>'form-control', "step"=>0.1, "id"=>"width", 'min'=>2, 'max'=>10]) !!}
                        </div>

                        <div class="col-md-6 col-sm-6">
                            {!! Form::label('height', 'Salida:') !!}
                            {!! Form::number('height', 2, ['class'=>'form-control', "step"=>0.1, "id"=>"height", 'min'=>2, 'max'=>10]) !!}
                        </div>
                    </div>
                    <br>
                    <h6>Características</h6>
                    <div class="form-row">
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('control_id', 'Control:' )  !!}
                            <select class="form-control" name="control_id" id="control_id">
                                @foreach($controls as $control)
                                    <option value="{{$control->id}}">{{$control->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('control_quantity', 'Cantidad:') !!}
                            {!! Form::number('control_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"control_quantity"]) !!}
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('sensor_id', 'Sensor:' )  !!}
                            <select class="form-control" name="sensor_id" id="sensor_id">
                                @foreach($sensors as $sensor)
                                    <option value="{{$sensor->id}}">{{$sensor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('sensor_quantity', 'Cantidad:') !!}
                            {!! Form::number('sensor_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"sensor_quantity"]) !!}
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
                    <br>
                    <h6>Refuerzos</h6>
                    <div class="form-row">
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('reinforcement_id', 'Guía+:' )  !!}
                                <select class="form-control" name="reinforcement_id" id="reinforcement_id" >
                                    <option value="0">NO</option>
                                    <option value="1">SI</option>
                                </select>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('reinforcement_quantity', 'Cantidad:') !!}
                            {!! Form::number('reinforcement_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"reinforcement_quantity"]) !!}
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('trave', 'Trave+:' )  !!}
                                <select class="form-control" name="trave" id="trave" >
                                    <option value="0">NO</option>
                                    <option value="1">SI</option>
                                </select>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('trave_quantity', 'Cantidad:') !!}
                            {!! Form::number('trave_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"trave_quantity"]) !!}
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('semigoal', 'Semiportería+:' )  !!}
                            <select class="form-control" name="semigoal" id="semigoal" >
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('semigoal_quantity', 'Cantidad:') !!}
                            {!! Form::number('semigoal_quantity', 0 , ['class'=>'form-control', 'id'=>'semigoal_quantity']) !!}
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="col-md-9 col-sm-9">
                            {!! Form::label('goal', 'Portería+:' )  !!}
                            <select class="form-control" name="goal" id="goal" >
                                <option value="0">NO</option>
                                <option value="1">SI</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('goal_quantity', 'Cantidad:') !!}
                            {!! Form::number('goal_quantity', 0 , ['class'=>'form-control', 'id'=>'goal_quantity']) !!}
                        </div>

                    </div>

                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="row" id="dynamicInfoP">

                    </div>
                    <hr>
                    <div class="row" id="dynamicInfoPA">

                    </div>
                </div>
                </div>

                <div class="form-group text-right">

                        {!! Form::submit('Guardar', ['class'=>'btn btn-primary', 'id'=>'save_palilleria', $order_id]) !!}
                        {!! Form::close() !!}

                </div>
            </div>

      </div>
    </div>
  </div>
</div>
</div>
    @endsection

