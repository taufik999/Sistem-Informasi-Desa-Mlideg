<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Galeri - DESA MLIDEG</title>
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
        .form-control:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px rgba(249,115,22,0.1); }
        
        .btn-submit {
            background-color: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 8px;
            font-weight: 700; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem;
        }
        .btn-submit:hover { background-color: var(--primary-hover); transform: translateY(-2px); box-shadow: 0 4px 10px rgba(249,115,22,0.2); }

        /* Gallery Grid */
        .gallery-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;
        }
        .gallery-item {
            background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            position: relative; transition: transform 0.3s;
        }
        .gallery-item:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .gallery-img { width: 100%; height: 200px; object-fit: cover; }
        .gallery-content { padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: center; }
        .gallery-info h4 { font-size: 1rem; color: var(--text-dark); margin-bottom: 0.2rem; }
        .gallery-info p { font-size: 0.8rem; color: var(--primary); font-weight: 700; text-transform: uppercase; }
        .btn-delete { color: #ef4444; background: none; border: none; font-size: 1.2rem; cursor: pointer; transition: color 0.3s; }
        .btn-delete:hover { color: #b91c1c; }

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
            .main-content { margin-left: 0 !important; padding: 1rem; transition: all 0.3s ease; }
            .header { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .header-title h2 { font-size: 1.4rem; }
            .gallery-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
            /* Upload form grid */
            .upload-card div[style*="grid-template-columns"] { grid-template-columns: 1fr !important; }
        }
        @media (max-width: 480px) {
            .main-content { padding: 0.75rem; }
            .gallery-grid { grid-template-columns: 1fr; }
            .gallery-img { height: 160px; }
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
                    <h2>Kelola Galeri Desa</h2>
                    <p>Unggah dan kelola foto dokumentasi desa</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div style="background-color: #dcfce3; color: #166534; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; font-weight: 600;">
                <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i> {{ session('success') }}
            </div>
        @endif

        <div class="upload-card">
            <h3><i class="fa-solid fa-cloud-arrow-up" style="color: var(--primary);"></i> Tambah Foto Baru</h3>
            <form action="/admin/galeri/tambah" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label>Judul / Keterangan Foto</label>
                        <input type="text" name="judul" class="form-control" placeholder="Contoh: Panen Raya Kelompok Tani" required>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori" class="form-control" required>
                            <option value="Pembangunan">Pembangunan</option>
                            <option value="Sosial Budaya">Sosial Budaya</option>
                            <option value="Pemerintahan">Pemerintahan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Unggah File Foto</label>
                    <input type="file" name="foto" class="form-control" accept="image/*" required style="padding: 0.6rem 1rem;">
                </div>
                <button type="submit" class="btn-submit"><i class="fa-solid fa-upload"></i> Unggah Foto</button>
            </form>
        </div>

        <div class="gallery-grid">
            @forelse($galeri as $g)
            <div class="gallery-item">
                @if(isset($g['is_url']) && $g['is_url'])
                    <img src="{{ $g['foto'] }}" alt="{{ $g['judul'] ?? 'Galeri' }}" class="gallery-img">
                @else
                    <img src="{{ asset('storage/' . $g['foto']) }}" alt="{{ $g['judul'] ?? 'Galeri' }}" class="gallery-img">
                @endif
                <div class="gallery-content">
                    <div class="gallery-info">
                        <h4>{{ $g['judul'] ?? 'Tanpa Judul' }}</h4>
                        <p>{{ $g['kategori'] ?? 'Belum Dikategorikan' }}</p>
                    </div>
                    <a href="/admin/galeri/{{ $g['id'] }}/delete" class="btn-delete" title="Hapus Foto" onclick="return confirm('Yakin ingin menghapus foto ini dari galeri?')">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>
                </div>
            </div>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; background: white; border-radius: 12px; color: #64748b;">
                <i class="fa-regular fa-images" style="font-size: 3rem; margin-bottom: 1rem; color: #cbd5e1;"></i>
                <p>Belum ada foto di galeri. Silakan unggah foto baru.</p>
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

