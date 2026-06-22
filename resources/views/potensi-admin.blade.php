<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Potensi - DESA MLIDEG</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #f97316; --sidebar-bg: #0f172a; --sidebar-hover: #1e293b;
            --bg-main: #f1f5f9; --text-dark: #1e293b; --white: #ffffff;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Montserrat', sans-serif; }
        body { display: flex; min-height: 100vh; background-color: var(--bg-main); overflow-x: hidden; }
        
        /* Sidebar */
        .sidebar { width: 260px; background-color: var(--sidebar-bg); color: #94a3b8; display: flex; flex-direction: column; position: fixed; height: 100vh; z-index: 1000; transition: all 0.3s ease; }
        .sidebar-brand { padding: 1.5rem; display: flex; align-items: center; gap: 1rem; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--white); }
        .sidebar-brand i { color: var(--primary); font-size: 1.5rem; }
        .sidebar-brand span { font-weight: 800; font-size: 1.2rem; }
        .sidebar-menu { list-style: none; padding: 1.5rem 0; flex-grow: 1; overflow-y: auto; }
        .sidebar-menu::-webkit-scrollbar { width: 4px; }
        .sidebar-menu::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        .menu-title { font-size: 0.75rem; text-transform: uppercase; font-weight: 800; padding: 0 1.5rem; margin-bottom: 0.8rem; letter-spacing: 1px; }
        .sidebar-menu li a { display: flex; align-items: center; gap: 1rem; padding: 0.8rem 1.5rem; color: #cbd5e1; text-decoration: none; font-size: 0.95rem; font-weight: 600; transition: all 0.3s; }
        .sidebar-menu li a:hover, .sidebar-menu li.active a { background-color: var(--sidebar-hover); color: var(--white); border-left: 4px solid var(--primary); }
        .sidebar-menu li a i { width: 20px; text-align: center; }
        .sidebar-user { padding: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; gap: 1rem; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background-color: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .user-info h4 { color: white; font-size: 0.9rem; margin-bottom: 0.2rem; }
        .user-info p { font-size: 0.75rem; color: #cbd5e1; }

        /* Main Content */
        .main-content { flex-grow: 1; margin-left: 260px; padding: 2rem 2.5rem; transition: all 0.3s ease; min-width: 0; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .header-title-wrapper { display: flex; align-items: center; }
        .btn-toggle-sidebar {
            background: white; border: 1px solid #e2e8f0; border-radius: 8px; color: var(--text-dark); 
            font-size: 1.2rem; cursor: pointer; transition: all 0.3s; margin-right: 1.5rem; 
            width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; 
            box-shadow: 0 2px 5px rgba(0,0,0,0.02); flex-shrink: 0;
        }
        .btn-toggle-sidebar:hover { color: var(--primary); border-color: var(--primary); background: #fff7ed; }
        .header-title h2 { color: var(--text-dark); font-weight: 800; font-size: 1.8rem; }
        .header-title p { color: #64748b; font-size: 0.95rem; font-weight: 500; margin-top: 0.3rem;}

        /* Upload Section */
        .upload-card {
            background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); margin-bottom: 2rem;
        }
        .upload-card h3 { font-size: 1.2rem; margin-bottom: 1.5rem; color: var(--text-dark); }
        
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; font-weight: 600; margin-bottom: 0.5rem; color: #475569; }
        .form-control {
            width: 100%; padding: 0.8rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 1rem;
        }
        textarea.form-control { resize: vertical; min-height: 100px; }
        .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(249,115,22,0.1); }
        
        .btn-submit {
            background-color: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 8px;
            font-weight: 700; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .btn-submit:hover { background-color: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 4px 10px rgba(249,115,22,0.2); }

        /* Potensi List */
        .potensi-list { display: flex; flex-direction: column; gap: 1.5rem; }
        .potensi-item {
            background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            display: flex; gap: 1.5rem; padding: 1.5rem; align-items: center; transition: transform 0.3s;
        }
        .potensi-item:hover { transform: translateY(-3px); box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .potensi-img { width: 180px; height: 120px; object-fit: cover; border-radius: 8px; }
        .potensi-content { flex-grow: 1; }
        .potensi-cat { color: var(--primary); font-size: 0.8rem; font-weight: 800; text-transform: uppercase; margin-bottom: 0.3rem; display: block;}
        .potensi-title { font-size: 1.3rem; font-weight: 800; color: var(--text-dark); margin-bottom: 0.5rem; }
        .potensi-desc { color: #64748b; font-size: 0.95rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        
        .potensi-actions { display: flex; gap: 0.5rem; }
        .btn-delete {
            background-color: #fee2e2; color: #ef4444; border: none; padding: 0.8rem; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center;
        }
        .btn-delete:hover { background-color: #ef4444; color: white; }

        /* Sidebar Overlay */
        .sidebar-overlay {
            display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15,23,42,0.6); z-index: 999; backdrop-filter: blur(2px);
        }
        .sidebar-overlay.show { display: block; }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); width: 280px; }
            .sidebar.mobile-open .sidebar-menu li a { font-size: 0.95rem; justify-content: flex-start; padding: 0.8rem 1.5rem; }
            .sidebar.mobile-open .sidebar-brand span, .sidebar.mobile-open .menu-title,
            .sidebar.mobile-open .user-info { display: block; }
            .sidebar.mobile-open .sidebar-brand { justify-content: flex-start; padding: 1.5rem; }
            .sidebar.mobile-open .sidebar-user { justify-content: flex-start; padding: 1.5rem; }
            .main-content { margin-left: 0 !important; padding: 1rem; }
            .header { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .header-title h2 { font-size: 1.4rem; }
            .potensi-item { flex-direction: column; align-items: stretch; }
            .potensi-img { width: 100%; height: 200px; }
            /* Upload form grid */
            .upload-card div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; }
        }
        @media (max-width: 480px) {
            .main-content { padding: 0.75rem; }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    @include('partials.sidebar')

    <main class="main-content">
        <div class="header">
            <div class="header-title-wrapper">
                <button id="sidebarToggle" class="btn-toggle-sidebar"><i class="fa-solid fa-bars"></i></button>
                <div class="header-title">
                    <h2>Kelola Potensi Desa</h2>
                    <p>Promosikan kekayaan alam dan budaya desa kepada masyarakat luas</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div style="background-color: #dcfce3; color: #166534; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; font-weight: 600;">
                <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i> {{ session('success') }}
            </div>
        @endif

        <div class="upload-card">
            <h3><i class="fa-solid fa-plus" style="color: var(--primary);"></i> Tambah Data Potensi</h3>
            <form action="/admin/potensi/tambah" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Nama Potensi</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Lumbung Padi Organik" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option value="Pertanian Unggulan">Pertanian Unggulan</option>
                            <option value="Pusat UMKM">Pusat UMKM</option>
                            <option value="Pariwisata">Pariwisata</option>
                            <option value="Peternakan">Peternakan</option>
                            <option value="Sumber Daya Alam">Sumber Daya Alam</option>
                            <option value="Seni Budaya">Seni Budaya</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Deskripsi Singkat</label>
                    <textarea name="deskripsi" class="form-control" style="min-height: 80px;" required></textarea>
                </div>
                
                <div class="form-group">
                    <label>Deskripsi Lengkap</label>
                    <textarea name="full_desc" class="form-control" style="min-height: 120px;" required></textarea>
                </div>

                <div class="form-group">
                    <label>Unggah Gambar Ilustrasi</label>
                    <input type="file" name="foto" class="form-control" accept="image/*" required style="padding: 0.6rem 1rem;">
                </div>
                <button type="submit" class="btn-submit"><i class="fa-solid fa-save"></i> Simpan Potensi Desa</button>
            </form>
        </div>

        <div class="potensi-list">
            @forelse($potensi as $p)
            <div class="potensi-item">
                @if(isset($p['is_url']) && $p['is_url'])
                    <img src="{{ $p['foto'] }}" alt="{{ $p['judul'] ?? ($p['nama'] ?? 'Potensi') }}" class="potensi-img">
                @else
                    <img src="{{ asset('storage/' . $p['foto']) }}" alt="{{ $p['judul'] ?? ($p['nama'] ?? 'Potensi') }}" class="potensi-img">
                @endif
                <div class="potensi-content">
                    <span class="potensi-cat">{{ $p['kategori'] ?? 'Umum' }}</span>
                    <h3 class="potensi-title">{{ $p['judul'] ?? ($p['nama'] ?? 'Tanpa Nama') }}</h3>
                    <p class="potensi-desc">{{ $p['deskripsi'] ?? '' }}</p>
                </div>
                <div class="potensi-actions">
                    <a href="/admin/potensi/{{ $p['id'] }}/delete" class="btn-delete" title="Hapus Data" onclick="return confirm('Yakin ingin menghapus potensi ini?')">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 3rem; background: white; border-radius: 12px; color: #64748b;">
                <i class="fa-solid fa-seedling" style="font-size: 3rem; margin-bottom: 1rem; color: #cbd5e1;"></i>
                <p>Belum ada data potensi desa yang dimasukkan.</p>
            </div>
            @endforelse
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
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
                        }
                    });
                }

                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('mobile-open');
                    overlay.classList.remove('show');
                });
            }
        });
    </script>
</body>
</html>

