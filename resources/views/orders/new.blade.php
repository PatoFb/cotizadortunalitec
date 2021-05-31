@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Ordenes')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Datos de orden</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>'App\Http\Controllers\OrdersController@newOrderPost']) !!}

                    <div class="form-row">

                        <div class="col-md-4 col-sm-4">
                            {!! Form::label('activity', 'Actividad:') !!}
                            <select class="form-control" name="activity" >
                                <option value="">Selecciona la actividad</option>
                                <option>Oferta</option>
                                <option>Pedido</option>
                            </select>
                        </div>

                        <div class="col-md-4 col-sm-4">
                            {!! Form::label('project', 'Nombre del proyecto:') !!}
                            {!! Form::text('project', null, ['class'=>'form-control']) !!}
                        </div>

                        <div class="col-sm-12 col-md-4">
                            {!! Form::label('discount', 'Descuento:') !!}
                            {!! Form::number('discount', \Illuminate\Support\Facades\Auth::user()->discount, ['class'=>'form-control', 'readonly']) !!}
                        </div>
                    </div>

                <br>
                <div class="form-group">
                    <div class="col-sm-12 col-md-12">
                        {!! Form::label('comments', 'Comentarios:') !!}
                        {!! Form::textarea('comments', null, ['class'=>'form-control']) !!}
                    </div>
                </div>

                    <div class="form-group text-right">
                        {!! Form::submit('Siguiente', ['class'=>'btn btn-primary', 'id'=>'create_order']) !!}
                    </div>

            </div>
          {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
    @endsection

