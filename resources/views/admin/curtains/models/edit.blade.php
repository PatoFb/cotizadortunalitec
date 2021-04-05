@extends('layouts.app', ['activePage' => 'modelos_cortina', 'titlePage' => __('Modelos')])

@section('content')
    <div class="content">
        @include('alerts.errors')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Editar Modelo</h4>
                            {{--<p class="card-category"> Here you can manage users</p>--}}
                        </div>
                        <div class="card-body">
                            {!! Form::model($model, ['method'=>'PATCH', 'action'=>['App\Http\Controllers\CurtainModelsController@update', $model->id]]) !!}
                            <div class="row">
                                <div class="form-group col-sm-6 col-lg-6">
                                    {!! Form::label('name', 'Nombre:') !!}
                                    {!! Form::text('name', null, ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group col-sm-6 col-lg-6">
                                    {!! Form::label('type_id', 'Tipo de producto:' )  !!}
                                    {!! Form::select('type_id', [''=>'Selecciona el tipo'] + $types, null, ['class' => 'form-control' ]) !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-6 col-lg-3">
                                    {!! Form::label('max_resistance', 'Resistencia máxima:') !!}
                                    {!! Form::number('max_resistance', null, ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group col-sm-6 col-lg-3">
                                    {!! Form::label('production_time', 'Tiempo de producción:') !!}
                                    {!! Form::number('production_time', null, ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group col-sm-6 col-lg-3">
                                    {!! Form::label('max_width', 'Ancho máximo:' )  !!}
                                    {!! Form::number('max_width', null, ['class'=>'form-control']) !!}
                                </div>

                                <div class="form-group col-sm-6 col-lg-3">
                                    {!! Form::label('max_height', 'Caída máxima:' )  !!}
                                    {!! Form::number('max_height', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-sm-12 col-lg-12">
                                    {!! Form::label('base_price', 'Precio:' )  !!}
                                    {!! Form::number('base_price', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12 col-lg-12">
                                    {!! Form::label('description', 'Descripción:') !!}
                                    {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
                                </div>
                            </div>


                            <div class="row">
                                <div class="form-group col-sm-9 col-lg-9">
                                    {!! Form::submit('Aceptar', ['class'=>'btn btn-primary pull-right']) !!}
                                </div>

                                {!! Form::close() !!}

                                {!! Form::open(['method'=>'DELETE', 'action'=>['App\Http\Controllers\CurtainModelsController@destroy', $model->id]]) !!}

                                <div class="form-group col-sm-1 col-lg-1">
                                    {!! Form::submit('Delete', ['class'=>'btn btn-danger']) !!}
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

