<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penduduk - DESA MLIDEG</title>
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

        .detail-card {
            background-color: var(--white); border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            padding: 2.5rem; margin-bottom: 2rem;
        }

        .profile-header {
            display: flex; align-items: center; gap: 2rem; margin-bottom: 2.5rem; padding-bottom: 1.5rem; border-bottom: 2px solid #f1f5f9;
        }
        .profile-icon {
            width: 100px; height: 100px; border-radius: 50%; background-color: #e2e8f0; color: #94a3b8;
            display: flex; align-items: center; justify-content: center; font-size: 3rem;
        }
        .profile-title h3 { font-size: 1.8rem; font-weight: 800; color: #0f172a; margin-bottom: 0.5rem;}
        .profile-title p { font-size: 1rem; color: #64748b; font-family: monospace; letter-spacing: 1px;}
        .status-badge { padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700; background-color: #dcfce3; color: #166534; display: inline-block; margin-top: 0.5rem;}

        .data-grid {
            display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem 3rem;
        }
        .data-item { margin-bottom: 0.5rem; }
        .data-label { font-size: 0.85rem; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 0.3rem;}
        .data-value { font-size: 1rem; color: #1e293b; font-weight: 700; }

        .form-actions {
            display: flex; padding-top: 2rem; margin-top: 2rem; border-top: 1px solid #e2e8f0; gap: 1rem;
        }
        .btn {
            padding: 0.8rem 1.5rem; border-radius: 8px; font-weight: 700; font-size: 0.9rem; 
            cursor: pointer; text-decoration: none; border: none; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .btn-secondary { background-color: #f1f5f9; color: #475569; }
        .btn-secondary:hover { background-color: #e2e8f0; }
        .btn-edit { background-color: #3b82f6; color: white; }
        .btn-edit:hover { background-color: #2563eb; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3); }
        .btn-cetak { background-color: var(--primary); color: white; }
        .btn-cetak:hover { background-color: #ea580c; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(249,115,22,0.3); }

    
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
    @include('partials.sidebar')

    <main class="main-content">
        <div class="header">
            <div class="header-title-wrapper">
                <button id="sidebarToggle" class="btn-toggle-sidebar"><i class="fa-solid fa-bars"></i></button>
                <div class="header-title">
                <h2>Rincian Data Penduduk</h2>
                <div class="breadcrumb">
                    <a href="/dashboard">Dashboard</a> <i class="fa-solid fa-chevron-right" style="font-size: 0.6rem; margin-top: 4px;"></i>
                    <a href="/penduduk">Data Penduduk</a> <i class="fa-solid fa-chevron-right" style="font-size: 0.6rem; margin-top: 4px;"></i>
                    <span>Detail Penduduk ID: {{ $p->id }}</span>
                </div>
            </div>
            </div>
        </div>

        <div class="detail-card">
            <div class="profile-header">
                <div class="profile-icon">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="profile-title">
                    <h3 id="vNama">{{ $p->nama }}</h3>
                    <p id="vNik">NIK: {{ $p->nik }}</p>
                    <span class="status-badge" id="vStatus" style="{{ $p->status === 'Pindah Keluar' ? 'background-color: #fee2e2; color: #991b1b;' : '' }}">{{ $p->status }}</span>
                </div>
            </div>

            <h4 style="color:var(--primary); margin-bottom: 1rem; border-bottom: 2px solid #ffedd5; padding-bottom: 0.5rem;"><i class="fa-regular fa-address-card"></i> Data Pribadi</h4>
            <div class="data-grid">
                <div class="data-item">
                    <div class="data-label">Nomor Kartu Keluarga (KK)</div>
                    <div class="data-value" id="vKk">{{ $p->nkk }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Jenis Kelamin</div>
                    <div class="data-value" id="vJk">{{ $p->jk == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Tempat, Tanggal Lahir</div>
                    <div class="data-value" id="vTTL">{{ $p->tempat_lahir }}, {{ \Carbon\Carbon::parse($p->tgl_lahir)->isoFormat('D MMMM Y') }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Agama</div>
                    <div class="data-value" id="vAgama">{{ $p->agama }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Pendidikan Terakhir</div>
                    <div class="data-value" id="vPendidikan">{{ $p->pendidikan }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Pekerjaan</div>
                    <div class="data-value" id="vPekerjaan">{{ $p->pekerjaan }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Status Perkawinan</div>
                    <div class="data-value" id="vStatusKawin">{{ $p->status_kawin }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Hubungan Keluarga</div>
                    <div class="data-value" id="vHubunganKeluarga">{{ $p->hubungan_keluarga ?? 'Anggota Keluarga' }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Kewarganegaraan</div>
                    <div class="data-value" id="vWN">{{ $p->kewarganegaraan }}</div>
                </div>
            </div>

            <h4 style="color:var(--primary); margin-top: 2rem; margin-bottom: 1rem; border-bottom: 2px solid #ffedd5; padding-bottom: 0.5rem;"><i class="fa-solid fa-map-location-dot"></i> Data Alamat</h4>
            <div class="data-grid">
                <div class="data-item" style="grid-column: span 2;">
                    <div class="data-label">Alamat Lengkap</div>
                    <div class="data-value" id="vAlamat">{{ $p->alamat }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Desa / Kelurahan</div>
                    <div class="data-value">Mlideg</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Dusun</div>
                    <div class="data-value" id="vDusun">{{ $p->dusun }}</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Kecamatan</div>
                    <div class="data-value">Kedungadem</div>
                </div>
                <div class="data-item">
                    <div class="data-label">Kab/Kota & Provinsi</div>
                    <div class="data-value">Bojonegoro, Jawa Timur</div>
                </div>
            </div>

            <div class="form-actions">
                <a href="/penduduk" class="btn btn-secondary"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                <a href="/penduduk/{{ $p->id }}/edit" class="btn btn-edit"><i class="fa-solid fa-pen-to-square"></i> Edit Data</a>
                <button class="btn btn-cetak"><i class="fa-solid fa-print"></i> Cetak Biodata</button>
            </div>
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

