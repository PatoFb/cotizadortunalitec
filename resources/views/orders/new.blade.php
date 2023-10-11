@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Ordenes')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Generar proyecto</h4>
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
                            @if(\Illuminate\Support\Facades\Auth::user()->role_id == 1)
                                {!! Form::label('discount', 'Descuento:') !!}
                                {!! Form::number('discount', \Illuminate\Support\Facades\Auth::user()->discount, ['class'=>'form-control', 'min'=>0, 'max'=>99, 'step'=>1]) !!}
                            @else
                                {!! Form::label('discount', 'Descuento:') !!}
                                {!! Form::number('discount', \Illuminate\Support\Facades\Auth::user()->discount, ['class'=>'form-control', 'readonly']) !!}
                            @endif
                        </div>
                    </div>

                <br>
                <div class="form-row">
                    <div class="col-sm-12 col-md-12">
                        {!! Form::label('comments', 'Comentarios:') !!}
                        {!! Form::textarea('comments', null, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <br>
                <div class="form-check">
                    <div class="col-sm-12 col-md-12">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" value="1" id="addressCheck" name="addressCheck" checked>
                        Utilizar dirección predeterminada
                        <span class="form-check-sign">
                             <span class="check"></span>
                        </span>
                    </label>
                    </div>
                </div>
                <br>
                <div class="d-none" id="addressForm">
                <div class="form-row">
                    <div class="col-md-5 col-sm-12">
                        {!! Form::label('city', 'Ciudad:') !!}
                        {!! Form::text('city', null, ['class'=>'form-control']) !!}
                    </div>
                    <div class="col-md-5 col-sm-12">
                        {!! Form::label('state', 'Estado:') !!}
                        {!! Form::text('state', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="col-md-2 col-sm-12">
                        {!! Form::label('zip_code', 'Código postal:') !!}
                        {!! Form::text('zip_code', null, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="col-md-12 col-sm-12">
                        {!! Form::label('line1', 'Colonia:') !!}
                        {!! Form::text('line1', null, ['class'=>'form-control', 'placeholder'=>'Colonia']) !!}
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="col-md-12 col-sm-12">
                        {!! Form::label('line2', 'Calle y número:') !!}
                        {!! Form::text('line2', null, ['class'=>'form-control', 'placeholder'=>'Calle, nombre de la empresa, # exterior']) !!}
                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="col-md-12 col-sm-12">
                        {!! Form::label('reference', 'Referencias:') !!}
                        {!! Form::text('reference', null, ['class'=>'form-control']) !!}
                    </div>
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

