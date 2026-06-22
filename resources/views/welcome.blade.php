<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DESA MLIDEG - Smart Village</title>
    <meta name="description" content="Website profil resmi Desa Mlideg. Mewujudkan tata kelola desa yang transparan, mandiri, dan berdaya saing melalui digitalisasi pelayanan publik.">
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

        /* Hero Section */
        .hero {
            height: 100vh;
            /* Using a high-quality landscape image simulating a village/countryside */
            background-image: linear-gradient(rgba(15, 23, 42, 0.65), rgba(15, 23, 42, 0.8)), url('https://images.unsplash.com/photo-1501785888041-af3ef285b470?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 2rem;
            margin-top: 0; /* offset navbar */
            position: relative;
        }
        .hero-content {
            max-width: 900px;
            animation: slideUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }
        .hero-title {
            font-size: 4.8rem;
            font-weight: 900;
            color: var(--white);
            line-height: 1.1;
            margin-bottom: 2rem;
            text-shadow: 0 4px 15px rgba(0,0,0,0.4);
            letter-spacing: -1px;
        }
        .text-orange {
            color: var(--primary);
        }
        .hero-subtitle {
            font-size: 1.35rem;
            color: #e2e8f0;
            font-weight: 500;
            line-height: 1.6;
            margin-bottom: 3rem;
            text-shadow: 0 2px 5px rgba(0,0,0,0.5);
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        .hero-buttons {
            display: flex;
            gap: 1.5rem;
            justify-content: center;
        }
        .btn-primary {
            background-color: var(--primary);
            color: var(--white);
            padding: 1.1rem 2.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 800;
            font-size: 1.05rem;
            display: inline-flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.3);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-3px);
            box-shadow: 0 15px 25px rgba(249, 115, 22, 0.4);
        }
        .btn-secondary {
            background-color: rgba(30, 41, 59, 0.4);
            color: var(--white);
            padding: 1.1rem 2.5rem;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 800;
            font-size: 1.05rem;
            border: 2px solid rgba(255, 255, 255, 0.4);
            transition: all 0.3s ease;
            backdrop-filter: blur(8px);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: var(--white);
            transform: translateY(-3px);
        }


        /* Features Section */
        .features {
            padding: 5rem 2rem;
            background-color: var(--bg-light);
            position: relative;
            z-index: 10;
        }
        .features-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            padding-top: 2rem;
        }
        .feature-card {
            background-color: var(--white);
            border-radius: 20px;
            padding: 3rem 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
        }
        .feature-icon-wrapper {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            background-color: #f8fafc;
            font-size: 2rem;
        }
        
        /* Specific colors for icons */
        .card-1 .feature-icon-wrapper {
            color: #3b82f6; /* Blue */
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.1);
        }
        .card-2 .feature-icon-wrapper {
            color: #f97316; /* Orange */
            box-shadow: 0 10px 20px rgba(249, 115, 22, 0.1);
        }
        .card-3 .feature-icon-wrapper {
            color: #22c55e; /* Green */
            box-shadow: 0 10px 20px rgba(34, 197, 94, 0.1);
        }

        .feature-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .feature-desc {
            font-size: 0.95rem;
            color: #64748b;
            line-height: 1.6;
            font-weight: 500;
        }

        /* Simplified Footer according to image */
        .simple-footer {
            background-color: #0f172a;
            padding: 2.5rem 0;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
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
        @keyframes slideUp {
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInRight {
            to { opacity: 1; transform: translateX(0); }
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .hero-title { font-size: 4rem; }
            .nav-links { gap: 1.5rem; }
            .navbar { padding: 1rem 2rem; }
            .features-container { gap: 1.5rem; }
        }
        @media (max-width: 992px) {
            .nav-links { display: none; }
            .navbar { padding: 1rem 1.5rem; }
            .hero-title { font-size: 3.2rem; }
            .hero-subtitle { font-size: 1.15rem; }
            .features-container { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .hero-title { font-size: 2.5rem; }
            .hero-subtitle { font-size: 1.05rem; margin-bottom: 2rem; }
            .hero-buttons { flex-direction: column; gap: 1rem; }
            .btn-primary, .btn-secondary { width: 100%; justify-content: center; }
            .features-container { grid-template-columns: 1fr; }
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

    <!-- Hero Section -->
    <section class="hero">

        <div class="hero-content">
            <h1 class="hero-title">
                {!! $setting->hero_title ?? 'Selamat Datang di <br> <span class="text-orange">Desa Mlideg</span>' !!}
            </h1>
            <p class="hero-subtitle">
                {{ $setting->hero_subtitle ?? 'Mewujudkan tata kelola desa yang transparan, mandiri, dan berdaya saing melalui digitalisasi pelayanan publik.' }}
            </p>
            <div class="hero-buttons">
                <a href="/lapor" class="btn-primary">
                    SAMPAIKAN ASPIRASI <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="/cek-laporan" class="btn-secondary">
                    CEK STATUS LAPORAN
                </a>
            </div>
        </div>
        

    </section>

    <!-- Sambutan Kades -->
    <section style="padding: 5rem 2rem; background: var(--white);">
        <div style="max-width: 1100px; margin: 0 auto; display: flex; gap: 4rem; align-items: center; flex-wrap: wrap;">
            <div style="flex: 1; min-width: 300px;">
                <div style="background: #e2e8f0; width: 100%; aspect-ratio: 3/4; border-radius: 20px; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative;">
                    <i class="fa-solid fa-user-tie" style="font-size: 8rem; color: #94a3b8;"></i>
                    <div style="position: absolute; bottom: 0; width: 100%; background: rgba(15,23,42,0.8); color: white; text-align: center; padding: 1.5rem; backdrop-filter: blur(5px);">
                        <h4 style="margin: 0; font-size: 1.2rem; font-weight: 800;">{{ $setting->sambutan_nama ?? 'Erry Cahyono, S.H' }}</h4>
                        <p style="margin: 0; font-size: 0.9rem; opacity: 0.9; margin-top: 0.3rem;">{{ $setting->sambutan_jabatan ?? 'Kepala Desa Mlideg' }}</p>
                    </div>
                </div>
            </div>
            <div style="flex: 2; min-width: 300px;">
                <span style="color: var(--primary); font-weight: 800; letter-spacing: 2px; text-transform: uppercase; font-size: 0.85rem; display: block; margin-bottom: 0.5rem;">Sambutan Kepala Desa</span>
                <h2 style="font-size: 2.2rem; font-weight: 900; color: var(--text-dark); margin: 0 0 1.5rem 0; line-height: 1.3;">{{ $setting->sambutan_judul ?? 'Membangun Desa Bersama Berbasis Digital' }}</h2>
                <p style="color: #64748b; line-height: 1.8; font-size: 1.05rem; margin-bottom: 1.5rem;">
                    {{ $setting->sambutan_konten ?? '"Assalamu\'alaikum Warahmatullahi Wabarakatuh. Puji syukur ke hadirat Tuhan YME atas peluncuran website profil Desa Mlideg. Kami berkomitmen untuk terus meningkatkan pelayanan publik melalui digitalisasi. Website ini merupakan wujud transparansi dan inovasi kami untuk memudahkan warga mengakses informasi dan layanan administrasi tanpa batas ruang dan waktu."' }}
                </p>
                <a href="/profil" style="color: var(--primary); font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: gap 0.3s;" onmouseover="this.style.gap='0.8rem'" onmouseout="this.style.gap='0.5rem'">Baca Profil Desa <i class="fa-solid fa-arrow-right"></i></a>
            </div>
        </div>
    </section>

    <!-- Quick Stats -->
    <section style="padding: 4rem 2rem; background: var(--text-dark); color: white; text-align: center;">
        <div style="max-width: 1100px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 3rem;">
            <div>
                <i class="fa-solid fa-users" style="font-size: 2.5rem; color: var(--primary); margin-bottom: 1rem;"></i>
                <h3 style="font-size: 2.5rem; font-weight: 900; margin: 0;">{{ number_format($totalPenduduk ?? 0, 0, ',', '.') }}</h3>
                <p style="font-size: 0.9rem; opacity: 0.8; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-top: 0.5rem;">Total Penduduk</p>
            </div>
            <div>
                <i class="fa-solid fa-mars-and-venus" style="font-size: 2.5rem; color: var(--primary); margin-bottom: 1rem;"></i>
                <h3 style="font-size: 2.5rem; font-weight: 900; margin: 0;">{{ number_format($totalKK ?? 0, 0, ',', '.') }}</h3>
                <p style="font-size: 0.9rem; opacity: 0.8; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-top: 0.5rem;">Kepala Keluarga</p>
            </div>
            <div>
                <i class="fa-solid fa-map-location-dot" style="font-size: 2.5rem; color: var(--primary); margin-bottom: 1rem;"></i>
                <h3 style="font-size: 2.5rem; font-weight: 900; margin: 0;">{{ number_format($wilayahDusun ?? 0, 0, ',', '.') }}</h3>
                <p style="font-size: 0.9rem; opacity: 0.8; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-top: 0.5rem;">Wilayah Dusun</p>
            </div>
            <div>
                <i class="fa-solid fa-house-chimney" style="font-size: 2.5rem; color: var(--primary); margin-bottom: 1rem;"></i>
                <h3 style="font-size: 2.5rem; font-weight: 900; margin: 0;">{{ number_format($rukunTetangga ?? 0, 0, ',', '.') }}</h3>
                <p style="font-size: 0.9rem; opacity: 0.8; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; margin-top: 0.5rem;">Rukun Tetangga</p>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="features-container">
            <!-- Card 1 -->
            <div class="feature-card card-1">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-user-group"></i>
                </div>
                <h3 class="feature-title">DATA KEPENDUDUKAN</h3>
                <p class="feature-desc">Integrasi data kependudukan yang aman untuk efisiensi layanan administratif.</p>
            </div>

            <!-- Card 2 -->
            <div class="feature-card card-2">
                <div class="feature-icon-wrapper">
                    <i class="fa-regular fa-comment-dots"></i>
                </div>
                <h3 class="feature-title">PENGADUAN ONLINE</h3>
                <p class="feature-desc">Kanal aspirasi warga yang dihitung secara matematis dengan metode AHP.</p>
                <div style="margin-top: 1.5rem; display: flex; gap: 1rem; justify-content: center;">
                    <a href="/lapor" style="font-size: 0.8rem; font-weight: 700; color: var(--primary); text-decoration: none; border: 1px solid var(--primary); padding: 0.4rem 0.8rem; border-radius: 5px;">Buat Laporan</a>
                    <a href="/cek-laporan" style="font-size: 0.8rem; font-weight: 700; color: var(--text-light); text-decoration: none; border: 1px solid #cbd5e1; padding: 0.4rem 0.8rem; border-radius: 5px;">Cek Status</a>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="feature-card card-3">
                <div class="feature-icon-wrapper">
                    <i class="fa-solid fa-chart-column"></i>
                </div>
                <h3 class="feature-title">MONITORING TRANSPARAN</h3>
                <p class="feature-desc">Akses informasi progres pembangunan dan layanan desa secara real-time.</p>
            </div>
        </div>
    </section>

    <!-- Berita Terkini -->
    <section style="padding: 5rem 2rem; background: var(--white);">
        <div style="max-width: 1100px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 3rem;">
                <span style="color: var(--primary); font-weight: 800; letter-spacing: 2px; text-transform: uppercase; font-size: 0.85rem; display: block; margin-bottom: 0.5rem;">Kabar Desa</span>
                <h2 style="font-size: 2.2rem; font-weight: 900; color: var(--text-dark); margin: 0;">Berita & Artikel Terbaru</h2>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
                @forelse($berita ?? [] as $b)
                <div style="border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    @if(isset($b['foto']) && $b['foto'])
                    <div style="height: 200px; background: #cbd5e1; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        <img src="{{ asset('storage/' . $b['foto']) }}" alt="{{ $b['judul'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    @else
                    <div style="height: 200px; background: #cbd5e1; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                        <i class="fa-solid fa-image" style="font-size: 3rem;"></i>
                    </div>
                    @endif
                    <div style="padding: 1.5rem; display: flex; flex-direction: column; height: calc(100% - 200px);">
                        <span style="font-size: 0.8rem; color: var(--primary); font-weight: 700;">{{ $b['tanggal'] }}</span>
                        <h3 style="font-size: 1.2rem; font-weight: 800; margin: 0.5rem 0; color: var(--text-dark); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $b['judul'] }}</h3>
                        <p style="font-size: 0.95rem; color: #64748b; line-height: 1.5; margin-bottom: 1.5rem; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; flex-grow: 1;">
                            {{ isset($b['konten']) ? \Illuminate\Support\Str::limit($b['konten'], 100) : 'Klik selengkapnya untuk membaca berita ini...' }}
                        </p>
                        <a href="/berita/{{ $b['id'] }}" style="color: var(--text-dark); font-weight: 700; text-decoration: none; font-size: 0.9rem; margin-top: auto;">Selengkapnya <i class="fa-solid fa-angle-right"></i></a>
                    </div>
                </div>
                @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: #f8fafc; border-radius: 15px; color: #64748b; border: 1px dashed #cbd5e1;">
                    <i class="fa-regular fa-newspaper" style="font-size: 3rem; margin-bottom: 1rem; color: #cbd5e1;"></i>
                    <h3 style="color: #0f172a; margin-bottom: 0.5rem;">Belum Ada Kabar</h3>
                    <p>Saat ini belum ada publikasi berita terbaru dari desa.</p>
                </div>
                @endforelse
            </div>
            
            <div style="text-align: center; margin-top: 3rem;">
                <a href="/berita" class="btn-secondary" style="background: var(--text-dark); color: white; border: none; font-weight: 700;">Lihat Semua Berita</a>
            </div>
        </div>
    </section>

    <!-- Simple Footer -->
    <footer class="simple-footer">
        <div class="footer-brand">
            <i class="fa-solid fa-shield-halved"></i>
            <span>Desa Mlideg</span>
        </div>
    </footer>

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


