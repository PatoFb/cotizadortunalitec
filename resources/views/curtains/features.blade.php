@extends('layouts.app', ['activePage' => 'orders', 'titlePage' => __('Cortina')])

@section('content')
<div class="content">
    @include('alerts.errors')
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title">Características de cortina (Paso 5 de 6)</h4>
            </div>
            <div class="card-body">
                {!! Form::open(['method'=>'POST', 'action'=>['App\Http\Controllers\CurtainsController@addFeaturesPost', $order_id]]) !!}


                <div class="form-row">
                    @if($curtain->handle_id == 9999)
                        {!! Form::number('handle_id', 9999, ['class'=>'form-control', "step"=>1, "id"=>"handle_id", 'hidden']) !!}
                        {!! Form::number('handle_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"handle_quantity", 'hidden']) !!}
                    @else
                        <div class="col-6">
                            {!! Form::label('handle_id', 'Manivela (Medida en metros) (Precio por unidad)' )  !!}
                            <select class="form-control" name="handle_id" id="handle_id" >
                                <option value="999" {{{ (isset($curtain->handle_id) && $curtain->handle_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                @foreach($handles as $handle)
                                    <option value="{{$handle->id}}" {{{ (isset($curtain->handle_id) && $curtain->handle_id == $handle->id) ? "selected=\"selected\"" : "" }}}>{{$handle->measure}} mts - ${{number_format($handle->price*1.16, 2)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            {!! Form::label('handle_quantity', 'Cantidad (manivelas):') !!}
                            {!! Form::number('handle_quantity', $curtain->handle_quantity ?? 0, ['class'=>'form-control', "step"=>1, "id"=>"handle_quantity"]) !!}
                        </div>
                    @endif
                </div>
                @if($curtain->handle_id != 9999)
                    <br>
                @endif
                <div class="form-row">
                    @if($curtain->control_id == 9999)
                        {!! Form::number('control_id', 9999, ['class'=>'form-control', "step"=>1, "id"=>"control_id", 'hidden']) !!}
                        {!! Form::number('control_quantity', 0, ['class'=>'form-control', "step"=>1, "id"=>"control_quantity", 'hidden']) !!}
                    @else
                        <div class="col-6">
                            {!! Form::label('control_id', 'Control (Precio por unidad)' )  !!}
                            <select class="form-control" name="control_id" id="control_id">
                                <option value="999" {{{ (isset($curtain->control_id) && $curtain->control_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                @foreach($controls as $control)
                                    <option value="{{$control->id}}" {{{ (isset($curtain->control_id) && $curtain->control_id == $control->id) ? "selected=\"selected\"" : "" }}}>{{$control->name}} - ${{number_format($control->price*1.16, 2)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            {!! Form::label('control_quantity', 'Cantidad (controles):') !!}
                            {!! Form::number('control_quantity', $curtain->control_quantity ?? 0, ['class'=>'form-control', "step"=>1, "id"=>"control_quantity"]) !!}
                        </div>
                    @endif
                </div>
                @if($curtain->control_id != 9999)
                    <br>
                @endif
                <div class="form-row">
                    @if($curtain->voice_id == 9999)
                        {!! Form::number('voice_id', 9999, ['class'=>'form-control', 'id'=>'voice_id', 'hidden']) !!}
                        {!! Form::number('voice_quantity', 0, ['class'=>'form-control', 'id'=>'voice_quantity', 'hidden']) !!}
                    @else
                        <div class="col-6">
                            {!! Form::label('voice_id', 'Voz (Precio por unidad)' )  !!}
                            <select class="form-control hidden" name="voice_id" id="voice_id" >
                                <option value="999" {{{ (isset($curtain->voice_id) && $curtain->voice_id == 999) ? "selected=\"selected\"" : "" }}}>No aplica</option>
                                @foreach($voices as $voice)
                                    <option value="{{$voice->id}}" {{{ (isset($curtain->voice_id) && $curtain->voice_id == $voice->id) ? "selected=\"selected\"" : "" }}}>{{$voice->name}} - ${{number_format($voice->price*1.16, 2)}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            {!! Form::label('voice_quantity', 'Cantidad (controles de voz):') !!}
                            {!! Form::number('voice_quantity', $curtain->voice_quantity ?? 0, ['class'=>'form-control', 'id'=>'voice_quantity']) !!}
                        </div>
                    @endif
                </div>
                @if($curtain->voice_id != 9999)
                    <br>
                @endif
                @if($curtain->model_id == 5 || $curtain->model_id == 6)
                    {!! Form::number('canopy', 0, ['class'=>'form-control', 'id'=>'canopy', 'hidden']) !!}
                @else
                    <div class="form-row">
                        <div class="col-12">
                            {!! Form::label('canopy', 'Tejadillo:' )  !!}
                            <select class="form-control" name="canopy" id="canopy" >
                                <option value="1" {{{ (isset($curtain->canopy) && $curtain->canopy == '1') ? "selected=\"selected\"" : "" }}}>Si</option>
                                <option value="0" {{{ (isset($curtain->canopy) && $curtain->canopy == '0') ? "selected=\"selected\"" : "" }}}>No</option>
                            </select>
                        </div>

                    </div>
                    @endif

                <br>
                @if($order->activity == 'Pedido')
                    <h6><strong>Datos para producción</strong></h6>
                    <div class="form-row">
                        <div class="col-12">
                            {!! Form::label('installation_type', 'Tipo de instalación:') !!}
                            <select class="form-control" name="installation_type">
                                <option value="">Selecciona tipo de instalacion</option>
                                <option {{{ (isset($curtain->installation_type) && $curtain->installation_type == 'Pared') ? "selected=\"selected\"" : "" }}}>Pared</option>
                                <option {{{ (isset($curtain->installation_type) && $curtain->installation_type == 'Techo') ? "selected=\"selected\"" : "" }}}>Techo</option>
                                <option {{{ (isset($curtain->installation_type) && $curtain->installation_type == 'Entre muros a pared') ? "selected=\"selected\"" : "" }}}>Entre muros a pared</option>
                                <option {{{ (isset($curtain->installation_type) && $curtain->installation_type == 'Entre muros a techo') ? "selected=\"selected\"" : "" }}}>Entre muros a techo</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="form-row">
                        <div class="col-12">
                            {!! Form::label('mechanism_side', 'Lado de mecanismo:') !!}
                            <select class="form-control" name="mechanism_side" >
                                <option value="">Lado del mecanismo</option>
                                <option {{{ (isset($curtain->mechanism_side) && $curtain->mechanism_side == 'Izquierdo') ? "selected=\"selected\"" : "" }}}>Izquierdo</option>
                                <option {{{ (isset($curtain->mechanism_side) && $curtain->mechanism_side == 'Derecho') ? "selected=\"selected\"" : "" }}}>Derecho</option>
                            </select>
                        </div>
                    </div>
                    <br>
                @endif
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

