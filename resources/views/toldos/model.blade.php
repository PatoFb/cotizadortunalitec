@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Toldo')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Selecciona un modelo (Paso 2 de 6)</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\ToldosController@addModelPost', $order_id]]) !!}

                    <div class="form-row">
                        <div class="col-md-12 col-sm-12">
                            @if($models)
                                @foreach($models as $model)
                            <div class="form-check form-check-radio">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="model_id" id="exampleRadios1" value="{{$model->id}}" {{ (isset($toldo->model_id) && $toldo->model_id == $model->id) ? "checked" : "" }} >
                                    <div class='row'>
                                        <div class='col-md-7 col-sm-12'>
                                            <h7 style='color: grey;'><h3><strong>{{$model->description}}</strong></h3></h7>
                                            <br>
                                            <h7 style='color: grey;'>Máxima resistencia al viento de <strong>{{$model->wind_resistance}} km/h</strong></h7>
                                            <br>
                                            <h7 style='color: grey;'>Tiempo de producción: <strong>{{$model->production_time}} días hábiles</strong></h7>
                                            <br>
                                            <h7 style='color: grey;'>Ancho máximo: <strong>{{$model->max_width}} m</strong></h7>
                                            <br>
                                            <h7 style='color: grey;'>Ancho mínimo: <strong>{{$model->min_width}} m</strong></h7>
                                        </div>
                                        <div class='col-md-5 col-sm-12'>
                                            <img src="{{asset('storage')}}/images/{{$model->photo}}" style="max-width: 250px">
                                        </div>
                                    </div>
                                    <span class="circle">
                                        <span class="check"></span>
                                    </span>
                                </label>
                            </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                <div class="form-row">
                    <div class="col-md-6 text-left">
                        <a href="{{ route('orders.type', $order_id) }}" class="btn btn-danger">Anterior</a>
                    </div>
                    <div class="col-md-6 text-right">
                        {!! Form::submit('Siguiente', ['class'=>'btn btn-primary', $order_id]) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
      </div>
    </div>
  </div>
</div>
</div>
    @endsection

