@extends('layouts.app', ['activePage' => 'tejadillos_cortina', 'titlePage' => __('Tejadillos')])

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
                            {!! Form::model($canopy, ['method'=>'PATCH', 'action'=>['App\Http\Controllers\CurtainCanopiesController@update', $canopy->id]]) !!}
                            <div class="form-group">
                                    {!! Form::label('price', 'Precio:') !!}
                                    {!! Form::number('price', null, ['class'=>'form-control', 'step'=>0.01]) !!}
                            </div>

                            <div class="form-row float-right">
                                    {!! Form::submit('Aceptar', ['class'=>'btn btn-primary']) !!}




                                {!! Form::close() !!}

                                {!! Form::open(['method'=>'DELETE', 'action'=>['App\Http\Controllers\CurtainCanopiesController@destroy', $canopy->id]]) !!}

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

