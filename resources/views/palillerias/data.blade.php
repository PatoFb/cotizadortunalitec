@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Palilleria')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Especificaciones (Paso 4 de 7)</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\PalilleriasController@addDataPost', $order_id]]) !!}
                <div class="form-row">
                    <div class="col-md-12 col-sm-12">
                        {!! Form::label('mechanism_id', 'Mecanismo') !!}
                        <select class="form-control" name="mechanism_id" id="mechanism_id" >
                            @foreach($mechs as $mech)
                                <option value="{{$mech->id}}" {{{ (isset($palilleria->mechanism_id) && $palilleria->mechanism_id== $mech->id) ? "selected=\"selected\"" : "" }}}>{{$mech->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('width', 'Ancho') !!}
                        {!! Form::number('width', $palilleria->width ?? null , ['class'=>'form-control', "step"=>0.1]) !!}
                    </div>

                    <div class="col-md-6 col-sm-6">
                        {!! Form::label('height', 'Salida') !!}
                        {!! Form::number('height', $palilleria->height ?? null, ['class'=>'form-control', "step"=>0.1]) !!}
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="col-md-12 col-sm-12">
                        {!! Form::label('quantity', 'Cantidad de sistemas') !!}
                        {!! Form::number('quantity', $palilleria->quantity ?? null, ['class'=>'form-control', "step"=>1]) !!}
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="col-md-6 text-left">
                        <a href="{{ route('palilleria.model', $order_id) }}" class="btn btn-danger">Anterior</a>
                    </div>
                    <div class="col-md-6 text-right">
                        {!! Form::submit('Siguiente', ['class'=>'btn btn-primary', $order_id]) !!}
                        {!! Form::close() !!}
                    </div>
                </div>




            </div>
      </div>
    </div>
  </div>
</div>
    @endsection

