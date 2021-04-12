@extends('layouts.app', ['activePage' => 'usuarios', 'titlePage' => __('Admninistracion de usuarios')])

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
                      Fecha de creacion
                    </th>
                        <th>
                            Rol
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
                        <td>{{$user->created_at}}</td>
                      <td>{{$user->role->name}}</td>
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
          </div>
      </div>
    </div>
  </div>
</div>
    @endsection

