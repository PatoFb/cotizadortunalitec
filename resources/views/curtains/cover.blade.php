@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Cortina')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Selecciona una cubierta (Paso 4 de 6)</h4>
              {{--<p class="card-category"> Here you can manage users</p>--}}
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\CurtainsController@addCoverPost', $order_id]]) !!}

                <div class="form-row">
                    <div class="col-md-6 col-sm-12" id="coverForm">
                        {!! Form::label('cover_id', 'Clave (del 1 al 10 son estilos pendientes)') !!}
                        @if($order->activity == 'Oferta')
                            {!! Form::number('cover_id', $curtain->cover_id ?? null, ['class'=>'form-control', "id"=>"cover_id", 'min'=>0]) !!}
                        @else
                            {!! Form::number('cover_id', $curtain->cover_id ?? null, ['class'=>'form-control', "id"=>"cover_id", 'min'=>20]) !!}
                        @endif
                    </div>
                    <div class="col-md-6 col-sm-12" id="coverDynamic">

                    </div>
                </div>
                <br>
                <div class="form-row text-center">
                    <div class="col-6 text-left">
                        <a href="{{ route('curtain.data', $order_id) }}" class="btn btn-danger">Anterior</a>
                    </div>
                    <div class="col-6 text-right">
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

