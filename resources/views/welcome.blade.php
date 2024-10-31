@extends('layouts.app', ['activePage' => 'home', 'titlePage' => __('Bienvenido')])

@section('content')
    <div class="content">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
      <div class="card">
          <div class="card-body text-center">
              @if(\Illuminate\Support\Facades\Auth::user()->role_id == 3)
                  <h2>{{ __('Bienvenido a Toldos Solair - Aquí podrás configurar tu sistema. Su usuario pasará a revisión del equipo, se le notificará cuando sea autorizado.') }}</h2>
              @else
                  <h2>{{ __('Bienvenido a Toldos Solair - Aquí podrás configurar tu sistema') }}</h2>
              @endif
          </div>
      </div>
  </div>
    </div>
</div>
</div>
@endsection
