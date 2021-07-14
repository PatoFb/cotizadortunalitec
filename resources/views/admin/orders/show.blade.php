@extends('layouts.app', ['activePage' => 'allorders', 'titlePage' => __('Mis ordenes')])

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
                      @if($order->activity == 'Pedido')
                      <div class="form-row float-right">
                          <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#authorizeModal" id="authorize_order_modal">
                              Autorizar y enviar a producción
                              </button>
                      </div>
                      @endif
                      <div class="table-responsive">
                          <table class="table">
                              <thead class=" text-primary">
                              <tr>
                                  <th>
                                      Proyecto
                                  </th>
                                  <th>
                                      Usuario
                                  </th>
                                  <th>
                                      Actividad
                                  </th>
                                  <th>
                                      Precio
                                  </th>
                                  <th>
                                      Descuento
                                  </th>
                                  <th class="text-right">
                                      Total
                                  </th>
                                  <th class="text-right">
                                      Comprobante de pago
                                  </th>
                              </tr></thead>
                              <tbody>
                              <tr>
                                  <td>{{$order->project}}</td>
                                  <td>{{$order->user->name}}</td>
                                  <td>{{$order->activity}}</td>
                                  <td>${{number_format($order->price, 2)}}</td>
                                  <td>{{$order->discount}}%</td>
                                  <td class="text-right">${{number_format($order->total, 2)}}</td>
                                  <td class="text-right"><a href="{{route('orders.download', $order->id)}}"> Descargar archivo</a></td>
                              </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      @if($order->curtains)
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                  <div class="card-header card-header-primary">
                      <h4 class="card-title">Productos ({{count($order->curtains)}})</h4>
                      {{--<p class="card-category"> Here you can manage users</p>--}}
                  </div>
                  <div class="card-body">
                      <div class="table-responsive">
                          <table class="table">
                              <thead class=" text-primary">
                              <tr>
                                  <th>
                                      Modelo
                                  </th>
                                  <th>
                                      Cubierta
                                  </th>
                                  <th>
                                      Mecanismo
                                  </th>
                                  <th>
                                      Ancho
                                  </th>
                                  <th>
                                      Caída
                                  </th>
                                  <th>
                                      Manivela
                                  </th>
                                  <th>
                                      Control
                                  </th>
                                  <th>
                                      Tejadillo
                                  </th>
                                  <th>
                                        Cantidad
                                  </th>
                                  <th class="text-right">
                                      Precio
                                  </th>

                              </tr></thead>
                              <tbody>
                              @foreach($order->curtains as $curtain)
                              <tr>
                                  <td>{{$curtain->model->name}}</td>
                                  <td>{{$curtain->cover->name}}</td>
                                  <td>{{$curtain->mechanism->name}}</td>
                                  <td>{{$curtain->width}}</td>
                                  <td>{{$curtain->height}}</td>
                                  <td>{{$curtain->handle->measure}}</td>
                                  <td>{{$curtain->control->name}}</td>
                                  <td>Si</td>
                                  <td>{{$curtain->quantity}}</td>
                                  <td class="text-right">${{number_format($curtain->price, 2)}}</td>

                              </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      @endif
      <div class="modal fade" id="authorizeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Autorizar orden</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      Autorizar orden y enviar a producción?
                  </div>
                  <div class="modal-footer">
                      <a class="btn btn-primary" href="{{route('orders.production', $order->id)}}" data-original-title="" title="">
                          Autorizar
                      </a>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
    @endsection

