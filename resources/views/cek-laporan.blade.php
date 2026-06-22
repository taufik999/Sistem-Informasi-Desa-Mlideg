<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Laporan - DESA MLIDEG</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #f97316;
            --primary-hover: #ea580c;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --bg-light: #f8fafc;
        }
        body { margin: 0; font-family: 'Montserrat', sans-serif; background-color: var(--bg-light); color: var(--text-dark); }
        
        /* Navbar */
        .navbar {
            display: flex; justify-content: space-between; align-items: center;
            padding: 1rem 5%; background-color: var(--bg-light);
            box-shadow: 0 4px 6px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000;
        }
        .nav-brand { display: flex; align-items: center; gap: 0.8rem; text-decoration: none; color: var(--text-dark); font-weight: 800; font-size: 1.2rem; }
        .brand-icon { width: 35px; height: 35px; background-color: var(--primary); color: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 1rem; }
        
        .nav-links { display: flex; list-style: none; gap: 2rem; margin: 0; padding: 0; }
        .nav-links a { text-decoration: none; color: var(--text-light); font-weight: 600; font-size: 0.95rem; transition: color 0.3s; }
        .nav-links a:hover, .nav-links a.active { color: var(--primary); }
        
        .nav-actions { display: flex; gap: 1rem; align-items: center; }
        .btn-lapor {
            background-color: var(--primary); color: white; border: none; padding: 0.6rem 1.2rem;
            border-radius: 20px; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: background 0.3s;
            display: flex; align-items: center; gap: 0.5rem; text-decoration: none;
        }
        .btn-lapor:hover { background-color: var(--primary-hover); }

        /* Header */
        .track-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white; text-align: center; padding: 4rem 2rem;
        }
        .track-header h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; }
        .track-header p { font-size: 1.1rem; color: #cbd5e1; max-width: 600px; margin: 0 auto; line-height: 1.6; }

        /* Container & Cards */
        .track-container {
            max-width: 600px; margin: -3rem auto 4rem auto; padding: 0 1.5rem; position: relative; z-index: 10;
        }
        .track-card {
            background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); padding: 3rem; margin-bottom: 2rem;
        }

        /* Form */
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; font-size: 0.95rem; font-weight: 700; color: #475569; margin-bottom: 0.8rem; text-align: center;}
        .form-control {
            width: 100%; padding: 1.2rem; border: 2px solid #cbd5e1; border-radius: 12px;
            font-size: 1.2rem; outline: none; transition: all 0.3s; background-color: #f8fafc; font-family: monospace;
            box-sizing: border-box; text-align: center; letter-spacing: 2px; font-weight: 700; color: #0f172a;
        }
        .form-control:focus { border-color: var(--primary); background-color: white; box-shadow: 0 0 0 4px rgba(249,115,22,0.1); }
        
        .btn-submit {
            background-color: var(--text-dark); color: white; border: none; padding: 1.2rem;
            border-radius: 12px; font-weight: 700; font-size: 1.1rem; cursor: pointer; transition: all 0.3s;
            width: 100%; display: flex; justify-content: center; align-items: center; gap: 0.8rem;
        }
        .btn-submit:hover { background-color: #0f172a; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(15,23,42,0.3); }

        /* Alerts & Results */
        .alert-error {
            background-color: #fee2e2; color: #991b1b; padding: 1.2rem; border-radius: 10px; margin-bottom: 1.5rem;
            display: flex; align-items: center; gap: 0.8rem; border-left: 5px solid #ef4444; font-size: 0.95rem; font-weight: 600;
        }

        .result-card {
            background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); padding: 2.5rem; border: 2px solid #e2e8f0;
        }
        .result-header { border-bottom: 2px dashed #e2e8f0; padding-bottom: 1.5rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: flex-start;}
        .result-title { font-size: 1.2rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem;}
        .result-date { font-size: 0.85rem; color: #64748b; font-weight: 500;}
        
        .r-status { padding: 0.6rem 1.2rem; border-radius: 20px; font-size: 0.85rem; font-weight: 800; display: inline-flex; align-items: center; gap: 0.5rem;}
        .bg-menunggu { background-color: #fef3c7; color: #b45309; }
        .bg-proses { background-color: #dbeafe; color: #1d4ed8; }
        .bg-selesai { background-color: #dcfce3; color: #15803d; }

        .detail-item { margin-bottom: 1rem; }
        .detail-label { font-size: 0.8rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 0.2rem;}
        .detail-value { font-size: 1rem; color: #334155; font-weight: 600;}
        .detail-msg { background: #f8fafc; padding: 1rem; border-radius: 8px; font-style: italic; color: #475569; font-size: 0.95rem; line-height: 1.6; margin-top: 1rem; border-left: 3px solid #cbd5e1;}

    
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
        .btn-outline-white {
            display: inline-flex; align-items: center; gap: 0.5rem;
            border: 2px solid rgba(255,255,255,0.2); color: white; padding: 0.8rem 1.5rem;
            border-radius: 10px; font-weight: 600; text-decoration: none; transition: all 0.3s;
            margin-top: 2rem;
        }
        .btn-outline-white:hover { border-color: white; background: rgba(255,255,255,0.1); }

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

        .mobile-nav-links { list-style: none; text-align: center; padding: 0; }
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
            .navbar { padding: 1rem 1.5rem; }
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

    <header class="track-header">
        <h1>Pantau Laporan Anda</h1>
        <p>Masukkan Kode Laporan (Track ID) yang Anda dapatkan saat mengirimkan laporan untuk melihat status tindak lanjut.</p>
        <a href="/" class="btn-outline-white"><i class="fa-solid fa-arrow-left"></i> Beranda</a>
    </header>

    <section class="track-container">
        <div class="track-card">
            @if(session('error'))
                <div class="alert-error">
                    <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            <form action="/cek-laporan" method="GET">
                <div class="form-group">
                    <label class="form-label" for="track_id">KODE LAPORAN (TRACK ID)</label>
                    <input type="text" id="track_id" name="track_id" class="form-control" placeholder="LPR-XXXXXX" required autocomplete="off" style="text-transform: uppercase;" value="{{ request('track_id') }}">
                </div>
                <button type="submit" class="btn-submit"><i class="fa-solid fa-magnifying-glass"></i> Cek Status Sekarang</button>
            </form>
        </div>

        @if(isset($report) && $report)
        <div class="result-card" style="margin-top: 1rem; border-top: 5px solid var(--primary);">
            <div class="result-header">
                <div>
                    <h3 class="result-title">{{ $report['subjek'] }}</h3>
                    <div class="result-date">Dikirim pada: {{ $report['tanggal'] }}</div>
                </div>
                <div>
                    @if($report['status'] === 'Menunggu Validasi')
                        <span class="r-status bg-menunggu"><i class="fa-solid fa-hourglass-half"></i> Menunggu Validasi</span>
                    @elseif($report['status'] === 'Sedang Diproses')
                        <span class="r-status bg-proses"><i class="fa-solid fa-spinner fa-spin"></i> Sedang Diproses</span>
                    @elseif($report['status'] === 'Spam')
                        <span class="r-status bg-spam" style="background-color: #fee2e2; color: #dc2626;"><i class="fa-solid fa-ban"></i> Laporan Tidak Valid</span>
                    @else
                        <span class="r-status bg-selesai"><i class="fa-solid fa-check-double"></i> Selesai Ditangani</span>
                    @endif
                </div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Track ID</div>
                <div class="detail-value" style="font-family: monospace; color: var(--primary); font-weight: 700;">{{ $report['track_id'] }}</div>
            </div>

            <div class="detail-item">
                <div class="detail-label">Kategori Laporan</div>
                <div class="detail-value">{{ $report['kategori'] }}</div>
            </div>
            <div class="detail-item">
                <div class="detail-label">Lokasi Kejadian</div>
                <div class="detail-value">{{ $report['dusun'] }}</div>
            </div>
            
            <div class="detail-msg">
                "{{ $report['pesan'] }}"
            </div>

            @if(isset($report['foto']) && $report['foto'])
            <div class="detail-item" style="margin-top: 1.5rem;">
                <div class="detail-label">Lampiran Foto / Bukti</div>
                <div style="margin-top: 0.5rem;">
                    <img src="{{ asset('storage/' . $report['foto']) }}" alt="Bukti Laporan" style="max-width: 100%; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                </div>
            </div>
            @endif

            <div style="margin-top: 2rem; border-top: 1px solid #e2e8f0; padding-top: 1.5rem; text-align: center;">
                <a href="/cek-laporan" style="text-decoration: none; color: #64748b; font-weight: 700; font-size: 0.9rem;"><i class="fa-solid fa-rotate-left"></i> Cari Laporan Lain</a>
            </div>
        </div>
        @endif

    </section>

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

