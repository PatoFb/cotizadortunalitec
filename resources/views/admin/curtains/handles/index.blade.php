@extends('layouts.app', ['activePage' => 'manivelas_cortina', 'titlePage' => __('Manivelas')])

@section('content')
<div class="content">
    @include('alerts.success')
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Manivelas</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                                  {!! Form::open(['method'=>'POST', 'action'=>'App\Http\Controllers\CurtainHandlesController@store']) !!}
                                  <div class="row">
                                      <div class="form-group col-lg-6 col-sm-6">
                                          {!! Form::label('measure', 'Medida:') !!}
                                          {!! Form::text('measure', null, ['class'=>'form-control']) !!}
                                      </div>

                                      <div class="form-group col-lg-6 col-sm-6">
                                          {!! Form::label('price', 'Precio:') !!}
                                          {!! Form::number('price', null, ['class'=>'form-control', 'step'=>0.01]) !!}
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="form-group col-12 text-right">
                                          {!! Form::submit('Agregar Manivela', ['class'=>'btn btn-primary btn-sm']) !!}
                                      </div>

                                      {!! Form::close() !!}
                                  </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr><th>
                        ID
                    </th>
                    <th>
                      Medida
                    </th>
                    <th>
                      Precio
                    </th>
                    <th class="text-right">
                      Acciones
                    </th>
                  </tr></thead>
                  <tbody>
                  @if($handles)
                      @foreach($handles as $handle)
                  <tr>
                        <td>{{$handle->id}}</td>
                        <td>{{$handle->measure}}</td>
                        <td>${{number_format($handle->price, 2)}}</td>
                        <td class="td-actions text-right">
                            <a rel="tooltip" class="btn btn-success btn-link" href="{{route('handles.edit', $handle->id)}}" data-original-title="" title="">
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

