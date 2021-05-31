@extends('layouts.app', ['activePage' => 'mecanismos_cortina', 'titlePage' => __('Mecanismos')])

@section('content')
    <div class="content">
        @include('alerts.errors')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Editar Mecanismo</h4>
                            {{--<p class="card-category"> Here you can manage users</p>--}}
                        </div>
                        <div class="card-body">
                            {!! Form::model($mechanism, ['method'=>'PATCH', 'action'=>['App\Http\Controllers\CurtainMechanismsController@update', $mechanism->id]]) !!}
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

                            <div class="form-row float-right">

                                    {!! Form::submit('Aceptar', ['class'=>'btn btn-primary']) !!}





                                {!! Form::close() !!}

                                {!! Form::open(['method'=>'DELETE', 'action'=>['App\Http\Controllers\CurtainMechanismsController@destroy', $mechanism->id]]) !!}


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

