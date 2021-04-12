@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Cubiertas')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Selecciona una cubiertas</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\CurtainsController@addCoverPost', $order_id]]) !!}

                    <div class="form-row">
                        <div class="col-md-2 col-sm-12 text-center text-justify">
                            @if($covers)
                                @foreach($covers as $cover)
                            <div class="form-check form-check-radio">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="cover_id" id="exampleRadios1" value="{{$cover->id}}" {{ (isset($curtain->cover_id) && $curtain->cover_id == $cover->id) ? "checked" : "" }} >
                                        <img src="{{asset('storage')}}/images/{{$cover->photo}}" style="max-width: 250px">
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
                        <a href="{{ route('curtain.model', $order_id) }}" class="btn btn-danger">Anterior</a>
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
    @endsection

