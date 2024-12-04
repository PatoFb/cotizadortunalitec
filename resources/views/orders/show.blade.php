@extends('layouts.app', ['activePage' => 'myorders', 'titlePage' => __('Mis proyectos')])

@section('content')
<div class="content">
    @include('alerts.success')
    @include('alerts.error')
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
          <div class="col-md-12">
              <div class="card">
                  <div class="card-header card-header-primary">
                      <h4 class="card-title">Proyecto {{$order->id}}</h4>
                      {{--<p class="card-category"> Here you can manage users</p>--}}
                  </div>
                  <div class="card-body">
                      <div class="form-row float-right">
                          @if($order->activity == 'Produccion' && $role == 1)
                              <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#closeModal" id="close_order_modal">
                                  Cerrar pedido
                              </button>
                              <a class="btn btn-danger btn-sm" href="{{route('orders.cancel', $order->id)}}" data-original-title="" title="">
                                  Cancelar
                              </a>
                              <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#fileModal" id="file_order_modal">
                                  Agregar comprobante
                              </button>
                              @if($order->file)
                                  <a class="btn btn-sm btn-info" href="{{route('orders.download', $order->id)}}">
                                      Descargar comprobante
                                  </a>
                              @endif
                          @endif
                          @if($order->activity == 'Pedido')
                                  <a class="btn btn-success btn-sm" target="_blank" href="{{route('orders.generate', $order->id)}}" data-original-title="" title="">
                                      Generar PDF
                                  </a>
                              @if($role == 1)
                                  <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#authorizeModal" id="authorize_order_modal">
                                      Enviar a producción
                                  </button>
                              @endif
                          <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#fileModal" id="file_order_modal">
                              Agregar comprobante
                          </button>
                                  @if($order->file)
                                      <a class="btn btn-sm btn-info" href="{{route('orders.download', $order->id)}}">
                                          Descargar comprobante
                                      </a>
                                  @endif
                          @endif
                              @if($order->activity == 'Oferta')
                                  <a class="btn btn-success btn-sm" target="_blank" href="{{route('orders.generate', $order->id)}}" data-original-title="" title="">
                                      Generar PDF
                                  </a>
                          <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal" id="edit_order_modal">
                              Editar Proyecto
                          </button>
                          <a href="{{route('orders.type', $order->id)}}" class="btn btn-sm btn-primary" >Agregar producto</a>
                                  <!--<button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#makeOrderModal" id="make_order_modal">
                                      Hacer Pedido
                                  </button>-->
                              @endif
                      </div>
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
                                      Descuento
                                  </th>
                                  <th class="text-right">
                                      Paquetería
                                  </th>
                                  <th class="text-right">
                                      Total
                                  </th>
                                  @if($order->activity == 'Oferta')
                                  <th class="text-right">
                                      Eliminar
                                  </th>
                                      @endif
                              </tr></thead>
                              <tbody>
                              <tr>
                                  <td>{{$order->project}}</td>
                                  <td>{{$order->user->name}}</td>
                                  <td>{{$order->activity}}</td>
                                  <td>{{$order->discount}}%</td>
                                  <td class="text-right">${{number_format($order->total_packages + $order->insurance, 2)}}</td>
                                  <td class="text-right">${{number_format($order->total, 2)}}</td>
                                  @if($order->activity == 'Oferta')
                                  <td class="td-actions text-right">
                                      <button type="button" class="btn btn-danger btn-link" data-toggle="modal" data-target="#deleteOrderModal" id="delete_order_modal">
                                          <i class="material-icons">delete</i>
                                          <div class="ripple-container"></div></button>
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
      @if(count($order->curtains) > 0)
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
                                          <button type="button" class="btn btn-link btn-info" data-toggle="modal" data-target="#curtainDetailsModal{{$curtain->id}}" id="curtain_details_modal">
                                              <i class="material-icons">info</i>
                                              <div class="ripple-container"></div></button>
                                          @if($order->activity == "Oferta")
                                              <a class="btn btn-info btn-link" href="{{route('curtains.edit', $curtain->id)}}">
                                                  <i class="material-icons">edit_square</i>
                                                  <div class="ripple-container"></div>
                                              </a>
                                              <a class="btn btn-success btn-link" href="{{route('curtain.copy', $curtain->id)}}">
                                                  <i class="material-icons">content_copy</i>
                                                  <div class="ripple-container"></div>
                                              </a>
                                          <button type="button" class="btn btn-danger btn-link" data-toggle="modal" data-target="#deleteModal{{$curtain->id}}" id="delete_product_modal">
                                              <i class="material-icons">delete</i>
                                              <div class="ripple-container"></div></button>
                                              @endif
                                      </td>

                              </tr>

                                  @endforeach

                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
      </div>
          @foreach($order->curtains as $curtain)
              <div class="modal fade" id="curtainDetailsModal{{$curtain->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 1050;">
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
                              <br>
                              <h5><strong>Accesorios</strong></h5>
                              @if($curtain->canopy == 1)
                                  <div class="row">
                                      <div class="col-6 text-center">
                                          Tejadillo:
                                      </div>
                                      <div class="col-6 text-center">
                                          <strong>Si</strong>
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
                                          <strong>{{$curtain->handle->measure}} m</strong>
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
                              <br>
                                  <h5><strong>Datos para producción</strong></h5>
                                  <div class="row">
                                      <div class="col-6 text-center">
                                          Tipo de instalación:
                                      </div>
                                      <div class="col-6 text-center">
                                          @if($curtain->installation_type)
                                            <strong>{{$curtain->installation_type}}</strong>
                                          @else
                                              <strong class="text-danger">Faltante</strong>
                                          @endif
                                      </div>
                                  </div>
                                  <hr>
                                  <div class="row">
                                      <div class="col-6 text-center">
                                          Lado del mecanismo:
                                      </div>
                                      <div class="col-6 text-center">
                                          @if($curtain->mechanism_side)
                                              <strong>{{$curtain->mechanism_side}}</strong>
                                          @else
                                              <strong class="text-danger">Faltante</strong>
                                          @endif
                                      </div>
                                  </div>
                                  <hr>
                                  <br>
                              <h5><strong>Precios</strong></h5>
                              <div class="row">
                                  <div class="col-6 text-center">
                                      Precio unitario:
                                  </div>
                                  <div class="col-6 text-center">
                                      <strong>${{number_format($curtain->systems_total/$curtain->quantity, 2)}}</strong>
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
                                      Accesorios:
                                  </div>
                                  <div class="col-6 text-center">
                                      <strong>${{number_format($curtain->accessories_total, 2)}}</strong>
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
              <div class="modal fade" id="deleteModal{{$curtain->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Eliminar producto</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                              </button>
                          </div>
                          <div class="modal-body">
                              Seguro que desea eliminar el producto de su proyecto? Esta acción es irreversible.
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
      @endif
      @if(count($order->palillerias) > 0)
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
                                              <button type="button" class="btn btn-link btn-info" data-toggle="modal" data-target="#pDetailsModal{{$p->id}}" id="p_details_modal">
                                                  <i class="material-icons">info</i>
                                                  <div class="ripple-container"></div></button>
                                              @if($order->activity == "Oferta")
                                                  <a class="btn btn-info btn-link" href="{{route('palillerias.edit', $p->id)}}">
                                                      <i class="material-icons">edit_square</i>
                                                      <div class="ripple-container"></div>
                                                  </a>
                                                  <a class="btn btn-success btn-link" href="{{route('palilleria.copy', $p->id)}}">
                                                      <i class="material-icons">content_copy</i>
                                                      <div class="ripple-container"></div>
                                                  </a>
                                                  <button type="button" class="btn btn-danger btn-link" data-toggle="modal" data-target="#pDeleteModal{{$p->id}}" id="delete_product_modal">
                                                      <i class="material-icons">delete</i>
                                                      <div class="ripple-container"></div></button>
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
                                                      <br>
                                                      <h5><strong>Datos para producción</strong></h5>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Inclinación:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              @if($p->inclination)
                                                                  <strong>{{$p->inclination}}</strong>
                                                              @else
                                                                  <strong class="text-danger">Faltante</strong>
                                                              @endif
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Altura de porterías:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              @if($p->goal_height != 0)
                                                                  <strong>{{$p->goal_height}}</strong>
                                                              @else
                                                                  <strong class="text-danger">Faltante</strong>
                                                              @endif
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <br>
                                                      <h5><strong>Precios</strong></h5>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Precio unitario:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>${{number_format($p->systems_total/$p->quantity, 2)}}</strong>
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
                                                              Accesorios:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>${{number_format($p->accessories_total, 2)}}</strong>
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
                                      <div class="modal fade" id="pDeleteModal{{$p->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
      @if(count($order->toldos) > 0)
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
                                              <button type="button" class="btn btn-link btn-info" data-toggle="modal" data-target="#tDetailsModal{{$toldo->id}}" id="curtain_details_modal">
                                                  <i class="material-icons">info</i>
                                                  <div class="ripple-container"></div></button>
                                              @if($order->activity == "Oferta")
                                                  <a class="btn btn-info btn-link" href="{{route('toldos.edit', $toldo->id)}}">
                                                      <i class="material-icons">edit_square</i>
                                                      <div class="ripple-container"></div>
                                                  </a>
                                                  <a class="btn btn-success btn-link" href="{{route('toldo.copy', $toldo->id)}}">
                                                      <i class="material-icons">content_copy</i>
                                                      <div class="ripple-container"></div>
                                                  </a>
                                                  <button type="button" class="btn btn-danger btn-link" data-toggle="modal" data-target="#tDeleteModal{{$toldo->id}}" id="delete_product_modal">
                                                      <i class="material-icons">delete</i>
                                                      <div class="ripple-container"></div></button>
                                              @endif
                                          </td>

                                      </tr>
                                      <div class="modal fade" id="tDetailsModal{{$toldo->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                      <br>
                                                      <h5><strong>Datos para producción</strong></h5>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Tipo de instalación:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              @if($toldo->installation_type)
                                                                  <strong>{{$toldo->installation_type}}</strong>
                                                              @else
                                                                  <strong class="text-danger">Faltante</strong>
                                                              @endif
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Lado del mecanismo:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              @if($toldo->mechanism_side)
                                                                  <strong>{{$toldo->mechanism_side}}</strong>
                                                              @else
                                                                  <strong class="text-danger">Faltante</strong>
                                                              @endif
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Tipo de bambalina:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              @if($toldo->bambalina_type)
                                                                  <strong>{{$toldo->bambalina_type}}</strong>
                                                              @else
                                                                  <strong class="text-danger">Faltante</strong>
                                                              @endif
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                                Inclinación:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              @if($toldo->inclination)
                                                                  <strong>{{$toldo->inclination}}</strong>
                                                              @else
                                                                  <strong class="text-danger">Faltante</strong>
                                                              @endif
                                                          </div>
                                                      </div>
                                                      <hr>
                                                      <br>
                                                      <h5><strong>Precios</strong></h5>
                                                      <div class="row">
                                                          <div class="col-6 text-center">
                                                              Precio unitario:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>${{number_format($toldo->systems_total/$toldo->quantity, 2)}}</strong>
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
                                                              Accesorios:
                                                          </div>
                                                          <div class="col-6 text-center">
                                                              <strong>${{number_format($toldo->accessories_total, 2)}}</strong>
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
                                      <div class="modal fade" id="tDeleteModal{{$toldo->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                      <h5 class="modal-title" id="exampleModalLabel">Enviar proyecto</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      Seguro que desea enviar su proyecto a Solair? Pasará a revisión y un colaborador se pondrá en contacto con usted.
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
                    <h5 class="modal-title" id="exampleModalLabel">Editar Proyecto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::model($order, ['method'=>'PUT', 'action'=>['App\Http\Controllers\OrdersController@update', $order->id]]) !!}
                        <div class="row">
                    <div class="col-md-6 col-sm-12">
                        {!! Form::label('project', 'Nombre del proyecto:') !!}
                        {!! Form::text('project', null, ['class'=>'form-control']) !!}
                    </div>
                    <br>
                    <div class="col-md-6 col-sm-12">
                        {!! Form::label('discount', 'Descuento:') !!}
                        @if($role == 1)
                            {!! Form::number('discount', null, ['class'=>'form-control', 'step'=>0.1]) !!}
                        @else
                            {!! Form::number('discount', null, ['class'=>'form-control', 'step'=>0.1, 'readonly']) !!}
                        @endif
                    </div>
                        </div>
                    <br>
                    <div class="form-row">
                        <div class="col-12">
                            {!! Form::label('delivery', 'Paquetería:') !!}
                            <select class="form-control" name="delivery" readonly>
                                <option value="1" {{{ ($order->delivery == 1) ? "selected=\"selected\"" : "" }}}>Si</option>
                                <option value="0" {{{ ($order->delivery == 0) ? "selected=\"selected\"" : "" }}}>No</option>
                            </select>
                        </div>
                    </div>
                    <br>
                        <div class="row">
                        <div class="col-sm-12 col-md-12">
                            {!! Form::label('comments', 'Comentarios:') !!}
                            {!! Form::textarea('comments', null, ['class'=>'form-control', 'rows'=>3]) !!}
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="line1">{{ __('Colonia') }}</label>
                            <div class="form-group{{ $errors->has('line1') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('line1') ? ' is-invalid' : '' }}" name="line1" id="input-line1" type="text" placeholder="{{ __('Colonia') }}" value="{{ old('line1', $order->line1) }}" required="true" aria-required="true"/>
                                @if ($errors->has('line1'))
                                    <span id="line1-error" class="error text-danger" for="input-line1">{{ $errors->first('line1') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="line2">{{ __('Calle y número exterior') }}</label>
                            <div class="form-group{{ $errors->has('line2') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('line2') ? ' is-invalid' : '' }}" name="line2" id="input-line2" type="text" placeholder="{{ __('Calle y número') }}" value="{{ old('line2', $order->line2) }}" required />
                                @if ($errors->has('line2'))
                                    <span id="line2-error" class="error text-danger" for="input-line2">{{ $errors->first('line2') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="zip_code">{{ __('Código Postal') }}</label>
                            <div class="form-group{{ $errors->has('zip_code') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('zip_code') ? ' is-invalid' : '' }}" name="zip_code" id="input-zip_code" type="text" placeholder="{{ __('Código Postal') }}" value="{{ old('zip_code', $order->zip_code) }}" required />
                                @if ($errors->has('zip_code'))
                                    <span id="zip_code-error" class="error text-danger" for="input-zip_code">{{ $errors->first('zip_code') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="city">{{ __('Ciudad') }}</label>
                            <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" id="input-city" type="text" placeholder="{{ __('Ciudad') }}" value="{{ old('city', $order->city) }}" required />
                                @if ($errors->has('city'))
                                    <span id="city-error" class="error text-danger" for="input-city">{{ $errors->first('city') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label for="state">{{ __('Estado') }}</label>
                            <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" name="state" id="input-state" type="text" placeholder="{{ __('Estado') }}" value="{{ old('state', $order->state) }}" required />
                                @if ($errors->has('state'))
                                    <span id="state-error" class="error text-danger" for="input-state">{{ $errors->first('state') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="reference">{{ __('Referencia') }}</label>
                            <div class="form-group{{ $errors->has('reference') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}" name="reference" id="input-reference" type="text" placeholder="{{ __('Calle y número') }}" value="{{ old('reference', $order->reference) }}" />
                                @if ($errors->has('reference'))
                                    <span id="reference-error" class="error text-danger" for="input-reference">{{ $errors->first('reference') }}</span>
                                @endif
                            </div>
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
                    <h5 class="modal-title" id="exampleModalLabel">Editar Proyecto</h5>
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
    <div class="modal fade" id="makeOrderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Convertir a pedido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Seguro que desea realizar su pedido? Una vez finalizado, será pasado a revisión por nuestro equipo para ser enviado a producción.
                </div>
                <div class="modal-footer">
                    {!! Form::open(['method'=>'GET', 'action'=>['App\Http\Controllers\OrdersController@makeOrder', $order->id]]) !!}
                    {!! Form::submit('Aceptar', ['class'=>'btn btn-success', 'id'=>'make_order']) !!}
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
                    Seguro que desea eliminar el proyecto? Se eliminarán todos los productos dentro de ella también.
                </div>
                <div class="modal-footer">
                    {!! Form::open(['method'=>'DELETE', 'action'=>['App\Http\Controllers\OrdersController@destroy', $order->id]]) !!}
                    {!! Form::submit('Eliminar', ['class'=>'btn btn-danger', 'id'=>'delete_order']) !!}
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="authorizeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Autorizar Proyecto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Autorizar proyecto y enviar a producción?
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
    @endsection

