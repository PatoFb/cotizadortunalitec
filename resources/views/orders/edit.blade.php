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

                    <div class="col-md-4 col-sm-12">
                        {!! Form::label('activity', 'Actividad:') !!}
                        <select class="form-control" name="activity" >
                            <option value="">Selecciona la actividad</option>
                            <option @if($order->activity == "Oferta") selected @endif>Oferta</option>
                            <option @if($order->activity == "Pedido") selected @endif>Pedido</option>
                        </select>
                    </div>

                    <div class="col-md-4 col-sm-12">
                        {!! Form::label('project', 'Nombre del proyecto:') !!}
                        {!! Form::text('project', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="col-sm-12 col-md-4">
                        {!! Form::label('discount', 'Descuento:') !!}
                        {!! Form::number('discount', null, ['class'=>'form-control', 'step'=>0.1, 'readonly']) !!}
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

