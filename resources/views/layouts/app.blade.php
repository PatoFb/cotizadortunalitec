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
            $('.dynamicPro').on('input', function (event) {
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
            $('#coverFormT').on('input', function (event) {
                event.preventDefault();
                let $wrapper = $('#coverFormT'),
                    cover_id = $wrapper.find('#cover_id').val(),
                    _token = $('input[name="_token"]').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('toldo.fetch.cover') }}",
                    method: "POST",
                    data: {
                        cover_id: cover_id,
                        _token: _token },
                    success: function (result) {
                        $('#coverDynamicT').html(result);
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
                        $('#coverDynamicT').html(msg);
                    }
                });
            });
        </script>

        <script>
            $('#coverFormP').on('input', function (event) {
                event.preventDefault();
                let $wrapper = $('#coverFormP'),
                    cover_id = $wrapper.find('#cover_id').val(),
                    _token = $('input[name="_token"]').val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('[name="_token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('palilleria.fetch.cover') }}",
                    method: "POST",
                    data: {
                        cover_id: cover_id,
                        _token: _token },
                    success: function (result) {
                        $('#coverDynamicP').html(result);
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
                        $('#coverDynamicP').html(msg);
                    }
                });
            });
        </script>

        <script>
            $(document).ready(function() {
                // Function to calculate the multiplication
                function calculateMultiplication() {
                    const width = parseFloat($('#width').val());
                    const height = parseFloat($('#height').val());

                    if (!isNaN(width) && !isNaN(height)) {
                        const multiplication = width * height;
                        $('#squared').val(multiplication); // Set the value of the input field
                    } else {
                        $('#squared').val(''); // Clear the input field if any input is not a number
                    }
                }

                // Bind the calculation function to input changes
                $('#width, #height').on('input', calculateMultiplication);

                // Initial calculation
                calculateMultiplication();
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
