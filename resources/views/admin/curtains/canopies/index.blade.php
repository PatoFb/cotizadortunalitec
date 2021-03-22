@extends('layouts.app', ['activePage' => 'tejadillos_cortina', 'titlePage' => __('Tejadillos')])

@section('content')
<div class="content">
    @include('alerts.success')
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Tejadillos</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                                  {!! Form::open(['method'=>'POST', 'action'=>'App\Http\Controllers\CurtainCanopiesController@store']) !!}
                                  <div class="row">
                                      <div class="form-group col-lg-12 col-sm-12">
                                          {!! Form::label('price', 'Precio:') !!}
                                          {!! Form::number('price', null, ['class'=>'form-control', 'step'=>0.01]) !!}
                                      </div>
                                  </div>
                                  <div class="row">
                                      <div class="form-group col-12 text-right">
                                          {!! Form::submit('Agregar Tejadillo', ['class'=>'btn btn-primary btn-sm']) !!}
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
                      Precio
                    </th>
                    <th class="text-right">
                      Acciones
                    </th>
                  </tr></thead>
                  <tbody>
                  @if($canopies)
                      @foreach($canopies as $canopy)
                  <tr>
                        <td>{{$canopy->id}}</td>
                        <td>${{number_format($canopy->price, 2)}}</td>
                        <td class="td-actions text-right">
                            <a rel="tooltip" class="btn btn-success btn-link" href="{{route('canopies.edit', $canopy->id)}}" data-original-title="" title="">
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

