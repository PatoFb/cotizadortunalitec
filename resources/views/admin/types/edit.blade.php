@extends('layouts.app', ['activePage' => 'tipos', 'titlePage' => __('Tipos de productos')])

@section('content')
    <div class="content">
        @include('alerts.errors')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Editar Tipo</h4>
                            {{--<p class="card-category"> Here you can manage users</p>--}}
                        </div>
                        <div class="card-body">
                            {!! Form::model($type, ['method'=>'PATCH', 'action'=>['App\Http\Controllers\TypesController@update', $type->id]]) !!}

                                <div class="form-group">
                                    {!! Form::label('name', 'Nombre:') !!}
                                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                                </div>


                                    <div class="form-row float-right">
                                    {!! Form::submit('Aceptar', ['class'=>'btn btn-primary']) !!}





                                {!! Form::close() !!}

                                {!! Form::open(['method'=>'DELETE', 'action'=>['App\Http\Controllers\TypesController@destroy', $type->id]]) !!}

                                    {!! Form::submit('Eliminar', ['class'=>'btn btn-danger float-right']) !!}
                                    {!! Form::close() !!}
                                </div>


                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

