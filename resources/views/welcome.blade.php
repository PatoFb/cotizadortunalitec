@extends('layouts.app', ['activePage' => 'home', 'titlePage' => __('Bienvenido')])

@section('content')
    <div class="content">
        <div class="container-fluid">
            {{-- Welcome Message --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body text-center">
                            @if(Auth::user()->role_id == 3)
                                <h2>
                                    {{ __('Bienvenido a Toldos Solair - Aquí podrás configurar tu sistema. Su usuario pasará a revisión del equipo, se le notificará cuando sea autorizado.') }}
                                </h2>
                            @else
                                <h2>{{ __('Bienvenido a Toldos Solair - Aquí podrás configurar tu sistema') }}</h2>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- Notices --}}
            @if($notices->count())
                <div class="row">
                    @foreach($notices as $notice)
                        <div class="col-md-6">
                            <div class="card">
                                @if($notice->cover && !empty($notice->cover->photo))
                                    <img src="{{ asset('storage/images/covers/' . $notice->cover->photo) }}"
                                         class="card-img-top"
                                         alt="Imagen de aviso"
                                         style="max-height: 250px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h4 class="card-title">{{ $notice->title }}</h4>
                                    <h6 class="text-muted">
                                        @if($notice->type == 'deal') 🤑 Oferta especial
                                        @elseif($notice->type == 'out_of_stock') ⚠️ Producto sin stock
                                        @else ℹ️ Información
                                        @endif
                                    </h6>
                                    <p class="card-text mt-2">{{ $notice->message }}</p>
                                    <span class="badge {{ $notice->is_active ? 'badge-success' : 'badge-secondary' }}">
                            {{ $notice->is_active ? 'Activo' : 'Inactivo' }}
                        </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info text-center">
                            No hay avisos por el momento.
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
