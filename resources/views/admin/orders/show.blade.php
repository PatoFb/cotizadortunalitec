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
                      @if($order->activity == 'Produccion' && $role == 1)
                          <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#closeModal" id="close_order_modal">
                              Cerrar pedido
                          </button>
                      @endif
                      @if($order->activity == 'Pedido' && $role == 1)
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
                                  <td class="text-right">
                                      @if($order->file != null)
                                          <a href="{{route('orders.download', $order->id)}}"> Descargar archivo</a>
                                      @else
                                      Sin comprobante
                                          @endif
                                  </td>
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
                          <h4 class="card-title">Cortinas ({{count($order->curtains) + count($order->screenies)}})</h4>
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
                                          <td>@if($curtain->cover) {{$curtain->cover->name}} @else Cubierta descontinuada @endif</td>
                                          <td>{{$curtain->mechanism->name}}</td>
                                          <td>{{$curtain->width}} m</td>
                                          <td>{{$curtain->height}} m</td>
                                          <td>{{$curtain->quantity}}</td>
                                          <td class="text-right">${{number_format($curtain->price, 2)}}</td>

                                      </tr>
                                      <div class="modal fade" id="curtainDetailsModal{{$curtain->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                      </button>
                                                  </div>
                                                  <div class="modal-body">
                                                      <h5><strong>Estructura</strong></h5>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Modelo:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$curtain->model->name}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Cubierta:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>@if($curtain->cover) {{$curtain->cover->name}} @else Cubierta descontinuada @endif</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Mecanismo:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$curtain->mechanism->name}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Ancho:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$curtain->width}} m</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Caída:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$curtain->height}} m</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <h5><strong>Accesorios</strong></h5>
                                                      @if($curtain->canopy_id == 1)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Tejadillo:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>X</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($curtain->handle && $curtain->handle_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Manivela:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$curtain->handle->measure}}</strong>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Cantidad:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$curtain->handle_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($curtain->control && $curtain->control_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Control:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$curtain->control->name}}</strong>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Cantidad:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$curtain->control_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($curtain->voice && $curtain->voice_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Control de voz:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$curtain->voice->name}}</strong>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Cantidad:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$curtain->voice_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($curtain->sensor && $curtain->sensor_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Sensor:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$curtain->sensor->name}}</strong>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Cantidad:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$curtain->sensor_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      <h5><strong>Precios</strong></h5>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Precio unitario:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>${{number_format($curtain->price/$curtain->quantity, 2)}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Cantidad:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$curtain->quantity}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Total:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>${{number_format($curtain->price, 2)}}</strong>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  @endforeach
                                  @foreach($order->screenies as $screeny)
                                      <tr>
                                          <td>{{$screeny->model->name}}</td>
                                          <td>@if($screeny->cover) {{$screeny->cover->name}} @else Cubierta descontinuada @endif</td>
                                          <td>{{$screeny->mechanism->name}}</td>
                                          <td>{{$screeny->width}} m</td>
                                          <td>{{$screeny->height}} m</td>
                                          <td>{{$screeny->quantity}}</td>
                                          <td class="text-right">${{number_format($screeny->price, 2)}}</td>

                                      </tr>
                                      <div class="modal fade" id="screenyDetailsModal{{$screeny->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                      </button>
                                                  </div>
                                                  <div class="modal-body">
                                                      <h5><strong>Estructura</strong></h5>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Modelo:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$screeny->model->name}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Cubierta:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>@if($screeny->cover) {{$screeny->cover->name}} @else Cubierta descontinuada @endif</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Mecanismo:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$screeny->mechanism->name}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Ancho:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$screeny->width}} m</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Caída:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$screeny->height}} m</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <h5><strong>Accesorios</strong></h5>
                                                      @if($screeny->canopy_id == 1)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Tejadillo:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>X</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($screeny->handle && $screeny->handle_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Manivela:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$screeny->handle->measure}}</strong>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Cantidad:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$screeny->handle_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($screeny->control && $screeny->control_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Control:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$screeny->control->name}}</strong>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Cantidad:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$screeny->control_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($screeny->voice && $screeny->voice_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Control de voz:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$screeny->voice->name}}</strong>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Cantidad:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$screeny->voice_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($screeny->sensor && $screeny->sensor_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Sensor:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$screeny->sensor->name}}</strong>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Cantidad:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$screeny->sensor_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      <h5><strong>Precios</strong></h5>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Precio unitario:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>${{number_format($screeny->price/$screeny->quantity, 2)}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Cantidad:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$screeny->quantity}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Total:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>${{number_format($screeny->price, 2)}}</strong>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  @endforeach
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      @endif
      @if($order->palillerias)
          <div class="row">
              <div class="col-md-12">
                  <div class="card">
                      <div class="card-header card-header-primary">
                          <h4 class="card-title">Palillerias ({{count($order->palillerias)}})</h4>
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
                                          Salida
                                      </th>
                                      <th>
                                          Cantidad
                                      </th>
                                      <th class="text-right">
                                          Precio
                                      </th>

                                  </tr></thead>
                                  <tbody>
                                  @foreach($order->palillerias as $p)
                                      <tr>
                                          <td>{{$p->model->name}}</td>
                                          <td>@if($p->cover) {{$p->cover->name}} @else Cubierta descontinuada @endif</td>
                                          <td>{{$p->mechanism->name}}</td>
                                          <td>{{$p->width}} m</td>
                                          <td>{{$p->height}} m</td>
                                          <td>{{$p->quantity}}</td>
                                          <td class="text-right">${{number_format($p->price, 2)}}</td>

                                      </tr>
                                      <div class="modal fade" id="pDetailsModal{{$p->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                      </button>
                                                  </div>
                                                  <div class="modal-body">
                                                      <h5><strong>Estructura</strong></h5>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Modelo:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$p->model->name}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Cubierta:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>@if($p->cover) {{$p->cover->name}} @else Cubierta descontinuada @endif</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Mecanismo:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$p->mechanism->name}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Acho:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$p->width}} m</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Proyección:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$p->height}} m</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <h5><strong>Accesorios</strong></h5>
                                                      @if($p->control && $p->control_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Control:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$p->control->name}}</strong>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Cantidad:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$p->control_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($p->voice && $p->voice_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Control de voz:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$p->voice->name}}</strong>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Cantidad:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$p->voice_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($p->sensor && $p->sensor_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Sensor:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$p->sensor->name}}</strong>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Cantidad:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$p->sensor_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      <h5><strong>Refuerzos</strong></h5>
                                                      @if($p->reinforcement_id == 1 && $p->reinforcement_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Guía+
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$p->reinforcement_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($p->trave == 1 && $p->trave_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Travesaño+
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$p->trave_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($p->semigoal == 1 && $p->semigoal_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Semiporterías+
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$p->semigoal_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($p->goal == 1 && $p->goal_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Porterías+
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$p->goal_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      <h5><strong>Precios</strong></h5>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Precio unitario:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>${{number_format($p->price/$p->quantity, 2)}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Cantidad:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$p->quantity}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Total:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>${{number_format($p->price, 2)}}</strong>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                  @endforeach
                                  </tbody>
                              </table>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      @endif
      @if($order->toldos)
          <div class="row">
              <div class="col-md-12">
                  <div class="card">
                      <div class="card-header card-header-primary">
                          <h4 class="card-title">Toldos ({{count($order->toldos)}})</h4>
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
                                          Proyección
                                      </th>
                                      <th>
                                          Cantidad
                                      </th>
                                      <th class="text-right">
                                          Precio
                                      </th>

                                  </tr></thead>
                                  <tbody>
                                  @foreach($order->toldos as $toldo)
                                      <tr>
                                          <td>{{$toldo->model->name}}</td>
                                          <td>@if($toldo->cover) {{$toldo->cover->name}} @else Cubierta descontinuada @endif</td>
                                          <td>{{$toldo->mechanism->name}}</td>
                                          <td>{{$toldo->width}} m</td>
                                          <td>{{$toldo->projection}} m</td>
                                          <td>{{$toldo->quantity}}</td>
                                          <td class="text-right">${{number_format($toldo->price, 2)}}</td>

                                      </tr>
                                      <div class="modal fade" id="toldoDetailsModal{{$toldo->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                      </button>
                                                  </div>
                                                  <div class="modal-body">
                                                      <h5><strong>Estructura</strong></h5>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Modelo:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$toldo->model->name}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Cubierta:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>@if($toldo->cover) {{$toldo->cover->name}} @else Cubierta descontinuada @endif</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Mecanismo:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$toldo->mechanism->name}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Acho:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$toldo->width}} m</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Proyección:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$toldo->projection}} m</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <h5><strong>Accesorios</strong></h5>
                                                      @if($toldo->bambalina == 1)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Bambalina:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>X</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($toldo->canopy_id == 1)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Tejadillo:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>X</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($toldo->handle && $toldo->handle_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Manivela:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$toldo->handle->measure}}</strong>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Cantidad:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$toldo->handle_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($toldo->control && $toldo->control_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Control:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$toldo->control->name}}</strong>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Cantidad:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$toldo->control_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($toldo->voice && $toldo->voice_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Control de voz:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$toldo->voice->name}}</strong>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Cantidad:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$toldo->voice_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      @if($toldo->sensor && $toldo->sensor_quantity > 0)
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Sensor:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$toldo->sensor->name}}</strong>
                                                              </div>
                                                          </div>
                                                          <div class="row">
                                                              <div class="col-6 text-center">
                                                                  Cantidad:
                                                              </div>
                                                              <div class="col-6 text-center">
                                                                  <strong>{{$toldo->sensor_quantity}}</strong>
                                                              </div>
                                                          </div>
                                                          <hr>
                                                      @endif
                                                      <h5><strong>Precios</strong></h5>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Precio unitario:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>${{number_format($toldo->price/$toldo->quantity, 2)}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Cantidad:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$toldo->quantity}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Total:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>${{number_format($toldo->price, 2)}}</strong>
                                                          </div>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
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
      <div class="modal fade" id="closeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Cerrar pedido</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      Confirmar el pedido como cerrado?
                  </div>
                  <div class="modal-footer">
                      <a class="btn btn-primary" href="{{route('orders.close', $order->id)}}" data-original-title="" title="">
                          Autorizar
                      </a>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
    @endsection

