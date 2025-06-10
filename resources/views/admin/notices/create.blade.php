@extends('layouts.app', ['activePage' => 'notices', 'titlePage' => isset($notice) ? 'Editar aviso' : 'Crear aviso'])

@section('content')
    <div class="content">
        @include('alerts.success')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ isset($notice) ? 'Editar aviso' : 'Crear nuevo aviso' }}</h4>
                        </div>
                        <div class="card-body">
                            @if(isset($notice))
                                {!! Form::model($notice, ['method' => 'PUT', 'route' => ['notices.update', $notice->id]]) !!}
                            @else
                                {!! Form::open(['method' => 'POST', 'route' => 'notices.store']) !!}
                            @endif

                            <div class="form-group">
                                {!! Form::label('title', 'Título') !!}
                                {!! Form::text('title', null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('type', 'Tipo de aviso') !!}
                                {!! Form::select('type', [
                                    'deal' => 'Oferta',
                                    'out_of_stock' => 'Sin stock',
                                    'info' => 'Informativo'
                                ], null, ['class' => 'form-control', 'placeholder' => 'Selecciona un tipo', 'required']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('message', 'Mensaje') !!}
                                {!! Form::textarea('message', null, ['class' => 'form-control', 'rows' => 4]) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('cover_id', 'ID de cubierta') !!}
                                {!! Form::text('cover_id', null, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {!! Form::label('is_active', '¿Activo?') !!}
                                {!! Form::select('is_active', [1 => 'Sí', 0 => 'No'], null, ['class' => 'form-control', 'required']) !!}
                            </div>

                            <div class="form-group text-right">
                                <a href="{{ route('notices.index') }}" class="btn btn-default btn-sm">Cancelar</a>
                                {!! Form::submit(isset($notice) ? 'Actualizar' : 'Crear', ['class' => 'btn btn-primary btn-sm']) !!}
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
