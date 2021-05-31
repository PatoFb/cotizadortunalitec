@extends('layouts.app', ['activePage' => 'paneles_cortina', 'titlePage' => __('Paneles')])

@section('content')
<div class="content">
    @include('alerts.success')
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Paneles</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                                  {!! Form::open(['method'=>'POST', 'action'=>'App\Http\Controllers\CurtainPanelsController@store']) !!}
                                  <div class="form-row">
                                      <div class="col-lg-6 col-sm-12">
                                          {!! Form::label('name', 'Nombre:') !!}
                                          {!! Form::text('name', null, ['class'=>'form-control']) !!}
                                      </div>

                                      <div class="col-md-6 col-sm-12">
                                          {!! Form::label('price', 'Precio:') !!}
                                          {!! Form::number('price', null, ['class'=>'form-control', 'step'=>0.01]) !!}
                                      </div>
                                  </div>

                                      <div class="form-group text-right">
                                          {!! Form::submit('Agregar Panel', ['class'=>'btn btn-primary btn-sm']) !!}
                                      </div>

                                      {!! Form::close() !!}

              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr><th>
                        ID
                    </th>
                    <th>
                      Nombre
                    </th>
                    <th>
                      Precio
                    </th>
                    <th class="text-right">
                      Acciones
                    </th>
                  </tr></thead>
                  <tbody>
                  @if($panels)
                      @foreach($panels as $panel)
                  <tr>
                        <td>{{$panel->id}}</td>
                        <td>{{$panel->name}}</td>
                        <td>${{number_format($panel->price, 2)}}</td>
                        <td class="td-actions text-right">
                            <a rel="tooltip" class="btn btn-success btn-link" href="{{route('panels.edit', $panel->id)}}" data-original-title="" title="">
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

