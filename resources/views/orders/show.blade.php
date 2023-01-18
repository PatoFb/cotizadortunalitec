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
                          @if($order->activity == 'Pedido')
                          <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#fileModal" id="file_order_modal">
                              Agregar comprobante
                          </button>
                          @endif
                          <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal" id="edit_order_modal">
                              Editar Orden
                          </button>
                          <a href="{{route('orders.type', $order->id)}}" class="btn btn-sm btn-primary" >Agregar producto</a>
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
                                      Descuento
                                  </th>
                                  <th class="text-right">
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
                                  <td>{{$order->discount}}%</td>
                                  <td class="text-right">${{number_format($order->total, 2)}}</td>
                                  <td class="td-actions text-right">
                                      <button type="button" class="btn btn-danger btn-link" data-toggle="modal" data-target="#deleteOrderModal" id="delete_order_modal">
                                          <i class="material-icons">delete</i>
                                          <div class="ripple-container"></div></button>
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
                                  <th class="text-right">
                                      Acciones
                                  </th>

                              </tr></thead>
                              <tbody>
                              @foreach($order->curtains as $curtain)
                              <tr>
                                  <td>{{$curtain->model->name}}</td>
                                  <td>{{$curtain->cover->name}}</td>
                                  <td>{{$curtain->mechanism->name}}</td>
                                  <td>{{$curtain->width}} m</td>
                                  <td>{{$curtain->height}} m</td>
                                  <td>{{$curtain->quantity}}</td>
                                  <td class="text-right">${{number_format($curtain->price, 2)}}</td>
                                      <td class="td-actions text-right">
                                          <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#curtainDetailsModal{{$curtain->id}}" id="curtain_details_modal">
                                              Ver detalle
                                          </button>
                                          <button type="button" class="btn btn-danger btn-link" data-toggle="modal" data-target="#deleteModal" id="delete_product_modal">
                                              <i class="material-icons">delete</i>
                                              <div class="ripple-container"></div></button>
                                          @if($order->activity == "Pedido")
                                              <button type="button" class="btn btn-info btn-link" data-toggle="modal" data-target="#addModal" id="add_data_modal">
                                                  Añadir datos
                                                  </button>
                                              @endif
                                      </td>

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
                                                      <strong>{{$curtain->cover->name}}</strong>
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
                              <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                  <div class="modal-dialog modal-lg" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Agregar datos para pedido</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                              </button>
                                          </div>
                                          <div class="modal-body">
                                              {!! Form::model($curtain, ['method'=>'PUT', 'action'=>['App\Http\Controllers\CurtainsController@addData', $curtain->id]]) !!}
                                              <input name="id" type="hidden" value="{{$curtain->id}}">
                                              <div class="col-12">
                                                  {!! Form::label('installation_type', 'Tipo de instalación:') !!}
                                                  <select class="form-control" name="installation_type">
                                                      <option value="">Selecciona tipo de instalacion</option>
                                                      <option>Pared</option>
                                                      <option>Techo</option>
                                                      <option>Entre muros</option>
                                                  </select>
                                              </div>
                                              <br>
                                              <div class="col-12">
                                                  {!! Form::label('mechanism_side', 'Lado de mecanismo:') !!}
                                                  <select class="form-control" name="mechanism_side" >
                                                      <option value="">Lado del mecanismo</option>
                                                      <option>Izquierdo</option>
                                                      <option>Derecho</option>
                                                  </select>
                                              </div>
                                              <br>
                                              <div class="col-12">
                                                  {!! Form::label('view_type', 'Tipo de vista:') !!}
                                                  <select class="form-control" name="view_type" >
                                                      <option value="">Tipo de vista</option>
                                                      <option>Exterior</option>
                                                      <option>Interior</option>
                                                  </select>
                                              </div>
                                          </div>
                                          <div class="modal-footer">
                                              {!! Form::submit('Aceptar', ['class'=>'btn btn-primary', 'id'=>'add_data']) !!}
                                              {!! Form::close() !!}
                                          </div>
                                      </div>
                                  </div>
                              </div>
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
                                              {!! Form::submit('Eliminar', ['class'=>'btn btn-danger', "id"=>'delete_curtain']) !!}
                                              {!! Form::close() !!}
                                          </div>
                                      </div>
                                  </div>
                              </div>
                                  @endforeach
                              @foreach($order->screenies as $screeny)
                                  <tr>
                                      <td>{{$screeny->model->name}}</td>
                                      <td>{{$screeny->cover->name}}</td>
                                      <td>{{$screeny->mechanism->name}}</td>
                                      <td>{{$screeny->width}} m</td>
                                      <td>{{$screeny->height}} m</td>
                                      <td>{{$screeny->quantity}}</td>
                                      <td class="text-right">${{number_format($screeny->price, 2)}}</td>
                                      <td class="td-actions text-right">
                                          <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#screenyDetailsModal{{$screeny->id}}" id="screeny_details_modal">
                                              Ver detalle
                                          </button>
                                          <button type="button" class="btn btn-danger btn-link" data-toggle="modal" data-target="#deleteModal" id="delete_product_modal">
                                              <i class="material-icons">delete</i>
                                              <div class="ripple-container"></div></button>
                                          @if($order->activity == "Pedido")
                                              <button type="button" class="btn btn-info btn-link" data-toggle="modal" data-target="#addModal" id="add_data_modal">
                                                  Añadir datos
                                              </button>
                                          @endif
                                      </td>

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
                                                          <strong>{{$screeny->cover->name}}</strong>
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
                                  <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                      <div class="modal-dialog modal-lg" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="exampleModalLabel">Agregar datos para pedido</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  {!! Form::model($screeny, ['method'=>'PUT', 'action'=>['App\Http\Controllers\ScreenyCurtainsController@addData', $screeny->id]]) !!}
                                                  <input name="id" type="hidden" value="{{$screeny->id}}">
                                                  <div class="col-12">
                                                      {!! Form::label('installation_type', 'Tipo de instalación:') !!}
                                                      <select class="form-control" name="installation_type">
                                                          <option value="">Selecciona tipo de instalacion</option>
                                                          <option>Pared</option>
                                                          <option>Techo</option>
                                                          <option>Entre muros</option>
                                                      </select>
                                                  </div>
                                                  <br>
                                                  <div class="col-12">
                                                      {!! Form::label('mechanism_side', 'Lado de mecanismo:') !!}
                                                      <select class="form-control" name="mechanism_side" >
                                                          <option value="">Lado del mecanismo</option>
                                                          <option>Izquierdo</option>
                                                          <option>Derecho</option>
                                                      </select>
                                                  </div>
                                                  <br>
                                                  <div class="col-12">
                                                      {!! Form::label('view_type', 'Tipo de vista:') !!}
                                                      <select class="form-control" name="view_type" >
                                                          <option value="">Tipo de vista</option>
                                                          <option>Exterior</option>
                                                          <option>Interior</option>
                                                      </select>
                                                  </div>
                                              </div>
                                              <div class="modal-footer">
                                                  {!! Form::submit('Aceptar', ['class'=>'btn btn-primary', 'id'=>'add_data']) !!}
                                                  {!! Form::close() !!}
                                              </div>
                                          </div>
                                      </div>
                                  </div>
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
                                                  {!! Form::open(['method'=>'DELETE', 'action'=>['App\Http\Controllers\ScreenyCurtainsController@destroy', $screeny->id]]) !!}
                                                  {!! Form::submit('Eliminar', ['class'=>'btn btn-danger', "id"=>'delete_curtain']) !!}
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
                                      <th class="text-right">
                                          Acciones
                                      </th>

                                  </tr></thead>
                                  <tbody>
                                  @foreach($order->palillerias as $p)
                                      <tr>
                                          <td>{{$p->model->name}}</td>
                                          <td>{{$p->cover->name}}</td>
                                          <td>{{$p->mechanism->name}}</td>
                                          <td>{{$p->width}} m</td>
                                          <td>{{$p->height}} m</td>
                                          <td>{{$p->quantity}}</td>
                                          <td class="text-right">${{number_format($p->price, 2)}}</td>
                                          <td class="td-actions text-right">
                                              <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#pDetailsModal{{$p->id}}" id="p_details_modal">
                                                  Ver detalle
                                              </button>
                                              <button type="button" class="btn btn-danger btn-link" data-toggle="modal" data-target="#deletePModal" id="delete_product_modal">
                                                  <i class="material-icons">delete</i>
                                                  <div class="ripple-container"></div></button>
                                              @if($order->activity == "Pedido")
                                                  {{--<button type="button" class="btn btn-info btn-link" data-toggle="modal" data-target="#addModal" id="add_data_modal">
                                                      Añadir datos
                                                  </button>--}}
                                              @endif
                                          </td>

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
                                                              <strong>{{$p->cover->name}}</strong>
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
                                      <div class="modal fade" id="deletePModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">Eliminar Palilleria</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                      </button>
                                                  </div>
                                                  <div class="modal-body">
                                                      Seguro que desea eliminar el producto de su order? Esta acción es irreversible.
                                                  </div>
                                                  <div class="modal-footer">
                                                      {!! Form::open(['method'=>'DELETE', 'action'=>['App\Http\Controllers\PalilleriasController@destroy', $p->id]]) !!}
                                                      {!! Form::submit('Eliminar', ['class'=>'btn btn-danger', "id"=>'delete_palilleria']) !!}
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
                                          <td>{{$toldo->width}} m</td>
                                          <td>{{$toldo->projection}} m</td>
                                          <td>{{$toldo->quantity}}</td>
                                          <td class="text-right">${{number_format($toldo->price, 2)}}</td>
                                          <td class="td-actions text-right">
                                              <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#toldoDetailsModal{{$toldo->id}}" id="toldo_details_modal">
                                                  Ver detalle
                                              </button>
                                              <button type="button" class="btn btn-danger btn-link" data-toggle="modal" data-target="#deleteToldoModal" id="delete_product_modal">
                                                  <i class="material-icons">delete</i>
                                                  <div class="ripple-container"></div></button>
                                              @if($order->activity == "Pedido")
                                                  {{--<button type="button" class="btn btn-info btn-link" data-toggle="modal" data-target="#addModal" id="add_data_modal">
                                                      Añadir datos
                                                  </button>--}}
                                              @endif
                                          </td>

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
                                      <div class="modal fade" id="deleteToldoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                          <div class="modal-dialog" role="document">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h5 class="modal-title" id="exampleModalLabel">Eliminar Toldo</h5>
                                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                          <span aria-hidden="true">&times;</span>
                                                      </button>
                                                  </div>
                                                  <div class="modal-body">
                                                      Seguro que desea eliminar el producto de su order? Esta acción es irreversible.
                                                  </div>
                                                  <div class="modal-footer">
                                                      {!! Form::open(['method'=>'DELETE', 'action'=>['App\Http\Controllers\ToldosController@destroy', $toldo->id]]) !!}
                                                      {!! Form::submit('Eliminar', ['class'=>'btn btn-danger', "id"=>'delete_toldo']) !!}
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
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Orden</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::model($order, ['method'=>'PUT', 'action'=>['App\Http\Controllers\OrdersController@update', $order->id]]) !!}



                    <div class="col-12">
                        {!! Form::label('activity', 'Actividad:') !!}
                        <select class="form-control" name="activity" >
                            <option value="">Selecciona la actividad</option>
                            <option @if($order->activity == "Oferta") selected @endif>Oferta</option>
                            <option @if($order->activity == "Pedido") selected @endif>Pedido</option>
                        </select>
                    </div>
                    <br>
                    <div class="col-12">
                        {!! Form::label('project', 'Nombre del proyecto:') !!}
                        {!! Form::text('project', null, ['class'=>'form-control']) !!}
                    </div>
                    <br>
                    <div class="col-12">
                        {!! Form::label('discount', 'Descuento:') !!}
                        {!! Form::number('discount', null, ['class'=>'form-control', 'step'=>0.1]) !!}
                    </div>


                    <br>
                    <div class="form-group">
                        <div class="col-sm-12 col-md-12">
                            {!! Form::label('comments', 'Comentarios:') !!}
                            {!! Form::textarea('comments', null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    {!! Form::submit('Aceptar', ['class'=>'btn btn-primary pull-right', 'id'=>'edit_order']) !!}


                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="fileModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Orden</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\OrdersController@upload', $order->id], 'files'=>true]) !!}
                    {!! Form::label('photo', 'Archivo (PDF, JPG, JPEG, PNG):') !!}
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <span class="btn btn-raised btn-round btn-primary btn-file">
                            <input type="file" name="file" />
                        </span>
                            {{--<a href="#" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>--}}
                        </div>
                    </div>
                <div class="modal-footer">

                    {!! Form::submit('Subir', ['class'=>'btn btn-primary pull-right', 'id'=>'file_order']) !!}


                    {!! Form::close() !!}
                </div>
        </div>
        </div>
            </div>
    <div class="modal fade" id="deleteOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                    {!! Form::submit('Eliminar', ['class'=>'btn btn-danger', 'id'=>'delete_order']) !!}
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
</div>
    @endsection

