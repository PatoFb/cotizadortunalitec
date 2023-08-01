@extends('layouts.app', ['activePage' => 'allorders', 'titlePage' => __('Mis ordenes')])

@section('content')
<div class="content">
    @include('alerts.success')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
                <ul class="nav nav-tabs" id="orders-list" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#ofertas" role="tab" aria-controls="ofertas" aria-selected="true">Ofertas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pedidos" role="tab" aria-controls="pedidos" aria-selected="false">Pedidos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#produccion" role="tab" aria-controls="produccion" aria-selected="false">Producción</a>
                    </li>
                </ul>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                <div class="tab-content mt-3">
                    <div class="tab-pane" id="pedidos" role="tabpanel" aria-labelledby="pedidos-tab">
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr><th>
                            Folio
                        </th>
                        <th>
                            Usuario
                        </th>
                    <th>
                      Proyecto
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
                      @if($order->user)
                          <td>{{$order->user->name}}</td>
                      @else
                          <td>Sin usuario</td>
                      @endif
                        <td>{{$order->project}}</td>
                      <td>${{number_format($order->price, 2)}}</td>
                      <td>{{$order->discount}}%</td>
                      <td>${{number_format($order->total, 2)}}</td>
                        <td class="text-right">
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
                    <div class="tab-pane active" id="ofertas" role="tabpanel" aria-labelledby="ofertas-tab">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                <tr><th>
                                        Folio
                                    </th>
                                    <th>
                                        Usuario
                                    </th>
                                    <th>
                                        Proyecto
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
                                @if($offers)
                                    @foreach($offers as $offer)
                                        <tr>
                                            <td>{{$offer->id}}</td>
                                            @if($offer->user)
                                                <td>{{$offer->user->name}}</td>
                                            @else
                                                <td>Sin usuario</td>
                                            @endif
                                            <td>{{$offer->project}}</td>
                                            <td>${{number_format($offer->price, 2)}}</td>
                                            <td>{{$offer->discount}}%</td>
                                            <td>${{number_format($offer->total, 2)}}</td>
                                            <td class="text-right">
                                                <a rel="tooltip" class="btn btn-info btn-link" href="{{route('orders.show', $offer->id)}}" data-original-title="" title="">
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
                    <div class="tab-pane" id="produccion" role="tabpanel" aria-labelledby="produccion-tab">
                        <div class="table-responsive">
                            <table class="table">
                                <thead class=" text-primary">
                                <tr><th>
                                        Folio
                                    </th>
                                    <th>
                                        Usuario
                                    </th>
                                    <th>
                                        Proyecto
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
                                @if($prods)
                                    @foreach($prods as $prod)
                                        <tr>
                                            <td>{{$prod->id}}</td>
                                            @if($prod->user)
                                                <td>{{$prod->user->name}}</td>
                                            @else
                                                <td>Sin usuario</td>
                                            @endif
                                            <td>{{$prod->project}}</td>
                                            <td>${{number_format($prod->price, 2)}}</td>
                                            <td>{{$prod->discount}}%</td>
                                            <td>${{number_format($prod->total, 2)}}</td>
                                            <td class="text-right">
                                                <a rel="tooltip" class="btn btn-info btn-link" href="{{route('orders.show', $prod->id)}}" data-original-title="" title="">
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
  </div>
</div>
    @endsection

