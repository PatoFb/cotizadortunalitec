@extends('layouts.app', ['activePage' => 'myorders', 'titlePage' => __('Mis ordenes')])

@section('content')
<div class="content">
    @include('alerts.success')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Mis ordenes</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 text-right">
                        <a href="{{route('orders.new')}}" class="btn btn-sm btn-primary">Nueva orden</a>
                    </div>
                </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr><th>
                        ID
                    </th>
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
                        <th>
                            Total
                        </th>
                    <th class="text-right">
                      Detalles
                    </th>
                  </tr></thead>
                  <tbody>
                  @if($orders)
                      @foreach($orders as $order)
                  <tr>
                        <td>{{$order->id}}</td>
                        <td>{{$order->project}}</td>
                        <td>{{$order->activity}}</td>
                      <td>${{number_format($order->price, 2)}}</td>
                      <td>{{$order->discount}}%</td>
                      <td>${{number_format($order->total, 2)}}</td>
                        <td class="td-actions text-right">
                            <a rel="tooltip" class="btn btn-info btn-link" href="{{route('orders.show', $order->id)}}" data-original-title="" title="">
                              <i class="material-icons">arrow_forward_ios</i>
                              <div class="ripple-container"></div>
                            </a>
                        </td>
                      </tr>
                      @endforeach
                  @endif
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

