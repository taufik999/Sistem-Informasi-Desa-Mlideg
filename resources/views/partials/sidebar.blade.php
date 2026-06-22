@php 
    $p_surat = \App\Models\Surat::where('status', 'Menunggu Validasi')->count();
    $p_adu = \App\Models\Pengaduan::where('status', 'Menunggu Validasi')->count();
    
    $role = session('role') ?? 'Admin';
    $user = session('user') ?? 'User';
@endphp

<aside class="sidebar">
    <a href="/dashboard" class="sidebar-brand"><i class="fa-solid fa-shield-halved"></i><span>SID ADMIN</span></a>
    <ul class="sidebar-menu">

        <p class="menu-title">Menu Utama</p>
        <li class="{{ request()->is('dashboard') ? 'active' : '' }}"><a href="/dashboard"><i class="fa-solid fa-chart-pie"></i> Dashboard</a></li>
        <li class="{{ request()->is('penduduk') ? 'active' : '' }}"><a href="/penduduk"><i class="fa-solid fa-users"></i> Data Penduduk</a></li>
        <li class="{{ request()->is('admin/kk*') ? 'active' : '' }}"><a href="/admin/kk"><i class="fa-solid fa-users-rectangle"></i> Daftar KK</a></li>
        <li class="{{ request()->is('admin/surat*') ? 'active' : '' }}"><a href="/admin/surat"><i class="fa-solid fa-envelope-open-text"></i> Layanan Surat @if($p_surat > 0)<span style="background: #ef4444; color: white; font-size: 0.7rem; font-weight: 800; padding: 2px 6px; border-radius: 10px; margin-left: auto;">{{ $p_surat }}</span>@endif</a></li>
        
        <p class="menu-title" style="margin-top: 1.5rem;">Laporan Warga</p>
        <li class="{{ request()->is('pengaduan*') ? 'active' : '' }}"><a href="/pengaduan"><i class="fa-solid fa-bullhorn"></i> Daftar Pengaduan @if($p_adu > 0)<span style="background: #ef4444; color: white; font-size: 0.7rem; font-weight: 800; padding: 2px 6px; border-radius: 10px; margin-left: auto;">{{ $p_adu }}</span>@endif</a></li>
        
        @if(session('role') === 'Super Admin')
            <p class="menu-title" style="margin-top: 1.5rem;">Manajemen Internal</p>
            <li class="{{ request()->is('admin/perangkat*') ? 'active' : '' }}"><a href="/admin/perangkat"><i class="fa-solid fa-sitemap"></i> Struktur Organisasi</a></li>
            <li class="{{ request()->is('admin/users*') ? 'active' : '' }}"><a href="/admin/users"><i class="fa-solid fa-user-shield"></i> Manajemen Role</a></li>
        @endif

        @if(session('role') === 'Super Admin')
            <p class="menu-title" style="margin-top: 1.5rem;">Kelola Konten</p>
            <li class="{{ request()->is('admin/beranda') ? 'active' : '' }}"><a href="/admin/beranda"><i class="fa-solid fa-home"></i> Pengaturan Beranda</a></li>
            <li class="{{ request()->is('admin/profil') ? 'active' : '' }}"><a href="/admin/profil"><i class="fa-solid fa-address-card"></i> Pengaturan Profil</a></li>
            <li class="{{ request()->is('admin/berita*') ? 'active' : '' }}"><a href="/admin/berita"><i class="fa-solid fa-newspaper"></i> Berita & Artikel</a></li>
            <li class="{{ request()->is('admin/galeri*') ? 'active' : '' }}"><a href="/admin/galeri"><i class="fa-solid fa-images"></i> Galeri Desa</a></li>
            <li class="{{ request()->is('admin/potensi*') ? 'active' : '' }}"><a href="/admin/potensi"><i class="fa-solid fa-seedling"></i> Potensi Desa</a></li>
            
            <p class="menu-title" style="margin-top: 1.5rem;">Sistem</p>
            <li class="{{ request()->is('admin/ahp*') ? 'active' : '' }}"><a href="/admin/ahp"><i class="fa-solid fa-gears"></i> Pengaturan AHP</a></li>
        @endif
    
        <li class="logout-sidebar-item" style="margin-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05); padding-top: 1rem;">
            <a href="/logout" onMouseOver="this.style.color='#f87171'" onMouseOut="this.style.color='#cbd5e1'"><i class="fa-solid fa-arrow-right-from-bracket" style="color: #ef4444;"></i> Log Out</a>
        </li>
    </ul>
    <div class="sidebar-user">
        <div class="user-avatar">{{ substr($user, 0, 1) }}</div>
        <div class="user-info"><h4>{{ $user }}</h4><p>{{ $role }}</p></div>
    </div>
</aside>
