<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <img class="mx-auto" src="/img/logo/logo.png" width="120px" alt="">

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item {{ Route::current()->getName() == 'dashboard' ? 'active' : '' }}">
            <a href="/" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Analytics">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ Route::current()->getName() == 'absen' ? 'active' : '' }}">
            <a href="/absen" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-user-check'></i>
                <div data-i18n="Analytics">Absensi</div>
            </a>
        </li>
        <li class="menu-item {{ Route::current()->getName() == 'history' ? 'active' : '' }}">
            <a href="/history" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-report'></i>
                <div data-i18n="Analytics">Riwayat</div>
            </a>
        </li>

        @if (
            Auth::user()->id_jabatan == '1' ||
            Auth::user()->id_jabatan == '2' ||
            Auth::user()->id_jabatan == '3'
        )
            <li class="menu-item {{ str_contains(Route::current()->getName(), 'users.') ? 'active' : '' }}">
                <a href="/users" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-user-account'></i>
                    <div data-i18n="Analytics">Data Karyawan</div>
                </a>
            </li>
            <li class="menu-item {{ str_contains(Route::current()->getName(), 'recap') ? 'active' : '' }}">
                <a href="/recap" class="menu-link">
                    <i class='menu-icon tf-icons bx bx-book-bookmark'></i>
                    <div data-i18n="Analytics">Rekap Per Orang</div>
                </a>
            </li>
            <li class="menu-item {{ str_contains(Route::current()->getName(), 'settings') ? 'active' : '' }}">
                <a href="/settings" class="menu-link">
                    <i class='menu-icon tf-icons bx bxs-cog'></i>
                    <div data-i18n="Analytics">Pengaturan</div>
                </a>
            </li>
        @endif
    </ul>
</aside>
