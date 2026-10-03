<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a href="{{ route('home.mahasiswa') }}" class="nav-link {{ request()->routeIs('home.mahasiswa') || request()->routeIs('home.mhs') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Beranda Mahasiswa</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="{{ route('mahasiswa.presensi') }}" class="nav-link {{ request()->routeIs('mahasiswa.presensi*') || request()->routeIs('proses.presensi') ? 'active' : '' }}">
        <i class="nav-icon fas fa-calendar-check"></i>
        <p>Presensi</p>
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
