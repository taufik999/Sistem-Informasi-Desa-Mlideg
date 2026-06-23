<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struktur Organisasi - DESA MLIDEG</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #f97316;
            --primary-hover: #ea580c;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --white: #ffffff;
            --bg-light: #f8fafc;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Montserrat', sans-serif; }
        body { background-color: var(--bg-light); color: var(--text-dark); display: flex; flex-direction: column; min-height: 100vh; }
        
        /* Navbar (Mirrored) */
        .navbar { display: flex; justify-content: space-between; align-items: center; padding: 1rem 4rem; background-color: var(--white); box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: fixed; width: 100%; top: 0; z-index: 50; }
        .nav-brand { display: flex; align-items: center; gap: 1rem; cursor: pointer; text-decoration: none; }
        .brand-icon { background-color: var(--primary); color: var(--white); width: 44px; height: 44px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
        .brand-text { display: flex; flex-direction: column; }
        .brand-title { font-weight: 800; font-size: 1.3rem; line-height: 1.1; color: #1e293b; letter-spacing: 0.5px; }
        .brand-subtitle { font-size: 0.7rem; color: #94a3b8; font-weight: 600; letter-spacing: 1.5px; margin-top: 2px; }
        
        .nav-links { display: flex; gap: 2.2rem; list-style: none; }
        .nav-links li a { text-decoration: none; color: #64748b; font-weight: 700; font-size: 0.95rem; transition: color 0.3s; position: relative; padding-bottom: 0.5rem; }
        .nav-links li a:hover, .nav-links li.active a { color: var(--primary); }
        .nav-links li.active a::after { content: ''; position: absolute; bottom: -5px; left: 0; width: 100%; height: 3px; background-color: var(--primary); border-radius: 2px; }

        .nav-actions { display: flex; align-items: center; gap: 1rem; }
        .btn-lapor { background-color: var(--primary); color: var(--white); border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; text-decoration: none; }
        .btn-lapor:hover { background-color: var(--primary-hover); transform: translateY(-2px); }
        .btn-grid { background-color: #f1f5f9; border: none; width: 44px; height: 44px; border-radius: 8px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #64748b; font-size: 1.2rem; transition: all 0.3s; }
        .btn-grid:hover { background-color: #e2e8f0; color: var(--text-dark); }

        /* Header Section */
        .detail-header { margin-top: 0; background-color: #0f172a; padding: 4rem 2rem; text-align: center; color: var(--white); }
        .detail-header-title { font-size: 2.5rem; font-weight: 900; letter-spacing: 1px; margin-bottom: 1rem; }
        .breadcrumb { display: flex; align-items: center; justify-content: center; gap: 0.5rem; color: #94a3b8; font-size: 0.9rem; font-weight: 600; }
        .breadcrumb a, .breadcrumb span { color: var(--primary); text-decoration: none; white-space: nowrap; }
        .breadcrumb span { color: #94a3b8; }
        @media (max-width: 576px) {
            .breadcrumb { font-size: 0.75rem; gap: 0.3rem; }
        }

        /* Organization Chart Styles */
        .org-container { padding: 5rem 2rem; flex-grow: 1; max-width: 100%; margin: 0 auto; width: 100%; overflow-x: auto; }
        
        .org-tree { display: inline-flex; flex-direction: column; align-items: center; gap: 2rem; position: relative; padding: 2rem; width: max-content; min-width: 100%; margin: 0 auto; }
        
        /* Node Card */
        .org-node {
            background: white; border-radius: 12px; padding: 1.5rem; box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            width: 260px; position: relative; z-index: 10; border-top: 5px solid var(--primary); transition: transform 0.3s; cursor: pointer;
        }
        .org-node:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.1); }
        .org-node.kades { border-color: #dc2626; background: #fef2f2; }
        .org-node.sekdes { border-color: #ea580c; background: #fff7ed; }
        .org-node.bpd { border-color: #475569; background: #f8fafc; }
        
        .node-avatar { width: 70px; height: 70px; background: #e2e8f0; border-radius: 50%; margin: 0 auto 1rem auto; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: #94a3b8; border: 3px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .node-name { font-weight: 800; font-size: 1.1rem; color: #0f172a; margin-bottom: 0.3rem; }
        .node-role { font-size: 0.85rem; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 1px; }

        /* Tree Lines using Flex and Borders */
        .level { display: flex; justify-content: center; gap: 3rem; position: relative; }
        .level::before { content: ''; position: absolute; top: -2rem; left: 50%; width: 2px; height: 2rem; background: #cbd5e1; transform: translateX(-50%); }
        .level.top-level::before { display: none; }
        
        /* Fork line for siblings */
        .siblings-fork { position: absolute; top: -2rem; left: 130px; right: 130px; height: 2px; background: #cbd5e1; }
        
        .line-down { width: 2px; height: 2rem; background: #cbd5e1; margin: 0 auto; }

        /* Layout specific adjustments */
        .bpd-container { position: absolute; left: 0; top: 0; width: 100%; pointer-events: none; }
        .bpd-container .org-node { pointer-events: auto; }
        .bpd-line { position: absolute; top: 50px; left: 260px; width: calc(50% - 260px); height: 2px; border-top: 2px dashed #cbd5e1; }

        .btn-surat { background-color: var(--primary); color: white; border: none; padding: 0.65rem 1.4rem; border-radius: 8px; font-weight: 700; font-size: 1rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; transition: all 0.3s ease; box-shadow: 0 4px 10px rgba(249, 115, 22, 0.2); text-decoration: none; }
        .btn-surat:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(249, 115, 22, 0.3); background-color: var(--primary-hover); }

        .simple-footer { background-color: #0f172a; padding: 2.5rem 0; text-align: center; display: flex; justify-content: center; align-items: center; margin-top: auto; }
        .footer-brand { display: flex; align-items: center; gap: 0.8rem; }
        .footer-brand i { color: var(--primary); font-size: 1.4rem; }
        .footer-brand span { color: var(--white); font-weight: 700; font-size: 1.2rem; letter-spacing: 0.5px; }

        /* Mobile Menu */
        .hamburger-btn {
            display: none;
            background: #f1f5f9;
            border: none;
            width: 44px;
            height: 44px;
            border-radius: 8px;
            cursor: pointer;
            color: #64748b;
            font-size: 1.2rem;
            transition: all 0.3s;
        }
        .hamburger-btn:hover { background: #e2e8f0; color: var(--text-dark); }

        .mobile-menu-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(15, 23, 42, 0.98); z-index: 1000;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            opacity: 0; visibility: hidden; transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .mobile-menu-overlay.active { opacity: 1; visibility: visible; }
        
        .close-menu { position: absolute; top: 1.5rem; right: 1.5rem; background: transparent; border: none; color: white; font-size: 2rem; cursor: pointer; }
        .mobile-brand { display: flex; align-items: center; gap: 1rem; color: white; margin-bottom: 3rem; }
        .mobile-brand i { color: var(--primary); font-size: 2rem; }
        .mobile-brand span { font-weight: 800; font-size: 1.5rem; letter-spacing: 1px; }

        .mobile-nav-links { list-style: none; text-align: center; }
        .mobile-nav-links li { margin-bottom: 1.5rem; }
        .mobile-nav-links li a { color: #94a3b8; text-decoration: none; font-size: 1.2rem; font-weight: 700; transition: color 0.3s; }
        .mobile-nav-links li a:hover { color: var(--primary); }
        .mobile-btn-lapor { background-color: var(--primary); color: white !important; padding: 0.8rem 2rem; border-radius: 10px; display: inline-block; margin-bottom: 0.5rem; }
        .mobile-btn-surat { background-color: #334155; color: white !important; padding: 0.8rem 2rem; border-radius: 10px; display: inline-block; }

        @media (max-width: 1200px) {
            .nav-links { gap: 1.5rem; }
            .navbar { padding: 1rem 2rem; }
        }

        @media (max-width: 992px) {
            .nav-links { display: none; }
            .navbar { padding: 1rem 1.5rem; }
            .nav-actions .btn-lapor, .nav-actions .btn-surat { display: none; }
            .hamburger-btn { display: flex; align-items: center; justify-content: center; }
            .detail-header { padding: 3rem 1rem; }
            .detail-header-title { font-size: 2rem; }
            
            /* Give some space on mobile if tree is wide */
            .org-tree { padding: 2rem 1rem; }
        }

        /* Modal Styles */
        .modal-overlay {
            display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15,23,42,0.6); z-index: 1000; backdrop-filter: blur(4px);
            align-items: center; justify-content: center;
        }
        .modal-overlay.active { display: flex; }
        .modal-container {
            background: white; border-radius: 12px; width: 90%; max-width: 450px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1); overflow: hidden;
            animation: modalFadeIn 0.3s ease;
        }
        @keyframes modalFadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .modal-header {
            padding: 1.2rem 1.5rem; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; background-color: #f8fafc;
        }
        .modal-header h3 { color: #0f172a; margin: 0; font-size: 1.1rem; }
        .modal-close { background: none; border: none; font-size: 1.5rem; color: #64748b; cursor: pointer; transition: color 0.2s; }
        .modal-close:hover { color: #ef4444; }
        .modal-body { padding: 2rem; text-align: center; }
        .modal-avatar { width: 90px; height: 90px; background: #e2e8f0; border-radius: 50%; margin: 0 auto 1.5rem auto; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; color: #94a3b8; border: 4px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .modal-name { font-weight: 900; font-size: 1.4rem; color: #0f172a; margin-bottom: 0.3rem; }
        .modal-role { font-size: 0.9rem; font-weight: 700; color: var(--primary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.5rem; }
        .modal-desc { color: #475569; line-height: 1.6; font-size: 0.95rem; background: #f8fafc; padding: 1rem; border-radius: 8px; border-left: 4px solid #cbd5e1; }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="nav-brand">
            <div class="brand-icon"><i class="fa-solid fa-shield-halved"></i></div>
            <div class="brand-text">
                <span class="brand-title">DESA MLIDEG</span>
                <span class="brand-subtitle">SMART VILLAGE</span>
            </div>
        </a>
        <ul class="nav-links">
            <li><a href="/">Beranda</a></li>
            <li class="active"><a href="/profil">Profil</a></li>
            <li><a href="/statistik">Statistik</a></li>
            <li><a href="/berita">Berita</a></li>
            <li><a href="/potensi">Potensi</a></li>
            <li><a href="/galeri">Galeri</a></li>
            <li><a href="/kontak">Kontak</a></li>
        </ul>
        <div class="nav-actions">
            <a href="/lapor" class="btn-lapor" style="text-decoration:none;"><i class="fa-regular fa-message"></i> Lapor</a>
            <a href="/ajuan-surat" class="btn-surat" style="text-decoration:none;"><i class="fa-solid fa-envelope-open-text"></i> Layanan Surat</a>
            <a href="/login" class="btn-grid" style="text-decoration: none;">
                <i class="fa-solid fa-shapes"></i>
            </a>
            <button class="hamburger-btn" id="hamburgerBtn"><i class="fa-solid fa-bars"></i></button>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenu">
        <button class="close-menu" id="closeMenu"><i class="fa-solid fa-xmark"></i></button>
        <div class="mobile-brand">
            <i class="fa-solid fa-shield-halved"></i>
            <span>DESA MLIDEG</span>
        </div>
        <ul class="mobile-nav-links">
            <li><a href="/">Beranda</a></li>
            <li><a href="/profil">Profil</a></li>
            <li><a href="/statistik">Statistik</a></li>
            <li><a href="/berita">Berita</a></li>
            <li><a href="/potensi">Potensi</a></li>
            <li><a href="/galeri">Galeri</a></li>
            <li><a href="/kontak">Kontak</a></li>
            <li style="margin-top: 1rem;">
                <a href="/lapor" class="mobile-btn-lapor">Lapor Sekarang</a>
                <a href="/ajuan-surat" class="mobile-btn-surat">Layanan Surat</a>
            </li>
        </ul>
    </div>

    <!-- Header Detail Page -->
    <header class="detail-header">
        <h1 class="detail-header-title">Struktur Organisasi</h1>
        <div class="breadcrumb">
            <a href="/">Beranda</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i>
            <a href="/profil">Profil Desa</a>
            <i class="fa-solid fa-chevron-right" style="font-size: 0.7rem;"></i>
            <span>Struktur Organisasi</span>
        </div>
    </header>

    <!-- Org Chart Section -->
    <section class="org-container">
        <div class="org-tree">
            
            <!-- BPD (Sidebar conceptual) -->
            <div class="bpd-container">
                @foreach($perangkat->where('level', 0) as $p)
                <div class="org-node bpd" onclick="showProfile(this)" data-name="{{ $p->nama }}" data-role="{{ $p->jabatan }}" data-desc="{{ $p->deskripsi }}" data-icon="{{ $p->icon }}" data-ttl="{{ $p->ttl }}" data-pendidikan="{{ $p->pendidikan }}" data-nohp="{{ $p->no_hp }}">
                    <div class="node-avatar"><i class="fa-solid {{ $p->icon }}"></i></div>
                    <div class="node-name">{{ $p->nama }}</div>
                    <div class="node-role">{{ $p->jabatan }}</div>
                </div>
                @endforeach
                <div class="bpd-line"></div>
            </div>

            <!-- Level 1: Kepala Desa -->
            <div class="level top-level">
                @foreach($perangkat->where('level', 1) as $p)
                <div class="org-node kades" onclick="showProfile(this)" data-name="{{ $p->nama }}" data-role="{{ $p->jabatan }}" data-desc="{{ $p->deskripsi }}" data-icon="{{ $p->icon }}" data-ttl="{{ $p->ttl }}" data-pendidikan="{{ $p->pendidikan }}" data-nohp="{{ $p->no_hp }}">
                    <div class="node-avatar"><i class="fa-solid {{ $p->icon }}"></i></div>
                    <div class="node-name">{{ $p->nama }}</div>
                    <div class="node-role">{{ $p->jabatan }}</div>
                </div>
                @endforeach
            </div>
            
            <div class="line-down"></div>

            <!-- Level 2: Sekdes -->
            <div class="level">
                @foreach($perangkat->where('level', 2) as $p)
                <div class="org-node sekdes" onclick="showProfile(this)" data-name="{{ $p->nama }}" data-role="{{ $p->jabatan }}" data-desc="{{ $p->deskripsi }}" data-icon="{{ $p->icon }}" data-ttl="{{ $p->ttl }}" data-pendidikan="{{ $p->pendidikan }}" data-nohp="{{ $p->no_hp }}">
                    <div class="node-avatar"><i class="fa-solid {{ $p->icon }}"></i></div>
                    <div class="node-name">{{ $p->nama }}</div>
                    <div class="node-role">{{ $p->jabatan }}</div>
                </div>
                @endforeach
            </div>

            <div class="line-down"></div>

            <!-- Level 3: Kaur & Kasi -->
            <div class="level" style="position: relative; margin-top: 2rem;">
                <div class="siblings-fork" style="left: 130px; right: 130px;"></div>
                
                @foreach($perangkat->where('level', 3) as $p)
                <div class="org-node" onclick="showProfile(this)" data-name="{{ $p->nama }}" data-role="{{ $p->jabatan }}" data-desc="{{ $p->deskripsi }}" data-icon="{{ $p->icon }}" data-ttl="{{ $p->ttl }}" data-pendidikan="{{ $p->pendidikan }}" data-nohp="{{ $p->no_hp }}">
                    <div class="node-avatar"><i class="fa-solid {{ $p->icon }}"></i></div>
                    <div class="node-name">{{ $p->nama }}</div>
                    <div class="node-role">{{ $p->jabatan }}</div>
                </div>
                @endforeach
            </div>

            <div class="line-down" style="height: 3rem;"></div>

            <!-- Level 4: Kasi -->
            <div class="level" style="position: relative; margin-top: 2rem;">
                <div class="siblings-fork" style="left: 130px; right: 130px;"></div>
                
                @foreach($perangkat->where('level', 4) as $p)
                <div class="org-node" onclick="showProfile(this)" data-name="{{ $p->nama }}" data-role="{{ $p->jabatan }}" data-desc="{{ $p->deskripsi }}" data-icon="{{ $p->icon }}" data-ttl="{{ $p->ttl }}" data-pendidikan="{{ $p->pendidikan }}" data-nohp="{{ $p->no_hp }}">
                    <div class="node-avatar"><i class="fa-solid {{ $p->icon }}"></i></div>
                    <div class="node-name">{{ $p->nama }}</div>
                    <div class="node-role">{{ $p->jabatan }}</div>
                </div>
                @endforeach
            </div>

            <div class="line-down" style="height: 3rem;"></div>

            <!-- Level 5: Kepala Dusun -->
            <div class="level" style="position: relative; margin-top: 2rem;">
                <div class="siblings-fork" style="left: 130px; right: 130px;"></div>
                
                @foreach($perangkat->where('level', 5) as $p)
                <div class="org-node" style="border-color: #10b981; background: #ecfdf5;" onclick="showProfile(this)" data-name="{{ $p->nama }}" data-role="{{ $p->jabatan }}" data-desc="{{ $p->deskripsi }}" data-icon="{{ $p->icon }}" data-ttl="{{ $p->ttl }}" data-pendidikan="{{ $p->pendidikan }}" data-nohp="{{ $p->no_hp }}">
                    <div class="node-avatar"><i class="fa-solid {{ $p->icon }}"></i></div>
                    <div class="node-name">{{ $p->nama }}</div>
                    <div class="node-role" style="color: #059669;">{{ $p->jabatan }}</div>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- Modal Detail Profil -->
    <div class="modal-overlay" id="profileModal">
        <div class="modal-container">
            <div class="modal-header">
                <h3><i class="fa-solid fa-address-card" style="color:var(--primary); margin-right:0.5rem;"></i> Profil Singkat</h3>
                <button class="modal-close" onclick="closeModal()"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="modal-avatar" id="modalIcon">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="modal-name" id="modalName">Nama Pejabat</div>
                <div class="modal-role" id="modalRole">Jabatan</div>
                <div class="modal-desc" id="modalDesc" style="margin-bottom: 1rem;">Deskripsi tugas pokok dan fungsi jabatan.</div>
                
                <div class="biodata-grid" style="text-align: left; background: #f1f5f9; padding: 1.2rem; border-radius: 8px; font-size: 0.9rem;">
                    <div style="margin-bottom: 0.8rem; display: flex; border-bottom: 1px dashed #cbd5e1; padding-bottom: 0.5rem;">
                        <strong style="color: #475569; width: 110px;">Tempat, Tgl Lahir</strong>
                        <span style="color: #0f172a; font-weight: 600; flex: 1;">: <span id="modalTtl">-</span></span>
                    </div>
                    <div style="margin-bottom: 0.8rem; display: flex; border-bottom: 1px dashed #cbd5e1; padding-bottom: 0.5rem;">
                        <strong style="color: #475569; width: 110px;">Pendidikan</strong>
                        <span style="color: #0f172a; font-weight: 600; flex: 1;">: <span id="modalPendidikan">-</span></span>
                    </div>
                    <div style="display: flex;">
                        <strong style="color: #475569; width: 110px;">No. HP</strong>
                        <span style="color: #0f172a; font-weight: 600; flex: 1;">: <span id="modalNohp">-</span></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="simple-footer">
        <div class="footer-brand">
            <i class="fa-solid fa-shield-halved"></i>
            <span>Desa Mlideg</span>
        </div>
    </footer>

    <script>
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const closeMenu = document.getElementById('closeMenu');
        const mobileMenu = document.getElementById('mobileMenu');

        if(hamburgerBtn && mobileMenu && closeMenu) {
            hamburgerBtn.addEventListener('click', () => {
                mobileMenu.classList.add('active');
                document.body.style.overflow = 'hidden';
            });

            closeMenu.addEventListener('click', () => {
                mobileMenu.classList.remove('active');
                document.body.style.overflow = 'auto';
            });

            const mobileLinks = mobileMenu.querySelectorAll('a');
            mobileLinks.forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.remove('active');
                    document.body.style.overflow = 'auto';
                });
            });
        }

        function showProfile(element) {
            const name = element.getAttribute('data-name');
            const role = element.getAttribute('data-role');
            const desc = element.getAttribute('data-desc');
            const icon = element.getAttribute('data-icon');
            const ttl = element.getAttribute('data-ttl');
            const pendidikan = element.getAttribute('data-pendidikan');
            const nohp = element.getAttribute('data-nohp') || '-';

            document.getElementById('modalName').innerText = name;
            document.getElementById('modalRole').innerText = role;
            document.getElementById('modalDesc').innerText = desc;
            document.getElementById('modalIcon').innerHTML = `<i class="fa-solid ${icon}"></i>`;
            
            document.getElementById('modalTtl').innerText = ttl;
            document.getElementById('modalPendidikan').innerText = pendidikan;
            document.getElementById('modalNohp').innerText = nohp;

            document.getElementById('profileModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            document.getElementById('profileModal').classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Close on outside click
        document.getElementById('profileModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
</body>
</html>

