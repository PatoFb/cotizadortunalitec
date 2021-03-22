@extends('layouts.app', ['activePage' => 'controles_cortina', 'titlePage' => __('Controles')])

@section('content')
    <div class="content">
        @include('alerts.errors')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Editar Control</h4>
                            {{--<p class="card-category"> Here you can manage users</p>--}}
                        </div>
                        <div class="card-body">
                            {!! Form::model($control, ['method'=>'PATCH', 'action'=>['App\Http\Controllers\CurtainControlsController@update', $control->id]]) !!}
                            <div class="row">
                                <div class="form-group col-lg-6 col-sm-6">
                                    {!! Form::label('name', 'Nombre:') !!}
                                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group col-lg-6 col-sm-6">
                                    {!! Form::label('price', 'Precio:') !!}
                                    {!! Form::number('price', null, ['class'=>'form-control', 'step'=>0.01]) !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-10 col-lg-10">
                                    {!! Form::submit('Aceptar', ['class'=>'btn btn-primary']) !!}
                                </div>




                                {!! Form::close() !!}

                                {!! Form::open(['method'=>'DELETE', 'action'=>['App\Http\Controllers\CurtainControlsController@destroy', $control->id]]) !!}

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

