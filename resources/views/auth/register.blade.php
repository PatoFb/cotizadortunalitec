@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'register', 'title' => __('Material Dashboard')])

@section('content')
<div class="container" style="height: auto;">
    @include('alerts.success')
  <div class="row align-items-center">
    <div class="col-lg-8 col-md-8 col-sm-8 ml-auto mr-auto">
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
              <div class="bmd-form-group{{ $errors->has('number') ? ' has-danger' : '' }}">
                  <div class="input-group">
                      <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">face</i>
                  </span>
                      </div>
                      <input type="number" name="number" class="form-control" placeholder="{{ __('Número de socio*') }}" value="{{ old('number') }}" required>
                  </div>
                  @if ($errors->has('number'))
                      <div id="name-error" class="error text-danger pl-3" for="number" style="display: block;">
                          <strong>{{ $errors->first('number') }}</strong>
                      </div>
                  @endif
              </div>
            <div class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }} mt-3">
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
                  <h6>Datos de facturación</h6>
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

              <br>
              <div class="card-title">
                  <h6>Dirección principal</h6>
              </div>
              <div class="bmd-form-group{{ $errors->has('city') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                      <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">location_city</i>
                  </span>
                      </div>
                      <input type="text" name="city" class="form-control" placeholder="{{ __('Ciudad') }}" value="{{ old('city') }}">
                  </div>
                  @if ($errors->has('city'))
                      <div id="name-error" class="error text-danger pl-3" for="city" style="display: block;">
                          <strong>{{ $errors->first('city') }}</strong>
                      </div>
                  @endif
              </div>
              <div class="bmd-form-group{{ $errors->has('state') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                      <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">domain</i>
                  </span>
                      </div>
                      <input type="text" name="state" class="form-control" placeholder="{{ __('Estado') }}" value="{{ old('state') }}">
                  </div>
                  @if ($errors->has('state'))
                      <div id="name-error" class="error text-danger pl-3" for="state" style="display: block;">
                          <strong>{{ $errors->first('state') }}</strong>
                      </div>
                  @endif
              </div>
              <div class="bmd-form-group{{ $errors->has('zip_code') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                      <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">source</i>
                  </span>
                      </div>
                      <input type="text" name="zip_code" class="form-control" placeholder="{{ __('Código postal') }}" value="{{ old('zip_code') }}">
                  </div>
                  @if ($errors->has('zip_code'))
                      <div id="name-error" class="error text-danger pl-3" for="zip_code" style="display: block;">
                          <strong>{{ $errors->first('zip_code') }}</strong>
                      </div>
                  @endif
              </div>
              <div class="bmd-form-group{{ $errors->has('line1') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                      <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">description</i>
                  </span>
                      </div>
                      <input type="text" name="line1" class="form-control" placeholder="{{ __('Colonia') }}" value="{{ old('line1') }}">
                  </div>
                  @if ($errors->has('line1'))
                      <div id="name-error" class="error text-danger pl-3" for="line1" style="display: block;">
                          <strong>{{ $errors->first('line1') }}</strong>
                      </div>
                  @endif
              </div>
              <div class="bmd-form-group{{ $errors->has('line2') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                      <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">description</i>
                  </span>
                      </div>
                      <input type="text" name="line2" class="form-control" placeholder="{{ __('Calle, nombre de la empresa, # exterior') }}" value="{{ old('line2') }}">
                  </div>
                  @if ($errors->has('line2'))
                      <div id="name-error" class="error text-danger pl-3" for="line2" style="display: block;">
                          <strong>{{ $errors->first('line2') }}</strong>
                      </div>
                  @endif
              </div>
              <div class="bmd-form-group{{ $errors->has('reference') ? ' has-danger' : '' }} mt-3">
                  <div class="input-group">
                      <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">description</i>
                  </span>
                      </div>
                      <input type="text" name="reference" class="form-control" placeholder="{{ __('Referencias (opcional)') }}" value="{{ old('reference') }}">
                  </div>
                  @if ($errors->has('reference'))
                      <div id="name-error" class="error text-danger pl-3" for="reference" style="display: block;">
                          <strong>{{ $errors->first('reference') }}</strong>
                      </div>
                  @endif
              </div>
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
