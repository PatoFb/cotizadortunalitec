@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Cortina')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8 offset-md-2">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Revisión de sistema (Paso 7 de 7)</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body text-left">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\CurtainsController@reviewPost', $order_id]]) !!}
                <br>
                <h5><strong>Configuración de sistema:</strong></h5>
                <tr class="table-responsive">
                    <table class="table">
                        <tr>
                            <td style="width: 250px">Modelo:</td>
                            <td><strong>{{$curtain->model->name}}</strong></td>
                        </tr>
                        <tr>
                            <td>Cubierta:</td>
                            <td><strong>{{$curtain->cover->name}}</strong></td>
                        </tr>
                        <tr>
                            <td>Mecanismo:</td>
                            <td><strong>{{$curtain->mechanism->name}}</strong></td>
                        </tr>
                        <tr>
                            <td>Ancho:</td>
                            <td><strong>{{$curtain->width}} mts</strong></td>
                        </tr>
                        <tr>
                            <td>Caida:</td>
                            <td><strong>{{$curtain->height}} mts</strong></td>
                        </tr>
                    </table>
                </tr>
                <br>
                <h5><strong>Accesorios:</strong></h5>
                        <tr class="table-responsive">
                            <table class="table">
                        @if($curtain->canopy == 1)
                            <tr>
                                <td style="width: 250px">
                                    Tejadillo:
                                </td>
                                <td>
                                    <strong>Si</strong>
                                </td>
                            </tr>
                        @endif
                        @if($curtain->handle_id != 9999 && $curtain->handle_id != 999 && $curtain->handle_quantity > 0)
                            <tr>
                                <td style="width: 250px">
                                    Manivela:
                                    <br>
                                    Cantidad:
                                </td>
                                <td>
                                    <strong>{{$curtain->handle->measure}} mts</strong>
                                    <br>
                                    <strong>{{$curtain->handle_quantity}}</strong>
                                </td>
                            </tr>
                        @endif
                        @if($curtain->control_id != 9999 && $curtain->control_id != 999 && $curtain->control_quantity > 0)
                            <tr>
                                <td style="width: 250px">
                                    Control:
                                    <br>
                                    Cantidad:
                                </td>
                                <td>
                                    <strong>{{$curtain->control->name}}</strong>
                                    <br>
                                    <strong>{{$curtain->control_quantity}}</strong>
                                </td>
                            </tr>
                        @endif
                        @if($curtain->voice_id != 9999 && $curtain->voice_id != 999 && $curtain->voice_quantity > 0)
                            <tr>
                                <td style="width: 250px">
                                    Control de voz:
                                    <br>
                                    Cantidad:
                                </td>
                                <td>
                                    <strong>{{$curtain->voice->name}}</strong>
                                    <br>
                                    <strong>{{$curtain->voice_quantity}}</strong>
                                </td>
                            </tr>
                        @endif
                            </table>
                        </tr>
                <br>
                <h5><strong>Precio:</strong></h5>
                                <tr class="table-responsive">
                                    <table class="table">
                        <tr>
                            <td style="width: 250px">Precio unitario:</td>
                            <td><strong>${{number_format($curtain->price/$curtain->quantity, 2)}}</strong></td>
                        </tr>
                        <tr>
                            <td style="width: 250px">Cantidad:</td>
                            <td><strong>{{$curtain->quantity}}</strong></td>
                        </tr>
                        <tr>
                            <td style="width: 250px">Total:</td>
                            <td><strong>${{number_format($curtain->price, 2)}}</strong></td>
                        </tr>
                    </table>
                </tr>
                    <div class="mt-4 d-flex justify-content-between">
                        <a href="{{ route('curtain.features', $order_id) }}" class="btn btn-danger">Anterior</a>
                        {!! Form::submit('Guardar', ['class'=>'btn btn-primary', $order_id]) !!}
                        {!! Form::close() !!}
                    </div>

          </div>

</div>
            </div>
      </div>
      <div class="row">
          <div class="col-md-8 offset-md-2">
              <div class="card">
                  <div class="card-header card-header-primary">
                      <h4 class="card-title">Revisión de sistema (Paso 7 de 7)</h4>
                  </div>
                  <div class="card-body">
                      <h5 class="card-title">Configuración de sistema</h5>
                      <p class="card-text">
                          <strong>Modelo:</strong> {{$curtain->model->name}}
                          <br>
                          <strong>Cubierta:</strong> {{$curtain->cover->name}}
                          <br>
                          <strong>Mecanismo:</strong> {{$curtain->mechanism->name}}
                          <br>
                          <strong>Ancho:</strong> {{$curtain->width}} mts
                          <br>
                          <strong>Caída:</strong> {{$curtain->height}} mts
                      </p>
                  </div>
              </div>

              <div class="card mt-3">
                  <div class="card-body">
                      <h5 class="card-title">Accesorios</h5>
                      <ul class="list-group">
                          @if($curtain->canopy == 1)
                              <li class="list-group-item"><strong>Tejadillo: </strong>Si</li>
                          @endif
                          @if($curtain->handle_id != 9999 && $curtain->handle_id != 999 && $curtain->handle_quantity > 0)
                              <li class="list-group-item"><strong>Manivela: </strong>{{$curtain->handle->measure}} mts ({{$curtain->handle_quantity}})</li>
                          @endif
                          @if($curtain->control_id != 9999 && $curtain->control_id != 999 && $curtain->control_quantity > 0)
                              <li class="list-group-item"><strong>Control: </strong>{{$curtain->control->name}} mts ({{$curtain->control_quantity}})</li>
                          @endif
                          @if($curtain->voice_id != 9999 && $curtain->voice_id != 999 && $curtain->voice_quantity > 0)
                              <li class="list-group-item"><strong>Control de voz: </strong>{{$curtain->voice->name}} mts ({{$curtain->voice_quantity}})</li>
                          @endif
                      </ul>
                  </div>
              </div>

              <div class="card mt-3">
                  <div class="card-body">
                      <h5 class="card-title">Precio</h5>
                      <p class="card-text">
                          <strong>Precio unitario:</strong> ${{number_format($curtain->price/$curtain->quantity, 2)}}
                          <br>
                          <strong>Cantidad:</strong> {{$curtain->quantity}}
                          <br>
                          <strong>Total:</strong> ${{number_format($curtain->price, 2)}}
                      </p>
                  </div>
              </div>
              <div class="mt-4 d-flex justify-content-between">
                  <a href="{{ route('curtain.features', $order_id) }}" class="btn btn-danger">Anterior</a>
                  {!! Form::submit('Guardar', ['class'=>'btn btn-primary', $order_id]) !!}
                  {!! Form::close() !!}
              </div>
          </div>
      </div>
    </div>
  </div>
</div>
    @endsection

