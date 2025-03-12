<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-header">Master</li>
      <li class="nav-item">
        <a href="{{ route('customer.index') }}" class="nav-link @if(Route::is('customer.*')) active @endif">
          <i class="nav-icon far fa-user"></i>
          <p>
            Customer
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('package.index') }}" class="nav-link @if(Route::is('package.*')) active @endif">
          <i class="nav-icon far fa-user"></i>
          <p>
            Paket Langganan
          </p>
        </a>
      </li>
    </ul>
</nav>