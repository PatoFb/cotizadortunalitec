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
                      <h4 class="card-title">Cortinas ({{count($order->curtains)}})</h4>
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
                                      <th class="text-right">
                                          Acciones
                                      </th>

                                  </tr></thead>
                                  <tbody>
                                  @foreach($order->toldos as $toldo)
                                      <tr>
                                          <td>{{$toldo->model->name}}</td>
                                          <td>{{$toldo->cover->name}}</td>
                                          <td>{{$toldo->mechanism->name}}</td>
                                          <td>{{$toldo->width}}</td>
                                          <td>{{$toldo->projection}}</td>
                                          <td>{{$toldo->quantity}}</td>
                                          <td class="text-right">${{number_format($toldo->price, 2)}}</td>
                                          <td class="td-actions text-right">
                                              <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#toldoDetailsModal{{$toldo->id}}" id="toldo_details_modal">
                                                  Ver detalle
                                              </button>
                                          </td>
                                      </tr>
                                      <div class="modal fade" id="toldoDetailsModal{{$toldo->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog modal-lg mdal modal-dialog-scrollable" role="document">
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
                                                              <strong>{{$toldo->cover->name}}</strong>
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
                                                              <strong>{{$toldo->width}}</strong>
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Proyección:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>{{$toldo->projection}}</strong>
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
                                                      @if($toldo->handle_id && $toldo->handle_quantity != 0)
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
                                                      @if($toldo->control && $toldo->control_quantity != 0)
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
                                                      @if($toldo->voice && $toldo->voice_quantity != 0)
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
                                                      @if($toldo->sensor && $toldo->sensor_quantity != 0)
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
  </div>
</div>
    @endsection

