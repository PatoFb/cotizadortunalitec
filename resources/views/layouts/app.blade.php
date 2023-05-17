<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Cotizador Solair') }}</title>
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('material') }}/img/favicon.png">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
        <link href="{{ asset('assets') }}/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('layouts.page_templates.auth')
        @endauth
        @guest()
            @include('layouts.page_templates.guest')
        @endguest
        {{--@if (auth()->check())
        <div class="fixed-plugin">
          <div class="dropdown show-dropdown">
            <a href="#" data-toggle="dropdown">
              <i class="fa fa-cog fa-2x"> </i>
            </a>
            <ul class="dropdown-menu">
              <li class="header-title"> Sidebar Filters</li>
              <li class="adjustments-line">
                <a href="javascript:void(0)" class="switch-trigger active-color">
                  <div class="badge-colors ml-auto mr-auto">
                    <span class="badge filter badge-purple " data-color="purple"></span>
                    <span class="badge filter badge-azure" data-color="azure"></span>
                    <span class="badge filter badge-green" data-color="green"></span>
                    <span class="badge filter badge-warning active" data-color="orange"></span>
                    <span class="badge filter badge-danger" data-color="danger"></span>
                    <span class="badge filter badge-rose" data-color="rose"></span>
                  </div>
                  <div class="clearfix"></div>
                </a>
              </li>
              <li class="header-title">Images</li>
              <li class="active">
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                  <img src="{{ asset('material') }}/img/sidebar-1.jpg" alt="">
                </a>
              </li>
              <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                  <img src="{{ asset('material') }}/img/sidebar-2.jpg" alt="">
                </a>
              </li>
              <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                  <img src="{{ asset('material') }}/img/sidebar-3.jpg" alt="">
                </a>
              </li>
              <li>
                <a class="img-holder switch-trigger" href="javascript:void(0)">
                  <img src="{{ asset('material') }}/img/sidebar-4.jpg" alt="">
                </a>
              </li>
              <!-- <li class="header-title">Want more components?</li>
                  <li class="button-container">
                      <a href="https://www.creative-tim.com/product/material-dashboard-pro" target="_blank" class="btn btn-warning btn-block">
                        Get the pro version
                      </a>
                  </li> -->
            </ul>
          </div>
        </div>
        @endif--}}
        <!--   Core JS Files   -->
        <script src="{{ asset('material') }}/js/core/jquery.min.js"></script>
        <script src="{{ asset('material') }}/js/core/popper.min.js"></script>
        <script src="{{ asset('material') }}/js/core/bootstrap-material-design.min.js"></script>
        <script src="{{ asset('material') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
        <!-- Plugin for the momentJs  -->
        <script src="{{ asset('material') }}/js/plugins/moment.min.js"></script>
        <!--  Plugin for Sweet Alert -->
        <script src="{{ asset('material') }}/js/plugins/sweetalert2.js"></script>
        <!-- Forms Validations Plugin -->
        <script src="{{ asset('material') }}/js/plugins/jquery.validate.min.js"></script>
        <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
        <script src="{{ asset('material') }}/js/plugins/jquery.bootstrap-wizard.js"></script>
        <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
        <script src="{{ asset('material') }}/js/plugins/bootstrap-selectpicker.js"></script>
        <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
        <script src="{{ asset('material') }}/js/plugins/bootstrap-datetimepicker.min.js"></script>
        <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
        <script src="{{ asset('material') }}/js/plugins/jquery.dataTables.min.js"></script>
        <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
        <script src="{{ asset('material') }}/js/plugins/bootstrap-tagsinput.js"></script>
        <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
        <script src="{{ asset('material') }}/js/plugins/jasny-bootstrap.min.js"></script>
        <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
        <script src="{{ asset('material') }}/js/plugins/fullcalendar.min.js"></script>
        <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
        <script src="{{ asset('material') }}/js/plugins/jquery-jvectormap.js"></script>
        <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
        <script src="{{ asset('material') }}/js/plugins/nouislider.min.js"></script>
        <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
        <!-- Library for adding dinamically elements -->
        <script src="{{ asset('material') }}/js/plugins/arrive.min.js"></script>
        <!-- Chartist JS -->
        <script src="{{ asset('material') }}/js/plugins/chartist.min.js"></script>
        <!--  Notifications Plugin    -->
        <script src="{{ asset('material') }}/js/plugins/bootstrap-notify.js"></script>

        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{ asset('material') }}/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>

        <script src="{{ asset('material') }}/js/settings.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

        <!-- (Optional) Latest compiled and minified JavaScript translation files -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js"></script>
        <script>
            $('#orders-list a').on('click', function (e) {
                e.preventDefault()
                $(this).tab('show')
            })
        </script>
        <script>
            $('#inputGroupFile01').on('change',function(){
                //get the file name
                var fileName = $(this).val();
                //replace the "Choose a file" label
                $(this).next('.custom-file-label').html(fileName);
            })
        </script>
        <script>
            $('.dynamic').on('input', function (event) {
                event.preventDefault();
                if($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependent =  $(this).data('dependent');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route('toldo.fetch.numbers') }}',
                        method: 'POST',
                        data: {select:select, value:value, _token:_token, dependent:dependent},
                        success: function(result) {
                            $('#'+dependent).html(result);
                        }
                    })
                }
            });
        </script>
        <script>
            $('.dynamicC').on('input', function (event) {
                event.preventDefault();
                if($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependent =  $(this).data('dependent');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route('curtain.fetch.numbers') }}',
                        method: 'POST',
                        data: {select:select, value:value, _token:_token, dependent:dependent},
                        success: function(result) {
                            $('#'+dependent).html(result);
                        }
                    })
                }
            });
        </script>
        <script>
            $('.dynamic2').on('input', function (event) {
                event.preventDefault();
                if($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependent2 =  $(this).data('dependent2');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route('toldo.fetch.projection') }}',
                        method: 'POST',
                        data: {select:select, value:value, _token:_token, dependent2:dependent2},
                        success: function(result) {
                            $('#'+dependent2).html(result);
                        }
                    })
                }
            });
        </script>
        <script>
            $('.dynamic3').on('input', function (event) {
                event.preventDefault();
                if($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependent3 =  $(this).data('dependent3');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route('toldo.fetch.controls') }}',
                        method: 'POST',
                        data: {select:select, value:value, _token:_token, dependent3:dependent3},
                        success: function(result) {
                            $('#'+dependent3).html(result);
                        }
                    })
                }
            });
        </script>
        <script>
            $('.dynamic4').on('input', function (event) {
                event.preventDefault();
                if($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependent4 =  $(this).data('dependent4');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route('toldo.fetch.voices') }}',
                        method: 'POST',
                        data: {select:select, value:value, _token:_token, dependent4:dependent4},
                        success: function(result) {
                            $('#voice_id').html(result);
                        }
                    })
                }
            });
        </script>
        <script>
            $('.dynamic5').on('input', function (event) {
                event.preventDefault();
                if($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route('curtain.fetch.controls') }}',
                        method: 'POST',
                        data: {select:select, value:value, _token:_token},
                        success: function(result) {
                            $('#control_id').html(result);
                        }
                    })
                }
            });
        </script>
        <script>
            $('.dynamic6').on('input', function (event) {
                event.preventDefault();
                if($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route('curtain.fetch.voices') }}',
                        method: 'POST',
                        data: {select:select, value:value, _token:_token},
                        success: function(result) {
                            $('#voice_id').html(result);
                        }
                    })
                }
            });
        </script>
        <script>
            $('.dynamic7').on('input', function (event) {
                event.preventDefault();
                if($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route('screeny.fetch.controls') }}',
                        method: 'POST',
                        data: {select:select, value:value, _token:_token},
                        success: function(result) {
                            $('#control_id').html(result);
                        }
                    })
                }
            });
        </script>
        <script>
            $('.dynamic8').on('input', function (event) {
                event.preventDefault();
                if($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route('screeny.fetch.voices') }}',
                        method: 'POST',
                        data: {select:select, value:value, _token:_token},
                        success: function(result) {
                            $('#voice_id').html(result);
                        }
                    })
                }
            });
        </script>

        <script>
            $('.dynamicP1').on('input', function (event) {
                event.preventDefault();
                if($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependentP1 =  $(this).data('dependentP1');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route('palilleria.fetch.controls') }}',
                        method: 'POST',
                        data: {select:select, value:value, _token:_token, dependentP1:dependentP1},
                        success: function(result) {
                            $('#control_id').html(result);
                        }
                    })
                }
            });
        </script>

        <script>
            $('.dynamicP2').on('input', function (event) {
                event.preventDefault();
                if($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependentP2 =  $(this).data('dependentP2');
                    var _token = $('input[name="_token"]').val();
                    $.ajax({
                        url: '{{ route('palilleria.fetch.voices') }}',
                        method: 'POST',
                        data: {select:select, value:value, _token:_token, dependentP2:dependentP2},
                        success: function(result) {
                            $('#voice_id').html(result);
                        }
                    })
                }
            });
        </script>

        <script>
            $('#palilleriaForm').on('input', function (event) {
                event.preventDefault();
                let $wrapper = $('#palilleriaForm'),
                    cover_id = $wrapper.find('#cover_id').val(),
                    width = $wrapper.find('#width').val(),
                    height = $wrapper.find('#height').val(),
                    mechanism_id = $wrapper.find('#mechanism_id').val(),
                    quantity = $wrapper.find('#quantity').val(),
                    model_id = $wrapper.find('#model_id').val(),
                    reinforcement_quantity = $wrapper.find('#reinforcement_quantity').val()
                    _token = $('input[name="_token"]').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('palilleria.fetch.data') }}",
                    method: "POST",
                    data: {
                        cover_id: cover_id,
                        width:  width,
                        height: height,
                        mechanism_id: mechanism_id,
                        quantity: quantity,
                        model_id: model_id,
                        reinforcement_quantity: reinforcement_quantity,
                        _token: _token },
                    success: function (result) {
                        $('#dynamicInfoP').html(result);
                    }
                });
            });
        </script>
        <script>
            $('#palilleriaForm').on('input', function (event) {
                event.preventDefault();
                let $wrapper = $('#palilleriaForm'),
                    cover_id = $wrapper.find('#cover_id').val(),
                    height = $wrapper.find('#height').val(),
                    control_id = $wrapper.find('#control_id').val(),
                    mechanism_id = $wrapper.find('#mechanism_id').val(),
                    quantity = $wrapper.find('#quantity').val(),
                    reinforcement_quantity = $wrapper.find('#reinforcement_quantity').val(),
                    reinforcement_id = $wrapper.find('#reinforcement_id').val(),
                    control_quantity = $wrapper.find('#control_quantity').val(),
                    sensor_id = $wrapper.find('#sensor_id').val(),
                    sensor_quantity = $wrapper.find('#sensor_quantity').val(),
                    trave = $wrapper.find('#trave').val(),
                    trave_quantity = $wrapper.find('#trave_quantity').val(),
                    goal = $wrapper.find('#goal').val(),
                    goal_quantity = $wrapper.find('#goal_quantity').val(),
                    semigoal = $wrapper.find('#semigoal').val(),
                    semigoal_quantity = $wrapper.find('#semigoal_quantity').val(),
                    voice_quantity = $wrapper.find('#voice_quantity').val(),
                    voice_id = $wrapper.find('#voice_id').val(),
                    _token = $('input[name="_token"]').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('palilleria.fetch.accessories') }}",
                    method: "POST",
                    data: {
                        cover_id: cover_id,
                        height: height,
                        control_id: control_id,
                        mechanism_id: mechanism_id,
                        quantity: quantity,
                        reinforcement_quantity: reinforcement_quantity,
                        reinforcement_id: reinforcement_id,
                        control_quantity: control_quantity,
                        sensor_id: sensor_id,
                        sensor_quantity: sensor_quantity,
                        voice_quantity: voice_quantity,
                        voice_id: voice_id,
                        trave_quantity: trave_quantity,
                        trave: trave,
                        goal_quantity: goal_quantity,
                        goal: goal,
                        semigoal_quantity: semigoal_quantity,
                        semigoal: semigoal,
                        _token: _token },
                    success: function (result) {
                        $('#dynamicInfoPA').html(result);
                    }
                });
            });
        </script>
        <script>
            $('#toldoForm').on('input', function (event) {
                event.preventDefault();
                let $wrapper = $('#toldoForm'),
                    modelo_toldo_id = $wrapper.find('#modelo_toldo_id').val(),
                    cover_id = $wrapper.find('#cover_id').val(),
                    width = $wrapper.find('#width').val(),
                    projection = $wrapper.find('#projection').val(),
                    mechanism_id = $wrapper.find('#mechanism_id').val(),
                    quantity = $wrapper.find('#quantity').val(),
                    _token = $('input[name="_token"]').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('toldo.fetch.data') }}",
                    method: "POST",
                    data: {
                        modelo_toldo_id: modelo_toldo_id,
                        cover_id: cover_id,
                        width:  width,
                        projection: projection,
                        mechanism_id: mechanism_id,
                        quantity: quantity,
                        _token: _token },
                    success: function (result) {
                        $('#dynamicInfoT').html(result);
                    },
                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            msg = 'Por favor elija una combinación de valores válidos.';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                        $('#dynamicInfoT').html(msg);
                    }
                });
            });
        </script>
        <script>
            $('#curtainForm').on('input', function (event) {
                event.preventDefault();
                let $wrapper = $('#curtainForm'),
                    model_id = $wrapper.find('#model_id').val(),
                    cover_id = $wrapper.find('#cover_id').val(),
                    width = $wrapper.find('#width').val(),
                    height = $wrapper.find('#height').val(),
                    mechanism_id = $wrapper.find('#mechanism_id').val(),
                    quantity = $wrapper.find('#quantity').val(),
                    _token = $('input[name="_token"]').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('curtain.fetch.data') }}",
                    method: "POST",
                    data: {
                        model_id: model_id,
                        cover_id: cover_id,
                        width:  width,
                        height: height,
                        mechanism_id: mechanism_id,
                        quantity: quantity,
                        _token: _token },
                    success: function (result) {
                        $('#dynamicInfoCT').html(result);
                    },
                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            msg = 'Por favor elija una combinación de valores válidos.';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                        $('#dynamicInfoCT').html(msg);
                    }
                });
            });
        </script>
        <script>
            $('#coverForm').on('input', function (event) {
                event.preventDefault();
                let $wrapper = $('#coverForm'),
                    cover_id = $wrapper.find('#cover_id').val(),
                    _token = $('input[name="_token"]').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('curtain.fetch.cover') }}",
                    method: "POST",
                    data: {
                        cover_id: cover_id,
                        _token: _token },
                    success: function (result) {
                        $('#coverDynamic').html(result);
                    },
                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            msg = 'Por favor elija una combinación de valores válidos.';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                        $('#coverDynamic').html(msg);
                    }
                });
            });
        </script>
        <script>
            $('#screenyForm').on('input', function (event) {
                event.preventDefault();
                let $wrapper = $('#screenyForm'),
                    model_id = $wrapper.find('#model_id').val(),
                    cover_id = $wrapper.find('#cover_id').val(),
                    width = $wrapper.find('#width').val(),
                    height = $wrapper.find('#height').val(),
                    mechanism_id = $wrapper.find('#mechanism_id').val(),
                    quantity = $wrapper.find('#quantity').val(),
                    _token = $('input[name="_token"]').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('screeny.fetch.data') }}",
                    method: "POST",
                    data: {
                        model_id: model_id,
                        cover_id: cover_id,
                        width:  width,
                        height: height,
                        mechanism_id: mechanism_id,
                        quantity: quantity,
                        _token: _token },
                    success: function (result) {
                        $('#dynamicInfoST').html(result);
                    },
                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            msg = 'Por favor elija una combinación de valores válidos.';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                        $('#dynamicInfoST').html(msg);
                    }
                });
            });
        </script>
        <script>
            $('#toldoForm').on('input', function (event) {
                event.preventDefault();
                let $wrapper = $('#toldoForm'),
                    width = $wrapper.find('#width').val(),
                    handle_id = $wrapper.find('#handle_id').val(),
                    control_id = $wrapper.find('#control_id').val(),
                    mechanism_id = $wrapper.find('#mechanism_id').val(),
                    handle_quantity = $wrapper.find('#handle_quantity').val(),
                    sensor_id = $wrapper.find('#sensor_id').val(),
                    control_quantity = $wrapper.find('#control_quantity').val(),
                    voice_id = $wrapper.find('#voice_id').val(),
                    sensor_quantity = $wrapper.find('#sensor_quantity').val(),
                    voice_quantity = $wrapper.find('#voice_quantity').val(),
                    bambalina = $wrapper.find('#bambalina').val(),
                    canopy_id = $wrapper.find('#canopy_id').val(),
                    quantity = $wrapper.find('#quantity').val(),
                    _token = $('input[name="_token"]').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('toldo.fetch.accesories') }}",
                    method: "POST",
                    data: {
                        width:  width,
                        control_id: control_id,
                        mechanism_id: mechanism_id,
                        handle_quantity: handle_quantity,
                        sensor_id: sensor_id,
                        control_quantity: control_quantity,
                        handle_id: handle_id,
                        sensor_quantity: sensor_quantity,
                        voice_id: voice_id,
                        voice_quantity: voice_quantity,
                        bambalina: bambalina,
                        canopy_id: canopy_id,
                        quantity: quantity,
                        _token: _token },
                    success: function (result) {
                        $('#dynamicInfoA').html(result);
                    },
                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            msg = 'Por favor elija una combinación de valores válidos.';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                        $('#dynamicInfoA').html(msg);
                    }
                });
            });
        </script>
        <script>
            $('#curtainForm').on('input', function (event) {
                event.preventDefault();
                let $wrapper = $('#curtainForm'),
                    width = $wrapper.find('#width').val(),
                    handle_id = $wrapper.find('#handle_id').val(),
                    control_id = $wrapper.find('#control_id').val(),
                    mechanism_id = $wrapper.find('#mechanism_id').val(),
                    handle_quantity = $wrapper.find('#handle_quantity').val(),
                    sensor_id = $wrapper.find('#sensor_id').val(),
                    control_quantity = $wrapper.find('#control_quantity').val(),
                    voice_id = $wrapper.find('#voice_id').val(),
                    sensor_quantity = $wrapper.find('#sensor_quantity').val(),
                    voice_quantity = $wrapper.find('#voice_quantity').val(),
                    canopy_id = $wrapper.find('#canopy_id').val(),
                    quantity = $wrapper.find('#quantity').val(),
                    _token = $('input[name="_token"]').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('curtain.fetch.accesories') }}",
                    method: "POST",
                    data: {
                        width:  width,
                        control_id: control_id,
                        mechanism_id: mechanism_id,
                        handle_quantity: handle_quantity,
                        sensor_id: sensor_id,
                        control_quantity: control_quantity,
                        handle_id: handle_id,
                        sensor_quantity: sensor_quantity,
                        voice_id: voice_id,
                        voice_quantity: voice_quantity,
                        canopy_id: canopy_id,
                        quantity: quantity,
                        _token: _token },
                    success: function (result) {
                        $('#dynamicInfoCA').html(result);
                    },
                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            msg = 'Por favor elija una combinación de valores válidos.';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                        $('#dynamicInfoCA').html(msg);
                    }
                });
            });
        </script>
        <script>
            $('#screenyForm').on('input', function (event) {
                event.preventDefault();
                let $wrapper = $('#screenyForm'),
                    width = $wrapper.find('#width').val(),
                    handle_id = $wrapper.find('#handle_id').val(),
                    control_id = $wrapper.find('#control_id').val(),
                    mechanism_id = $wrapper.find('#mechanism_id').val(),
                    handle_quantity = $wrapper.find('#handle_quantity').val(),
                    sensor_id = $wrapper.find('#sensor_id').val(),
                    control_quantity = $wrapper.find('#control_quantity').val(),
                    voice_id = $wrapper.find('#voice_id').val(),
                    sensor_quantity = $wrapper.find('#sensor_quantity').val(),
                    voice_quantity = $wrapper.find('#voice_quantity').val(),
                    canopy_id = $wrapper.find('#canopy_id').val(),
                    quantity = $wrapper.find('#quantity').val(),
                    _token = $('input[name="_token"]').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('screeny.fetch.accesories') }}",
                    method: "POST",
                    data: {
                        width:  width,
                        control_id: control_id,
                        mechanism_id: mechanism_id,
                        handle_quantity: handle_quantity,
                        sensor_id: sensor_id,
                        control_quantity: control_quantity,
                        handle_id: handle_id,
                        sensor_quantity: sensor_quantity,
                        voice_id: voice_id,
                        voice_quantity: voice_quantity,
                        canopy_id: canopy_id,
                        quantity: quantity,
                        _token: _token },
                    success: function (result) {
                        $('#dynamicInfoSA').html(result);
                    },
                    error: function (jqXHR, exception) {
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            msg = 'Por favor elija una combinación de valores válidos.';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                        $('#dynamicInfoSA').html(msg);
                    }
                });
            });
        </script>

        <script>
            $('#addressCheck').change(function () {
                if (this.checked) {
                    document.getElementById('addressForm').classList.add('d-none');
                } else {
                    document.getElementById('addressForm').classList.remove('d-none');
                }
            });
        </script>
        @stack('js')
    </body>
</html>
