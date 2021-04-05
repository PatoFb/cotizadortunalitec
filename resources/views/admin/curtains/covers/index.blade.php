@extends('layouts.app', ['activePage' => 'cubiertas_cortina', 'titlePage' => __('Cubiertas')])

@section('content')
<div class="content">
    @include('alerts.success')
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Cubiertas</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 text-right">
                        <a href="{{route('covers.create')}}" class="btn btn-sm btn-primary">Agregar cubierta</a>
                    </div>
                </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Ancho de rollo</th>
                        <th class="text-center">Uniones</th>
                        <th class="text-center">Precio</th>
                        <th class="text-right">
                            Acciones
                        </th>
                  </tr></thead>
                  <tbody>
                  @if($covers)
                      @foreach($covers as $cover)
                  <tr>
                        <td class="text-center">{{$cover->id}}</td>
                        <td class="text-center">{{$cover->name}}</td>
                      <td class="text-center">{{$cover->roll_width}}</td>
                      <td class="text-center">{{$cover->unions}}</td>
                        <td class="text-center">${{number_format($cover->price, 2)}}</td>
                        <td class="td-actions text-right">
                            <a rel="tooltip" class="btn btn-success btn-link" href="{{route('covers.edit', $cover->id)}}" data-original-title="" title="">
                              <i class="material-icons">edit</i>
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

