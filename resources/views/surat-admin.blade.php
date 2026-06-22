<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengajuan Surat - DESA MLIDEG</title>
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
        
        .r-icon {
            width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; background-color: #ffedd5; color: #ea580c; 
        }

        .r-content { flex-grow: 1; }
        .r-header { display: flex; justify-content: space-between; margin-bottom: 0.5rem; align-items: center; }
        .r-title { font-size: 1.15rem; font-weight: 800; color: #0f172a; margin: 0;}
        .r-date { font-size: 0.85rem; color: #94a3b8; font-weight: 500;}
        
        .r-meta { display: flex; gap: 1rem; margin-bottom: 1rem; font-size: 0.85rem; font-weight: 600; color: #64748b; flex-wrap: wrap; }
        .r-meta i { color: var(--primary); margin-right: 0.3rem;}
        
        .r-desc { font-size: 0.95rem; color: #334155; line-height: 1.6; margin-bottom: 1.5rem; background: #f8fafc; padding: 1rem; border-radius: 8px;}
        
        .r-actions { display: flex; justify-content: space-between; align-items: center; }
        
        .r-status { padding: 0.4rem 1rem; border-radius: 20px; font-size: 0.8rem; font-weight: 700; }
        .bg-menunggu { background-color: #fef3c7; color: #b45309; }
        .bg-proses { background-color: #dbeafe; color: #1d4ed8; }
        .bg-selesai { background-color: #dcfce3; color: #15803d; }

        .btn-action {
            background-color: var(--primary); color: white; padding: 0.6rem 1.2rem; border-radius: 8px; text-decoration: none;
            font-size: 0.85rem; font-weight: 700; transition: all 0.2s; display: inline-flex; align-items: center; gap: 0.5rem; cursor: pointer; border: none;
        }
        .btn-action:hover { background-color: var(--primary-hover); }
        .btn-process { background-color: #3b82f6; }
        .btn-process:hover { background-color: #2563eb; }
        .btn-finish { background-color: #10b981; }
        .btn-finish:hover { background-color: #059669; }

        /* Upload form inline */
        .upload-form-inline {
            display: flex; gap: 1rem; align-items: center;
        }
        .form-control-file {
            padding: 0.4rem; border: 1px solid #cbd5e1; border-radius: 6px; font-size: 0.85rem;
        }

        .empty-state {
            text-align: center; padding: 5rem 2rem; background: white; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }
        .empty-state i { font-size: 4rem; color: #cbd5e1; margin-bottom: 1rem; }
        .empty-state h3 { font-size: 1.5rem; color: #475569; margin-bottom: 0.5rem; }
        .empty-state p { color: #94a3b8; }
    
        /* Sidebar */
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
        .header-title-wrapper { display: flex; align-items: center; }

        .sidebar-overlay {
            display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(15,23,42,0.6); z-index: 999; backdrop-filter: blur(2px);
        }
        .sidebar-overlay.show { display: block; }
        .sidebar-menu { overflow-y: auto; }
        .sidebar-menu::-webkit-scrollbar { width: 4px; }
        .sidebar-menu::-webkit-scrollbar-track { background: transparent; }
        .sidebar-menu::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        .sidebar-menu::-webkit-scrollbar-thumb:hover { background: #475569; }

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
            .r-header { flex-direction: column; align-items: flex-start; gap: 0.3rem; }
            .r-title { font-size: 1rem; word-break: break-word; }
            .r-meta { gap: 0.4rem; font-size: 0.78rem; flex-wrap: wrap; }
            .r-actions { flex-direction: column; align-items: stretch; gap: 0.8rem; }
            .r-actions > div { flex-wrap: wrap; width: 100%; gap: 0.5rem; }
            .btn-action { font-size: 0.8rem; padding: 0.45rem 0.8rem; }
            .tab-btn { padding: 0.7rem 0.9rem; font-size: 0.82rem; white-space: nowrap; }
            .upload-form-inline { flex-direction: column; align-items: stretch; }
        }
        @media (max-width: 480px) {
            .main-content { padding: 0.7rem; }
            .btn-action { font-size: 0.75rem; padding: 0.4rem 0.7rem; }
        }

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
                <h2>Kelola Layanan Surat</h2>
                <p>Modul pemrosesan dokumen dan permohonan surat administrasi warga desa</p>
            </div>
            </div>
        </div>

        @if(session('success'))
            <div style="background-color: #dcfce3; color: #166534; padding: 1rem 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem; font-weight: 600;">
                <i class="fa-solid fa-circle-check" style="font-size: 1.2rem;"></i> {{ session('success') }}
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
        </div>

        <div class="reports-grid" id="reportsGrid">
            
            @foreach($surat as $s)
                <div class="report-card @if($s['status']==='Menunggu Validasi') s-menunggu @elseif($s['status']==='Sedang Diproses') s-proses @else s-selesai @endif" data-status="{{ $s['status'] }}">
                    <div class="r-icon"><i class="fa-solid fa-envelope"></i></div>
                    <div class="r-content">
                        <div class="r-header">
                            <h3 class="r-title">{{ $s['jenis'] }}  <span style="font-size: 0.8rem; background: #e2e8f0; padding: 0.2rem 0.5rem; border-radius: 4px; margin-left: 0.5rem;">{{ $s['track_id'] }}</span></h3>
                            <span class="r-date">{{ $s['tanggal'] }}</span>
                        </div>
                        <div class="r-meta">
                            <span><i class="fa-regular fa-user"></i> {{ $s['nama'] }}</span>
                            <span><i class="fa-solid fa-address-card"></i> NIK: {{ $s['nik'] }}</span>
                        </div>
                        <div class="r-desc">
                            <strong>Keperluan:</strong> {{ $s['keperluan'] }}
                        </div>
                        <div class="r-actions">
                            <div style="display: flex; gap: 1rem; align-items: center;">
                                @if($s['status'] === 'Menunggu Validasi')
                                    <span class="r-status bg-menunggu">{{ $s['status'] }}</span>
                                    <a href="/admin/surat/{{ $s['id'] }}/status/Sedang Diproses" class="btn-action btn-process"><i class="fa-solid fa-spinner"></i> Proses Surat</a>
                                @elseif($s['status'] === 'Sedang Diproses')
                                    <span class="r-status bg-proses">{{ $s['status'] }}</span>
                                    <a href="/admin/surat/{{ $s['id'] }}/status/Selesai Ditangani" class="btn-action btn-finish"><i class="fa-solid fa-check-double"></i> Tandai Selesai</a>
                                @else
                                    <span class="r-status bg-selesai">{{ $s['status'] }}</span>
                                @endif
                            </div>
                            
                            @if(isset($s['dokumen_pendukung']) && $s['dokumen_pendukung'])
                                <a href="{{ asset('storage/' . $s['dokumen_pendukung']) }}" target="_blank" class="btn-action" style="background-color: #64748b;"><i class="fa-solid fa-file-invoice"></i> Lihat Lampiran</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="empty-state" id="emptyState" style="display: none;">
                <i class="fa-regular fa-folder-open"></i>
                <h3>Belum Ada Pengajuan Surat</h3>
                <p>Tidak ada permohonan surat pada status ini.</p>
            </div>

        </div>

    </main>

    <script>
        function filterReports(status, btnElement) {
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

            const emptyState = document.getElementById('emptyState');
            if (visibleCount === 0) {
                emptyState.style.display = "block";
            } else {
                emptyState.style.display = "none";
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.report-card');
            let cMenunggu = 0, cProses = 0, cSelesai = 0;
            
            cards.forEach(card => {
                if (card.dataset.status === 'Menunggu Validasi') cMenunggu++;
                else if (card.dataset.status === 'Sedang Diproses') cProses++;
                else if (card.dataset.status === 'Selesai Ditangani') cSelesai++;
            });

            document.getElementById('b-menunggu').innerText = cMenunggu;
            document.getElementById('b-proses').innerText = cProses;
            document.getElementById('b-selesai').innerText = cSelesai;

            const firstTab = document.querySelector('.tab-btn');
            filterReports('Menunggu Validasi', firstTab);
        });

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
            }
        });
    </script>
</body>
</html>

