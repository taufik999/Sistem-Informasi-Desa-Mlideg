<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Perangkat Desa - SID Admin</title>
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
        
        .sidebar-menu { list-style: none; padding: 1.5rem 0; flex-grow: 1; overflow-y: auto; }
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
        .header-title p { color: #64748b; font-size: 0.95rem; font-weight: 500; margin-top: 0.3rem;}
        
        .detail-card {
            background: var(--white); padding: 2.5rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            max-width: 800px;
        }

        .profile-header {
            display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem;
            padding-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0;
        }
        .profile-icon {
            width: 80px; height: 80px; background: #fff7ed; color: var(--primary); 
            border-radius: 50%; display: flex; justify-content: center; align-items: center; font-size: 2.5rem;
        }
        .profile-title h3 { font-size: 1.5rem; color: var(--text-dark); margin-bottom: 0.3rem; }
        .profile-title p { color: #0ea5e9; font-weight: 700; font-size: 1rem; }

        .detail-grid {
            display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;
        }
        .detail-item {
            background: #f8fafc; padding: 1.2rem; border-radius: 8px; border: 1px solid #f1f5f9;
        }
        .detail-item span { display: block; font-size: 0.8rem; font-weight: 700; color: #64748b; text-transform: uppercase; margin-bottom: 0.4rem; }
        .detail-item strong { display: block; font-size: 1.05rem; color: var(--text-dark); }

        .detail-full {
            grid-column: span 2;
        }

        .btn-back {
            background-color: #e2e8f0; color: #475569; padding: 0.8rem 1.5rem; border: none; border-radius: 8px;
            font-weight: 700; cursor: pointer; font-size: 1rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .btn-back:hover { background-color: #cbd5e1; color: #334155; }
        
        .btn-edit {
            background-color: #3b82f6; color: white; padding: 0.8rem 1.5rem; border: none; border-radius: 8px;
            font-weight: 700; cursor: pointer; font-size: 1rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; margin-left: 1rem;
        }
        .btn-edit:hover { background-color: #2563eb; }

    </style>
</head>
<body>

    @include('partials.sidebar')

    <main class="main-content">
        <div class="header">
            <div class="header-title">
                <h2>Detail Perangkat Desa</h2>
                <p>Informasi lengkap anggota perangkat desa</p>
            </div>
        </div>

        <div class="detail-card">
            <div class="profile-header">
                <div class="profile-icon">
                    <i class="fa-solid {{ $perangkat->icon ?? 'fa-user' }}"></i>
                </div>
                <div class="profile-title">
                    <h3>{{ $perangkat->nama }}</h3>
                    <p>{{ $perangkat->jabatan }}</p>
                </div>
            </div>

            <div class="detail-grid">
                <div class="detail-item">
                    <span>Tempat, Tanggal Lahir</span>
                    <strong>{{ $perangkat->ttl ?: '-' }}</strong>
                </div>
                <div class="detail-item">
                    <span>Pendidikan Terakhir</span>
                    <strong>{{ $perangkat->pendidikan ?: '-' }}</strong>
                </div>
                <div class="detail-item">
                    <span>Nomor Handphone</span>
                    <strong>{{ $perangkat->no_hp ?: '-' }}</strong>
                </div>
                <div class="detail-item">
                    <span>Level Organisasi</span>
                    <strong>
                        @if($perangkat->level == 0) BPD
                        @elseif($perangkat->level == 1) Kepala Desa
                        @elseif($perangkat->level == 2) Sekretaris Desa
                        @elseif($perangkat->level == 3) Kaur
                        @elseif($perangkat->level == 4) Kasi
                        @elseif($perangkat->level == 5) Kepala Dusun
                        @else Level {{ $perangkat->level }}
                        @endif
                        (Urutan: {{ $perangkat->urutan }})
                    </strong>
                </div>
                <div class="detail-item detail-full">
                    <span>Deskripsi Tugas Utama</span>
                    <strong style="line-height: 1.6; font-weight: 500; font-size: 0.95rem;">
                        {{ $perangkat->deskripsi ?: 'Belum ada deskripsi tugas yang ditambahkan.' }}
                    </strong>
                </div>
            </div>

            <div style="margin-top: 1rem;">
                <a href="/admin/perangkat" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                <a href="/admin/perangkat/{{ $perangkat->id }}/edit" class="btn-edit"><i class="fa-solid fa-pen-to-square"></i> Edit Data</a>
            </div>
        </div>
    </main>

</body>
</html>
