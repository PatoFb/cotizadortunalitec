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
                          <a href="{{route('orders.type', $order->id)}}" class="btn btn-sm btn-primary" >Agregar producto</a>
                          <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal" id="edit_order_modal">
                              Editar Orden
                              </button>
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
                                  <th class="text-right">
                                      Eliminar
                                  </th>
                              </tr></thead>
                              <tbody>
                              <tr>
                                  <td>{{$order->project}}</td>
                                  <td>{{$order->activity}}</td>
                                  <td>${{number_format($order->price, 2)}}</td>
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
                                      Acciones
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

