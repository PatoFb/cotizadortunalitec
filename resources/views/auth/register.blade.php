@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'register', 'title' => __('Material Dashboard')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row align-items-center">
    <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
      <form class="form" method="POST" action="{{ route('register') }}">
        @csrf

        <div class="card card-login card-hidden mb-3">
          <div class="card-header card-header-primary text-center">
            <h4 class="card-title"><strong>{{ __('Registrarse') }}</strong></h4>
            {{--<div class="social-line">
              <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                <i class="fa fa-facebook-square"></i>
              </a>
              <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                <i class="fa fa-twitter"></i>
              </a>
              <a href="#pablo" class="btn btn-just-icon btn-link btn-white">
                <i class="fa fa-google-plus"></i>
              </a>
            </div>--}}
          </div>
          <div class="card-body ">
            <div class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">face</i>
                  </span>
                </div>
                <input type="text" name="name" class="form-control" placeholder="{{ __('Nombre*') }}" value="{{ old('name') }}" required>
              </div>
              @if ($errors->has('name'))
                <div id="name-error" class="error text-danger pl-3" for="name" style="display: block;">
                  <strong>{{ $errors->first('name') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">email</i>
                  </span>
                </div>
                <input type="email" name="email" class="form-control" placeholder="{{ __('Email*') }}" value="{{ old('email') }}" required>
              </div>
              @if ($errors->has('email'))
                <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                  <strong>{{ $errors->first('email') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">lock_outline</i>
                  </span>
                </div>
                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Contraseña*') }}" required>
              </div>
              @if ($errors->has('password'))
                <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                  <strong>{{ $errors->first('password') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">lock_outline</i>
                  </span>
                </div>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Confirmar Contraseña*') }}" required>
              </div>
              @if ($errors->has('password_confirmation'))
                <div id="password_confirmation-error" class="error text-danger pl-3" for="password_confirmation" style="display: block;">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                </div>
              @endif
            </div>
              <br>
              <div class="card-title">
                  <h6>Datos opcionales (se pedirán al hacer una orden)</h6>
              </div>
              <div class="bmd-form-group{{ $errors->has('phone') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                      <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">phone</i>
                  </span>
                      </div>
                      <input type="text" name="phone" class="form-control" placeholder="{{ __('Teléfono') }}" value="{{ old('phone') }}">
                  </div>
                  @if ($errors->has('phone'))
                      <div id="name-error" class="error text-danger pl-3" for="phone" style="display: block;">
                          <strong>{{ $errors->first('phone') }}</strong>
                      </div>
                  @endif
              </div>
              <div class="bmd-form-group{{ $errors->has('rfc') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                      <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">description</i>
                  </span>
                      </div>
                      <input type="text" name="rfc" class="form-control" placeholder="{{ __('RFC') }}" value="{{ old('rfc') }}">
                  </div>
                  @if ($errors->has('rfc'))
                      <div id="name-error" class="error text-danger pl-3" for="rfc" style="display: block;">
                          <strong>{{ $errors->first('rfc') }}</strong>
                      </div>
                  @endif
              </div>
              <div class="bmd-form-group{{ $errors->has('razon_social') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                      <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">description</i>
                  </span>
                      </div>
                      <input type="text" name="razon_social" class="form-control" placeholder="{{ __('Razón Social') }}" value="{{ old('razon_social') }}">
                  </div>
                  @if ($errors->has('razon_social'))
                      <div id="name-error" class="error text-danger pl-3" for="razon_social" style="display: block;">
                          <strong>{{ $errors->first('razon_social') }}</strong>
                      </div>
                  @endif
              </div>
              <div class="bmd-form-group{{ $errors->has('cfdi') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                      <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">description</i>
                  </span>
                      </div>
                      <input type="text" name="cfdi" class="form-control" placeholder="{{ __('CFDI') }}" value="{{ old('cfdi') }}">
                  </div>
                  @if ($errors->has('cfdi'))
                      <div id="name-error" class="error text-danger pl-3" for="cfdi" style="display: block;">
                          <strong>{{ $errors->first('cfdi') }}</strong>
                      </div>
                  @endif
              </div>


            {{--<div class="form-check mr-auto ml-3 mt-3">
              <label class="form-check-label">
                <input class="form-check-input" type="checkbox" id="policy" name="policy" {{ old('policy', 1) ? 'checked' : '' }} >
                <span class="form-check-sign">
                  <span class="check"></span>
                </span>
                {{ __('I agree with the ') }} <a href="#">{{ __('Privacy Policy') }}</a>
              </label>
            </div>--}}
          </div>
          <div class="card-footer justify-content-center">
            <button id="signup" type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Crear cuenta') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
