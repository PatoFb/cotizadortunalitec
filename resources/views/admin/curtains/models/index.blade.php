@extends('layouts.app', ['activePage' => 'modelos_cortina', 'titlePage' => __('Modelos')])

@section('content')
<div class="content">
    @include('alerts.success')
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Modelos</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 text-right">
                        <a href="{{route('models.create')}}" class="btn btn-sm btn-primary">Agregar modelo</a>
                    </div>
                </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr>
                        <th class="text-center">Imagen</th>
                        <th class="text-center">Nombre</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Res max vs viento</th>
                        <th class="text-center">Tiempo Prod</th>
                        <th class="text-center">Ancho máximo</th>
                        <th class="text-center">Caída máxima</th>
                        <th class="text-center">Precio</th>
                        <th class="text-right">
                            Acciones
                        </th>
                  </tr></thead>
                  <tbody>
                  @if($models)
                      @foreach($models as $model)
                  <tr>
                      <td>
                          @if($model->photo == '')
                              <span class="avatar avatar-sm rounded-circle">
                                <img src="{{asset('material')}}/img/defaut-avatar.png" alt="" style="max-width: 80px; border-radiu: 100px">
                            </span>
                          @else
                              <span class="avatar avatar-sm rounded-circle">
                                <img src="{{asset('storage')}}/images/{{$model->photo}}" alt="" style="max-width: 80px; border-radiu: 100px">
                            </span>
                          @endif
                      </td>
                        <td class="text-center">{{$model->name}}</td>
                      <td class="text-center">{{$model->type->name}}</td>
                      <td class="text-center">{{$model->max_resistance}}</td>
                      <td class="text-center">{{$model->production_time}}</td>
                      <td class="text-center">{{$model->max_width}}</td>
                      <td class="text-center">{{$model->max_height}}</td>
                        <td class="text-center">${{number_format($model->base_price, 2)}}</td>
                        <td class="td-actions text-right">
                            <a rel="tooltip" class="btn btn-success btn-link" href="{{route('models.edit', $model->id)}}" data-original-title="" title="">
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

