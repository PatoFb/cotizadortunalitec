@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Cubiertas')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Selecciona una cubierta</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\PalilleriasController@addCoverPost', $order_id]]) !!}

                <div class="form-row">
                    <div class="col-md-6 col-sm-12" id="coverFormP">

                        <select class="form-control" name="cover_id" id="cover_id">
                            @foreach($cov as $cover)
                                <option value="{{$cover->id}}" {{{ (isset($curtain->cover_id) && $curtain->cover_id == $cover->id) ? "selected=\"selected\"" : "" }}}>{{$cover->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-sm-12" id="coverDynamicP">

                    </div>
                </div>
                <br>
                <div class="form-row">
                    <div class="col-md-6 text-left">
                        <a href="{{ route('palilleria.data', $order_id) }}" class="btn btn-danger">Anterior</a>
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

