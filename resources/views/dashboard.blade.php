<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - DESA MLIDEG</title>
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
        .header-title p { color: #64748b; font-size: 0.95rem; font-weight: 500; margin-top: 0.2rem;}
        
        .btn-logout {
            background-color: #ef4444; color: white; text-decoration: none; padding: 0.6rem 1.2rem;
            border-radius: 8px; font-weight: 700; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem;
            transition: background 0.3s;
        }
        .btn-logout:hover { background-color: #dc2626; }

        /* Role Alert */
        .role-alert {
            background-color: #e0f2fe; border-left: 4px solid #0ea5e9; padding: 1.2rem 1.5rem;
            border-radius: 0 8px 8px 0; display: flex; align-items: flex-start; gap: 1rem; margin-bottom: 2rem;
        }
        .role-alert i { color: #0ea5e9; font-size: 1.5rem; margin-top: 0.2rem;}
        .role-alert-text h4 { color: #0369a1; margin-bottom: 0.3rem; font-size: 1.1rem; font-weight: 800;}
        .role-alert-text p { color: #0c4a6e; font-size: 0.95rem; line-height: 1.5; font-weight: 500;}

        /* Privilege Badges */
        .privilege-tags { display: flex; gap: 0.5rem; margin-top: 0.8rem; flex-wrap: wrap; }
        .tag { padding: 0.3rem 0.8rem; background-color: #bae6fd; color: #0369a1; border-radius: 20px; font-size: 0.75rem; font-weight: 700; }
        .tag-super { background-color: #fca5a5; color: #991b1b; }

        /* Dashboard Cards */
        .dash-cards {
            display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem;
        }
        @media (max-width: 992px) {
            .dash-cards { grid-template-columns: repeat(2, 1fr); }
        }
        .card {
            background-color: var(--white); border-radius: 16px; padding: 1.5rem; display: flex; align-items: center; gap: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02);
        }
        .card-icon { width: 60px; height: 60px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.8rem; }
        .c-blue { background-color: #e0f2fe; color: #0ea5e9; }
        .c-orange { background-color: #ffedd5; color: #f97316; }
        .c-green { background-color: #dcfce3; color: #22c55e; }
        .card-info h3 { font-size: 2rem; font-weight: 900; color: var(--text-dark); line-height: 1.1;}
        .card-info p { color: #64748b; font-size: 0.85rem; font-weight: 600; text-transform: uppercase;}

        /* Table Area */
        .table-section { background-color: var(--white); border-radius: 16px; padding: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.02); }
        .table-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
        .table-header h3 { font-size: 1.2rem; font-weight: 800; color: var(--text-dark); }
        .table-scroll-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .data-table { width: 100%; min-width: 800px; border-collapse: collapse; }
        .data-table th { text-align: left; padding: 0.8rem 1rem; background-color: #f8fafc; color: #475569; font-weight: 700; font-size: 0.85rem; border-bottom: 2px solid #e2e8f0; white-space: nowrap; }
        .data-table td { padding: 0.8rem 1rem; border-bottom: 1px solid #e2e8f0; font-size: 0.9rem; color: #334155; font-weight: 500;}
        .status { padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; font-weight: 700; white-space: nowrap; display: inline-block; }
        .s-pending { background-color: #fef3c7; color: #d97706; }
    
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
            
            .dash-cards { grid-template-columns: 1fr; gap: 0.8rem; }
            .header { flex-direction: row; align-items: center; justify-content: space-between; gap: 0.5rem; flex-wrap: wrap; margin-bottom: 1rem; }
            .header-title-wrapper { flex: 1; min-width: 0; }
            .header-title h2 { font-size: 1.3rem; }
            .header-title p { font-size: 0.8rem; }
            .btn-logout { font-size: 0.8rem; padding: 0.5rem 0.8rem; white-space: nowrap; }
            .btn-logout i { margin: 0; }

            .role-alert { flex-direction: column; gap: 0.8rem; padding: 1rem; }
            .role-alert-text p { font-size: 0.85rem; word-break: break-word; }
            .privilege-tags { flex-wrap: wrap; gap: 0.4rem; }
            .tag { font-size: 0.7rem; padding: 0.2rem 0.6rem; }

            .table-section { padding: 1rem; }
            .table-header h3 { font-size: 1rem; }
        }
        @media (max-width: 480px) {
            .main-content { padding: 0.7rem; }
            .card { padding: 0.9rem; gap: 0.8rem; }
            .card-icon { width: 44px; height: 44px; font-size: 1.3rem; }
            .card-info h3 { font-size: 1.5rem; }
            .card-info p { font-size: 0.75rem; }
            .header-title h2 { font-size: 1.15rem; }
            /* Show only icon on logout button */
            .btn-logout span { display: none; }
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
    @php 
        $p_surat = \App\Models\Surat::where('status', 'Menunggu Validasi')->count();
        $p_adu = \App\Models\Pengaduan::where('status', 'Menunggu Validasi')->count();
        $role = session('role') ?? 'Admin';
        $user = session('user') ?? 'User';
    @endphp
    @include('partials.sidebar')

    <!-- Main Content -->
    <main class="main-content">
        <div class="header">
            <div class="header-title-wrapper">
                <button id="sidebarToggle" class="btn-toggle-sidebar"><i class="fa-solid fa-bars"></i></button>
                <div class="header-title">
                <h2>Dashboard Overview</h2>
                <p>Selamat datang kembali, {{ $user }}!</p>
            </div>
            </div>
            <a href="/logout" class="btn-logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar</a>
        </div>

        <!-- RBAC Alert Message based on user request -->
        <div class="role-alert">
            <i class="fa-solid fa-circle-info"></i>
            <div class="role-alert-text">
                <h4>Status Otoritas: {{ $role }}</h4>
                @if($role === 'Super Admin')
                    <p>Anda login sebagai Sekretaris Desa (Admin Utama). Anda memiliki hak akses penuh untuk memantau semua dusun secara terpusat dan mengatur bobot kriteria AHP.</p>
                    <div class="privilege-tags">
                        <span class="tag tag-super">Akses Penuh Semua Dusun</span>
                        <span class="tag tag-super">Pengaturan AHP</span>
                        <span class="tag tag-super">Kelola Data Terpusat</span>
                    </div>
                @else
                    <p>Anda login sebagai {{ $user }}. Anda memiliki hak akses untuk mengelola dan merespon laporan/pengaduan dari seluruh wilayah desa guna mempercepat penanganan.</p>
                    <div class="privilege-tags">
                        <span class="tag">Akses Penuh Seluruh Dusun</span>
                        <span class="tag">Validasi Laporan Desa</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Dashboard Widgets -->
        <div class="dash-cards">
            @if($role === 'Super Admin')
                <div class="card">
                    <div class="card-icon c-blue"><i class="fa-solid fa-users"></i></div>
                    <div class="card-info">
                        <h3>{{ $totalPenduduk }}</h3>
                        <p>Total Penduduk (Semua)</p>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-icon c-blue"><i class="fa-solid fa-users"></i></div>
                    <div class="card-info">
                        <h3>{{ $pendudukDusun }}</h3>
                        <p>Penduduk Dusun {{ substr($role, -1) }}</p>
                    </div>
                </div>
            @endif
            
            <div class="card">
                <div class="card-icon c-orange"><i class="fa-solid fa-bullhorn"></i></div>
                <div class="card-info">
                    <h3>{{ $p_adu }}</h3>
                    <p>Pengaduan Menunggu</p>
                </div>
            </div>
            <div class="card">
                <div class="card-icon c-green"><i class="fa-solid fa-envelope-open-text"></i></div>
                <div class="card-info">
                    <h3>{{ $suratAktif }}</h3>
                    <p>Permintaan Surat Aktif</p>
                </div>
            </div>
        </div>

        <!-- Latest Reports Table -->
        <div class="table-section">
            <div class="table-header">
                <h3>Laporan Pengaduan Terbaru</h3>
            </div>
            <div class="table-scroll-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Pelapor</th>
                        <th>Kategori</th>
                        <th>Subjek Laporan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $pengaduan = \App\Models\Pengaduan::all()->toArray();
                        
                        $ahpRanking = \App\Models\ReportPriority::all()->toArray();
                        
                        // Mapping rank ke data
                        foreach($pengaduan as &$p) {
                            $p['ahp_rank'] = 999;
                            foreach($ahpRanking as $r) {
                                if ($r['report_id'] === $p['track_id']) {
                                    $p['ahp_rank'] = $r['priority_rank'] ?: 999;
                                    break;
                                }
                            }
                        }
                        
                        // Sortir berdasarkan rank tertinggi (1) lalu ID (terbaru)
                        usort($pengaduan, function($a, $b) {
                            if ($a['ahp_rank'] === $b['ahp_rank']) {
                                return $b['id'] <=> $a['id'];
                            }
                            return $a['ahp_rank'] <=> $b['ahp_rank'];
                        });
                        
                        $count = 0;
                    @endphp
                    
                    @forelse ($pengaduan as $p)
                        @php $count++; @endphp
                            @if($count <= 5)
                            <tr>
                                <td>{{ $p['tanggal'] }}</td>
                                <td>
                                    {{ $p['nama'] }}
                                    @if(isset($p['ahp_rank']) && $p['ahp_rank'] === 1)
                                        <br><span style="font-size: 0.65rem; background: #ef4444; color: white; padding: 2px 6px; border-radius: 10px; font-weight: 700;">Top Urgent</span>
                                    @endif
                                </td>
                                <td>{{ $p['kategori'] }}</td>
                                <td>{{ $p['subjek'] }}</td>
                                <td>
                                    @if($p['status'] === 'Menunggu Validasi')
                                        <span class="status s-pending">{{ $p['status'] }}</span>
                                    @elseif($p['status'] === 'Sedang Diproses')
                                        <span class="status s-pending" style="background-color: #dbeafe; color: #1d4ed8;">{{ $p['status'] }}</span>
                                    @else
                                        <span class="status s-pending" style="background-color: #dcfce3; color: #15803d;">{{ $p['status'] }}</span>
                                    @endif
                                </td>
                                <td><a href="/pengaduan" style="color:var(--primary); text-decoration:none; font-weight:bold;">Tinjau</a></td>
                            </tr>
                            @endif
                    @empty
                        <tr>
                            <td colspan="6" class="text-center" style="padding: 2rem;">Belum ada laporan pengaduan terbaru.</td>
                        </tr>
                    @endforelse
                    
                </tbody>
            </table>
            </div>{{-- end table-scroll-wrapper --}}
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
