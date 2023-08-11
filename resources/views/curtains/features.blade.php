@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Cortina')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Características de cortina (Paso 6 de 7)</h4>
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\CurtainsController@addFeaturesPost', $order_id]]) !!}


                <div class="form-row">
                    <div class="col-md-9 col-sm-9">
                        {!! Form::label('handle_id', 'Manivela (Medida en metros):' )  !!}
                        <select class="form-control" name="handle_id" id="handle_id" >
                            @if(isset($handles))
                                @foreach($handles as $handle)
                                    <option value="{{$handle->id}}" {{{ (isset($curtain->handle_id) && $curtain->handle_id == $handle->id) ? "selected=\"selected\"" : "" }}}>{{$handle->measure}}</option>
                                @endforeach
                            @else
                                <option value="">No aplica</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        {!! Form::label('handle_quantity', 'Cantidad:') !!}
                        @if($curtain->handle_id == 9999)
                            {!! Form::number('handle_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"handle_quantity", 'readonly']) !!}
                        @else
                            {!! Form::number('handle_quantity', $curtain->handle_quantity ?? 0, ['class'=>'form-control', "step"=>1, "id"=>"handle_quantity"]) !!}
                        @endif
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-9 col-sm-9">
                        {!! Form::label('control_id', 'Control:' )  !!}
                        <select class="form-control" name="control_id" id="control_id">
                            @if(isset($controls))
                                @foreach($controls as $control)
                                    <option value="{{$control->id}}" {{{ (isset($curtain->control_id) && $curtain->control_id == $control->id) ? "selected=\"selected\"" : "" }}}>{{$control->name}}</option>
                                @endforeach
                            @else
                                <option value="">No aplica</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        {!! Form::label('control_quantity', 'Cantidad:') !!}
                        @if($curtain->control_id == 9999)
                            {!! Form::number('control_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"control_quantity", 'readonly']) !!}
                        @else
                            {!! Form::number('control_quantity', $curtain->control_quantity ?? 0, ['class'=>'form-control', "step"=>1, "id"=>"control_quantity"]) !!}
                        @endif
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-9 col-sm-9">
                        {!! Form::label('voice_id', 'Voz:' )  !!}
                        <select class="form-control" name="voice_id" id="voice_id" >
                            @if(isset($voices))
                                @foreach($voices as $voice)
                                    <option value="{{$voice->id}}" {{{ (isset($curtain->voice_id) && $curtain->voice_id == $voice->id) ? "selected=\"selected\"" : "" }}}>{{$voice->name}}</option>
                                @endforeach
                            @else
                                <option value="">No aplica</option>
                            @endif
                        </select>
                    </div>

                    <div class="col-md-3 col-sm-3">
                        {!! Form::label('voice_quantity', 'Cantidad:') !!}
                        @if($curtain->voice_id == 9999)
                            {!! Form::number('voice_quantity', 0, ['class'=>'form-control', 'id'=>'voice_quantity', 'readonly']) !!}
                        @else
                            {!! Form::number('voice_quantity', $curtain->voice_quantity ?? 0, ['class'=>'form-control', 'id'=>'voice_quantity']) !!}
                        @endif
                    </div>

                </div>
                <div class="form-row">
                    <div class="col-md-12 col-sm-12">
                        {!! Form::label('canopy_id', 'Tejadillo:' )  !!}
                        <select class="form-control" name="canopy_id" id="canopy_id" >
                            <option value="1" {{{ (isset($curtain->canopy_id) && $curtain->canopy_id == '1') ? "selected=\"selected\"" : "" }}}>Si</option>
                            <option value="0" {{{ (isset($curtain->canopy_id) && $curtain->canopy_id == '0') ? "selected=\"selected\"" : "" }}}>No</option>
                        </select>
                    </div>

                </div>

                <br>

                <div class="form-row text-center">
                    <div class="col-6 text-left">
                        <a href="{{ route('curtain.cover', $order_id) }}" class="btn btn-danger">Anterior</a>
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
</div>
    @endsection

