<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potensi Desa - DESA MLIDEG</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* CSS reset and vars */
        :root {
            --primary: #f97316; /* Orange */
            --primary-hover: #ea580c;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --white: #ffffff;
            --bg-light: #f8fafc;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }
        body {
            background-color: var(--bg-light);
            color: var(--text-dark);
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 4rem;
            background-color: var(--white);
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 50;
        }
        .nav-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            cursor: pointer;
            text-decoration: none;
        }
        .brand-icon {
            background-color: var(--primary);
            color: var(--white);
            width: 44px;
            height: 44px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
        }
        .brand-text {
            display: flex;
            flex-direction: column;
        }
        .brand-title {
            font-weight: 800;
            font-size: 1.3rem;
            line-height: 1.1;
            color: #1e293b;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .brand-subtitle {
            font-size: 0.7rem;
            color: #94a3b8;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-top: 2px;
        }

        /* Nav Links */
        .nav-links {
            display: flex;
            gap: 2.2rem;
            list-style: none;
        }
        .nav-links li a {
            text-decoration: none;
            color: #64748b;
            font-weight: 700;
            font-size: 0.95rem;
            transition: color 0.3s;
            position: relative;
            padding-bottom: 0.5rem;
        }
        .nav-links li a:hover {
            color: var(--primary);
        }
        .nav-links li.active a {
            color: var(--primary);
        }
        .nav-links li.active a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--primary);
            border-radius: 2px;
        }

        /* Nav actions */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .btn-lapor {
            background-color: var(--primary);
            color: var(--white);
            border: none;
            padding: 0.65rem 1.4rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(249, 115, 22, 0.2);
        }
        .btn-lapor:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(249, 115, 22, 0.3);
        }
        .btn-grid {
            background-color: #f1f5f9;
            border: none;
            width: 44px;
            height: 44px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #64748b;
            font-size: 1.2rem;
            transition: all 0.3s;
        }
        .btn-grid:hover {
            background-color: #e2e8f0;
            color: var(--text-dark);
        }

        /* Detail Header Section */
        .detail-header {
            margin-top: 0;
            background-color: #0f172a;
            padding: 4rem 2rem;
            text-align: center;
            color: var(--white);
            position: relative;
        }
        .detail-header-title {
            font-size: 2.5rem;
            font-weight: 900;
            letter-spacing: 1px;
            margin-bottom: 1rem;
        }
        .breadcrumb {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: #94a3b8;
            font-size: 0.9rem;
            font-weight: 600;
        }
        .breadcrumb a {
            color: var(--primary);
            text-decoration: none;
        }

        /* Potensi Section */
        .potensi-section {
            padding: 5rem 2rem;
            flex-grow: 1;
            background-color: var(--bg-light);
        }
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        .section-title {
            font-size: 2.5rem;
            font-weight: 900;
            color: #0f172a;
            text-transform: uppercase;
            font-style: italic;
            position: relative;
            display: inline-block;
        }
        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--primary);
            border-radius: 2px;
        }

        .potensi-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 3rem;
        }
        .potensi-item {
            background-color: var(--white);
            border-radius: 24px;
            overflow: hidden;
            display: flex;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.04);
            transition: transform 0.3s ease;
        }
        .potensi-item:hover {
            transform: translateY(-5px);
        }
        .potensi-img {
            width: 40%;
            object-fit: cover;
        }
        .potensi-content {
            padding: 2.5rem;
            width: 60%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .potensi-category {
            color: var(--primary);
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.8rem;
        }
        .potensi-title {
            font-size: 1.6rem;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 1rem;
            line-height: 1.2;
        }
        .potensi-desc {
            color: #64748b;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* Simplified Footer according to image */
        .simple-footer {
            background-color: #0f172a;
            padding: 2.5rem 0;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: auto;
        }
        .footer-brand {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }
        .footer-brand i {
            color: var(--primary);
            font-size: 1.4rem;
        }
        .footer-brand span {
            color: var(--white);
            font-weight: 700;
            font-size: 1.2rem;
            letter-spacing: 0.5px;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .nav-links { gap: 1.5rem; }
            .navbar { padding: 1rem 2rem; }
            .potensi-container { gap: 2rem; }
        }
        @media (max-width: 992px) {
            .nav-links { display: none; }
            .navbar { padding: 1rem 1.5rem; }
            .potensi-container { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .section-title { font-size: 1.8rem; }
            .detail-header-title { font-size: 2rem; }
            .potensi-item { flex-direction: column; }
            .potensi-img { width: 100%; height: 250px; }
            .potensi-content { width: 100%; padding: 2rem; }
        }
    
        .btn-surat {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 0.65rem 1.4rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(249, 115, 22, 0.2);
            text-decoration: none;
        }
        .btn-surat:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(249, 115, 22, 0.3);
            background-color: var(--primary-hover);
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(5px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }
        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }
        .potensi-modal {
            background: var(--white);
            border-radius: 20px;
            width: 90%;
            max-width: 800px;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            transform: scale(0.9);
            transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 25px 50px rgba(0,0,0,0.25);
            display: flex;
            flex-direction: column;
        }
        .modal-overlay.active .potensi-modal {
            transform: scale(1);
        }
        .modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(0,0,0,0.5);
            color: white;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            cursor: pointer;
            z-index: 10;
            transition: background 0.3s;
        }
        .modal-close:hover {
            background: var(--primary);
        }
        .modal-img {
            width: 100%;
            height: 350px;
            object-fit: cover;
        }
        .modal-body {
            padding: 2.5rem;
        }
        .modal-category {
            color: var(--primary);
            font-size: 0.9rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 0.5rem;
            display: inline-block;
            background: #fff7ed;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
        }
        .modal-title {
            font-size: 2.2rem;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }
        .modal-desc {
            color: #475569;
            font-size: 1.05rem;
            line-height: 1.8;
            margin-bottom: 1.5rem;
            text-align: justify;
        }
        .modal-gallery {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
            margin-top: 2rem;
        }
        .modal-gallery img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s;
        }
        .modal-gallery img:hover {
            transform: scale(1.05);
        }
        
        .potensi-item { cursor: pointer; } /* Added cursor pointer */
        /* Mobile Menu */
        .hamburger-btn {
            display: none;
            background: #f1f5f9;
            border: none;
            width: 44px;
            height: 44px;
            border-radius: 8px;
            cursor: pointer;
            color: #64748b;
            font-size: 1.2rem;
            transition: all 0.3s;
        }
        .hamburger-btn:hover { background: #e2e8f0; color: var(--text-dark); }

        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.98);
            z-index: 1000;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .mobile-menu-overlay.active { opacity: 1; visibility: visible; }
        
        .close-menu {
            position: absolute;
            top: 1.5rem;
            right: 1.5rem;
            background: transparent;
            border: none;
            color: white;
            font-size: 2rem;
            cursor: pointer;
        }
        .mobile-brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: white;
            margin-bottom: 3rem;
        }
        .mobile-brand i { color: var(--primary); font-size: 2rem; }
        .mobile-brand span { font-weight: 800; font-size: 1.5rem; letter-spacing: 1px; }

        .mobile-nav-links { list-style: none; text-align: center; }
        .mobile-nav-links li { margin-bottom: 1.5rem; }
        .mobile-nav-links li a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: 700;
            transition: color 0.3s;
        }
        .mobile-nav-links li a:hover { color: var(--primary); }
        .mobile-btn-lapor {
            background-color: var(--primary);
            color: white !important;
            padding: 0.8rem 2rem;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 0.5rem;
        }
        .mobile-btn-surat {
            background-color: #334155;
            color: white !important;
            padding: 0.8rem 2rem;
            border-radius: 10px;
            display: inline-block;
        }

        @media (max-width: 992px) {
            .nav-links { display: none; }
            .nav-actions .btn-lapor, .nav-actions .btn-surat { display: none; }
            .hamburger-btn { display: flex; align-items: center; justify-content: center; }
        }
        </style>
</head>
<body>

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenu">
        <button class="close-menu" id="closeMenu"><i class="fa-solid fa-xmark"></i></button>
        <div class="mobile-brand">
            <i class="fa-solid fa-shield-halved"></i>
            <span>DESA MLIDEG</span>
        </div>
        <ul class="mobile-nav-links">
            <li><a href="/">Beranda</a></li>
            <li><a href="/profil">Profil</a></li>
            <li><a href="/statistik">Statistik</a></li>
            <li><a href="/berita">Berita</a></li>
            <li><a href="/potensi">Potensi</a></li>
            <li><a href="/galeri">Galeri</a></li>
            <li><a href="/kontak">Kontak</a></li>
            <li style="margin-top: 1rem;">
                <a href="/lapor" class="mobile-btn-lapor">Lapor Sekarang</a>
                <a href="/ajuan-surat" class="mobile-btn-surat">Layanan Surat</a>
            </li>
        </ul>
    </div>

    <!-- Header Detail Page -->
    <header class="detail-header">
        <h1 class="detail-header-title">Sumber Daya & Potensi</h1>
        <div class="breadcrumb">
            <a href="/">Beranda</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i>
            <span>Potensi Desa</span>
        </div>
    </header>

    <!-- Potensi Section -->
    <section class="potensi-section">
        <div class="section-header">
            <h2 class="section-title">Kekayaan Desa Mlideg</h2>
        </div>
        
        <div class="potensi-container">
            @forelse($potensi ?? [] as $p)
            <div class="potensi-item" onclick="openModal(this)">
                @if(isset($p['is_url']) && $p['is_url'])
                    <img src="{{ $p['foto'] }}" alt="{{ $p['kategori'] ?? 'Potensi' }}" class="potensi-img">
                @else
                    <img src="{{ asset('storage/' . $p['foto']) }}" alt="{{ $p['kategori'] ?? 'Potensi' }}" class="potensi-img">
                @endif
                <div class="potensi-content">
                    <span class="potensi-category">{{ $p['kategori'] ?? 'Umum' }}</span>
                    <h3 class="potensi-title">{{ $p['judul'] ?? ($p['nama'] ?? 'Potensi Desa') }}</h3>
                    <p class="potensi-desc">{{ $p['deskripsi'] ?? '' }}</p>
                    <div class="full-desc" style="display: none;">
                        {!! $p['full_desc'] ?? '<p>Tidak ada deskripsi lengkap.</p>' !!}
                    </div>
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: white; border-radius: 12px; color: #64748b;">
                <i class="fa-solid fa-seedling" style="font-size: 3rem; margin-bottom: 1rem; color: #cbd5e1;"></i>
                <p>Belum ada data potensi desa yang dipublikasikan.</p>
            </div>
            @endforelse
        </div>
    </section>

    <!-- Simple Footer -->
    <footer class="simple-footer">
        <div class="footer-brand">
            <i class="fa-solid fa-shield-halved"></i>
            <span>Desa Mlideg</span>
        </div>
    </footer>

    <!-- Modal Detail Potensi -->
    <div class="modal-overlay" id="potensiModal" onclick="closeModal(event)">
        <div class="potensi-modal" onclick="event.stopPropagation()">
            <button class="modal-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
            <img src="" alt="Potensi Detail" class="modal-img" id="modalImg">
            <div class="modal-body">
                <span class="modal-category" id="modalCat"></span>
                <h2 class="modal-title" id="modalTitle"></h2>
                <div class="modal-desc" id="modalDesc"></div>
                <div class="modal-gallery">
                    <!-- Dummy gallery images -->
                    <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=400&q=80" alt="Galeri 1">
                    <img src="https://images.unsplash.com/photo-1505934333218-8fe21ff88269?w=400&q=80" alt="Galeri 2">
                    <img src="https://images.unsplash.com/photo-1596707316625-f77e203c9ac3?w=400&q=80" alt="Galeri 3">
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(element) {
            const img = element.querySelector('.potensi-img').src;
            const category = element.querySelector('.potensi-category').innerText;
            const title = element.querySelector('.potensi-title').innerText;
            const fullDescHTML = element.querySelector('.full-desc').innerHTML;

            document.getElementById('modalImg').src = img;
            document.getElementById('modalCat').innerText = category;
            document.getElementById('modalTitle').innerText = title;
            document.getElementById('modalDesc').innerHTML = fullDescHTML;

            const overlay = document.getElementById('potensiModal');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal(event) {
            // Jika event disuplai, pastikan diklik di overlay bukan isinya
            if (event && event.target !== document.getElementById('potensiModal') && !event.target.classList.contains('modal-close') && !event.target.closest('.modal-close')) {
                return;
            }
            const overlay = document.getElementById('potensiModal');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    </script>
    <script>
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const closeMenu = document.getElementById('closeMenu');
        const mobileMenu = document.getElementById('mobileMenu');

        if(hamburgerBtn && mobileMenu && closeMenu) {
            hamburgerBtn.addEventListener('click', () => {
                mobileMenu.classList.add('active');
                document.body.style.overflow = 'hidden';
            });

            closeMenu.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = 'auto';
            });

            // Close on link click
            const mobileLinks = mobileMenu.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.remove('active');
                    document.body.style.overflow = 'auto';
                });
            });
        }
    </script>
</body>
</html>


