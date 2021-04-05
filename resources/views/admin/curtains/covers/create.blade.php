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
                <div class="row">
                    <div class="form-group col-sm-12 col-lg-12">
                        {!! Form::label('name', 'Nombre:') !!}
                        {!! Form::text('name', null, ['class'=>'form-control']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-6 col-lg-4">
                        {!! Form::label('roll_width', 'Ancho de rollo:') !!}
                        {!! Form::number('roll_width', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group col-sm-6 col-lg-4">
                        {!! Form::label('unions', 'Uniones:') !!}
                        {!! Form::number('unions', null, ['class'=>'form-control']) !!}
                    </div>

                    <div class="form-group col-sm-6 col-lg-4">
                        {!! Form::label('price', 'Precio' )  !!}
                        {!! Form::number('price', null, ['class'=>'form-control']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12 col-lg-12">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="inputGroupFile01" lang="es" name="photo">
                            <label class="custom-file-label" for="inputGroupFile01">Seleccionar imagen</label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-12 col-lg-12">
                        {!! Form::submit('Agregar cubierta', ['class'=>'btn btn-primary pull-right']) !!}
                    </div>
                </div>
            </div>
          {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>
    @endsection

