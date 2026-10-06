<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        
        <!-- Menu Beranda -->
        <li class="nav-item">
            <a href="{{ route('home.admin') }}" class="nav-link {{ request()->routeIs('home.admin') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Beranda</p>
            </a>
        </li>

        <!-- Menu Dropdown Master Data -->
        <li class="nav-item {{ request()->routeIs(['admin.data_administrator', 'admin.mahasiswa.*', 'admin.dosen.*', 'admin.periode.*', 'admin.jurusan.*', 'admin.matkul.*']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ request()->routeIs(['admin.data_administrator', 'admin.mahasiswa.*', 'admin.dosen.*', 'admin.periode.*', 'admin.jurusan.*', 'admin.matkul.*']) ? 'active' : '' }}">
                <i class="nav-icon fas fa-database"></i>
                <p>
                    Master Data
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('admin.data_administrator') }}" class="nav-link {{ request()->routeIs('admin.data_administrator') ? 'active' : '' }}">
                        <i class="nav-icon far fa-circle"></i>
                        <p>Data Administrator</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.mahasiswa.index') }}" class="nav-link {{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-circle"></i>
                        <p>Data Mahasiswa</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.dosen.index') }}" class="nav-link {{ request()->routeIs('admin.dosen.*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-circle"></i>
                        <p>Data Dosen</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.periode.index') }}" class="nav-link {{ request()->routeIs('admin.periode.*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-circle"></i>
                        <p>Data Periode Akademik</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.jurusan.index') }}" class="nav-link {{ request()->routeIs('admin.jurusan.*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-circle"></i>
                        <p>Data Jurusan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.matkul.index') }}" class="nav-link {{ request()->routeIs('admin.matkul.*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-circle"></i>
                        <p>Data Mata Kuliah</p>
                    </a>
                </li>
            </ul>
        </li>

        <!-- Data Kelas Mata Kuliah (Berdiri Sendiri) -->
        <li class="nav-item">
            <a href="{{ route('admin.kelas.index') }}" class="nav-link {{ request()->routeIs('admin.kelas.*') ? 'active' : '' }}">
                <i class="nav-icon fas fa-door-open"></i>
                <p>Data Kelas Mata Kuliah</p>
            </a>
        </li>

        <!-- Menu Keluar -->
        <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Keluar</p>
            </a>
        </li>
        
    </ul>
</nav>