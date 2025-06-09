<div class="user-panel mt-3 pb-3 mb-3 d-flex">
  <div class="image">
    <img src="{{ asset('admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
  </div>
  <div class="info">
    <a href="#" class="d-block">{{ auth()->user()->name ?? 'superadmin' }}</a>
  </div>
</div>

<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <a href="{{ route('admin.home') }}" class="nav-link @if(Route::is('admin.home')) active @endif">
          <i class="nav-icon fa fa-home"></i>
          <p>
            Dashboard
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('universities.index') }}" class="nav-link @if(Route::is('universities.*')) active @endif">
          <i class="nav-icon fa fa-school"></i>
          <p>
            Universitas
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('customer.index') }}" class="nav-link @if(Route::is('customer.*')) active @endif">
          <i class="nav-icon fa fa-users"></i>
          <p>
            Customer
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('package-record.index') }}" class="nav-link @if(Route::is('package-record.*')) active @endif">
          <i class="nav-icon fa fa-briefcase"></i>
          <p>
            Langganan
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('payment.index') }}" class="nav-link @if(Route::is('payment.*')) active @endif">
          <i class="nav-icon fa fa-money-bill"></i>
          <p>
            Pembayaran
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('package.index') }}" class="nav-link @if(Route::is('package.*')) active @endif">
          <i class="nav-icon fa fa-suitcase"></i>
          <p>
            Paket
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('user-affiliates.index') }}" class="nav-link @if(Route::is('user-affiliates.*')) active @endif">
          <i class="nav-icon fa fa-dollar-sign"></i>
          <p>
            Withdraw
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('file.index') }}" class="nav-link @if(Route::is('file.*')) active @endif">
          <i class="nav-icon fa fa-file"></i>
          <p>
            File
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('superadmin.index') }}" class="nav-link @if(Route::is('superadmin.*')) active @endif">
          <i class="nav-icon fa fa-user"></i>
          <p>
            Superadmin
          </p>
        </a>
      </li>
      <li class="nav-item">
        <a href="{{ route('configuration.index') }}" class="nav-link @if(Route::is('configuration.*')) active @endif">
          <i class="nav-icon fa fa-cog"></i>
          <p>
            Konfigurasi
          </p>
        </a>
      </li>
    </ul>
</nav>