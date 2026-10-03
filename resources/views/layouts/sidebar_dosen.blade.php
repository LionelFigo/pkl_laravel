<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a href="{{ route('home.dosen') }}" class="nav-link {{ request()->routeIs('home.dosen') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Beranda Dosen</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('dosen.kelas.index') }}" class="nav-link {{ request()->routeIs('dosen.kelas.*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-calendar-check"></i>
        <p>Kelas Mata Kuliah</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('logout') }}" class="nav-link">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Keluar</p>
      </a>
    </li>
  </ul>
</nav>
