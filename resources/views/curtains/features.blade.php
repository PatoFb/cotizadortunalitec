@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Características')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Características de cortina</h4>
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\CurtainsController@addFeaturesPost', $order_id]]) !!}


                <div class="form-group">
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('control_id', 'Control:' )  !!}
                        <select class="form-control" name="control_id" >
                            <option value="">Selecciona el control</option>
                            @foreach($controls as $control)
                                <option {{isset($curtain) && $curtain->control_id ? 'selected' : ''}} value="{{$control->id}}">{{$control->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('canopy_id', 'Tejadillo:' )  !!}
                        <select class="form-control" name="canopy_id" >
                            <option value="">Selecciona el tejadillo</option>
                            @foreach($canopies as $canopy)
                                <option {{isset($curtain) && $curtain->canopy_id ? 'selected' : ''}} value="{{$canopy->id}}">{{$canopy->price}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('handle_id', 'Manivela:' )  !!}
                        <select class="form-control" name="handle_id" >
                            <option value="">Selecciona la manivela</option>
                            @foreach($handles as $handle)
                                <option {{isset($curtain) && $curtain->handle_id ? 'selected' : ''}} value="{{$handle->id}}">{{$handle->measure}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('quantity', 'Cantidad:') !!}
                        {!! Form::number('quantity', $curtain->quantity ?? null , ['class'=>'form-control']) !!}
                    </div>

                </div>



                <div class="form-row text-center">
                    <div class="col-6 text-left">
                        <a href="{{ route('curtain.data', $order_id) }}" class="btn btn-danger">Anterior</a>
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

