<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Penduduk - DESA MLIDEG</title>
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
        body { display: flex; min-height: 100vh; background-color: var(--bg-main); overflow-x: hidden; }
        
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
            flex-grow: 1; margin-left: 260px; padding: 2rem 2.5rem; min-width: 0;
        }
        .header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;
        }
        .header-title h2 { color: var(--text-dark); font-weight: 800; font-size: 1.8rem; }
        .header-title p { color: #64748b; font-size: 0.95rem; font-weight: 500; margin-top: 0.3rem;}
        
        .header-actions {
            display: flex; gap: 1rem;
        }
        .btn {
            padding: 0.7rem 1.2rem; border-radius: 8px; font-weight: 700; font-size: 0.9rem; 
            display: flex; align-items: center; gap: 0.5rem; cursor: pointer; text-decoration: none; border: none;
            transition: all 0.3s;
        }
        .btn-primary { background-color: var(--primary); color: white; box-shadow: 0 4px 10px rgba(249,115,22,0.2); }
        .btn-primary:hover { background-color: #ea580c; transform: translateY(-2px); box-shadow: 0 6px 15px rgba(249,115,22,0.3); }
        
        .btn-secondary { background-color: var(--white); color: #475569; border: 1px solid #cbd5e1; }
        .btn-secondary:hover { background-color: #f8fafc; border-color: #94a3b8; }

        /* Tools Bar (Search & Filter) */
        .tools-bar {
            display: flex; justify-content: space-between; margin-bottom: 1.5rem; background: var(--white); padding: 1.2rem; border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02); flex-wrap: wrap; gap: 1rem;
        }
        .search-box {
            position: relative; width: 350px; max-width: 100%;
        }
        .search-box i { position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        .search-box input {
            width: 100%; padding: 0.6rem 1rem 0.6rem 2.8rem; border: 1px solid #e2e8f0; border-radius: 8px;
            font-size: 0.95rem; outline: none; transition: border 0.3s; font-family: 'Montserrat', sans-serif;
        }
        .search-box input:focus { border-color: var(--primary); }
        
        .filters { display: flex; gap: 1rem; flex-wrap: wrap; }
        .filter-select {
            padding: 0.6rem 1rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.9rem;
            color: #475569; outline: none; background-color: white; cursor: pointer; font-family: 'Montserrat', sans-serif;
        }

        /* Data Table */
        .table-container {
            background-color: var(--white); border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.02); overflow: hidden;
        }
        .table-scroll { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .data-table { width: 100%; min-width: 900px; border-collapse: collapse; }
        .data-table th { 
            text-align: left; padding: 1.2rem 1.5rem; background-color: #f8fafc; 
            color: #475569; font-weight: 700; font-size: 0.85rem; border-bottom: 2px solid #e2e8f0;
            text-transform: uppercase; letter-spacing: 0.5px;
        }
        .data-table td { 
            padding: 1.2rem 1.5rem; border-bottom: 1px solid #f1f5f9; 
            font-size: 0.95rem; color: #334155; font-weight: 500;
        }
        .data-table tr:hover { background-color: #f8fafc; }
        
        .status-badge { 
            padding: 0.4rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; white-space: nowrap; display: inline-block;
        }
        .badge-active { background-color: #dcfce3; color: #166534; }
        .badge-moved { background-color: #fee2e2; color: #991b1b; }
        
        .action-btns { display: flex; gap: 0.5rem; }
        .action-btn { 
            width: 32px; height: 32px; border-radius: 6px; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center; color: white; transition: opacity 0.3s;
        }
        .action-btn:hover { opacity: 0.8; }
        .btn-edit { background-color: #3b82f6; }
        .btn-delete { background-color: #ef4444; }
        .btn-view { background-color: #10b981; }

        /* Pagination */
        .pagination {
            display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; border-top: 1px solid #e2e8f0;
        }
        .page-info { font-size: 0.9rem; color: #64748b; font-weight: 500; }
        .page-links { display: flex; gap: 0.3rem; }
        .page-link {
            width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;
            border: 1px solid #e2e8f0; border-radius: 6px; color: #475569; text-decoration: none; font-weight: 600;
            transition: all 0.2s; font-size: 0.9rem;
        }
        .page-link:hover { background-color: #f1f5f9; }
        .page-link.active { background-color: var(--primary); color: white; border-color: var(--primary); }

    
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
            
            .main-content { margin-left: 0 !important; padding: 0.9rem; }
            .main-content.expanded { margin-left: 0 !important; }
            
            .header { flex-direction: column; align-items: flex-start; gap: 0.8rem; margin-bottom: 1rem; }
            .header-title-wrapper { width: 100%; }
            .header-title h2 { font-size: 1.3rem; }
            .header-title p { font-size: 0.8rem; }
            .header-actions { width: 100%; flex-wrap: wrap; }
            .header-actions .btn { flex: 1; justify-content: center; font-size: 0.85rem; }

            .tools-bar { flex-direction: column; padding: 0.9rem; }
            .search-box { width: 100%; }
            .search-box input { font-size: 0.9rem; }
            .filters { width: 100%; flex-direction: column; }
            .filter-select { width: 100%; }

            .pagination { flex-direction: column; gap: 0.8rem; align-items: flex-start; padding: 1rem; }
            .page-links { flex-wrap: wrap; }
        }
        @media (max-width: 480px) {
            .main-content { padding: 0.7rem; }
            .header-actions .btn span { display: none; }
            .header-actions .btn { flex: none; padding: 0.6rem; }
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

    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <main class="main-content">
        <div class="header">
            <div class="header-title-wrapper">
                <button id="sidebarToggle" class="btn-toggle-sidebar"><i class="fa-solid fa-bars"></i></button>
                <div class="header-title">
                <h2>Kelola Data Penduduk</h2>
                <p>Manajemen Basis Data Induk Kependudukan Desa Mlideg</p>
            </div>
            </div>
            
            <div class="header-actions">
                <a href="/penduduk/export" class="btn btn-secondary" target="_blank"><i class="fa-solid fa-file-export"></i> Ekspor CSV</a>
                <a href="/penduduk/tambah" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Penduduk</a>
            </div>
        </div>

        @if(session('success'))
            <div style="background-color: #dcfce3; color: #166534; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; font-weight: 600;">
                <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i> {{ session('success') }}
            </div>
        @endif

        <form id="searchForm" method="GET" action="/penduduk" class="tools-bar">
            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" name="search" id="searchInput" placeholder="Cari NIK atau Nama Penduduk..." value="{{ request('search') }}">
            </div>
            
            <div class="filters">
                <select name="dusun" id="filterDusun" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Dusun</option>
                    @if($role === 'Super Admin' || $role === 'Admin Dusun Mlideg') <option value="Mlideg" {{ request('dusun') == 'Mlideg' ? 'selected' : '' }}>Dusun Mlideg</option> @endif
                    @if($role === 'Super Admin' || $role === 'Admin Dusun Ngrapah') <option value="Ngrapah" {{ request('dusun') == 'Ngrapah' ? 'selected' : '' }}>Dusun Ngrapah</option> @endif
                </select>
                <select name="status" id="filterStatus" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Pindah" {{ request('status') == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                    <option value="Meninggal" {{ request('status') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                </select>
                <button type="submit" class="btn btn-primary" style="padding: 0.6rem 1rem; border-radius: 8px;">Cari</button>
            </div>
        </form>

        <div class="table-container">
            <div class="table-scroll">
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="15%">NIK</th>
                        <th width="25%">Nama Lengkap</th>
                        <th width="15%">Dusun</th>
                        <th width="12%">Gelar/Pekerjaan</th>
                        <th width="13%">Status</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penduduk as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td style="font-family: monospace; font-size:1rem;">{{ $p->nik }}</td>
                        <td><strong>{{ $p->nama }}</strong><br><span style="color:#94a3b8; font-size:0.8rem;">{{ $p->jk === 'L' ? 'Laki-laki' : 'Perempuan' }}</span></td>
                        <td>Dusun {{ $p->dusun }}</td>
                        <td>{{ $p->pekerjaan }}</td>
                        <td>
                            @if($p->status === 'Aktif')
                                <span class="status-badge badge-active">Penduduk Tetap</span>
                            @elseif($p->status === 'Pindah')
                                <span class="status-badge badge-moved">Pindah Keluar</span>
                            @else
                                <span class="status-badge badge-moved" style="background-color: #334155; color: white;">Meninggal</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-btns">
                                <a href="/penduduk/{{ $p->id }}" class="action-btn btn-view" title="Lihat Detail"><i class="fa-regular fa-eye"></i></a>
                                <a href="/penduduk/{{ $p->id }}/edit" class="action-btn btn-edit" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                @if($role === 'Super Admin')
                                <a href="/penduduk/{{ $p->id }}/delete" class="action-btn btn-delete" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus data penduduk {{ $p->nama }}? Data yang dihapus tidak dapat dikembalikan.')"><i class="fa-solid fa-trash-can"></i></a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2rem; color: #64748b;">Belum ada data penduduk yang tersimpan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>{{-- end table-scroll --}}
            
            {{ $penduduk->links('partials.pagination') }}
        </div>

    </main>

    <script>

    </script>

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

