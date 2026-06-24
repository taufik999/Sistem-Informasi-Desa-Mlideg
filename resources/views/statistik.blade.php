<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Desa - DESA MLIDEG</title>
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
            margin-top: 0; /* offset navbar */
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

        /* Statistik Section */
        .statistik-section {
            padding: 5rem 2rem;
            flex-grow: 1; /* allow it to grow to push footer down */
            background-color: var(--bg-light);
        }
        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }
        .section-title {
            font-size: 2.5rem;
            font-weight: 900;
            color: #0f172a; /* dark blue */
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

        .statistik-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }
        .stat-card {
            background-color: var(--white);
            border-radius: 24px;
            padding: 3rem 1.5rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(0,0,0,0.03);
        }
        .stat-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.05);
        }
        .stat-icon-wrapper {
            width: 70px;
            height: 70px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem auto;
            font-size: 1.8rem;
            background-color: #f8fafc;
        }
        
        /* Specific colors for icons */
        .card-penduduk .stat-icon-wrapper {
            color: #3b82f6; /* Blue */
            background-color: rgba(59, 130, 246, 0.08);
        }
        .card-kk .stat-icon-wrapper {
            color: #6366f1; /* Indigo */
            background-color: rgba(99, 102, 241, 0.08);
        }
        .card-pendidikan .stat-icon-wrapper {
            color: #22c55e; /* Green */
            background-color: rgba(34, 197, 94, 0.08);
        }
        .card-sektor .stat-icon-wrapper {
            color: #f97316; /* Orange */
            background-color: rgba(249, 115, 22, 0.08);
        }

        .stat-label {
            font-size: 0.8rem;
            font-weight: 800;
            color: #94a3b8;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .stat-value {
            font-size: 3rem;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 0.3rem;
            line-height: 1;
        }
        .stat-desc {
            font-size: 0.9rem;
            color: #64748b;
            font-weight: 600;
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
            .statistik-container { gap: 1.5rem; }
        }
        @media (max-width: 992px) {
            .nav-links { display: none; }
            .navbar { padding: 1rem 1.5rem; }
            .statistik-container { grid-template-columns: repeat(2, 1fr); gap: 2rem; }
        }
        @media (max-width: 768px) {
            .section-title { font-size: 1.8rem; }
            .detail-header-title { font-size: 2rem; }
            .statistik-container { grid-template-columns: 1fr; }
            .charts-container { grid-template-columns: 1fr !important; }
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
        <h1 class="detail-header-title">Data & Demografi</h1>
        <div class="breadcrumb">
            <a href="/">Beranda</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i>
            <span>Statistik Desa</span>
        </div>
    </header>

    <!-- Statistik Section -->
    <section class="statistik-section">
        <div class="section-header">
            <h2 class="section-title">STATISTIK DESA</h2>
        </div>
        
        <div class="statistik-container">
            <!-- Card 1 -->
            <div class="stat-card card-penduduk">
                <div class="stat-icon-wrapper">
                    <i class="fa-solid fa-user-group"></i>
                </div>
                <div class="stat-label">TOTAL PENDUDUK</div>
                <div class="stat-value">{{ $totalPenduduk }}</div>
                <div class="stat-desc">Jiwa Terdata</div>
            </div>

            <!-- Card 2 -->
            <div class="stat-card card-kk">
                <div class="stat-icon-wrapper">
                    <i class="fa-solid fa-book-open"></i>
                </div>
                <div class="stat-label">TOTAL KK</div>
                <div class="stat-value">{{ $totalKK }}</div>
                <div class="stat-desc">Keluarga</div>
            </div>

            <!-- Card 3 -->
            <div class="stat-card card-pendidikan">
                <div class="stat-icon-wrapper">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <div class="stat-label">PENDIDIKAN TINGGI</div>
                <div class="stat-value">{{ $eduRatio }}%</div>
                <div class="stat-desc">Rasio S1</div>
            </div>

            <!-- Card 4 -->
            <div class="stat-card card-sektor">
                <div class="stat-icon-wrapper">
                    <i class="fa-solid fa-briefcase"></i>
                </div>
                <div class="stat-label">{{ $mayoritasJobName }}</div>
                <div class="stat-value">{{ $mayoritasJobRatio }}%</div>
                <div class="stat-desc">Mayoritas Mata Pencaharian</div>
            </div>
        </div>

        <div class="charts-container" style="max-width: 1200px; margin: 4rem auto 0 auto; display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem;">
            <div style="background: white; border-radius: 20px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.03);">
                <h3 style="text-align: center; margin-bottom: 1.5rem; color: #0f172a; font-size: 1.2rem;">Demografi Jenis Kelamin</h3>
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
            <div style="background: white; border-radius: 20px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.03);">
                <h3 style="text-align: center; margin-bottom: 1.5rem; color: #0f172a; font-size: 1.2rem;">Kelompok Umur</h3>
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="ageChart"></canvas>
                </div>
            </div>
            <div style="background: white; border-radius: 20px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.03);">
                <h3 style="text-align: center; margin-bottom: 1.5rem; color: #0f172a; font-size: 1.2rem;">Tingkat Pendidikan</h3>
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="eduChart"></canvas>
                </div>
            </div>
            <div style="background: white; border-radius: 20px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.02); border: 1px solid rgba(0,0,0,0.03);">
                <h3 style="text-align: center; margin-bottom: 1.5rem; color: #0f172a; font-size: 1.2rem;">Mata Pencaharian Utama</h3>
                <div style="position: relative; height: 300px; width: 100%;">
                    <canvas id="jobChart"></canvas>
                </div>
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

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Global configuration
        Chart.defaults.font.family = "'Montserrat', sans-serif";
        Chart.defaults.color = '#64748b';

        // 1. Demografi Jenis Kelamin (Doughnut)
        new Chart(document.getElementById('genderChart'), {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [{{ $genderData['L'] }}, {{ $genderData['P'] }}],
                    backgroundColor: ['#3b82f6', '#ec4899'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '70%'
            }
        });

        // 2. Kelompok Umur (Bar)
        new Chart(document.getElementById('ageChart'), {
            type: 'bar',
            data: {
                labels: ['0-14 Thn', '15-24 Thn', '25-44 Thn', '45-64 Thn', '65+ Thn'],
                datasets: [{
                    label: 'Jumlah Jiwa',
                    data: [
                        {{ $ageGroups['0-14'] }}, 
                        {{ $ageGroups['15-24'] }}, 
                        {{ $ageGroups['25-44'] }}, 
                        {{ $ageGroups['45-64'] }}, 
                        {{ $ageGroups['65+'] }}
                    ],
                    backgroundColor: '#10b981',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true, grid: { borderDash: [5, 5] }, ticks: { precision: 0, stepSize: 1 } },
                    x: { grid: { display: false } }
                }
            }
        });

        // 3. Tingkat Pendidikan (Pie)
        new Chart(document.getElementById('eduChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($eduData)) !!},
                datasets: [{
                    data: {!! json_encode(array_values($eduData)) !!},
                    backgroundColor: ['#94a3b8', '#f59e0b', '#8b5cf6', '#06b6d4', '#eab308', '#22c55e', '#ef4444', '#10b981'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right' }
                }
            }
        });

        // 4. Mata Pencaharian (Horizontal Bar)
        new Chart(document.getElementById('jobChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($jobData)) !!},
                datasets: [{
                    label: 'Jumlah Penduduk',
                    data: {!! json_encode(array_values($jobData)) !!},
                    backgroundColor: '#f97316',
                    borderRadius: 8
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { beginAtZero: true, grid: { borderDash: [5, 5] }, ticks: { precision: 0, stepSize: 1 } },
                    y: { grid: { display: false } }
                }
            }
        });
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


