<style>
    hr.dashed {
    border-top: 2px dashed rgb(255, 255, 255);
}
</style>

<div class="sidebar" data-color="orange">
  <!--
    Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
-->
  <div class="logo">
    <a href="/home" class="simple-text logo-mini">
      {{ __('TEX') }}
    </a>
    <a href="/home" class="simple-text logo-normal">
      {{ __('Tujuh Express UDB') }}
    </a>
  </div>
  <div class="sidebar-wrapper" id="sidebar-wrapper">
    <ul class="nav">
      <!--<li class="@if ($activePage == 'home') active @endif">
        <a href="{{ route('home') }}">
          <i class="now-ui-icons design_app"></i>
          <p>{{ __('Dashboard') }}</p>
        </a>
      </li>-->


      <li class = "@if ($activePage == 'Orders') active @endif">
        <a href="{{ route('orders.index') }}">
          <i class="now-ui-icons shopping_delivery-fast"></i>
          <p>{{ __('Orders') }}</p>
        </a>
      </li>

      <li class="@if ($activePage == 'users') active @endif">
        <a href="{{ route('user.index') }}">
          <i class="now-ui-icons users_single-02"></i>
          <p> {{ __("Users") }} </p>
        </a>
      </li>

      <li class="@if ($activePage == 'clients') active @endif">
        <a href="{{ route('clients.index') }}">
          <i class="now-ui-icons business_briefcase-24"></i>
          <p> {{ __("Clients") }} </p>
        </a>
      </li>
      <hr class="dashed">
      <li class="@if ($activePage == 'Menu Management') active @endif">
        <a href="{{ route('menu.index') }}">
          <i class="now-ui-icons loader_gear"></i>
          <p> {{ __("Menu Management") }} </p>
        </a>
      </li>

      {{-- {{ dd($activePage) }} --}}
      <!--<li>
        <a data-toggle="collapse" href="#laravelExamples">
            <i class="fab fa-laravel"></i>
          <p>
            {{ __("Laravel Examples") }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="laravelExamples">
          <ul class="nav">
            <li class="@if ($activePage == 'profile') active @endif">
              <a href="{{ route('profile.edit') }}">
                <i class="now-ui-icons users_single-02"></i>
                <p> {{ __("User Profile") }} </p>
              </a>
            </li>

            </li>
          </ul>
        </div>
      <li class="@if ($activePage == 'icons') active @endif">
        <a href="{{ route('page.index','icons') }}">
          <i class="now-ui-icons education_atom"></i>
          <p>{{ __('Icons') }}</p>
        </a>
      </li>
      <li class = "@if ($activePage == 'maps') active @endif">
        <a href="{{ route('page.index','maps') }}">
          <i class="now-ui-icons location_map-big"></i>
          <p>{{ __('Maps') }}</p>
        </a>
      </li>
      <li class = " @if ($activePage == 'notifications') active @endif">
        <a href="{{ route('page.index','notifications') }}">
          <i class="now-ui-icons ui-1_bell-53"></i>
          <p>{{ __('Notifications') }}</p>
        </a>
      </li>
      <li class = " @if ($activePage == 'table') active @endif">
        <a href="{{ route('page.index','table') }}">
          <i class="now-ui-icons design_bullet-list-67"></i>
          <p>{{ __('Table List') }}</p>
        </a>
      </li>
      <li class = "@if ($activePage == 'typography') active @endif">
        <a href="{{ route('page.index','typography') }}">
          <i class="now-ui-icons text_caps-small"></i>
          <p>{{ __('Typography') }}</p>
        </a>
      </li>-->

    </ul>
  </div>
</div>
