<div class="sidebar" data-color="danger" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="/" class="simple-text logo-normal">
      {{ __('Cotizador') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
        <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('profile.edit') }}">
                <i class="material-icons">person</i>
                <p>{{ __('Perfil') }}</p>
            </a>
        </li>
      <li class="nav-item {{ ($activePage == 'usuarios') || ($activePage == 'controles_cortina') || ($activePage == 'tipos') || ($activePage == 'tejaillos_cortina')
                              || ($activePage == 'manivelas_cortina') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
            <i class="material-icons">settings_application</i>
          <p>{{ __('Admin') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="laravelExample">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'usuarios' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('users.index') }}">
                <span class="sidebar-mini"> U </span>
                <span class="sidebar-normal"> {{ __('Usuarios') }} </span>
              </a>
            </li>
              <li class="nav-item{{ $activePage == 'tipos' ? ' active' : '' }}">
                  <a class="nav-link" href="{{ route('types.index') }}">
                      <span class="sidebar-mini"> TP </span>
                      <span class="sidebar-normal"> {{ __('Tipos de productos') }} </span>
                  </a>
              </li>
              <li class="nav-item{{ $activePage == 'controles_cortina' ? ' active' : '' }}">
                  <a class="nav-link" href="{{ route('controls.index') }}">
                      <span class="sidebar-mini"> CC </span>
                      <span class="sidebar-normal"> {{ __('Controles para cortina') }} </span>
                  </a>
              </li>
              <li class="nav-item{{ $activePage == 'tejadillos_cortina' ? ' active' : '' }}">
                  <a class="nav-link" href="{{ route('canopies.index') }}">
                      <span class="sidebar-mini"> T </span>
                      <span class="sidebar-normal"> {{ __('Tejadillos') }} </span>
                  </a>
              </li>
              <li class="nav-item{{ $activePage == 'manivelas_cortina' ? ' active' : '' }}">
                  <a class="nav-link" href="{{ route('handles.index') }}">
                      <span class="sidebar-mini"> M </span>
                      <span class="sidebar-normal"> {{ __('Manivelas') }} </span>
                  </a>
              </li>
          </ul>
        </div>
      </li>
        {{--<li class="nav-item{{ $activePage == 'table' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('table') }}">
                <i class="material-icons">payments</i>
                <p>{{ __('Cotizar') }}</p>
            </a>
        </li>
      <li class="nav-item{{ $activePage == 'table' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('table') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Table List') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('typography') }}">
          <i class="material-icons">library_books</i>
            <p>{{ __('Typography') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('icons') }}">
          <i class="material-icons">bubble_chart</i>
          <p>{{ __('Icons') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'map' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('map') }}">
          <i class="material-icons">location_ons</i>
            <p>{{ __('Maps') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('notifications') }}">
          <i class="material-icons">notifications</i>
          <p>{{ __('Notifications') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('language') }}">
          <i class="material-icons">language</i>
          <p>{{ __('RTL Support') }}</p>
        </a>
      </li>--}}
    </ul>
  </div>
</div>