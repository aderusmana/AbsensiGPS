<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
            aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="/admin/dashboard">
                <img src="{{ asset('assetsAdmin') }}/dist/img/logoAdmin.png" width="160" height="50"
                    alt="Tabler">
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item d-none d-lg-flex me-3">
            </div>
            <div class="d-none d-lg-flex">
                <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode"
                    data-bs-toggle="tooltip" data-bs-placement="bottom">
                    <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
                    </svg>
                </a>
                <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode"
                    data-bs-toggle="tooltip" data-bs-placement="bottom">
                    <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                        <path
                            d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
                    </svg>
                </a>
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                    aria-label="Open user menu">
                    <span class="avatar avatar-sm"
                        style="background-image: url({{ asset('assetsAdmin') }}/static/avatars/000m.jpg)"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>Paweł Kuna</div>
                        <div class="mt-1 small text-muted">UI Designer</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="#" class="dropdown-item">Status</a>
                    <a href="{{ asset('assetsAdmin') }}/profile.html" class="dropdown-item">Profile</a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ asset('assetsAdmin') }}/settings.html" class="dropdown-item">Settings</a>
                    <a href="/admin/logout" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item {{ request()->is(['admin/dashboard']) ? 'active' : '' }}">
                    <a class="nav-link" href="/admin/dashboard">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Home
                        </span>
                    </a>
                </li>
                <li
                    class="nav-item dropdown {{ request()->is(['admin/karyawan', 'admin/department']) ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle {{ request()->is(['karyawan', 'department']) ? 'show' : '' }}"
                        href="#navbar-base" data-bs-toggle="dropdown"
                        data-bs-auto-close="{{ request()->is(['admin/karyawan', 'admin/department']) ? 'true' : 'false' }}"
                        role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/package -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                                <path d="M12 12l8 -4.5" />
                                <path d="M12 12l0 9" />
                                <path d="M12 12l-8 -4.5" />
                                <path d="M16 5.25l-8 4.5" />
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Data Master
                        </span>
                    </a>
                    <div
                        class="dropdown-menu {{ request()->is(['admin/karyawan', 'admin/department', 'admin/cabang']) ? 'show' : '' }}">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item {{ request()->is(['admin/karyawan']) ? 'active' : '' }}"
                                    href="/admin/karyawan">
                                    Data Karyawan
                                </a>
                                <a class="dropdown-item {{ request()->is(['admin/department']) ? 'active' : '' }}"
                                    href="/admin/department">
                                    Data Departemen
                                </a>

                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item {{ request()->is(['admin/monitoring']) ? 'active' : '' }}">
                    <a class="nav-link " href="/admin/monitoring">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-heart-rate-monitor" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M3 4m0 1a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1z">
                                </path>
                                <path d="M7 20h10"></path>
                                <path d="M9 16v4"></path>
                                <path d="M15 16v4"></path>
                                <path d="M7 10h2l2 3l2 -6l1 3h3"></path>
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Monitoring Absensi
                        </span>
                    </a>
                </li>
                <li class="nav-item {{ request()->is(['admin/dataIzinSakit']) ? 'active' : '' }}">
                    <a class="nav-link" href="/admin/dataIzinSakit">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/home -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-report-medical" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2">
                                </path>
                                <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z">
                                </path>
                                <path d="M10 14l4 0"></path>
                                <path d="M12 12l0 4"></path>
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Data Izin dan Sakit
                        </span>
                    </a>
                </li>
                <li
                    class="nav-item dropdown {{ request()->is(['admin/laporanAbsensi', 'admin/rekapAbsensi']) ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle {{ request()->is(['admin/laporanAbsensi', 'admin/rekapAbsensi']) ? 'show' : '' }}"
                        href="#navbar-base" data-bs-toggle="dropdown"
                        data-bs-auto-close="{{ request()->is(['admin/laporanAbsensi', 'admin/rekapAbsensi']) ? 'true' : 'false' }}"
                        role="button" aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/package -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-clipboard-data" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path
                                    d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2">
                                </path>
                                <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z">
                                </path>
                                <path d="M9 17v-4"></path>
                                <path d="M12 17v-1"></path>
                                <path d="M15 17v-2"></path>
                                <path d="M12 17v-1"></path>
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Data Laporan
                        </span>
                    </a>
                    <div
                        class="dropdown-menu {{ request()->is(['admin/laporanAbsensi', 'admin/rekapAbsensi']) ? 'show' : '' }}">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item {{ request()->is(['admin/laporanAbsensi']) ? 'active' : '' }}"
                                    href="/admin/laporanAbsensi">
                                    Laporan Absensi
                                </a>
                                <a class="dropdown-item {{ request()->is(['admin/rekapAbsensi']) ? 'active' : '' }}"
                                    href="/admin/rekapAbsensi">
                                    Rekap Absensi
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item dropdown {{ request()->is(['admin/lokasi', 'admin/jamKerja']) ? 'active' : '' }}">
                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                        data-bs-auto-close="{{ request()->is(['admin/lokasi']) ? 'true' : 'false' }}" role="button"
                        aria-expanded="false">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <!-- Download SVG icon from http://tabler-icons.io/i/package -->
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-current-location" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                <path d="M12 12m-8 0a8 8 0 1 0 16 0a8 8 0 1 0 -16 0"></path>
                                <path d="M12 2l0 2"></path>
                                <path d="M12 20l0 2"></path>
                                <path d="M20 12l2 0"></path>
                                <path d="M2 12l2 0"></path>
                            </svg>
                        </span>
                        <span class="nav-link-title">
                            Konfigurasi
                        </span>
                    </a>
                    <div class="dropdown-menu {{ request()->is(['admin/lokasi', 'admin/jamKerja']) ? 'show' : '' }} ">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item {{ request()->is(['admin/cabang']) ? 'active' : '' }}"
                                    href="/admin/cabang">
                                    Data Cabang
                                </a>
                            </div>
                        </div>
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                <a class="dropdown-item {{ request()->is(['admin/jamKerja']) ? 'active' : '' }}"
                                    href="/admin/jamKerja">
                                    Jam Kerja
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</aside>
