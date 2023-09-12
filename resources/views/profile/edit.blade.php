@extends('layouts.app', ['activePage' => 'profile', 'titlePage' => __('Perfil de Usuario')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('profile.update') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Editar Perfil') }}</h4>
                <p class="card-category">{{ __('Información de usuario') }}</p>
              </div>
              <div class="card-body ">
                @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Nombre') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('Nombre') }}" value="{{ old('name', auth()->user()->name) }}" required="true" aria-required="true"/>
                      @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="{{ __('Email') }}" value="{{ old('email', auth()->user()->email) }}" required />
                      @if ($errors->has('email'))
                        <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">{{ __('Telefono') }}</label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" id="input-phone" type="text" placeholder="{{ __('Telefono') }}" value="{{ old('phone', auth()->user()->phone) }}" required="true" aria-required="true"/>
                                @if ($errors->has('phone'))
                                    <span id="phone-error" class="error text-danger" for="input-phone">{{ $errors->first('phone') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">{{ __('RFC') }}</label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('rfc') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('rfc') ? ' is-invalid' : '' }}" name="rfc" id="input-rfc" type="text" placeholder="{{ __('RFC') }}" value="{{ old('rfc', auth()->user()->rfc) }}" required="true" aria-required="true"/>
                                @if ($errors->has('rfc'))
                                    <span id="rfc-error" class="error text-danger" for="input-rfc">{{ $errors->first('rfc') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">{{ __('CFDI') }}</label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('cfdi') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('cfdi') ? ' is-invalid' : '' }}" name="cfdi" id="input-cfdi" type="text" placeholder="{{ __('CFDI') }}" value="{{ old('cfdi', auth()->user()->cfdi) }}" required="true" aria-required="true"/>
                                @if ($errors->has('cfdi'))
                                    <span id="cfdi-error" class="error text-danger" for="input-cfdi">{{ $errors->first('cfdi') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('profile.password') }}" class="form-horizontal">
            @csrf
            @method('put')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Cambiar contraseña') }}</h4>
                <p class="card-category">{{ __('Contraseña') }}</p>
              </div>
              <div class="card-body ">
                @if (session('status_password'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status_password') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-current-password">{{ __('Contraseña actual') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('old_password') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('old_password') ? ' is-invalid' : '' }}" input type="password" name="old_password" id="input-current-password" placeholder="{{ __('Contraseña actual') }}" value="" required />
                      @if ($errors->has('old_password'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('old_password') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password">{{ __('Nueva contraseña') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="input-password" type="password" placeholder="{{ __('Nueva contraseña') }}" value="" required />
                      @if ($errors->has('password'))
                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password-confirmation">{{ __('Confirmar nueva contraseña') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      <input class="form-control" name="password_confirmation" id="input-password-confirmation" type="password" placeholder="{{ __('Confirmar nueva contraseña') }}" value="" required />
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Cambiar contraseña') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>

        <div class="row">
            <div class="col-md-12">
                <form method="post" action="{{ route('profile.address') }}" autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('put')

                    <div class="card ">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Dirección principal') }}</h4>
                            <p class="card-category">{{ __('Dirección de usuario') }}</p>
                        </div>
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="line1">{{ __('Colonia') }}</label>
                                    <div class="form-group{{ $errors->has('line1') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('line1') ? ' is-invalid' : '' }}" name="line1" id="input-line1" type="text" placeholder="{{ __('Colonia') }}" value="{{ old('line1', auth()->user()->line1) }}" required="true" aria-required="true"/>
                                        @if ($errors->has('line1'))
                                            <span id="line1-error" class="error text-danger" for="input-line1">{{ $errors->first('line1') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                                <br>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="line2">{{ __('Calle y número exterior') }}</label>
                                    <div class="form-group{{ $errors->has('line2') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('line2') ? ' is-invalid' : '' }}" name="line2" id="input-line2" type="text" placeholder="{{ __('Calle y número') }}" value="{{ old('line2', auth()->user()->line2) }}" required />
                                        @if ($errors->has('line2'))
                                            <span id="line2-error" class="error text-danger" for="input-line2">{{ $errors->first('line2') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="zip_code">{{ __('Código Postal') }}</label>
                                        <div class="form-group{{ $errors->has('zip_code') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('zip_code') ? ' is-invalid' : '' }}" name="zip_code" id="input-zip_code" type="text" placeholder="{{ __('Código Postal') }}" value="{{ old('zip_code', auth()->user()->zip_code) }}" required />
                                            @if ($errors->has('zip_code'))
                                                <span id="zip_code-error" class="error text-danger" for="input-zip_code">{{ $errors->first('zip_code') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="city">{{ __('Ciudad') }}</label>
                                        <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" id="input-city" type="text" placeholder="{{ __('Ciudad') }}" value="{{ old('city', auth()->user()->city) }}" required />
                                            @if ($errors->has('city'))
                                                <span id="city-error" class="error text-danger" for="input-city">{{ $errors->first('city') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="state">{{ __('Estado') }}</label>
                                        <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" name="state" id="input-state" type="text" placeholder="{{ __('Estado') }}" value="{{ old('state', auth()->user()->state) }}" required />
                                            @if ($errors->has('state'))
                                                <span id="state-error" class="error text-danger" for="input-state">{{ $errors->first('state') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="reference">{{ __('Referencia') }}</label>
                                        <div class="form-group{{ $errors->has('reference') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}" name="reference" id="input-reference" type="text" placeholder="{{ __('Calle y número') }}" value="{{ old('reference', auth()->user()->reference) }}" required />
                                            @if ($errors->has('reference'))
                                                <span id="reference-error" class="error text-danger" for="input-reference">{{ $errors->first('reference') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary">{{ __('Cambiar dirección') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
  </div>
@endsection
