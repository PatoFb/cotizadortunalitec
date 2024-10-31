@extends('layouts.app', ['activePage' => 'usuarios', 'titlePage' => __('Administración de usuarios')])

@section('content')
<div class="content">
    @include('alerts.success')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Usuarios</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                <toolbox>
                    {!! Form::open(['method'=>'POST', 'action'=>'App\Http\Controllers\UsersController@search']) !!}
                    @csrf

                    <div class="form-group">
                        <label for="partner_id">Número de socio:</label>
                        {!! Form::text('partner_id', null, ['class'=>'form-control', 'id'=>'partner_id']) !!}
                    </div>


                    <div class="form-group text-right">
                        {!! Form::submit('Buscar', ['class'=>'btn btn-primary btn-sm']) !!}
                    </div>

                    {!! Form::close() !!}
                </toolbox>
                              <div class="row">
                    <div class="col-12 text-right">
                        <a href="{{route('users.create')}}" class="btn btn-sm btn-primary">Agregar usuario</a>
                    </div>
                </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr><th>
                        Nombre
                    </th>
                    <th>
                      Email
                    </th>
                    <th>
                      Rol
                    </th>
                        <th>
                            Teléfono
                        </th>
                        <th>
                            RFC
                        </th>
                        <th>
                            CFDI
                        </th>
                        <th>
                            Razón social
                        </th>
                        <th>
                            Descuento
                        </th>
                    <th class="text-right">
                      Acciones
                    </th>
                  </tr></thead>
                  <tbody>
                  @if($users)
                      @foreach($users as $user)
                  <tr>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                      <td>{{$user->role->name}}</td>
                      <td>{{$user->phone}}</td>
                      <td>{{$user->rfc}}</td>
                      <td>{{$user->cfdi}}</td>
                      <td>{{$user->partner->description}}</td>
                      <td>{{$user->discount}}%</td>
                        <td class="td-actions text-right">
                            <a rel="tooltip" class="btn btn-success btn-link" href="{{route('users.edit', $user->id)}}" data-original-title="" title="">
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
              <div class="card-footer">
                  <div class="d-flex justify-content-center text-center">
                      {{ $users->links('pagination::bootstrap-4') }}
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</div>
    @endsection

