<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Kami - DESA MLIDEG</title>
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

        /* Kontak Section */
        .kontak-section {
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

        .kontak-container {
            max-width: 1100px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1.5fr;
            gap: 0;
            background-color: var(--white);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 50px rgba(0,0,0,0.08);
        }

        /* Info Kiri */
        .kontak-info {
            background-color: #0f172a;
            color: var(--white);
            padding: 4rem 3rem;
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
            position: relative;
        }
        .info-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            color: var(--white);
        }
        .info-item {
            display: flex;
            gap: 1.2rem;
            align-items: flex-start;
        }
        .info-icon {
            width: 45px;
            height: 45px;
            background-color: rgba(255,255,255,0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--primary);
            flex-shrink: 0;
        }
        .info-text h4 {
            font-size: 1rem;
            font-weight: 700;
            margin-bottom: 0.3rem;
            color: #e2e8f0;
        }
        .info-text p {
            color: #94a3b8;
            font-size: 0.95rem;
            line-height: 1.5;
        }
        .social-links {
            margin-top: auto;
            display: flex;
            gap: 1rem;
            padding-top: 2rem;
        }
        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255,255,255,0.1);
            color: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s;
        }
        .social-btn:hover {
            background-color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(249, 115, 22, 0.4);
        }

        /* Map Kanan */
        .map-wrapper {
            padding: 1.5rem;
            background-color: var(--white);
            display: flex;
            flex-direction: column;
        }
        .map-container {
            flex-grow: 1;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: inset 0 0 0 1px rgba(0,0,0,0.05), 0 10px 30px rgba(0,0,0,0.06);
            position: relative;
            min-height: 400px;
            transition: transform 0.3s ease;
        }
        .map-container:hover {
            transform: translateY(-2px);
            box-shadow: inset 0 0 0 1px rgba(0,0,0,0.05), 0 15px 35px rgba(0,0,0,0.08);
        }
        .map-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: 0;
            filter: contrast(1.02) saturate(1.05);
        }

        /* Form Kanan (Deprecated for Map but keeping classes just in case) */
        .kontak-form-wrapper {
            padding: 3rem 2.5rem;
        }
        .form-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #475569;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .form-control {
            width: 100%;
            padding: 0.8rem 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-family: inherit;
            font-size: 1rem;
            color: var(--text-dark);
            transition: border-color 0.3s;
            background-color: #f8fafc;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background-color: var(--white);
        }
        textarea.form-control {
            resize: vertical;
            min-height: 120px;
        }
        .btn-submit {
            background-color: var(--primary);
            color: var(--white);
            border: none;
            padding: 1rem 2rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.2);
        }
        .btn-submit:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.3);
        }

        /* Simplified Footer */
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

        /* Darurat Section */
        .darurat-container {
            max-width: 1100px;
            margin: 3rem auto 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
        }
        .darurat-card {
            background-color: var(--white);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            border-bottom: 4px solid var(--primary);
            transition: transform 0.3s;
        }
        .darurat-card:hover {
            transform: translateY(-5px);
        }
        .darurat-icon {
            width: 60px;
            height: 60px;
            background-color: #fff7ed;
            color: var(--primary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
        }
        .darurat-card h4 {
            font-size: 1.1rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }
        .darurat-card p {
            color: #64748b;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }
        .darurat-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background-color: #f0fdf4;
            color: #16a34a;
            font-weight: 700;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.95rem;
            transition: all 0.3s;
            border: 1.5px solid #bbf7d0;
        }
        .darurat-btn:hover {
            background-color: #25D366;
            color: white;
            border-color: #25D366;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(37, 211, 102, 0.35);
        }
        .darurat-btn i {
            font-size: 1rem;
        }

        /* Responsive */
        @media (max-width: 1200px) {
            .nav-links { gap: 1.5rem; }
            .navbar { padding: 1rem 2rem; }
        }
        @media (max-width: 992px) {
            .nav-links { display: none; }
            .navbar { padding: 1rem 1.5rem; }
            .kontak-container { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .section-title { font-size: 1.8rem; }
            .kontak-info, .kontak-form-wrapper { padding: 2rem 1.5rem; }
            .kontak-section { padding: 3rem 1rem; }
            .detail-header { padding: 3rem 1.5rem; margin-top: 65px; }
            .detail-header-title { font-size: 2rem; }
            .info-item { gap: 1rem; }
            .darurat-container { gap: 1rem; margin-top: 2rem; }
            .darurat-card { padding: 1.5rem; }
        }
        @media (max-width: 480px) {
            .section-title { font-size: 1.5rem; }
            .detail-header-title { font-size: 1.6rem; }
            .info-title { font-size: 1.3rem; }
            .info-item { flex-direction: column; align-items: center; text-align: center; }
            .social-links { justify-content: center; width: 100%; }
            .darurat-card h4 { font-size: 1rem; }
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

    <!-- Header Detail Page -->
    <header class="detail-header">
        <h1 class="detail-header-title">Hubungi Kami</h1>
        <div class="breadcrumb">
            <a href="/">Beranda</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i>
            <span>Kontak</span>
        </div>
    </header>

    <!-- Kontak Section -->
    <section class="kontak-section">
        <div class="section-header">
            <h2 class="section-title">LAYANAN INFORMASI</h2>
        </div>
        
        <div class="kontak-container">
            <!-- Info Kiri -->
            <div class="kontak-info">
                <h3 class="info-title">Pusat Bantuan Desa</h3>
                
                <div class="info-item">
                    <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <div class="info-text">
                        <h4>Alamat Kantor</h4>
                        <p>Jl. Raya Kesongo Kedungadem, Ds. Mlideg, Kec. Kedungadem, Kab. Bojonegoro, Jawa Timur 62195</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon"><i class="fa-solid fa-clock"></i></div>
                    <div class="info-text">
                        <h4>Jam Operasional</h4>
                        <p>Senin - Kamis, 08:00 - 15:00 WIB<br>Jumat, 08:30 - 14:00 WIB</p>
                    </div>
                </div>
                
                <div class="info-item">
                    <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
                    <div class="info-text">
                        <h4>Email</h4>
                        <p>mlidegdesa@gmail.com<br>
                    </div>
                </div>

            </div>

            <!-- Maps Kanan -->
            <div class="map-wrapper">
                <div class="map-container">
                    <iframe src="https://maps.google.com/maps?q=Mlideg,%20Kec.%20Kedungadem,%20Kabupaten%20Bojonegoro,%20Jawa%20Timur&t=&z=14&ie=UTF8&iwloc=&output=embed" 
                    allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>

        <div class="darurat-container">
            <div class="darurat-card">
                <div class="darurat-icon"><i class="fa-solid fa-user-shield"></i></div>
                <h4>Bhabinkamtibmas</h4>
                <p>Polisi Desa Mlideg</p>
                <a href="https://wa.me/6282141514119" target="_blank" class="darurat-btn"><i class="fa-brands fa-whatsapp"></i> 0821-4151-4119</a>
            </div>
            <div class="darurat-card">
                <div class="darurat-icon"><i class="fa-solid fa-person-military-rifle"></i></div>
                <h4>Babinsa</h4>
                <p>TNI Desa Mlideg</p>
                <a href="https://wa.me/6287750642602" target="_blank" class="darurat-btn"><i class="fa-brands fa-whatsapp"></i> 0877-5064-2602</a>
            </div>
            <div class="darurat-card">
                <div class="darurat-icon"><i class="fa-solid fa-truck-medical"></i></div>
                <h4>Mobil Siaga Desa</h4>
                <p>Layanan Darurat 24 Jam</p>
                <a href="https://wa.me/6282232292945" target="_blank" class="darurat-btn"><i class="fa-brands fa-whatsapp"></i> 0822-3229-2945</a>
            </div>
            <div class="darurat-card">
                <div class="darurat-icon"><i class="fa-solid fa-house-medical"></i></div>
                <h4>Bidan Desa</h4>
                <p>Polindes Mlideg</p>
                <a href="https://wa.me/6282333979697" target="_blank" class="darurat-btn"><i class="fa-brands fa-whatsapp"></i> 0823-3397-9697</a>
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


