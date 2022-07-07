@extends('layouts.app', ['activePage' => 'tipos', 'titlePage' => __('Tipos de Productos')])

@section('content')
<div class="content">
    @include('alerts.success')
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Tipos de productos</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                                  {!! Form::open(['method'=>'POST', 'action'=>'App\Http\Controllers\TypesController@store']) !!}

                                      <div class="form-group">
                                          <label for="typeName">Nombre:</label>
                                          {!! Form::text('name', null, ['class'=>'form-control', 'id'=>'typeName']) !!}
                                      </div>


                                      <div class="form-group text-right">
                                          {!! Form::submit('Agregar Tipo', ['class'=>'btn btn-primary btn-sm']) !!}
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
                    <th class="text-right">
                      Acciones
                    </th>
                  </tr></thead>
                  <tbody>
                  @if($types)
                      @foreach($types as $type)
                  <tr>
                        <td>{{$type->id}}</td>
                        <td>{{$type->name}}</td>
                        <td class="td-actions text-right">
                            <a rel="tooltip" class="btn btn-success btn-link" href="{{route('types.edit', $type->id)}}" data-original-title="" title="">
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

