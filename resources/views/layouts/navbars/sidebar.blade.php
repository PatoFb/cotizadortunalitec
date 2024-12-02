<div class="sidebar" data-color="grey" data-background-color="blue" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="/home" class="simple-text logo-normal">
        <img src="{{ asset('material') }}/img/logo.png" data-at2x="images/logo@2x.png" alt="Toldos y sombrillas" title="Toldos retractiles">
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      {{--<li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>--}}
        <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('profile.edit') }}">
                <i class="material-icons">person</i>
                <p>{{ __('Perfil') }}</p>
            </a>
        </li>
        <li class="nav-item{{ $activePage == 'contact' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('contact') }}">
                <i class="material-icons">contact_page</i>
                <p>{{ __('Contacto') }}</p>
            </a>
        </li>
        @if (\Illuminate\Support\Facades\Auth::user()->role_id != 3)
        <li class="nav-item{{ $activePage == 'orders' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('orders.new') }}">
                <i class="material-icons">add_shopping_cart</i>
                <p>{{ __('Cotizar') }}</p>
            </a>
        </li>
        <li class="nav-item{{ $activePage == 'myorders' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('orders.index') }}">
                <i class="material-icons">list</i>
                <p>{{ __('Mis proyectos') }}</p>
            </a>
        </li>
        @if (\Illuminate\Support\Facades\Auth::user()->role_id == 1)
        <li class="nav-item{{ $activePage == 'allorders' ? ' active' : '' }}">
            <a class="nav-link" href="{{ route('orders.all') }}">
                <i class="material-icons">list</i>
                <p>{{ __('Proyectos') }}</p>
            </a>
        </li>
      <li class="nav-item {{ ($activePage == 'usuarios') || ($activePage == 'controles') || ($activePage == 'tipos')
                              || ($activePage == 'manivelas_cortina') || ($activePage == 'modelos_cortina') || ($activePage == 'cubiertas') ||
                              ($activePage == 'mecanismos') || ($activePage == 'record') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#admin" aria-expanded="true">
            <i class="material-icons">settings_application</i>
          <p>{{ __('Admin') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse {{ ($activePage == 'usuarios') || ($activePage == 'controles') || ($activePage == 'tipos')
                              || ($activePage == 'manivelas_cortina') || ($activePage == 'modelos_cortina') || ($activePage == 'cubiertas') ||
                              ($activePage == 'mecanismos') || ($activePage == 'record') ? ' show' : 'hide' }}" id="admin">
          <ul class="nav">
              <li class="nav-item{{ $activePage == 'record' ? ' active' : '' }}">
                  <a class="nav-link" href="{{ route('orders.record') }}">
                      <span class="sidebar-mini"> H </span>
                      <span class="sidebar-normal">{{ __('Historial de proyectos') }}</span>
                  </a>
              </li>
              <li class="nav-item{{ $activePage == 'usuarios' ? ' active' : '' }}">
                  <a class="nav-link" href="{{ route('users.index') }}">
                      <span class="sidebar-mini"> U </span>
                      <span class="sidebar-normal"> {{ __('Usuarios') }} </span>
                  </a>
              </li>
          </ul>
        </div>

      </li>
            @endif
        @endif
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
