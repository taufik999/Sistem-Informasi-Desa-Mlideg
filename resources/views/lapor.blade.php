<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor Pemdes - DESA MLIDEG</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        :root {
            --primary: #f97316;
            --primary-hover: #ea580c;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --bg-light: #f8fafc;
        }
        body { margin: 0; font-family: 'Montserrat', sans-serif; background-color: var(--bg-light); color: var(--text-dark); }
        
        /* Navbar (Mirrored from welcome) */
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
            background-color: var(--text-dark); color: white; border: none; padding: 0.6rem 1.2rem;
            border-radius: 20px; font-weight: 600; font-size: 0.9rem; cursor: pointer; transition: background 0.3s;
            display: flex; align-items: center; gap: 0.5rem; text-decoration: none;
        }
        .btn-lapor.active { background-color: var(--primary); }
        .btn-lapor:hover { background-color: var(--primary); }
        .btn-grid {
            background-color: white; color: var(--text-dark); border: 2px solid #e2e8f0; width: 40px; height: 40px;
            border-radius: 10px; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.3s;
        }
        .btn-grid:hover { border-color: var(--primary); color: var(--primary); }

        /* Lapor Page Content */
        .lapor-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: white; text-align: center; padding: 4rem 2rem;
        }
        .lapor-header h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; }
        .lapor-header p { font-size: 1.1rem; color: #cbd5e1; max-width: 600px; margin: 0 auto; line-height: 1.6; }
        .header-actions { margin-top: 2rem; display: flex; justify-content: center; gap: 1rem; }
        .btn-outline-white {
            border: 2px solid rgba(255,255,255,0.2); color: white; padding: 0.8rem 1.5rem;
            border-radius: 10px; font-weight: 600; text-decoration: none; transition: all 0.3s;
        }
        .btn-outline-white:hover { border-color: white; background: rgba(255,255,255,0.1); }

        .lapor-container {
            max-width: 800px; margin: -3rem auto 4rem auto; padding: 0 1.5rem; position: relative; z-index: 10;
        }
        .lapor-form-card {
            background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); padding: 3rem;
        }

        .alert-success {
            background-color: #dcfce3; color: #166534; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem;
            display: flex; align-items: flex-start; gap: 1rem; border-left: 5px solid #22c55e;
            flex-direction: column;
        }
        .alert-header { display: flex; align-items: center; gap: 1rem; }
        .alert-header i { font-size: 1.5rem; }
        .alert-header h4 { margin: 0; font-size: 1.1rem; font-weight: 800; }
        .alert-body p { margin: 0; font-size: 0.95rem; line-height: 1.5; margin-bottom: 1rem;}
        
        .track-box {
            background: white; border: 2px dashed #22c55e; padding: 1rem; border-radius: 8px; width: 100%; text-align: center;
        }
        .track-label { font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 0.3rem;}
        .track-id { font-size: 1.8rem; font-weight: 800; color: #166534; font-family: monospace; letter-spacing: 2px;}
        .track-help { font-size: 0.85rem; color: #166534; margin-top: 0.5rem; font-weight: 600;}

        /* Form Styles */
        .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 1.5rem; }
        .form-group { margin-bottom: 1.5rem; }
        .form-group.full-width { grid-column: span 2; }
        .form-label { display: block; font-size: 0.9rem; font-weight: 700; color: #475569; margin-bottom: 0.5rem; }
        .form-control {
            width: 100%; padding: 0.9rem 1.2rem; border: 1px solid #cbd5e1; border-radius: 10px;
            font-size: 0.95rem; outline: none; transition: all 0.3s; background-color: #f8fafc; font-family: 'Montserrat', sans-serif;
            box-sizing: border-box;
        }
        .form-control:focus { border-color: var(--primary); background-color: white; box-shadow: 0 0 0 4px rgba(249,115,22,0.1); }
        textarea.form-control { resize: vertical; min-height: 120px; }
        
        .radio-group { display: flex; gap: 1.5rem; margin-top: 0.5rem; }
        .radio-item { display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.95rem; font-weight: 500; }
        .radio-item input[type="radio"] { accent-color: var(--primary); width: 18px; height: 18px; }

        .btn-submit {
            background-color: var(--primary); color: white; border: none; padding: 1rem 2rem;
            border-radius: 10px; font-weight: 700; font-size: 1.1rem; cursor: pointer; transition: all 0.3s;
            width: 100%; display: flex; justify-content: center; align-items: center; gap: 0.8rem;
            box-shadow: 0 4px 15px rgba(249,115,22,0.3);
        }
        .btn-submit:hover { background-color: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 6px 20px rgba(249,115,22,0.4); }

        .info-box {
            background-color: #f1f5f9; border-radius: 12px; padding: 1.5rem; margin-bottom: 2rem; font-size: 0.85rem; color: #64748b; line-height: 1.6;
        }
        .info-box i { color: var(--primary); margin-right: 0.5rem; }

        @media (max-width: 768px) {
            .header-actions { flex-direction: column; align-items: center; }
            .btn-outline-white { width: 100%; max-width: 300px; display: block; }
            .form-grid { grid-template-columns: 1fr; }
            .form-group.full-width { grid-column: 1; }
            .lapor-form-card { padding: 2rem; }
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
            @media (max-width: 992px) {
            .nav-links { display: none; }
            .nav-actions .btn-lapor, .nav-actions .btn-surat, .nav-actions .btn-grid { display: none; }
            .hamburger-btn { display: flex; align-items: center; justify-content: center; }
        }

        /* Mobile Menu Overlay */
        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.98);
            z-index: 2000;
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
        .mobile-brand-overlay {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: white;
            margin-bottom: 3rem;
        }
        .mobile-brand-overlay i { color: var(--primary); font-size: 2rem; }
        .mobile-brand-overlay span { font-weight: 800; font-size: 1.5rem; letter-spacing: 1px; }

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
    </style>
</head>
<body>

    <!-- Navbar -->
    @include('partials.navbar')

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenu">
        <button class="close-menu" id="closeMenu"><i class="fa-solid fa-xmark"></i></button>
        <div class="mobile-brand-overlay">
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

    <!-- Header -->
    <header class="lapor-header">
        <h1>Layanan Pengaduan Masyarakat</h1>
        <p>Sampaikan aspirasi, kritik, saran, maupun permohonan informasi kepada Pemerintah Desa Mlideg terkait pelayanan, infrastruktur, maupun hal lainnya.</p>
        <div class="header-actions">
            <a href="/" class="btn-outline-white"><i class="fa-solid fa-arrow-left"></i> Beranda</a>
            <a href="/cek-laporan" class="btn-outline-white"><i class="fa-solid fa-magnifying-glass"></i> Cek Status Laporan</a>
        </div>
    </header>

    <!-- Form Section -->
    <section class="lapor-container">
        <div class="lapor-form-card">
            
            @if(session('success'))
                <div class="alert-success">
                    <div class="alert-header">
                        <i class="fa-solid fa-circle-check"></i>
                        <h4>Pengaduan Terkirim!</h4>
                    </div>
                    <div class="alert-body">
                        <p>{{ session('success') }}</p>
                    </div>
                    @if(session('track_id'))
                    <div class="track-box">
                        <div class="track-label">Kode Laporan Anda:</div>
                        <div class="track-id">{{ session('track_id') }}</div>
                        <div class="track-help">Simpan kode ini dengan baik untuk memantau status laporan Anda.</div>
                    </div>
                    @endif
                </div>
            @endif

            <div class="info-box">
                <p><i class="fa-solid fa-circle-info"></i> <strong>Pemberitahuan:</strong> Demi keamanan dan mencegah penyalahgunaan, Anda diwajibkan memasukkan NIK dan Nomor KK. Alamat IP dan data perangkat Anda juga direkam secara otomatis oleh sistem.</p>
            </div>

            <form action="/lapor" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="nik">NIK Pelapor *</label>
                        <input type="text" id="nik" name="nik" class="form-control" placeholder="16 Digit NIK" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nkk">Nomor KK (NKK) *</label>
                        <input type="text" id="nkk" name="nkk" class="form-control" placeholder="16 Digit NKK" required>
                    </div>
                    <!-- Note: Nama is fetched from database using NIK and NKK -->
                    <div class="form-group">
                        <label class="form-label" for="nama">Nama Pelapor</label>
                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Terisi otomatis" readonly style="background-color: #e2e8f0; cursor: not-allowed;">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="hp">No. WhatsApp / Telepon *</label>
                        <input type="text" id="hp" name="hp" class="form-control" placeholder="0812xxxxxx" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="dusun">Lokasi Kejadian (Dusun) *</label>
                        <select id="dusun" name="dusun" class="form-control" required style="padding-right: 2rem;">
                            <option value="">-- Pilih Wilayah Dusun --</option>
                            <option value="Dusun Mlideg">Dusun Mlideg</option>
                            <option value="Dusun Ngrapah">Dusun Ngrapah</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="kategori">Kategori Laporan *</label>
                        <select id="kategori" name="kategori" class="form-control" required style="padding-right: 2rem;">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="Infrastruktur & Jalan">Infrastruktur & Jalan Umum</option>
                            <option value="Pelayanan Masyarakat">Pelayanan Masyarakat (Surat, KTP)</option>
                            <option value="Kebersihan & Lingkungan">Kebersihan & Lingkungan</option>
                            <option value="Keamanan & Ketertiban">Keamanan & Ketertiban Masalah</option>
                            <option value="Aspirasi / Saran">Aspirasi / Saran Pembangunan</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label" for="subjek">Subjek / Judul Laporan *</label>
                        <input type="text" id="subjek" name="subjek" class="form-control" placeholder="Contoh: Lampu Jalan Padam di Pertigaan Balai Desa" required>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label" for="pesan">Deskripsi / Detail Kejadian *</label>
                        <textarea id="pesan" name="pesan" class="form-control" placeholder="Ceritakan kronologi, lokasi spesifik, atau informasi lain yang mendukung laporan Anda secara rinci..." required></textarea>
                    </div>

                    <div class="form-group full-width">
                        <label class="form-label" for="foto">Unggah Foto / Bukti Kejadian (Opsional)</label>
                        <input type="file" id="foto" name="foto" class="form-control" accept=".jpg,.jpeg,.png" style="padding: 0.6rem 1.2rem; background-color: white;">
                        <span style="font-size: 0.8rem; color: #64748b; margin-top: 0.3rem; display: block;"><i class="fa-solid fa-circle-info"></i> Format didukung: JPG, JPEG, PNG. Maksimal 2MB.</span>
                    </div>
                </div>

                <button type="submit" class="btn-submit">Kirim Laporan Pengaduan <i class="fa-solid fa-paper-plane"></i></button>
            </form>
        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Pengaduan Ditolak!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#f97316'
            });
            @endif

            const nikInput = document.getElementById('nik');
            const nkkInput = document.getElementById('nkk');
            const namaInput = document.getElementById('nama');
            const hpInput = document.getElementById('hp');
            const dusunInput = document.getElementById('dusun');

            function checkPelapor() {
                const nik = nikInput.value.trim();
                const nkk = nkkInput.value.trim();

                if (nik.length >= 16 && nkk.length >= 16) {
                    fetch(`/api/cek-pelapor?nik=${nik}&nkk=${nkk}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                if (data.nama) {
                                    namaInput.value = data.nama;
                                }
                                if (data.hp) {
                                    hpInput.value = data.hp;
                                }
                                if (data.dusun) {
                                    for (let i = 0; i < dusunInput.options.length; i++) {
                                        if (dusunInput.options[i].value === data.dusun) {
                                            dusunInput.selectedIndex = i;
                                            break;
                                        }
                                    }
                                }
                                Swal.fire({
                                    toast: true,
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Data pelapor ditemukan dan diisi otomatis.',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                            }
                        })
                        .catch(err => console.error('Error fetching data:', err));
                }
            }

            nikInput.addEventListener('blur', checkPelapor);
            nkkInput.addEventListener('blur', checkPelapor);
            nikInput.addEventListener('input', checkPelapor);
            nkkInput.addEventListener('input', checkPelapor);
        });
    </script>
</body>
</html>

