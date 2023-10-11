@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Ordenes')])

@section('content')
<div class="content">
    @include('alerts.error_form')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
                <h4 class="card-title">Tipo de sistema (Paso 1 de 6)</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\TypesController@productTypePost', $order_id]]) !!}


                <div class="form-group">
                    <div class="col-md-12 col-sm-12">
                        {!! Form::label('type_id', 'Selecciona el tipo de producto:' )  !!}
                        {!! Form::select('type_id', [1=>'Cortina'] + $types, null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                    <div class="form-group text-left">
                        {!! Form::submit('Siguiente', ['class'=>'btn btn-primary', 'id'=>'select_product'], $order_id) !!}
                    </div>

            </div>
          {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
    @endsection

