<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tulis Berita Baru - DESA MLIDEG</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #f97316; --sidebar-bg: #0f172a; --sidebar-hover: #1e293b;
            --bg-main: #f1f5f9; --text-dark: #1e293b; --white: #ffffff;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Montserrat', sans-serif; }
        body { display: flex; min-height: 100vh; background-color: var(--bg-main); }
        
        /* Sidebar (Same structure) */
        .sidebar { width: 260px; background-color: var(--sidebar-bg); color: #94a3b8; display: flex; flex-direction: column; position: fixed; height: 100vh; }
        .sidebar-brand { padding: 1.5rem; display: flex; align-items: center; gap: 1rem; border-bottom: 1px solid rgba(255,255,255,0.05); color: var(--white); }
        .sidebar-brand i { color: var(--primary); font-size: 1.5rem; }
        .sidebar-brand span { font-weight: 800; font-size: 1.2rem; }
        .sidebar-menu { list-style: none; padding: 1.5rem 0; flex-grow: 1; }
        .menu-title { font-size: 0.75rem; text-transform: uppercase; font-weight: 800; padding: 0 1.5rem; margin-bottom: 0.8rem; letter-spacing: 1px; }
        .sidebar-menu li a { display: flex; align-items: center; gap: 1rem; padding: 0.8rem 1.5rem; color: #cbd5e1; text-decoration: none; font-size: 0.95rem; font-weight: 600; transition: all 0.3s; }
        .sidebar-menu li a:hover, .sidebar-menu li.active a { background-color: var(--sidebar-hover); color: var(--white); border-left: 4px solid var(--primary); }
        .sidebar-menu li a i { width: 20px; text-align: center; }
        .sidebar-user { padding: 1.5rem; border-top: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; gap: 1rem; }
        .user-avatar { width: 40px; height: 40px; border-radius: 50%; background-color: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .user-info h4 { color: white; font-size: 0.9rem; margin-bottom: 0.2rem; }
        .user-info p { font-size: 0.75rem; color: #cbd5e1; }

        /* Main Content */
        .main-content { flex-grow: 1; margin-left: 260px; padding: 2.5rem 3rem; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .header-title h2 { color: var(--text-dark); font-weight: 800; font-size: 1.8rem; }
        .header-title p { color: #64748b; font-size: 0.95rem; font-weight: 500; margin-top: 0.3rem;}
        
        .btn-back { display: inline-flex; align-items: center; gap: 0.5rem; color: #64748b; text-decoration: none; font-weight: 600; margin-bottom: 1.5rem; transition: color 0.3s; }
        .btn-back:hover { color: var(--primary); }

        .form-card { background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); padding: 2.5rem; max-width: 800px; }
        
        .form-group { margin-bottom: 1.5rem; }
        .form-label { display: block; font-weight: 700; color: #334155; margin-bottom: 0.5rem; font-size: 0.95rem; }
        .form-control { width: 100%; padding: 0.8rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem; transition: all 0.3s; background-color: #f8fafc; font-family: 'Montserrat', sans-serif;}
        .form-control:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 3px rgba(249,115,22,0.1); background-color: white; }
        textarea.form-control { resize: vertical; min-height: 200px; }

        .btn-submit {
            background-color: var(--primary); color: white; border: none; padding: 0.8rem 2rem; border-radius: 8px;
            font-size: 1rem; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px rgba(249,115,22,0.2);
            display: inline-flex; align-items: center; gap: 0.5rem; margin-top: 1rem;
        }
        .btn-submit:hover { background-color: #ea580c; transform: translateY(-2px); box-shadow: 0 6px 15px rgba(249,115,22,0.3); }

    
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
        <a href="/admin/berita" class="btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Berita</a>
        
        <div class="header">
            <div class="header-title-wrapper">
                <button id="sidebarToggle" class="btn-toggle-sidebar"><i class="fa-solid fa-bars"></i></button>
                <div class="header-title">
                <h2>Tulis Berita Baru</h2>
                <p>Publikasikan informasi atau pengumuman terbaru untuk warga.</p>
            </div>
            </div>
        </div>

        <div class="form-card">
            <form action="/admin/berita/tambah" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="foto">Foto Sampul</label>
                    <input type="file" id="foto" name="foto" class="form-control" accept="image/*, .png, .jpg, .jpeg, .webp, .svg, .gif, .bmp, .ico" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="judul">Judul Berita</label>
                    <input type="text" id="judul" name="judul" class="form-control" placeholder="Masukkan judul berita yang menarik" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="status">Status Rilis</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="Published">Published (Terbit Secara Publik)</option>
                        <option value="Draft">Draft (Hanya Disimpan)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label" for="konten">Konten Artikel</label>
                    <textarea id="konten" name="konten" class="form-control" placeholder="Tuliskan isi berita di sini..." required></textarea>
                </div>

                <button type="submit" class="btn-submit"><i class="fa-solid fa-paper-plane"></i> Publikasikan</button>
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

