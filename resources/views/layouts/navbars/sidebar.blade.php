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
      {{-- {{ dd(session('token')) }} --}}
       @if(session('access_menu'))
        @foreach(session('access_menu') as $menu)
          @if($menu['tb_menu']['menu_function_id'] == 1 && $menu['tb_menu']['menu_name'] == 'orders')
            <li class = "@if ($activePage == 'orders') active @endif">
              <a href="{{ route('orders.index') }}">
                <i class="now-ui-icons shopping_delivery-fast"></i>
                <p>{{ __('Orders') }}</p>
              </a>
            </li>
          @endif

          @if($menu['tb_menu']['menu_function_id'] == 1 && $menu['tb_menu']['menu_name'] == 'users')
          <li class="@if ($activePage == 'users') active @endif">
            <a href="{{ route('user.index') }}">
              <i class="now-ui-icons users_single-02"></i>
              <p> {{ __("Users") }} </p>
            </a>
          </li>
          @endif

          @if($menu['tb_menu']['menu_function_id'] == 1 && $menu['tb_menu']['menu_name'] == 'clients')
          <li class="@if ($activePage == 'clients') active @endif">
            <a href="{{ route('clients.index') }}">
              <i class="now-ui-icons business_briefcase-24"></i>
              <p> {{ __("Clients") }} </p>
            </a>
          </li>
          @endif

          @if($menu['tb_menu']['menu_function_id'] == 1 && $menu['tb_menu']['menu_name'] == 'user-role')
          <li class="@if ($activePage == 'user-role') active @endif">
            <a href="{{ route('role.index') }}">
              <i class="now-ui-icons ui-1_settings-gear-63"></i>
              <p> {{ __("User-role") }} </p>
            </a>
          </li>
          @endif

        @endforeach
      @endif

    </ul>
  </div>
</div>
