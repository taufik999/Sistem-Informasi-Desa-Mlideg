<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi - SID Admin</title>
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
        
        /* Sidebar (Copied from penduduk.blade.php) */
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
            flex-grow: 1; margin-left: 260px; padding: 2rem 2.5rem; min-width: 0;
        }
        .header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;
        }
        .header-title h2 { color: var(--text-dark); font-weight: 800; font-size: 1.8rem; }
        .header-title p { color: #64748b; font-size: 0.95rem; font-weight: 500; margin-top: 0.3rem;}
        
        .header-actions { display: flex; gap: 1rem; }
        .btn {
            padding: 0.7rem 1.2rem; border-radius: 8px; font-weight: 700; font-size: 0.9rem; 
            display: flex; align-items: center; gap: 0.5rem; cursor: pointer; text-decoration: none; border: none;
            transition: all 0.3s;
        }
        .btn-primary { background-color: var(--primary); color: white; box-shadow: 0 4px 10px rgba(249,115,22,0.2); }
        .btn-primary:hover { background-color: #ea580c; transform: translateY(-2px); box-shadow: 0 6px 15px rgba(249,115,22,0.3); }

        .table-container {
            background-color: var(--white); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }
        .data-table { width: 100%; border-collapse: collapse; }
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
        
        .action-btns { display: flex; gap: 0.5rem; }
        .action-btn { 
            width: 32px; height: 32px; border-radius: 6px; border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center; color: white; transition: opacity 0.3s;
        }
        .action-btn:hover { opacity: 0.8; }
        .btn-edit { background-color: #3b82f6; }
        .btn-delete { background-color: #ef4444; }
        .btn-info { background-color: #0ea5e9; }

        /* Sidebar Toggle */
        .sidebar { transition: all 0.3s ease; z-index: 1000; }
        .sidebar.minimized { width: 80px; }
        .sidebar.minimized .sidebar-brand span, .sidebar.minimized .menu-title,
        .sidebar.minimized .user-info { display: none; }
        .sidebar.minimized .sidebar-brand { justify-content: center; padding: 1.5rem 0; }
        .sidebar.minimized .sidebar-menu li a { font-size: 0; justify-content: center; padding: 1rem 0; }
        .sidebar.minimized .sidebar-menu li a i { font-size: 1.4rem; width: 100%; text-align: center; margin: 0; }
        .sidebar.minimized .sidebar-user { justify-content: center; padding: 1.5rem 0; }
        .main-content { transition: all 0.3s ease; }
        .main-content.expanded { margin-left: 80px; }
        .header-title-wrapper { display: flex; align-items: center; }
        .btn-toggle-sidebar {
            background: white; border: 1px solid #e2e8f0; border-radius: 8px; color: var(--text-dark);
            font-size: 1.2rem; cursor: pointer; transition: all 0.3s; margin-right: 1.5rem;
            width: 45px; height: 45px; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02); flex-shrink: 0;
        }
        .btn-toggle-sidebar:hover { color: var(--primary); border-color: var(--primary); background: #fff7ed; }
        .sidebar-overlay {
            display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15,23,42,0.6); z-index: 999; backdrop-filter: blur(2px);
        }
        .sidebar-overlay.show { display: block; }
        .table-container { overflow-x: auto; }
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); width: 280px; }
            .sidebar.mobile-open .sidebar-menu li a { font-size: 0.95rem; justify-content: flex-start; padding: 0.8rem 1.5rem; }
            .sidebar.mobile-open .sidebar-brand span, .sidebar.mobile-open .menu-title,
            .sidebar.mobile-open .user-info { display: block; }
            .sidebar.mobile-open .sidebar-brand { justify-content: flex-start; padding: 1.5rem; }
            .sidebar.mobile-open .sidebar-user { justify-content: flex-start; padding: 1.5rem; }
            .main-content { margin-left: 0 !important; padding: 1rem; }
            .main-content.expanded { margin-left: 0 !important; }
            .header { flex-direction: column; align-items: flex-start; gap: 1rem; }
            .header-title h2 { font-size: 1.4rem; }
            .header-actions { flex-wrap: wrap; }
            .data-table { min-width: 550px; }
        }
        @media (max-width: 480px) { .main-content { padding: 0.75rem; } }
    </style>
</head>
<body>

    @include('partials.sidebar')

    <main class="main-content">
        <div class="header">
            <div class="header-title-wrapper">
                <button id="sidebarToggle" class="btn-toggle-sidebar"><i class="fa-solid fa-bars"></i></button>
                <div class="header-title">
                    <h2>Struktur Organisasi</h2>
                    <p>Kelola Data Perangkat Desa</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="/admin/perangkat/tambah" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Perangkat</a>
            </div>
        </div>

        @if(session('success'))
            <div style="background-color: #dcfce3; color: #166534; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; font-weight: 600;">
                <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i> {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="20%">Nama Lengkap</th>
                        <th width="20%">Jabatan</th>
                        <th width="15%">Level</th>
                        <th width="25%">TTL</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($perangkat as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td><strong>{{ $p->nama }}</strong></td>
                        <td>{{ $p->jabatan }}</td>
                        <td>
                            @if($p->level == 0) BPD
                            @elseif($p->level == 1) Kepala Desa
                            @elseif($p->level == 2) Sekdes
                            @elseif($p->level == 3) Kaur
                            @elseif($p->level == 4) Kasi
                            @elseif($p->level == 5) Kepala Dusun
                            @else Level {{ $p->level }}
                            @endif
                        </td>
                        <td>{{ $p->ttl }}</td>
                        <td>
                            <div class="action-btns">
                                <a href="/admin/perangkat/{{ $p->id }}" class="action-btn btn-info" title="Detail"><i class="fa-solid fa-eye"></i></a>
                                <a href="/admin/perangkat/{{ $p->id }}/edit" class="action-btn btn-edit" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="/admin/perangkat/{{ $p->id }}/delete" class="action-btn btn-delete" title="Hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus perangkat ini?')"><i class="fa-solid fa-trash-can"></i></a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2rem; color: #64748b;">Belum ada data perangkat desa.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
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
