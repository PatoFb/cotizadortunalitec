@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Ordenes')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Revisión de producto</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\CurtainsController@reviewPost', $order_id]]) !!}
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <td class="text-center">Modelo:</td>
                            <td><strong>{{$curtain->model->name}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Cubierta:</td>
                            <td><strong>{{$curtain->cover->name}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Ancho:</td>
                            <td><strong>{{$curtain->width}} mts</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Caida:</td>
                            <td><strong>{{$curtain->height}} mts</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Tejadillo:</td>
                            <td><strong>{{$curtain->canopy->price}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Manivela:</td>
                            <td><strong>{{$curtain->handle->measure}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Control:</td>
                            <td><strong>{{$curtain->control->name}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Precio unitario:</td>
                            <td><strong>${{number_format($curtain->price/$curtain->quantity, 2)}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Cantidad:</td>
                            <td><strong>{{$curtain->quantity}}</strong></td>
                        </tr>
                        <tr>
                            <td class="text-center">Total:</td>
                            <td><strong>${{number_format($curtain->price, 2)}}</strong></td>
                        </tr>
                    </table>
                </div>
                <div class="form-row text-center">
                    <div class="col-6 text-left">
                        <a href="{{ route('curtain.features', $order_id) }}" class="btn btn-danger">Anterior</a>
                    </div>
                    <div class="col-6 text-right">
                        {!! Form::submit('Guardar', ['class'=>'btn btn-primary', $order_id]) !!}
                        {!! Form::close() !!}
                    </div>
                </div>




            </div>
      </div>
    </div>
  </div>
</div>
    @endsection

