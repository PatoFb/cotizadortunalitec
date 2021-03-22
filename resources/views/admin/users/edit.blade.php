@extends('layouts.app', ['activePage' => 'usuarios', 'titlePage' => __('Admninistracion de usuarios')])

@section('content')
    <div class="content">
        @include('alerts.errors')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Editar usuario</h4>
                            {{--<p class="card-category"> Here you can manage users</p>--}}
                        </div>
                        <div class="card-body">
                            {!! Form::model($user, ['method'=>'PATCH', 'action'=>['App\Http\Controllers\UsersController@update', $user->id]]) !!}
                            <div class="row">
                                <div class="form-group {{ $errors->has('name') ? ' has-danger' : '' }} col-sm-12 col-lg-6">
                                    {!! Form::label('name', 'Nombre:') !!}
                                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group {{ $errors->has('email') ? ' has-danger' : '' }} col-sm-12 col-lg-6">
                                    {!! Form::label('email', 'Email:') !!}
                                    {!! Form::email('email', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }} col-sm-12 col-lg-6">
                                    {!! Form::label('password', 'Contraseña:') !!}
                                    {!! Form::password('password', ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group {{ $errors->has('password') ? ' has-danger' : '' }} col-sm-12 col-lg-6">
                                    {!! Form::label('confirm_password', 'Confirmar contraseña:') !!}
                                    {!! Form::password('confirm_password', ['class'=>'form-control']) !!}
                                </div>
                            </div>



                            <div class="row">
                                <div class="form-group {{ $errors->has('role') ? ' has-danger' : '' }} col-sm-6 col-lg-6">
                                    {!! Form::label('role_id', 'Rol:' )  !!}
                                    {!! Form::select('role_id', [''=>'Select role'] + $roles, null, ['class' => 'form-control' ]) !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-10 col-lg-10">
                                    {!! Form::submit('Submit', ['class'=>'btn btn-primary']) !!}
                                </div>




                                {!! Form::close() !!}

                                {!! Form::open(['method'=>'DELETE', 'action'=>['App\Http\Controllers\UsersController@destroy', $user->id]]) !!}

                                <div class="form-group">
                                    {!! Form::submit('Eliminar', ['class'=>'btn btn-danger float-right']) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

