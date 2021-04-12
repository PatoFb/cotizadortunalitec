@extends('layouts.app', ['activePage' => 'home', 'titlePage' => __('Bienvenido')])

@section('content')
    <div class="content">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
      <div class="card">
          <div class="card-body text-center">
          <h2>{{ __('Bienvenido al cotizador Tunalitec.') }}</h2>
          </div>
      </div>
  </div>
    </div>
</div>
</div>
@endsection
