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

                        <div class="col-md-2 col-sm-12 text-center text-justify">
                            <div class="form-check form-check-radio">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="activity" id="exampleRadios1" value="Oferta" >
                                    Oferta
                                    <span class="circle">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check form-check-radio">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="activity" id="exampleRadios1" value="Orden" >
                                    Orden
                                    <span class="circle" >
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <div class="col-md-5 col-sm-12">
                            {!! Form::label('project', 'Nombre del proyecto:') !!}
                            {!! Form::text('project', null, ['class'=>'form-control']) !!}
                        </div>

                        <div class="col-sm-12 col-md-5">
                            {!! Form::label('invoice_data', 'Datos de facturación:') !!}
                            {!! Form::text('invoice_data', null, ['class'=>'form-control']) !!}
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
                        {!! Form::submit('Siguiente', ['class'=>'btn btn-primary']) !!}
                    </div>

            </div>
          {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
    @endsection

