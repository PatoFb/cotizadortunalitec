@extends('layouts.app', ['activePage' => 'usuarios', 'titlePage' => __('Admninistracion de usuarios')])

@section('content')
    <div class="content">
        @include('alerts.success')
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <form class="form" method="POST" action="{{ route('user.store') }}">
                    @csrf
                    @method('post')
                    <div class="card">
                        <div class="card-header card-header-primary">
                            <h4 class="card-title">{{ __('Generar usuario') }}</h4>
                            <p class="card-category">{{ __('Información principal') }}</p>
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
                                <label class="col-sm-2 col-form-label">{{ __('Número de socio') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('parnter_id') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('partner_id') ? ' is-invalid' : '' }}" name="partner_id" id="partner_id" type="text" placeholder="{{ __('Número de socio') }}" required="true" aria-required="true"/>
                                        @if ($errors->has('partner_id'))
                                            <span id="partner_id-error" class="error text-danger" for="partner_id">{{ $errors->first('partner_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Nombre') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('Nombre') }}" required="true" aria-required="true"/>
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
                                        <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="{{ __('Email') }}" required />
                                        @if ($errors->has('email'))
                                            <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Rol') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('role_id') ? ' has-danger' : '' }}">
                                        {!! Form::select('role_id', [''=>'Seleccionar rol'] + $roles, null, ['class' => 'form-control' . ($errors->has('role_id') ? ' is-invalid' : ''), 'id' => 'role_id', 'required'=>'true', 'aria-required'=>'true']) !!}
                                        @if ($errors->has('role_id'))
                                            <span id="role_id-error" class="error text-danger" for="role_id">{{ $errors->first('role_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Descuento') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('discount') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('discount') ? ' is-invalid' : '' }}" name="discount" id="input-discount" type="number" placeholder="{{ __('Descuento') }}" required="true" aria-required="true"/>
                                        @if ($errors->has('discount'))
                                            <span id="discount-error" class="error text-danger" for="input-discount">{{ $errors->first('discount') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">{{ __('Telefono') }}</label>
                                <div class="col-sm-7">
                                    <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                                        <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" id="input-phone" type="number" placeholder="{{ __('Telefono') }}" required="true" aria-required="true"/>
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
                                        <input class="form-control{{ $errors->has('rfc') ? ' is-invalid' : '' }}" name="rfc" id="input-rfc" type="text" placeholder="{{ __('RFC') }}" required="true" aria-required="true"/>
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
                                        <input class="form-control{{ $errors->has('cfdi') ? ' is-invalid' : '' }}" name="cfdi" id="input-cfdi" type="text" placeholder="{{ __('CFDI') }}" required="true" aria-required="true"/>
                                        @if ($errors->has('cfdi'))
                                            <span id="cfdi-error" class="error text-danger" for="input-cfdi">{{ $errors->first('cfdi') }}</span>
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
                    </div>
                    <div class="row">
                        <div class="col-md-12">
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
                                            <input class="form-control{{ $errors->has('line1') ? ' is-invalid' : '' }}" name="line1" id="input-line1" type="text" placeholder="{{ __('Colonia') }}" value="" required="true" aria-required="true"/>
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
                                            <input class="form-control{{ $errors->has('line2') ? ' is-invalid' : '' }}" name="line2" id="input-line2" type="text" placeholder="{{ __('Calle y número') }}" value="" required />
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
                                            <input class="form-control{{ $errors->has('zip_code') ? ' is-invalid' : '' }}" name="zip_code" id="input-zip_code" type="number" placeholder="{{ __('Código Postal') }}" value="" required />
                                            @if ($errors->has('zip_code'))
                                                <span id="zip_code-error" class="error text-danger" for="input-zip_code">{{ $errors->first('zip_code') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="city">{{ __('Ciudad') }}</label>
                                        <div class="form-group{{ $errors->has('city') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" id="input-city" type="text" placeholder="{{ __('Ciudad') }}" value="" required />
                                            @if ($errors->has('city'))
                                                <span id="city-error" class="error text-danger" for="input-city">{{ $errors->first('city') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="state">{{ __('Estado') }}</label>
                                        <div class="form-group{{ $errors->has('state') ? ' has-danger' : '' }}">
                                            <input class="form-control{{ $errors->has('state') ? ' is-invalid' : '' }}" name="state" id="input-state" type="text" placeholder="{{ __('Estado') }}" value="" required />
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
                                            <input class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}" name="reference" id="input-reference" type="text" placeholder="{{ __('Calle y número') }}" value="" required />
                                            @if ($errors->has('reference'))
                                                <span id="reference-error" class="error text-danger" for="input-reference">{{ $errors->first('reference') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer ml-auto mr-auto">
                                <button type="submit" class="btn btn-primary">{{ __('Generar usuario') }}</button>
                            </div>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
@endsection
