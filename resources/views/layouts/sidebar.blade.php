<!-- Sidebar Search Form -->
<div class="form-inline mt-2">
  <div class="input-group" data-widget="sidebar-search">
    <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
    <div class="input-group-append">
      <button class="btn btn-sidebar">
        <i class="fas fa-search fa-fw"></i>
      </button>
    </div>
  </div>
</div>

<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    <!-- Dashboard -->
    <li class="nav-item">
      <a href="{{ url('/') }}" class="nav-link {{ ($activeMenu == 'dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
      </a>
    </li>

    <!-- Data Pengguna -->
    <li class="nav-header">Data Pengguna</li>
    <li class="nav-item">
      <a href="{{ url('/user') }}" class="nav-link {{ ($activeMenu == 'user') ? 'active' : '' }}">
        <i class="nav-icon fas fa-user"></i>
        <p>Data User</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ url('/position') }}" class="nav-link {{ ($activeMenu == 'position') ? 'active' : '' }}">
        <i class="nav-icon fas fa-briefcase"></i>
        <p>Position</p>
      </a>
    </li>

    <!-- Store -->
    <li class="nav-header">Store</li>
    <li class="nav-item">
      <a href="{{ url('/branch') }}" class="nav-link {{ ($activeMenu == 'branch') ? 'active' : '' }}">
        <i class="nav-icon fas fa-store"></i>
        <p>Branch</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ url('/employee') }}" class="nav-link {{ ($activeMenu == 'employee') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>Employee</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ url('/barang') }}" class="nav-link {{ ($activeMenu == 'penjualan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-chart-line"></i> <!-- ganti dengan ikon relevan -->
        <p>Performances</p>
      </a>
    </li>    
  </ul>
</nav>
