@extends('layouts.app', ['activePage' => 'myorders', 'titlePage' => __('Mis ordenes')])

@section('content')
<div class="content">
    @include('alerts.success')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Orden {{$order->id}}</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                <div class="form-row float-right">
                        <a href="{{route('orders.type', $order->id)}}" class="btn btn-sm btn-primary">Agregar producto</a>

                        <a href="{{route('orders.edit', $order->id)}}" class="btn btn-sm btn-info">Editar orden</a>
                </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr>
                    <th>
                      Proyecto
                    </th>
                    <th>
                      Actividad
                    </th>
                        <th>
                           Datos de facturación
                        </th>
                        <th>
                            Precio
                        </th>
                        <th>
                            Descuento
                        </th>
                        <th>
                            Total
                        </th>
                    <th class="text-right">
                      Eliminar
                    </th>
                  </tr></thead>
                  <tbody>
                  <tr>
                        <td>{{$order->project}}</td>
                        <td>{{$order->activity}}</td>
                      <td>{{$order->invoice_data}}</td>
                      <td>${{number_format($order->price, 2)}}</td>
                      <td>{{$order->discount}}%</td>
                      <td>${{number_format($order->total, 2)}}</td>
                        <td class="td-actions text-right">
                            <a rel="tooltip" class="btn btn-danger btn-link" href="{{route('orders.destroy', $order->id)}}" data-original-title="" title="">
                              <i class="material-icons">delete</i>
                              <div class="ripple-container"></div>
                            </a>
                        </td>
                      </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
    @endsection

