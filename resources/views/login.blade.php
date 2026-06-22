<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - DESA MLIDEG</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #f97316;
            --primary-hover: #ea580c;
            --text-dark: #1e293b;
            --bg-light: #f1f5f9;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }
        body {
            background-color: var(--bg-light);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-container {
            background: #ffffff;
            width: 100%;
            max-width: 420px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.05);
            padding: 3rem 2.5rem;
            text-align: center;
        }
        .brand-icon {
            background-color: var(--primary);
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.5rem auto;
            box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);
        }
        .login-title {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }
        .login-subtitle {
            font-size: 0.9rem;
            color: #64748b;
            margin-bottom: 2rem;
            font-weight: 500;
        }

        .form-group {
            margin-bottom: 1.2rem;
            text-align: left;
        }
        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 700;
            color: #475569;
            margin-bottom: 0.5rem;
        }
        .form-control {
            width: 100%;
            padding: 0.9rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
            background-color: #f8fafc;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            background-color: #ffffff;
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
        }

        .btn-login {
            width: 100%;
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 1rem;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1rem;
            box-shadow: 0 4px 15px rgba(249, 115, 22, 0.2);
        }
        .btn-login:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(249, 115, 22, 0.3);
        }

        .error-msg {
            color: #ef4444;
            background-color: #fef2f2;
            padding: 0.8rem;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            border: 1px solid #fee2e2;
        }

        .back-link {
            display: inline-block;
            margin-top: 1.5rem;
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: color 0.3s;
        }
        .back-link:hover {
            color: var(--primary);
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="brand-icon">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
        <h1 class="login-title">Portal Admin SID</h1>
        <p class="login-subtitle">Silakan masuk menggunakan kredensial Anda</p>

        @if(session('error'))
            <div class="error-msg">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ session('error') }}
            </div>
        @endif

        <form action="/login" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="username">Username Akses</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Contoh: superadmin" required autofocus>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="password">Kata Sandi</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>

            <button type="submit" class="btn-login">Masuk Dashboard</button>
        </form>

        <a href="/" class="back-link"><i class="fa-solid fa-arrow-left"></i> Kembali ke Halaman Utama</a>
    </div>

</body>
</html>
