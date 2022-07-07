@extends('layouts.app', ['activePage' => 'modelos_cortina', 'titlePage' => __('Modelos')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Agregar modelo</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>'App\Http\Controllers\CurtainModelsController@store', 'files'=>true]) !!}
                <div class="form-row">
                    <div class="col-sm-6 col-md-6">
                        {!! Form::label('name', 'Nombre:') !!}
                        {!! Form::text('name', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="col-sm-6 col-md-6">
                        {!! Form::label('type_id', 'Tipo de producto:' )  !!}
                        {!! Form::select('type_id', [''=>'Selecciona el tipo'] + $types, null, ['class' => 'form-control' ]) !!}
                    </div>
                </div>
                <br>

                <div class="form-row">
                    <div class="col-sm-6 col-md-3">
                        {!! Form::label('max_resistance', 'Resistencia máxima:') !!}
                        {!! Form::number('max_resistance', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="col-sm-6 col-md-3">
                        {!! Form::label('production_time', 'Tiempo de producción:') !!}
                        {!! Form::number('production_time', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="col-sm-6 col-md-3">
                        {!! Form::label('max_width', 'Ancho máximo:' )  !!}
                        {!! Form::number('max_width', null, ['class'=>'form-control', "step"=>0.1]) !!}
                    </div>

                    <div class="col-sm-6 col-md-3">
                        {!! Form::label('max_height', 'Caída máxima:' )  !!}
                        {!! Form::number('max_height', null, ['class'=>'form-control', "step"=>0.1]) !!}
                    </div>
                </div>
<br>

                    <div class="form-group">
                        {!! Form::label('base_price', 'Precio:' )  !!}
                        {!! Form::number('base_price', null, ['class'=>'form-control', 'step'=>0.01]) !!}
                    </div>

<br>
                <div class="form-row">
                    <div class="col-sm-6 col-md-6">
                        {!! Form::label('tube_id', 'Tubo:' )  !!}
                        {!! Form::select('tube_id', [''=>'Selecciona el tubo'] + $tubes, null, ['class' => 'form-control' ]) !!}
                    </div>

                    <div class="col-sm-6 col-md-6">
                        {!! Form::label('panel_id', 'Pánel frontal:' )  !!}
                        {!! Form::select('panel_id', [''=>'Selecciona el panel'] + $panels, null, ['class' => 'form-control' ]) !!}
                    </div>
                </div>
                <br>
                    <div class="form-group">
                        {!! Form::label('description', 'Descripción:') !!}
                        {!! Form::textarea('description', null, ['class'=>'form-control']) !!}
                    </div>
<br>

                {!! Form::label('photo', 'Imagen:') !!}
                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                    <div class="fileinput-preview fileinput-exists thumbnail img-raised" style="max-width: 400px;"></div>
                    <div>
                        <span class="btn btn-raised btn-round btn-primary btn-file">
                            <input type="file" name="photo" />
                        </span>
                        {{--<a href="#" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>--}}
                    </div>
                </div>


<br>

                <div class="form-group float-right">
                        {!! Form::submit('Agregar modelo', ['class'=>'btn btn-primary pull-right']) !!}
                </div>
            </div>
          {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
    @endsection

