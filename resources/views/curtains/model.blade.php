@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Ordenes')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Selecciona un modelo</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\CurtainsController@addModelPost', $order_id]]) !!}

                    <div class="form-row">
                        <div class="col-md-2 col-sm-12 text-center text-justify">
                            @if($models)
                                @foreach($models as $model)
                            <div class="form-check form-check-radio">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="model_id" id="exampleRadios1" value="{{$model->id}}" {{ (isset($curtain->model_id) && $curtain->model_id == $model->id) ? "checked" : "" }} >
                                        <img src="{{asset('storage')}}/images/{{$model->photo}}" style="max-width: 250px">
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

