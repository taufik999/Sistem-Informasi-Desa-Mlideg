<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Berita - DESA MLIDEG</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #f97316; --sidebar-bg: #0f172a; --sidebar-hover: #1e293b;
            --bg-main: #f1f5f9; --text-dark: #1e293b; --white: #ffffff;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Montserrat', sans-serif; }
        body { display: flex; min-height: 100vh; background-color: var(--bg-main); overflow-x: hidden; }
        
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
        .main-content { flex-grow: 1; margin-left: 260px; padding: 2rem 2.5rem; overflow-x: hidden; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .header-title h2 { color: var(--text-dark); font-weight: 800; font-size: 1.8rem; }
        .header-title p { color: #64748b; font-size: 0.95rem; font-weight: 500; margin-top: 0.3rem;}
        
        .btn-add {
            background-color: var(--primary); color: white; padding: 0.8rem 1.2rem; border-radius: 8px; text-decoration: none;
            font-size: 0.95rem; font-weight: 700; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; border: none; cursor: pointer;
            box-shadow: 0 4px 10px rgba(249,115,22,0.2);
        }
        .btn-add:hover { background-color: #ea580c; transform: translateY(-2px); box-shadow: 0 6px 15px rgba(249,115,22,0.3); }

        /* News Cards Grid */
        .news-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 1.5rem; }
        
        .news-card {
            background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            display: flex; flex-direction: column; transition: transform 0.3s;
        }
        .news-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.05); }

        .news-img {
            height: 160px; background-color: #e2e8f0; position: relative; display: flex; align-items: center; justify-content: center; color: #94a3b8; font-size: 2rem;
        }
        
        .news-status {
            position: absolute; top: 1rem; left: 1rem; padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 800; color: white;
        }
        .status-published { background-color: #10b981; }
        .status-draft { background-color: #f59e0b; }

        .news-content { padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column; }
        .news-meta {
            display: flex; justify-content: space-between; font-size: 0.8rem; color: #64748b; font-weight: 600; margin-bottom: 0.8rem;
        }
        .news-title { font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 1rem; line-height: 1.4;}
        
        .news-actions {
            margin-top: auto; padding-top: 1rem; border-top: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center;
        }
        
        .action-icon {
            color: #64748b; font-size: 1.1rem; transition: color 0.2s; margin-left: 0.5rem;
        }
        .action-icon:hover { color: var(--primary); }
        .btn-edit { color: #3b82f6; }
        .btn-delete { color: #ef4444; }

    
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
            
            .main-content { margin-left: 0 !important; padding: 1rem; }
            .main-content.expanded { margin-left: 0 !important; }
            
            .header { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .header-title h2 { font-size: 1.4rem; }
            .btn-add { align-self: flex-start; }
            .news-grid { grid-template-columns: 1fr; }
        }
        @media (max-width: 480px) {
            .main-content { padding: 0.75rem; }
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
                <h2>Kelola Publikasi Berita</h2>
                <p>Manajemen artikel dan informasi publik portal desa</p>
            </div>
            </div>
            <a href="/admin/berita/tambah" class="btn-add"><i class="fa-solid fa-pen"></i> Tulis Berita Baru</a>
        </div>

        @if(session('success'))
            <div style="background-color: #dcfce3; color: #166534; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; font-weight: 600;">
                <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i> {{ session('success') }}
            </div>
        @endif

        <div class="news-grid">
            @foreach($berita as $b)
            <div class="news-card">
                <div class="news-img" style="overflow: hidden; justify-content: flex-start; align-items: flex-start;">
                    @if(isset($b['foto']) && $b['foto'])
                        <img src="{{ asset('storage/' . $b['foto']) }}" alt="Foto Berita" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <!-- Placeholder if no image -->
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background-color: #e2e8f0; font-size: 2rem; color: #94a3b8;">
                            <i class="fa-regular fa-image"></i>
                        </div>
                    @endif
                    <span class="news-status {{ $b['status'] == 'Published' ? 'status-published' : 'status-draft' }}">
                        {{ $b['status'] }}
                    </span>
                </div>
                <div class="news-content">
                    <div class="news-meta">
                        <span><i class="fa-regular fa-calendar"></i> {{ $b['tanggal'] }}</span>
                        <span><i class="fa-regular fa-eye"></i> {{ $b['views'] }}</span>
                    </div>
                    <h3 class="news-title">{{ $b['judul'] }}</h3>
                    
                    <div class="news-actions">
                        <span style="font-size: 0.8rem; color: #94a3b8; font-weight: 600;">Oleh: {{ $b['penulis'] }}</span>
                        <div>
                            <a href="/admin/berita/{{ $b['id'] }}" class="action-icon btn-view" title="Lihat Artikel"><i class="fa-solid fa-eye" style="color: #10b981;"></i></a>
                            <a href="/admin/berita/{{ $b['id'] }}/edit" class="action-icon btn-edit" title="Edit Artikel"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="/admin/berita/{{ $b['id'] }}/delete" class="action-icon btn-delete" title="Hapus Artikel" onclick="return confirm('Yakin ingin menghapus artikel ini?')"><i class="fa-solid fa-trash-can"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
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

