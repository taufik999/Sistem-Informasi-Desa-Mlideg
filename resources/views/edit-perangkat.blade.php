<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Perangkat Desa - SID Admin</title>
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
        body { display: flex; min-height: 100vh; background-color: var(--bg-main); }
        
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
            flex-grow: 1; margin-left: 260px; padding: 2.5rem 3rem;
        }
        .header {
            display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;
        }
        .header-title h2 { color: var(--text-dark); font-weight: 800; font-size: 1.8rem; }
        .header-title p { color: #64748b; font-size: 0.95rem; font-weight: 500; margin-top: 0.3rem;}
        
        .form-container {
            background: var(--white); padding: 2rem; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            max-width: 800px;
        }
        .form-group { margin-bottom: 1.5rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 600; color: var(--text-dark); font-size: 0.9rem;}
        .form-control {
            width: 100%; padding: 0.8rem 1rem; border: 1px solid #cbd5e1; border-radius: 8px; font-size: 0.95rem;
            outline: none; transition: border-color 0.3s;
        }
        .form-control:focus { border-color: var(--primary); }
        .btn-submit {
            background-color: var(--primary); color: white; padding: 0.8rem 1.5rem; border: none; border-radius: 8px;
            font-weight: 700; cursor: pointer; font-size: 1rem; transition: background-color 0.3s;
        }
        .btn-submit:hover { background-color: #ea580c; }
        .btn-cancel {
            background-color: #e2e8f0; color: #475569; padding: 0.8rem 1.5rem; border: none; border-radius: 8px;
            font-weight: 700; cursor: pointer; font-size: 1rem; text-decoration: none; margin-left: 1rem;
        }
    </style>
</head>
<body>

    @include('partials.sidebar')

    <main class="main-content">
        <div class="header">
            <div class="header-title">
                <h2>Edit Perangkat Desa</h2>
                <p>Ubah data struktur organisasi</p>
            </div>
        </div>

        <div class="form-container">
            <form action="/admin/perangkat/{{ $perangkat->id }}/edit" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input type="text" name="nama" class="form-control" required value="{{ $perangkat->nama }}">
                </div>
                
                <div class="form-group">
                    <label>Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" required value="{{ $perangkat->jabatan }}">
                </div>

                <div class="form-group">
                    <label>Level (Hierarki Bagan)</label>
                    <select name="level" class="form-control" required>
                        <option value="0" {{ $perangkat->level == 0 ? 'selected' : '' }}>0 - BPD (Badan Permusyawaratan Desa)</option>
                        <option value="1" {{ $perangkat->level == 1 ? 'selected' : '' }}>1 - Kepala Desa</option>
                        <option value="2" {{ $perangkat->level == 2 ? 'selected' : '' }}>2 - Sekretaris Desa</option>
                        <option value="3" {{ $perangkat->level == 3 ? 'selected' : '' }}>3 - Kepala Urusan (Kaur)</option>
                        <option value="4" {{ $perangkat->level == 4 ? 'selected' : '' }}>4 - Kepala Seksi (Kasi)</option>
                        <option value="5" {{ $perangkat->level == 5 ? 'selected' : '' }}>5 - Kepala Dusun (Kasun)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Deskripsi Tugas</label>
                    <textarea name="deskripsi" class="form-control" rows="3">{{ $perangkat->deskripsi }}</textarea>
                </div>

                <div class="form-group">
                    <label>Tempat, Tanggal Lahir (TTL)</label>
                    <input type="text" name="ttl" class="form-control" value="{{ $perangkat->ttl }}">
                </div>

                <div class="form-group">
                    <label>Pendidikan</label>
                    <input type="text" name="pendidikan" class="form-control" value="{{ $perangkat->pendidikan }}">
                </div>

                <div class="form-group">
                    <label>No. HP</label>
                    <input type="text" name="no_hp" class="form-control" value="{{ $perangkat->no_hp }}">
                </div>

                <div class="form-group">
                    <label>Class Icon (FontAwesome)</label>
                    <input type="text" name="icon" class="form-control" value="{{ $perangkat->icon }}">
                </div>

                <div class="form-group">
                    <label>Urutan (Untuk level yang sama)</label>
                    <input type="number" name="urutan" class="form-control" value="{{ $perangkat->urutan }}">
                </div>

                <div style="margin-top: 2rem;">
                    <button type="submit" class="btn-submit">Simpan Perubahan</button>
                    <a href="/admin/perangkat" class="btn-cancel">Batal</a>
                </div>
            </form>
        </div>
    </main>

</body>
</html>
