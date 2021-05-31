@extends('layouts.app', ['activePage' => 'usuarios', 'titlePage' => __('Admninistracion de usuarios')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Dar de alta a usuario</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>'App\Http\Controllers\UsersController@store']) !!}

                    <div class="form-row">
                        <div class="col-md-6 col-sm-12">
                        {!! Form::label('name', 'Nombre:') !!}
                        {!! Form::text('name', null, ['class'=>'form-control']) !!}
                        </div>

                        <div class="col-md-6 col-sm-12">
                        {!! Form::label('email', 'Email:') !!}
                        {!! Form::email('email', null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
<br>

                <div class="form-row">
                    <div class="col-sm-12 col-md-6">
                        {!! Form::label('password', 'Contraseña:') !!}
                        {!! Form::password('password', ['class'=>'form-control']) !!}
                    </div>

                    <div class="col-sm-12 col-md-6">
                        {!! Form::label('confirm_password', 'Confirmar contraseña:') !!}
                        {!! Form::password('confirm_password', ['class'=>'form-control']) !!}
                    </div>
                </div>


<br>

                    <div class="form-row">
                        <div class="col-md-6 col-sm-12">
                            {!! Form::label('role_id', 'Rol:' )  !!}
                            {!! Form::select('role_id', [''=>'Seleccionar rol'] + $roles, null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-6 col-sm-12">
                            {!! Form::label('discount', 'Descuento:') !!}
                            {!! Form::number('discount', null, ['class'=>'form-control']) !!}
                        </div>
                    </div>

                <div class="row">
                    <div class="form-group col-sm-12 col-lg-12">
                        {!! Form::submit('Agregar usuario', ['class'=>'btn btn-primary pull-right']) !!}
                    </div>
                </div>
            </div>
          {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
    @endsection

