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
                                      Precio
                                  </th>
                                  <th>
                                      Descuento
                                  </th>
                                  <th class="text-right">
                                      Total
                                  </th>
                                  @if($order->activity == "Pedido")
                                      <th class="text-right">
                                          Acciones
                                      </th>
                                  @endif
                              </tr></thead>
                              <tbody>
                              <tr>
                                  <td>{{$order->project}}</td>
                                  <td>{{$order->activity}}</td>
                                  <td>${{number_format($order->price, 2)}}</td>
                                  <td>{{$order->discount}}%</td>
                                  <td class="text-right">${{number_format($order->total, 2)}}</td>
                                  @if($order->activity == "Pedido")
                                      <td class="td-actions text-right">
                                          <button type="button" class="btn btn-success btn-link" data-toggle="modal" data-target="#sendModal">Enviar</button>
                                      </td>
                                  @endif
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
                                  <th class="text-right">
                                      Eliminar
                                  </th>

                              </tr></thead>
                              <tbody>
                              @foreach($order->curtains as $curtain)
                              <tr>
                                  <td>{{$curtain->model->name}}</td>
                                  <td>{{$curtain->cover->name}}</td>
                                  <td>{{$curtain->width}}</td>
                                  <td>{{$curtain->height}}</td>
                                  <td>{{$curtain->handle->measure}}</td>
                                  <td>{{$curtain->control->name}}</td>
                                  <td>${{number_format($curtain->canopy->price, 2)}}</td>
                                  <td>{{$curtain->quantity}}</td>
                                  <td class="text-right">${{number_format($curtain->price, 2)}}</td>
                                      <td class="td-actions text-right">
                                          <button type="button" class="btn btn-danger btn-link" data-toggle="modal" data-target="#deleteModal">
                                              <i class="material-icons">delete</i>
                                              <div class="ripple-container"></div></button>
                                      </td>

                              </tr>
                              <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Eliminar producto</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                              Seguro que desea eliminar el producto de su order? Esta acción es irreversible.
                                          </div>
                                          <div class="modal-footer">
                                              {!! Form::open(['method'=>'DELETE', 'action'=>['App\Http\Controllers\CurtainsController@destroy', $curtain->id]]) !!}
                                              {!! Form::submit('Eliminar', ['class'=>'btn btn-danger']) !!}
                                              {!! Form::close() !!}
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
      <div class="modal fade" id="sendModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Enviar orden</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      Seguro que desea enviar su orden a Tunalitec? Pasará a revisión y un colaborador se pondrá en contacto con usted.
                  </div>
                  <div class="modal-footer">
                      <a class="btn btn-success" href="{{route('orders.send', $order->id)}}" data-original-title="" title="">
                          Enviar
                      </a>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>
    @endsection

