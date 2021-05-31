@extends('layouts.app', ['activePage' => 'paneles_cortina', 'titlePage' => __('Paneles')])

@section('content')
    <div class="content">
        @include('alerts.errors')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">Editar panel</h4>
                            {{--<p class="card-category"> Here you can manage users</p>--}}
                        </div>
                        <div class="card-body">
                            {!! Form::model($panel, ['method'=>'PATCH', 'action'=>['App\Http\Controllers\CurtainPanelsController@update', $panel->id]]) !!}
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

                                {!! Form::open(['method'=>'DELETE', 'action'=>['App\Http\Controllers\CurtainPanelsController@destroy', $panel->id]]) !!}


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

