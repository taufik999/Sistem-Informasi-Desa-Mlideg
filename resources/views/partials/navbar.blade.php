<style>
/* CSS Navbar Global */
.navbar {
    display: flex; justify-content: space-between; align-items: center;
    padding: 1rem 5%; background-color: var(--bg-light);
    box-shadow: 0 4px 6px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000;
}
.nav-brand-container {
    display: flex; align-items: center; gap: 1.5rem;
}
.nav-brand {
    display: flex; align-items: center; gap: 1rem; text-decoration: none;
}
.brand-icon {
    width: 45px; height: 45px; background-color: var(--primary); color: white;
    border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
}
.brand-text { display: flex; flex-direction: column; }
.brand-title { font-size: 1.4rem; font-weight: 800; color: var(--text-dark); line-height: 1.2; }
.brand-subtitle { font-size: 0.8rem; font-weight: 600; color: var(--text-light); letter-spacing: 1px; }

.btn-grid {
    background-color: #f1f5f9; border: none; width: 44px; height: 44px;
    border-radius: 10px; cursor: pointer; color: #64748b; font-size: 1.2rem;
    display: flex; align-items: center; justify-content: center; transition: all 0.3s;
}
.btn-grid:hover { background-color: #e2e8f0; color: var(--primary); }

.nav-links { display: flex; list-style: none; gap: 2rem; margin: 0; padding: 0; }
.nav-links a { text-decoration: none; color: var(--text-light); font-weight: 600; font-size: 0.95rem; transition: color 0.3s; }
.nav-links a:hover { color: var(--primary); }
.nav-links li.active a { color: var(--primary); position: relative; }
.nav-links li.active a::after {
    content: ''; position: absolute; bottom: -5px; left: 0; width: 100%;
    height: 3px; background-color: var(--primary); border-radius: 2px;
}

.nav-actions { display: flex; align-items: center; gap: 1rem; }
.btn-lapor {
    background-color: var(--primary); color: white; border: none; padding: 0.65rem 1.4rem;
    border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer;
    display: flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(249, 115, 22, 0.2); text-decoration: none;
}
.btn-lapor:hover { background-color: #ea580c; transform: translateY(-2px); box-shadow: 0 6px 15px rgba(249, 115, 22, 0.3); }

.btn-surat {
    background-color: var(--primary); color: white; border: none; padding: 0.65rem 1.4rem;
    border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer;
    display: flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(249, 115, 22, 0.2); text-decoration: none;
}
.btn-surat:hover { background-color: #ea580c; transform: translateY(-2px); box-shadow: 0 6px 15px rgba(249, 115, 22, 0.3); }

/* Hide desktop elements on mobile */
@media (max-width: 992px) {
    .nav-links { display: none !important; }
    .nav-actions .btn-lapor { display: none !important; }
    .nav-actions .btn-surat { display: none !important; }
    .nav-brand-container .btn-grid { display: none !important; }
    .hamburger-btn { display: flex !important; align-items: center; justify-content: center; }
}
</style>

<nav class="navbar">
    <div class="nav-brand-container">
        <a href="/" class="nav-brand">
            <div class="brand-icon">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div class="brand-text">
                <span class="brand-title">DESA MLIDEG</span>
                <span class="brand-subtitle">SMART VILLAGE</span>
            </div>
        </a>
    </div>

    <ul class="nav-links">
        <li class="{{ Request::is('/') ? 'active' : '' }}"><a href="/">Beranda</a></li>
        <li class="{{ Request::is('profil') ? 'active' : '' }}"><a href="/profil">Profil</a></li>
        <li class="{{ Request::is('statistik') ? 'active' : '' }}"><a href="/statistik">Statistik</a></li>
        <li class="{{ Request::is('berita') || Request::is('berita/*') ? 'active' : '' }}"><a href="/berita">Berita</a></li>
        <li class="{{ Request::is('potensi') || Request::is('potensi/*') ? 'active' : '' }}"><a href="/potensi">Potensi</a></li>
        <li class="{{ Request::is('galeri') ? 'active' : '' }}"><a href="/galeri">Galeri</a></li>
        <li class="{{ Request::is('kontak') ? 'active' : '' }}"><a href="/kontak">Kontak</a></li>
    </ul>

    <div class="nav-actions">
        <a href="/lapor" class="btn-lapor" style="text-decoration:none;">
            <i class="fa-regular fa-message"></i> Lapor
        </a>
        <a href="/ajuan-surat" class="btn-surat" style="text-decoration:none;">
            <i class="fa-solid fa-envelope-open-text"></i> Layanan Surat
        </a>
        <a href="/login" class="btn-grid" style="text-decoration: none;" title="Admin Dashboard">
            <i class="fa-solid fa-shapes"></i>
        </a>
        <button class="hamburger-btn" id="hamburgerBtn" style="display: none; background: #f1f5f9; border: none; width: 44px; height: 44px; border-radius: 8px; cursor: pointer; color: #64748b; font-size: 1.2rem; transition: all 0.3s;">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</nav>
