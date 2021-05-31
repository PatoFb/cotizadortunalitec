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
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\CurtainsController@save', $order_id]]) !!}
                {!! csrf_field() !!}
            <div class="row">
                <div class="col-md-6 col-sm-6" id="curtainForm">
                    <h4>Producto</h4>
                    <h6>Modelo</h6>
                    <div class="form-row">

                        <div class="col-md-12 col-sm-12">
                                <select class="form-control " name="model_id" id="model_id">
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
                            {!! Form::number('width', 0 , ['class'=>'form-control', "step"=>0.1, "id"=>"width"]) !!}
                        </div>

                        <div class="col-md-6 col-sm-6">
                            {!! Form::label('height', 'Caida:') !!}
                            {!! Form::number('height', 0, ['class'=>'form-control', "step"=>0.1, "id"=>"height"]) !!}
                        </div>
                    </div>
                    <br>
                    <h6>Características</h6>
                    <div class="form-row">
                        <div class="col-md-6 col-sm-12">
                            {!! Form::label('control_id', 'Control:' )  !!}
                            <select class="form-control" name="control_id" id="control_id">
                                @foreach($controls as $control)
                                    <option value="{{$control->id}}">{{$control->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            {!! Form::label('canopy_id', 'Tejadillo:' )  !!}
                            <select class="form-control" name="canopy_id" id="canopy_id">
                                @foreach($canopies as $canopy)
                                    <option value="{{$canopy->id}}">{{$canopy->price}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-6 col-sm-12">
                            {!! Form::label('handle_id', 'Manivela:' )  !!}
                            <select class="form-control" name="handle_id" id="handle_id" >
                                @foreach($handles as $handle)
                                    <option value="{{$handle->id}}">{{$handle->measure}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            {!! Form::label('quantity', 'Cantidad:') !!}
                            {!! Form::number('quantity', 1 , ['class'=>'form-control', 'id'=>'quantity']) !!}
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
                <div class="col-md-6 col-sm-6" id="dynamicInfo">

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

