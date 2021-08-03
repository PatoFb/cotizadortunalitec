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

                            <select class="form-control" name="mechanism_id" id="mechanism_id" >
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
                            {!! Form::label('reinforcement_id', 'Refuerzo:' )  !!}
                            <select class="form-control" name="reinforcement_id" id="reinforcement_id" >
                                <option value="1">Guía+</option>
                                <option value="0">No aplica</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-3">
                            {!! Form::label('reinforcement_quantity', 'Cantidad:') !!}
                            {!! Form::number('reinforcement_quantity', 0 , ['class'=>'form-control', 'id'=>'reinforcement_quantity']) !!}
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="col-md-6 col-sm-6">
                            {!! Form::label('goals', 'Porterías:') !!}
                            {!! Form::number('goals', 0 , ['class'=>'form-control', 'id'=>'goals']) !!}
                        </div>

                        <div class="col-md-6 col-sm-6">
                            {!! Form::label('quantity', 'Cantidad de producto:') !!}
                            {!! Form::number('quantity', 1 , ['class'=>'form-control', 'id'=>'quantity']) !!}
                        </div>

                    </div>
                </div>
                <div class="col-md-6 col-sm-6" id="dynamicInfoP">

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

