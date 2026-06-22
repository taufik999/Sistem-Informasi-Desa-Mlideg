<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Berita Admin - DESA MLIDEG</title>
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

        .detail-card { background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); padding: 2.5rem; max-width: 900px; }
        
        .detail-title { font-size: 2rem; font-weight: 800; color: #0f172a; margin-bottom: 1rem; line-height: 1.4; }
        
        .detail-meta { display: flex; align-items: center; gap: 1.5rem; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid #e2e8f0; color: #64748b; font-size: 0.95rem; font-weight: 600; }
        .detail-meta span i { color: var(--primary); margin-right: 0.4rem; }
        
        .news-status { padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 800; color: white; }
        .status-published { background-color: #10b981; }
        .status-draft { background-color: #f59e0b; }

        .detail-img { width: 100%; max-height: 400px; object-fit: cover; border-radius: 8px; margin-bottom: 2rem; }
        .detail-img-placeholder { width: 100%; height: 300px; background: #e2e8f0; border-radius: 8px; margin-bottom: 2rem; display: flex; align-items: center; justify-content: center; font-size: 4rem; color: #94a3b8; }
        
        .detail-content { color: #334155; line-height: 1.8; font-size: 1.05rem; white-space: pre-line; }

        .btn-edit { background-color: var(--primary); color: white; border: none; padding: 0.8rem 1.5rem; border-radius: 8px; font-size: 0.95rem; font-weight: 700; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; margin-top: 2rem;}
        .btn-edit:hover { background-color: #ea580c; transform: translateY(-2px); box-shadow: 0 4px 10px rgba(249,115,22,0.2); }

    
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
                <h2>Pratinjau Artikel Berita</h2>
                <p>Tinjauan konten internal khusus Admin.</p>
            </div>
            </div>
        </div>

        <div class="detail-card">
            <h1 class="detail-title">{{ $berita['judul'] }}</h1>
            
            <div class="detail-meta">
                <span class="news-status {{ $berita['status'] == 'Published' ? 'status-published' : 'status-draft' }}">{{ $berita['status'] }}</span>
                <span><i class="fa-regular fa-calendar-days"></i> {{ $berita['tanggal'] }}</span>
                <span><i class="fa-solid fa-user-pen"></i> {{ $berita['penulis'] }}</span>
                <span><i class="fa-regular fa-eye"></i> {{ $berita['views'] ?? 0 }} Views</span>
            </div>

            @if(isset($berita['foto']) && $berita['foto'])
                <img src="{{ asset('storage/' . $berita['foto']) }}" alt="{{ $berita['judul'] }}" class="detail-img">
            @else
                <div class="detail-img-placeholder">
                    <i class="fa-regular fa-image"></i>
                </div>
            @endif

            <div class="detail-content">
                @if(isset($berita['konten']))
                    {{ $berita['konten'] }}
                @else
                    <p>Konten belum tersedia.</p>
                @endif
            </div>

            <a href="/admin/berita/{{ $berita['id'] }}/edit" class="btn-edit"><i class="fa-solid fa-pen-to-square"></i> Edit Artikel Ini</a>
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

