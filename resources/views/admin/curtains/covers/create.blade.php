@extends('layouts.app', ['activePage' => 'cubiertas_cortina', 'titlePage' => __('Cubiertas')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Agregar cubierta</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>'App\Http\Controllers\CurtainCoversController@store']) !!}
                    <div class="form-group">
                        {!! Form::label('name', 'Nombre:') !!}
                        {!! Form::text('name', null, ['class'=>'form-control']) !!}
                    </div>
                <br>
                <div class="form-row">
                    <div class="col-sm-6 col-md-4">
                        {!! Form::label('roll_width', 'Ancho de rollo:') !!}
                        {!! Form::number('roll_width', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="col-sm-6 col-md-4">
                        {!! Form::label('unions', 'Uniones:') !!}
                        {!! Form::number('unions', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="col-sm-6 col-md-4">
                        {!! Form::label('price', 'Precio' )  !!}
                        {!! Form::number('price', null, ['class'=>'form-control']) !!}
                    </div>
                </div>
                <br>

                {!! Form::label('photo', 'Imagen:') !!}
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                    <div>
        <span class="btn btn-raised btn-round btn-primary btn-file">
            <input type="file" name="photo" />
        </span>
                        <a href="#" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                    </div>
                </div>


                    <div class="form-group text-right">
                        {!! Form::submit('Agregar cubierta', ['class'=>'btn btn-primary pull-right']) !!}
                    </div>
            </div>
          {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
    @endsection

