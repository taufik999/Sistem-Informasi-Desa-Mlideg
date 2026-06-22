<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengaduan - DESA MLIDEG</title>
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
        .main-content { flex-grow: 1; margin-left: 260px; padding: 2rem 2.5rem; min-width: 0; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
        .header-title h2 { color: var(--text-dark); font-weight: 800; font-size: 1.8rem; }
        .header-title p { color: #64748b; font-size: 0.95rem; font-weight: 500; margin-top: 0.3rem;}
        
        /* Tabs Navbar */
        .tabs-nav {
            display: flex; gap: 0.5rem; border-bottom: 2px solid #e2e8f0; margin-bottom: 2rem;
            overflow-x: auto; white-space: nowrap; scrollbar-width: none;
        }
        .tabs-nav::-webkit-scrollbar { display: none; }
        .tab-btn {
            background: none; border: none; padding: 1rem 1.5rem; font-size: 0.95rem; font-weight: 700; color: #64748b;
            cursor: pointer; position: relative; transition: all 0.3s;
        }
        .tab-btn:hover { color: var(--primary); }
        .tab-btn.active { color: var(--primary); }
        .tab-btn.active::after {
            content: ''; position: absolute; bottom: -2px; left: 0; width: 100%; height: 4px; border-radius: 4px 4px 0 0; background-color: var(--primary);
        }
        .tab-badge {
            display: inline-flex; align-items: center; justify-content: center; background-color: #e2e8f0; color: #475569;
            width: 24px; height: 24px; border-radius: 50%; font-size: 0.75rem; font-weight: 800; margin-left: 0.5rem;
        }
        .tab-btn.active .tab-badge { background-color: var(--primary); color: white;}

        /* Report Cards */
        .reports-grid { display: flex; flex-direction: column; gap: 1rem; }

        .report-card {
            background-color: var(--white); border-radius: 12px; padding: 1.5rem 2rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02); display: flex; gap: 2rem; align-items: flex-start;
            border-left: 4px solid transparent; transition: all 0.3s;
        }
        .report-card.s-menunggu { border-left-color: #f59e0b; }
        .report-card.s-proses { border-left-color: #3b82f6; }
        .report-card.s-selesai { border-left-color: #10b981; }
        .report-card.s-spam { border-left-color: #ef4444; opacity: 0.8; }
        
        .r-icon {
            width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem;
        }
        .r-icon.i-infra { background-color: #ffedd5; color: #ea580c; }
        .r-icon.i-layanan { background-color: #dbeafe; color: #2563eb; }
        .r-icon.i-bersih { background-color: #dcfce3; color: #166534; }
        .r-icon.i-aman { background-color: #fee2e2; color: #dc2626; }
        .r-icon.i-umum { background-color: #f1f5f9; color: #475569; }

        .r-content { flex-grow: 1; }
        .r-header { display: flex; justify-content: space-between; margin-bottom: 0.5rem; align-items: center; }
        .r-title { font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;}
        .r-date { font-size: 0.85rem; color: #94a3b8; font-weight: 500;}
        
        .r-meta { display: flex; gap: 1rem; margin-bottom: 1rem; font-size: 0.85rem; font-weight: 600; color: #64748b; flex-wrap: wrap; }
        .r-meta i { color: var(--primary); margin-right: 0.3rem;}
        
        .r-desc { font-size: 0.95rem; color: #334155; line-height: 1.6; margin-bottom: 1.5rem; background: #f8fafc; padding: 1rem; border-radius: 8px;}
        
        .r-actions { display: flex; justify-content: space-between; align-items: center; }
        .r-actions-inner { display: flex; gap: 1rem; align-items: center; width: 100%; justify-content: space-between; }
        
        .r-status { padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700; white-space: nowrap; display: inline-block; width: max-content; }
        .bg-menunggu { background-color: #fef3c7; color: #b45309; }
        .bg-proses { background-color: #dbeafe; color: #1d4ed8; }
        .bg-selesai { background-color: #dcfce3; color: #15803d; }
        .bg-spam { background-color: #fee2e2; color: #dc2626; }

        .badge-ahp {
            font-size: 0.75rem; padding: 4px 10px; border-radius: 12px; font-weight: 700;
            display: inline-flex; align-items: center; gap: 0.3rem; white-space: nowrap;
        }
        .badge-ahp.sangat-urgent { background: #ef4444; color: white; box-shadow: 0 2px 5px rgba(239,68,68,0.3); }
        .badge-ahp.urgent { background: #f97316; color: white; }
        .badge-ahp.normal { background: #3b82f6; color: white; }
        .badge-ahp.belum { background: #94a3b8; color: white; font-size: 0.7rem; font-weight: 600; padding: 3px 8px;}

        .btn-action {
            background-color: var(--primary); color: white; padding: 0.6rem 1.2rem; border-radius: 8px; text-decoration: none;
            font-size: 0.85rem; font-weight: 700; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer; border: none;
        }
        .btn-action:hover { background-color: var(--primary-hover); }
        .btn-process { background-color: #3b82f6; }
        .btn-process:hover { background-color: #2563eb; }
        .btn-finish { background-color: #10b981; }
        .btn-finish:hover { background-color: #059669; }

        .dropdown-menu {
            position: relative; display: inline-block;
        }
        .dropdown-content {
            display: none; position: absolute; right: 0; background-color: white; min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1); z-index: 1; border-radius: 8px; overflow: hidden;
            margin-top: 0.5rem;
        }
        .dropdown-menu.show .dropdown-content { display: block; }
        .dropdown-content a {
            color: #334155; padding: 12px 16px; text-decoration: none; display: flex; align-items: center; gap: 0.8rem; font-size:0.9rem; font-weight: 600;
        }
        .dropdown-content a:hover { background-color: #f1f5f9; color: var(--primary); }

        .empty-state {
            text-align: center; padding: 5rem 2rem; background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }
        .empty-state i { font-size: 4rem; color: #cbd5e1; margin-bottom: 1rem; }
        .empty-state h3 { font-size: 1.5rem; color: #475569; margin-bottom: 0.5rem; }
        .empty-state p { color: #94a3b8; }
    
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
            .header-title h2 { font-size: 1.25rem; }
            .header-title p { font-size: 0.8rem; }

            .report-card { flex-direction: column; gap: 1rem; padding: 1rem; }
            .r-icon { width: 40px; height: 40px; font-size: 1.2rem; flex-shrink: 0; }
            .r-body { width: 100%; overflow: hidden; }
            .r-header { flex-direction: column; align-items: flex-start; gap: 0.5rem; }
            .r-title { font-size: 1.05rem; word-break: break-word; }
            .r-meta { gap: 0.6rem; font-size: 0.8rem; flex-wrap: wrap; line-height: 1.5; margin-bottom: 1rem; }
            .r-meta span { display: inline-flex; align-items: center; gap: 0.3rem; }
            
            .r-actions-inner { flex-direction: column; align-items: flex-start; gap: 1rem; justify-content: flex-start; }
            .r-actions-inner > div { width: 100%; }
            .r-actions-inner .btn-action { flex: 1; justify-content: center; text-align: center; }
            .r-actions-inner > div:last-child { display: flex; width: 100%; gap: 0.5rem; flex-wrap: wrap; }
            
            .btn-action { font-size: 0.8rem; padding: 0.6rem 0.8rem; }
            .detail-grid { grid-template-columns: 1fr; gap: 0.5rem; }
            .tab-btn { padding: 0.7rem 0.9rem; font-size: 0.82rem; white-space: nowrap; }
        }
        @media (max-width: 480px) {
            .main-content { padding: 0.7rem; }
            .r-title { font-size: 0.95rem; }
        }

    
        /* Sidebar Scrollable */
        .sidebar-menu { overflow-y: auto; }
        .sidebar-menu::-webkit-scrollbar { width: 4px; }
        .sidebar-menu::-webkit-scrollbar-track { background: transparent; }
        .sidebar-menu::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        .sidebar-menu::-webkit-scrollbar-thumb:hover { background: #475569; }

        /* Modal Styles */
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15,23,42,0.6); z-index: 1000; backdrop-filter: blur(4px);
            align-items: center; justify-content: center;
        }
        .modal-overlay.active { display: flex; }
        .modal-container {
            background: white; border-radius: 12px; width: 90%; max-width: 600px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); overflow: hidden;
            animation: modalFadeIn 0.3s ease;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .modal-header {
            padding: 1.5rem 2rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;
            background-color: #f8fafc;
        }
        .modal-header h3 { color: #0f172a; margin: 0; font-size: 1.2rem; }
        .modal-close {
            background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer; transition: color 0.2s;
        }
        .modal-close:hover { color: #ef4444; }
        .modal-body { padding: 2rem; max-height: 70vh; overflow-y: auto; }
        .detail-group { margin-bottom: 1.5rem; }
        .detail-label { font-size: 0.8rem; color: #64748b; text-transform: uppercase; font-weight: 700; margin-bottom: 0.4rem; letter-spacing: 0.5px;}
        .detail-value { font-size: 1rem; color: #334155; font-weight: 500; }
        .detail-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem; }
        .detail-message { background: #f8fafc; padding: 1.5rem; border-radius: 8px; border-left: 4px solid var(--primary); font-style: italic; }

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
                <h2>Kotak Pengaduan Masyarakat</h2>
                <p>Modul pemantauan aspirasi dan tanggap cepat permasalahan desa</p>
            </div>
            </div>
        </div>

        @if(session('success'))
            <div style="background-color: #dcfce3; color: #166534; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; font-weight: 600; border-left: 5px solid #10b981;">
                <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div style="background-color: #fee2e2; color: #991b1b; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; font-weight: 600; border-left: 5px solid #ef4444;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size: 1.2rem;"></i> {{ session('error') }}
            </div>
        @endif

        <div class="tabs-nav">
            <button class="tab-btn active" onclick="filterReports('Menunggu Validasi', this)">
                Menunggu Validasi <span class="tab-badge" id="b-menunggu">0</span>
            </button>
            <button class="tab-btn" onclick="filterReports('Sedang Diproses', this)">
                Sedang Diproses <span class="tab-badge" id="b-proses">0</span>
            </button>
            <button class="tab-btn" onclick="filterReports('Selesai Ditangani', this)">
                Selesai Ditangani <span class="tab-badge" id="b-selesai">0</span>
            </button>
            <button class="tab-btn" onclick="filterReports('Spam', this)">
                Spam <span class="tab-badge" id="b-spam">0</span>
            </button>
        </div>

        <!-- RBAC Logic: Filter array based on role before rendering if using real DB -->

        <div class="reports-grid" id="reportsGrid">
            
            <!-- Real Dynamic Data mapped from Session Storage -->
            @foreach($pengaduan as $p)
                <div class="report-card @if($p['status']==='Spam') s-spam @else s-menunggu @endif" data-status="{{ $p['status'] }}">
                    <div class="r-icon i-umum"><i class="fa-solid fa-file-lines"></i></div>
                    <div class="r-content">
                        <div class="r-header">
                            <h3 class="r-title" style="display: flex; align-items: flex-start; flex-wrap: wrap; gap: 0.5rem;">
                                {{ $p['subjek'] }}
                                @if(isset($p['ahp_rank']))
                                    @if($p['ahp_rank'] === 1)
                                        <span class="badge-ahp sangat-urgent"><i class="fa-solid fa-fire"></i> Sangat Urgent</span>
                                    @elseif($p['ahp_rank'] <= 3)
                                        <span class="badge-ahp urgent"><i class="fa-solid fa-bolt"></i> Urgent (Rank #{{ $p['ahp_rank'] }})</span>
                                    @elseif($p['ahp_rank'] < 999)
                                        <span class="badge-ahp normal"><i class="fa-solid fa-list-ol"></i> Rank #{{ $p['ahp_rank'] }}</span>
                                    @else
                                        <span class="badge-ahp belum"><i class="fa-regular fa-clock"></i> Belum Dinilai</span>
                                    @endif
                                @endif
                            </h3>
                            <span class="r-date">{{ $p['tanggal'] }}</span>
                        </div>
                        <div class="r-meta">
                            <span><i class="fa-regular fa-user"></i> {{ $p['nama'] }}</span>
                            <span><i class="fa-solid fa-map-pin"></i> {{ $p['dusun'] }}</span>
                            <span><i class="fa-solid fa-tag"></i> {{ $p['kategori'] }}</span>
                            <span><i class="fa-solid fa-phone"></i> {{ $p['hp'] }}</span>
                        </div>
                        <div class="r-desc">
                            "{{ $p['pesan'] }}"
                        </div>
                        <div class="r-actions">
                            <span class="r-status bg-menunggu" style="display:none;"></span> <!-- Placeholder to keep structure -->
                            <div class="r-actions-inner">
                                <div>
                                    @if($p['status'] === 'Menunggu Validasi')
                                        <span class="r-status bg-menunggu">{{ $p['status'] }}</span>
                                    @elseif($p['status'] === 'Sedang Diproses')
                                        <span class="r-status bg-proses">{{ $p['status'] }}</span>
                                    @elseif($p['status'] === 'Spam')
                                        <span class="r-status bg-spam"><i class="fa-solid fa-ban"></i> {{ $p['status'] }}</span>
                                    @else
                                        <span class="r-status bg-selesai">{{ $p['status'] }}</span>
                                    @endif

                                    @if(isset($p['handled_by']) && $p['handled_by'])
                                        <div style="margin-top: 0.5rem; font-size: 0.75rem; color: #64748b; font-weight: 600;">
                                            <i class="fa-solid fa-user-check" style="color: #3b82f6;"></i> Ditangani oleh: <span style="color: #334155;">{{ $p['handled_by'] }}</span>
                                            @if($p['handled_by'] === $user)
                                                <span style="background: #dcfce3; color: #15803d; padding: 1px 6px; border-radius: 4px; margin-left: 4px; font-size: 0.65rem;">Anda</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div style="display: flex; gap: 0.5rem;">
                                    <button class="btn-action" style="background-color: #f8fafc; color: #475569; border: 1px solid #cbd5e1;" onclick="openModal('{{ $p['track_id'] }}')"><i class="fa-solid fa-eye"></i> Detail</button>
                                    
                                    @php
                                        $isLocked = isset($p['handled_by']) && $p['handled_by'] && $p['handled_by'] !== $user && $role !== 'Super Admin';
                                    @endphp

                                    @if($isLocked)
                                        <button class="btn-action" style="background-color: #e2e8f0; color: #94a3b8; cursor: not-allowed;" title="Laporan ini sedang ditangani oleh {{ $p['handled_by'] }}" disabled>
                                            <i class="fa-solid fa-lock"></i> Terkunci
                                        </button>
                                    @else
                                        @if($p['status'] === 'Menunggu Validasi')
                                            <div class="dropdown-menu">
                                                <button class="btn-action btn-process" onclick="toggleDropdown(this)"><i class="fa-solid fa-bolt"></i> Tindaklanjuti <i class="fa-solid fa-chevron-down"></i></button>
                                                <div class="dropdown-content">
                                                    <a href="/admin/ahp/assessment"><i class="fa-solid fa-scale-balanced"></i> Beri Penilaian AHP</a>
                                                    <div style="height: 1px; background-color: #e2e8f0; margin: 4px 0;"></div>
                                                    <a href="/pengaduan/{{ $p['id'] }}/status/Sedang Diproses"><i class="fa-solid fa-spinner"></i> Tandai Sedang Diproses</a>
                                                    <a href="/pengaduan/{{ $p['id'] }}/status/Selesai Ditangani"><i class="fa-solid fa-check-double"></i> Tandai Selesai</a>
                                                    <a href="/pengaduan/{{ $p['id'] }}/status/Spam" style="color: #dc2626;"><i class="fa-solid fa-ban"></i> Tandai Spam</a>
                                                </div>
                                            </div>
                                        @elseif($p['status'] === 'Sedang Diproses')
                                            <a href="/pengaduan/{{ $p['id'] }}/status/Selesai Ditangani" class="btn-action btn-finish"><i class="fa-solid fa-check-double"></i> Tandai Selesai</a>
                                        @elseif($p['status'] === 'Spam')
                                            <a href="/pengaduan/{{ $p['id'] }}/status/Menunggu Validasi" class="btn-action" style="background-color: #64748b;"><i class="fa-solid fa-rotate-left"></i> Pulihkan</a>
                                        @else
                                            <a href="#" class="btn-action" style="background-color: #64748b;"><i class="fa-regular fa-file-pdf"></i> Arsip</a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Detail for this Report -->
                <div class="modal-overlay" id="modal-{{ $p['track_id'] }}">
                    <div class="modal-container">
                        <div class="modal-header">
                            <h3><i class="fa-solid fa-circle-info" style="color:var(--primary); margin-right: 0.5rem;"></i> Detail Laporan</h3>
                            <button class="modal-close" onclick="closeModal('{{ $p['track_id'] }}')"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        <div class="modal-body">
                            <div class="detail-grid">
                                <div class="detail-group">
                                    <div class="detail-label">Track ID</div>
                                    <div class="detail-value" style="font-family: monospace; color: var(--primary); font-weight: 700;">{{ $p['track_id'] }}</div>
                                </div>
                                <div class="detail-group">
                                    <div class="detail-label">Tanggal Masuk</div>
                                    <div class="detail-value"><i class="fa-regular fa-calendar" style="color: #94a3b8; margin-right:5px;"></i> {{ $p['tanggal'] }}</div>
                                </div>
                                <div class="detail-group">
                                    <div class="detail-label">Pelapor</div>
                                    <div class="detail-value"><i class="fa-regular fa-user" style="color: #94a3b8; margin-right:5px;"></i> {{ $p['nama'] }}</div>
                                </div>
                                <div class="detail-group">
                                    <div class="detail-label">NIK Pelapor</div>
                                    <div class="detail-value"><i class="fa-regular fa-id-card" style="color: #94a3b8; margin-right:5px;"></i> {{ $p['nik'] ?? '-' }}</div>
                                </div>
                                <div class="detail-group">
                                    <div class="detail-label">Nomor HP</div>
                                    <div class="detail-value"><i class="fa-solid fa-phone" style="color: #94a3b8; margin-right:5px;"></i> {{ $p['hp'] }}</div>
                                </div>
                                <div class="detail-group">
                                    <div class="detail-label">Kategori</div>
                                    <div class="detail-value"><span style="background: #f1f5f9; padding: 4px 10px; border-radius: 6px; font-size: 0.85rem; font-weight: 700;">{{ $p['kategori'] }}</span></div>
                                </div>
                                <div class="detail-group">
                                    <div class="detail-label">Wilayah (Dusun)</div>
                                    <div class="detail-value"><i class="fa-solid fa-map-pin" style="color: #ef4444; margin-right:5px;"></i> {{ $p['dusun'] }}</div>
                                </div>
                            </div>
                            
                            <div class="detail-group">
                                <div class="detail-label">Subjek Laporan</div>
                                <div class="detail-value" style="font-size: 1.1rem; font-weight: 700; color: #0f172a;">{{ $p['subjek'] }}</div>
                            </div>

                            <div class="detail-group">
                                <div class="detail-label">Isi Pesan Laporan</div>
                                <div class="detail-message">
                                    "{{ $p['pesan'] }}"
                                </div>
                            </div>

                            @if(isset($p['foto']) && $p['foto'])
                            <div class="detail-group">
                                <div class="detail-label">Foto / Bukti Lampiran</div>
                                <div style="margin-top: 0.5rem;">
                                    <img src="{{ asset('storage/' . $p['foto']) }}" alt="Bukti Laporan" style="max-width: 100%; border-radius: 8px; border: 1px solid #e2e8f0; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                                </div>
                            </div>
                            @endif

                            <div class="detail-group" style="background: #f1f5f9; padding: 1rem; border-radius: 8px; border: 1px dashed #cbd5e1; margin-top: 1.5rem;">
                                <div class="detail-label" style="color: #475569;"><i class="fa-solid fa-shield-halved"></i> Log Forensik Sistem</div>
                                <div style="font-size: 0.85rem; color: #64748b; margin-top: 0.5rem;">
                                    <strong>IP Address:</strong> <span style="font-family: monospace;">{{ $p['ip_address'] ?? 'Tidak Tercatat' }}</span><br>
                                    <strong>Perangkat / Browser:</strong> <span>{{ $p['user_agent'] ?? 'Tidak Tercatat' }}</span>
                                </div>
                            </div>

                            <div class="detail-group" style="background: #fff7ed; padding: 1.5rem; border-radius: 8px; border: 1px solid #fed7aa; margin-top: 2rem;">
                                <div class="detail-label" style="color: #ea580c;"><i class="fa-solid fa-scale-balanced"></i> Analisis Sistem AHP</div>
                                <div class="detail-grid" style="margin-bottom: 0; margin-top: 1rem;">
                                    <div>
                                        <span style="font-size: 0.8rem; color: #9a3412; display:block;">Skor Prioritas</span>
                                        <span style="font-size: 1.5rem; font-weight: 800; color: #c2410c;">{{ number_format($p['ahp_score'] ?? 0, 4) }}</span>
                                    </div>
                                    <div>
                                        <span style="font-size: 0.8rem; color: #9a3412; display:block;">Peringkat (Rank)</span>
                                        <span style="font-size: 1.5rem; font-weight: 800; color: #c2410c;">
                                            @if(($p['ahp_rank'] ?? 999) < 999)
                                                #{{ $p['ahp_rank'] }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Dummy Data 1 -->
            <div class="report-card s-menunggu" data-status="Menunggu Validasi">
                <div class="r-icon i-infra"><i class="fa-solid fa-road-barrier"></i></div>
                <div class="r-content">
                    <div class="r-header">
                        <h3 class="r-title">Lampu Jalan Padam di Pertigaan Balai</h3>
                        <span class="r-date">12 Mar 2026</span>
                    </div>
                    <div class="r-meta">
                        <span><i class="fa-regular fa-user"></i> Budi Santoso</span>
                        <span><i class="fa-solid fa-map-pin"></i> Dusun Mlideg</span>
                        <span><i class="fa-solid fa-tag"></i> Infrastruktur</span>
                    </div>
                    <div class="r-desc">
                        "Sudah 3 hari ini lampu jalan PJU utama di pertigaan dekat balai desa mati total pak. Kalau malam sangat gelap dan berbahaya untuk pengguna motor, mohon segera ditangani."
                    </div>
                    <div class="r-actions">
                        <span class="r-status bg-menunggu" style="display:none;"></span>
                        <div class="r-actions-inner">
                            <div>
                                <span class="r-status bg-menunggu">Menunggu Validasi</span>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <div class="dropdown-menu">
                                    <button class="btn-action btn-process" onclick="toggleDropdown(this)"><i class="fa-solid fa-bolt"></i> Tindaklanjuti <i class="fa-solid fa-chevron-down"></i></button>
                                    <div class="dropdown-content">
                                        <!-- using # for static dummy -->
                                        <a href="#" onclick="alert('Ini adalah purwarupa data dummy. Pada laporan aslu, status akan terganti.')"><i class="fa-solid fa-spinner"></i> Tandai Sedang Diproses</a>
                                        <a href="#" onclick="alert('Ini adalah purwarupa data dummy. Pada laporan aslu, status akan terganti.')"><i class="fa-solid fa-check-double"></i> Tandai Selesai</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Dummy Data 2 -->
            <div class="report-card s-selesai" data-status="Selesai Ditangani">
                <div class="r-icon i-bersih"><i class="fa-solid fa-leaf"></i></div>
                <div class="r-content">
                    <div class="r-header">
                        <h3 class="r-title">Timbunan Sampah di Bantaran Sungai</h3>
                        <span class="r-date">05 Mar 2026</span>
                    </div>
                    <div class="r-meta">
                        <span><i class="fa-regular fa-user"></i> Siti Aminah</span>
                        <span><i class="fa-solid fa-map-pin"></i> Dusun Ngrapah</span>
                        <span><i class="fa-solid fa-tag"></i> Lingkungan</span>
                    </div>
                    <div class="r-desc">
                        "Ada warga luar yang membuang sampah sembarangan di sungai dekat RT 02. Baunya menyengat. Mohon diadakan kerjabakti."
                    </div>
                    <div class="r-actions">
                        <span class="r-status bg-selesai" style="display:none;"></span>
                        <div class="r-actions-inner">
                            <div>
                                <span class="r-status bg-selesai">Selesai Ditangani</span>
                            </div>
                            <div style="display: flex; gap: 0.5rem;">
                                <a href="#" class="btn-action" style="background-color: #64748b;"><i class="fa-regular fa-file-pdf"></i> Arsip</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(count($pengaduan) === 0)
             <div class="empty-state">
                <i class="fa-regular fa-folder-open"></i>
                <h3>Belum Ada Laporan</h3>
                <p>Tidak ada pengaduan terbaru dari sistem hari ini.</p>
            </div>
            @endif

            <div class="empty-state" id="emptyState" style="display: none;">
                <i class="fa-regular fa-folder-open"></i>
                <h3>Belum Ada Laporan</h3>
                <p>Tidak ada pengaduan pada status ini.</p>
            </div>

        </div>

    </main>

    <script>
        // Modal logic
        function openModal(trackId) {
            document.getElementById('modal-' + trackId).classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevent scrolling
        }

        function closeModal(trackId) {
            document.getElementById('modal-' + trackId).classList.remove('active');
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal-overlay')) {
                event.target.classList.remove('active');
                document.body.style.overflow = 'auto';
            }
        });

        // Tabs filtering logic
        function filterReports(status, btnElement) {
            // Update active button
            const buttons = document.querySelectorAll('.tab-btn');
            buttons.forEach(btn => btn.classList.remove('active'));
            btnElement.classList.add('active');

            // Filter cards
            const cards = document.querySelectorAll('.report-card');
            cards.forEach(card => {
                if (card.getAttribute('data-status') === status) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Dropdown toggle logic
        function toggleDropdown(btn) {
            // Close all other dropdowns
            const allDropdowns = document.querySelectorAll('.dropdown-content');
            allDropdowns.forEach(dropdown => {
                if (dropdown !== btn.nextElementSibling) {
                    dropdown.parentElement.classList.remove('show');
                }
            });

            const dropdownContainer = btn.parentElement;
            dropdownContainer.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        window.onclick = function(event) {
            if (!event.target.matches('.btn-process') && !event.target.parentElement.matches('.btn-process')) {
                var dropdowns = document.getElementsByClassName("dropdown-menu");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }

        // Filtering Logic
        function filterReports(status, btnElement) {
            // Update active tab buttons
            if (btnElement) {
                document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
                btnElement.classList.add('active');
            }

            const cards = document.querySelectorAll('.report-card');
            let visibleCount = 0;

            cards.forEach(card => {
                if (card.dataset.status === status) {
                    card.style.display = "flex";
                    visibleCount++;
                } else {
                    card.style.display = "none";
                }
            });

            // Toggle empty state if no reports found in this tab
            const emptyState = document.getElementById('emptyState');
            if (visibleCount === 0) {
                emptyState.style.display = "block";
            } else {
                emptyState.style.display = "none";
            }
        }

        // Update Badges & Initial Load
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.report-card');
            let cMenunggu = 0, cProses = 0, cSelesai = 0, cSpam = 0;
            
            cards.forEach(card => {
                if (card.dataset.status === 'Menunggu Validasi') cMenunggu++;
                else if (card.dataset.status === 'Sedang Diproses') cProses++;
                else if (card.dataset.status === 'Selesai Ditangani') cSelesai++;
                else if (card.dataset.status === 'Spam') cSpam++;
            });

            document.getElementById('b-menunggu').innerText = cMenunggu;
            document.getElementById('b-proses').innerText = cProses;
            document.getElementById('b-selesai').innerText = cSelesai;
            document.getElementById('b-spam').innerText = cSpam;

            // Trigger click on first tab to apply filter visually
            const firstTab = document.querySelector('.tab-btn');
            filterReports('Menunggu Validasi', firstTab);
        });
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

