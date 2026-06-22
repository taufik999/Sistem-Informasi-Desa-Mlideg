<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Penduduk - DESA MLIDEG</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #f97316;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --bg-main: #f1f5f9;
            --text-dark: #1e293b;
            --white: #ffffff;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Montserrat', sans-serif; }
        body { display: flex; min-height: 100vh; background-color: var(--bg-main); }
        
        /* Sidebar */
        .sidebar {
            width: 260px; background-color: var(--sidebar-bg); color: #94a3b8;
            display: flex; flex-direction: column; position: fixed; height: 100vh;
        }
        .sidebar-brand {
            padding: 1.5rem; display: flex; align-items: center; gap: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--white);
        }
        .sidebar-brand i { color: var(--primary); font-size: 1.5rem; }
        .sidebar-brand span { font-weight: 800; font-size: 1.2rem; }
        
        .sidebar-menu { list-style: none; padding: 1.5rem 0; flex-grow: 1; }
        .menu-title { font-size: 0.75rem; text-transform: uppercase; font-weight: 800; padding: 0 1.5rem; margin-bottom: 0.8rem; letter-spacing: 1px;}
        .sidebar-menu li a {
            display: flex; align-items: center; gap: 1rem; padding: 0.8rem 1.5rem;
            color: #cbd5e1; text-decoration: none; font-size: 0.95rem; font-weight: 600;
            transition: all 0.3s;
        }
        .sidebar-menu li a:hover, .sidebar-menu li.active a {
            background-color: var(--sidebar-hover); color: var(--white); border-left: 4px solid var(--primary);
        }
        .sidebar-menu li a i { width: 20px; text-align: center; }

        .sidebar-user {
            padding: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; gap: 1rem;
        }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background-color: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold;}
        .user-info h4 { color: white; font-size: 0.9rem; margin-bottom: 0.2rem;}
        .user-info p { font-size: 0.75rem; color: #cbd5e1;}

        /* Main Content */
        .main-content {
            flex-grow: 1; margin-left: 260px; padding: 2.5rem 3rem;
        }
        .header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;
        }
        .header-title h2 { color: var(--text-dark); font-weight: 800; font-size: 1.8rem; }
        .breadcrumb { display: flex; gap: 0.5rem; font-size: 0.9rem; color: #64748b; margin-top: 0.3rem;}
        .breadcrumb a { color: var(--primary); text-decoration: none; font-weight: 600;}
        
        /* Form Card */
        .form-card {
            background-color: var(--white); border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            padding: 2.5rem; margin-bottom: 2rem;
        }
        .form-section-title {
            font-size: 1.2rem; font-weight: 800; color: #0f172a; margin-bottom: 1.5rem;
            padding-bottom: 0.5rem; border-bottom: 2px solid #e2e8f0;
        }

        .form-grid {
            display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; margin-bottom: 2rem;
        }
        
        .form-group { margin-bottom: 1rem; }
        .form-label { display: block; font-size: 0.9rem; font-weight: 700; color: #475569; margin-bottom: 0.5rem; }
        .form-control {
            width: 100%; padding: 0.8rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px;
            font-size: 0.95rem; outline: none; transition: border 0.3s; background-color: #f8fafc;
        }
        .form-control:focus { border-color: var(--primary); background-color: #ffffff; }
        select.form-control { appearance: none; background-image: url('data:image/svg+xml;utf8,<svg fill="black" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>'); background-repeat: no-repeat; background-position-x: 98%; background-position-y: 50%; }

        /* Actions Footer */
        .form-actions {
            display: flex; justify-content: flex-end; gap: 1rem; padding-top: 1rem; border-top: 1px solid #e2e8f0;
        }
        .btn {
            padding: 0.8rem 1.5rem; border-radius: 8px; font-weight: 700; font-size: 0.95rem; 
            cursor: pointer; text-decoration: none; border: none; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .btn-cancel { background-color: #f1f5f9; color: #475569; }
        .btn-cancel:hover { background-color: #e2e8f0; }
        .btn-save { background-color: var(--primary); color: white; box-shadow: 0 4px 10px rgba(249,115,22,0.2); }
        .btn-save:hover { background-color: #ea580c; transform: translateY(-2px); box-shadow: 0 6px 15px rgba(249,115,22,0.3); }

    
        /* Sidebar Minimized & Responsive Enhancements */
        .sidebar { transition: all 0.3s ease; z-index: 1000; }
        .sidebar.minimized { width: 80px; }
        .sidebar.minimized .sidebar-brand span, 
        .sidebar.minimized .menu-title, 
        .sidebar.minimized .user-info { display: none; }
        .sidebar.minimized .sidebar-brand { justify-content: center; padding: 1.5rem 0; }
        .sidebar.minimized .sidebar-menu li a { font-size: 0; justify-content: center; padding: 1rem 0; }
        .sidebar.minimized .sidebar-menu li a i { font-size: 1.4rem; width: 100%; text-align: center; margin: 0;}
        .sidebar.minimized .sidebar-user { justify-content: center; padding: 1.5rem 0; }
        .sidebar.minimized .sidebar-menu li a span { display: none; }

        .main-content { transition: all 0.3s ease; }
        .main-content.expanded { margin-left: 80px; }

        .btn-toggle-sidebar {
            background: white; border: 1px solid #e2e8f0; border-radius: 8px; color: var(--text-dark); 
            font-size: 1.2rem; cursor: pointer; transition: all 0.3s; margin-right: 1.5rem; 
            width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.02); flex-shrink: 0;
        }
        .btn-toggle-sidebar:hover { color: var(--primary); border-color: var(--primary); background: #fff7ed; }
        .header-title-wrapper { display: flex; align-items: center; }

        .sidebar-overlay {
            display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15,23,42,0.6); z-index: 999; backdrop-filter: blur(2px);
        }
        .sidebar-overlay.show { display: block; }

        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); width: 280px; }
            
            .sidebar.mobile-open .sidebar-menu li a { font-size: 0.95rem; justify-content: flex-start; padding: 0.8rem 1.5rem; }
            .sidebar.mobile-open .sidebar-menu li a i { font-size: 1rem; width: 20px; text-align: center; margin-right: 1rem;}
            .sidebar.mobile-open .sidebar-brand span, 
            .sidebar.mobile-open .menu-title, 
            .sidebar.mobile-open .user-info { display: block; }
            .sidebar.mobile-open .sidebar-brand { justify-content: flex-start; padding: 1.5rem; }
            .sidebar.mobile-open .sidebar-user { justify-content: flex-start; padding: 1.5rem; }
            
            .main-content { margin-left: 0 !important; padding: 1.5rem; }
            .main-content.expanded { margin-left: 0 !important; }
            
            .dash-cards { grid-template-columns: 1fr; }
            .header { flex-direction: column; align-items: flex-start; gap: 1.2rem; }
            .btn-logout, .btn-add { align-self: flex-start; }
            .news-grid, .gallery-grid { grid-template-columns: 1fr; }
            .upload-section { flex-direction: column; align-items: stretch; gap: 1.5rem; }
            .upload-form { flex-direction: column; }
            .form-row { flex-direction: column; align-items: stretch; }
            .role-alert { flex-direction: column; }
            .table-section { overflow-x: auto; width: 100%; display: block; }
        }

    
        /* Sidebar Scrollable */
        .sidebar-menu { overflow-y: auto; }
        .sidebar-menu::-webkit-scrollbar { width: 4px; }
        .sidebar-menu::-webkit-scrollbar-track { background: transparent; }
        .sidebar-menu::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        .sidebar-menu::-webkit-scrollbar-thumb:hover { background: #475569; }

    </style>
</head>
<body>

    <!-- Sidebar (Same as other pages) -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <main class="main-content">
        <div class="header">
            <div class="header-title-wrapper">
                <button id="sidebarToggle" class="btn-toggle-sidebar"><i class="fa-solid fa-bars"></i></button>
                <div class="header-title">
                <h2>Tambah Penduduk Baru</h2>
                <div class="breadcrumb">
                    <a href="/dashboard">Dashboard</a> <i class="fa-solid fa-chevron-right" style="font-size: 0.6rem; margin-top: 4px;"></i>
                    <a href="/penduduk">Data Penduduk</a> <i class="fa-solid fa-chevron-right" style="font-size: 0.6rem; margin-top: 4px;"></i>
                    <span>Tambah Data</span>
                </div>
            </div>
            </div>
        </div>

        @if ($errors->any())
            <div style="background-color: #fee2e2; color: #991b1b; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; font-weight: 600;">
                <ul style="margin: 0; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card">
            <form action="/penduduk/tambah" method="POST">
                @csrf
                
                <h3 class="form-section-title"><i class="fa-regular fa-id-card"></i> Informasi Dasar Kependudukan</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="nik">No. Induk Kependudukan (NIK) *</label>
                        <input type="text" id="nik" name="nik" class="form-control" required placeholder="16 Digit NIK" maxlength="16" minlength="16" pattern="\d{16}" title="NIK harus terdiri dari 16 digit angka">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nkk">No. Kartu Keluarga (KK) *</label>
                        <input type="text" id="nkk" name="nkk" class="form-control" required placeholder="16 Digit No. KK">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="nama">Nama Lengkap *</label>
                        <input type="text" id="nama" name="nama" class="form-control" required placeholder="Sesuai KTP">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="jk">Jenis Kelamin *</label>
                        <select id="jk" name="jk" class="form-control" required>
                            <option value="">-- Pilih Jenis Kelamin --</option>
                            <option value="L">Laki-laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tempat_lahir">Tempat Lahir *</label>
                        <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control" required placeholder="Contoh: Bojonegoro">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="tgl_lahir">Tanggal Lahir *</label>
                        <input type="date" id="tgl_lahir" name="tgl_lahir" class="form-control" required>
                    </div>
                </div>

                <h3 class="form-section-title"><i class="fa-solid fa-map-location-dot"></i> Alamat & Wilayah (RBAC Enforced)</h3>
                <div class="form-grid">
                    <div class="form-group" style="grid-column: span 2;">
                        <label class="form-label" for="alamat">Alamat Jalan / Rt / Rw *</label>
                        <input type="text" id="alamat" name="alamat" class="form-control" required placeholder="Contoh: Jl. Diponegoro RT 01 RW 02">
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="dusun">Dusun (Wilayah) *</label>
                        <select id="dusun" name="dusun" class="form-control" required>
                            <option value="">-- Pilih Dusun --</option>
                            @if($role === 'Super Admin' || $role === 'Admin Dusun Mlideg') <option value="Mlideg">Dusun Mlideg</option> @endif
                            @if($role === 'Super Admin' || $role === 'Admin Dusun Ngrapah') <option value="Ngrapah">Dusun Ngrapah</option> @endif
                        </select>
                        <small style="color:#64748b; font-size: 0.75rem; margin-top:0.3rem; display:block;">Pilihan dusun otomatis dibatasi sesuai Hak Akses Anda (RBAC).</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="kewarganegaraan">Kewarganegaraan</label>
                        <select id="kewarganegaraan" name="kewarganegaraan" class="form-control">
                            <option value="WNI">WNI (Warga Negara Indonesia)</option>
                            <option value="WNA">WNA (Warga Negara Asing)</option>
                        </select>
                    </div>
                </div>

                <h3 class="form-section-title"><i class="fa-solid fa-graduation-cap"></i> Data Sosial & Pendidikan</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label" for="agama">Agama *</label>
                        <select id="agama" name="agama" class="form-control" required>
                            <option value="">-- Pilih Agama --</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Konghucu">Konghucu</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="status_kawin">Status Perkawinan *</label>
                        <select id="status_kawin" name="status_kawin" class="form-control" required>
                            <option value="">-- Pilih Status --</option>
                            <option value="Belum Kawin">Belum Kawin</option>
                            <option value="Kawin">Kawin</option>
                            <option value="Cerai Hidup">Cerai Hidup</option>
                            <option value="Cerai Mati">Cerai Mati</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pendidikan">Pendidikan Terakhir *</label>
                        <select id="pendidikan" name="pendidikan" class="form-control" required>
                            <option value="">-- Pilih Pendidikan --</option>
                            <option value="Tidak/Belum Sekolah">Tidak / Belum Sekolah</option>
                            <option value="SD">Tamat SD / Sederajat</option>
                            <option value="SMP">Tamat SMP / Sederajat</option>
                            <option value="SMA">Tamat SMA / Sederajat</option>
                            <option value="D1/D2/D3">Diploma I/II/III</option>
                            <option value="S1/D4">S1 / Diploma IV</option>
                            <option value="S2/S3">S2 / S3</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="pekerjaan">Jenis Pekerjaan *</label>
                        <input type="text" id="pekerjaan" name="pekerjaan" class="form-control" required placeholder="Contoh: Petani / Karyawan Swasta">
                    </div>
                </div>

                <div class="form-actions">
                    <a href="/penduduk" class="btn btn-cancel">Batal</a>
                    <button type="submit" class="btn btn-save"><i class="fa-solid fa-floppy-disk"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </main>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const toggleBtn = document.getElementById('sidebarToggle');
            
            if(sidebar && !document.querySelector('.sidebar-overlay')){
                const overlay = document.createElement('div');
                overlay.classList.add('sidebar-overlay');
                document.body.appendChild(overlay);

                if(toggleBtn) {
                    toggleBtn.addEventListener('click', function() {
                        if (window.innerWidth <= 768) {
                            sidebar.classList.toggle('mobile-open');
                            overlay.classList.toggle('show');
                        } else {
                            sidebar.classList.toggle('minimized');
                            if(mainContent) mainContent.classList.toggle('expanded');
                        }
                    });
                }

                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('mobile-open');
                    overlay.classList.remove('show');
                });

                window.addEventListener('resize', function() {
                    if (window.innerWidth > 768) {
                        sidebar.classList.remove('mobile-open');
                        overlay.classList.remove('show');
                    }
                });
            }
        });
    </script>

</body>
</html>

