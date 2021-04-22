@extends('layouts.app', ['activePage' => 'myorders', 'titlePage' => __('Ordenes')])

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
                {!! Form::model($order, ['method'=>'PUT', 'action'=>['App\Http\Controllers\OrdersController@update', $order->id]]) !!}

                    <div class="form-row">

                        <div class="col-md-2 col-sm-12 text-center text-justify">
                            <div class="form-check form-check-radio">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="activity" id="exampleRadios1" value="Oferta" @if($order->activity == 'Oferta') checked @endif>
                                    Oferta
                                    <span class="circle">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                            <div class="form-check form-check-radio">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="activity" id="exampleRadios1" value="Orden" @if($order->activity == 'Orden') checked @endif>
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

                <div class="form-row float-right">

                    {!! Form::submit('Aceptar', ['class'=>'btn btn-primary pull-right']) !!}


                    {!! Form::close() !!}

                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal">Eliminar</button>
                </div>

            </div>
      </div>
    </div>
  </div>
      <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      Seguro que desea eliminar la orden? Se eliminarán todos los productos dentro de ella también.
                  </div>
                  <div class="modal-footer">
                      {!! Form::open(['method'=>'DELETE', 'action'=>['App\Http\Controllers\OrdersController@destroy', $order->id]]) !!}
                      {!! Form::submit('Eliminar', ['class'=>'btn btn-danger']) !!}
                      {!! Form::close() !!}
                  </div>
              </div>
          </div>
      </div>
</div>
    @endsection

