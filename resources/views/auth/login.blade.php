<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem SPP - Masuk</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            
            background: radial-gradient(circle at top left, #29406f 0%, #17244b 50%, #151e36 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Inter', sans-serif;
            color: #ffffff;
            position: relative;
        }
        
        .badge-brand {
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.05);
            font-weight: 400;
            padding: 8px 16px;
            border-radius: 50rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: #e2e8f0;
        }

        .highlight-text {
            color: #00d2ff;
        }

        .feature-icon-box {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        .icon-box-blue { background: rgba(37, 99, 235, 0.2); color: #60a5fa; }
        .icon-box-teal { background: rgba(20, 184, 166, 0.2); color: #2dd4bf; }

        
        .login-card {
            background-color: #f8fafc;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            border: none;
            color: #1e293b;
            padding: 2rem;
        }

        .login-logo {
            width: 64px;
            height: 64px;
            background: #009cff;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            color: white;
            font-size: 2rem;
            box-shadow: 0 10px 15px -3px rgba(0, 156, 255, 0.3);
        }

        .form-control {
            background-color: #ffffff;
            border: 1px solid #cbd5e1;
            padding-left: 2.5rem;
            border-radius: 10px;
            height: 48px;
        }
        .form-control:focus {
            border-color: #00d2ff;
            box-shadow: 0 0 0 0.25rem rgba(0, 210, 255, 0.15);
        }

        .input-icon-wrapper {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.1rem;
            z-index: 10;
        }

        .btn-masuk {
            background: linear-gradient(to right, #0061ff, #00d2ff);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 10px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.3s;
        }
        .btn-masuk:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 15px rgba(0, 160, 255, 0.3);
            color: white;
        }

        .demo-badge {
            font-size: 0.85rem;
            font-weight: 500;
            padding: 8px 0;
            border-radius: 8px;
            text-align: center;
            width: 100%;
            cursor: pointer;
            border: none;
        }
        .demo-admin { background: #fdf4ff; color: #c026d3; }
        .demo-petugas { background: #eff6ff; color: #2563eb; }
        .demo-siswa { background: #f0fdf4; color: #16a34a; }

        .divider-wrapper {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 24px 0;
            color: #64748b;
        }
        .divider-wrapper::before,
        .divider-wrapper::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }
        .divider-wrapper:not(:empty)::before {
            margin-right: .5em;
        }
        .divider-wrapper:not(:empty)::after {
            margin-left: .5em;
        }

        .footer-text {
            position: absolute;
            bottom: 24px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
            pointer-events: none;
        }

        .help-btn {
            position: absolute;
            bottom: 24px;
            right: 24px;
            width: 36px;
            height: 36px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .help-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <div class="row align-items-center justify-content-between">
            
            
            <div class="col-lg-6 mb-5 mb-lg-0 pe-lg-5">
                <div class="badge-brand mb-4">
                    <i class="bi bi-stars text-warning"></i> Sistem Manajemen Sekolah Modern
                </div>
                
                <h1 class="display-4 fw-bolder mb-2 leading-tight">Selamat Datang di</h1>
                <h1 class="display-4 fw-bolder highlight-text mb-4">Sistem SPP</h1>
                
                <p class="fs-5 mb-5" style="color: #cbd5e1; max-width: 480px;">
                    Solusi manajemen pembayaran komprehensif untuk institusi pendidikan
                </p>

                
                <div class="d-flex align-items-start mb-4">
                    <div class="feature-icon-box icon-box-blue me-3">
                        <i class="bi bi-mortarboard"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Portal Siswa</h5>
                        <p class="mb-0" style="color: #94a3b8; font-size: 0.95rem;">Pengajuan pembayaran dan pelacakan tagihan yang mudah</p>
                    </div>
                </div>

                <div class="d-flex align-items-start">
                    <div class="feature-icon-box icon-box-teal me-3">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">Verifikasi Petugas</h5>
                        <p class="mb-0" style="color: #94a3b8; font-size: 0.95rem;">Sistem persetujuan pembayaran semi-otomatis</p>
                    </div>
                </div>
            </div>

            
            <div class="col-lg-5 col-xl-4 mx-auto mx-lg-0">
                <div class="card login-card">
                    <div class="text-center mb-4 pt-2">
                        <div class="login-logo mb-3">
                            <i class="bi bi-mortarboard-fill"></i>
                        </div>
                        <h3 class="fw-bold fs-4 mb-1">Masuk</h3>
                        <p class="text-muted" style="font-size: 0.9rem;">Akses akun Anda untuk melanjutkan</p>
                    </div>

                    <form action="#" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 0.9rem; font-weight: 500;">Username</label>
                            <div class="input-icon-wrapper">
                                <i class="bi bi-person input-icon"></i>
                                <input type="text" name="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan username Anda" required>
                            </div>
                            @error('username')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="font-size: 0.9rem; font-weight: 500;">Password</label>
                            <div class="input-icon-wrapper">
                                <i class="bi bi-lock input-icon"></i>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password Anda" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-masuk w-100">
                            Masuk <i class="bi bi-box-arrow-in-right ms-1"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    
    <div class="footer-text">
        Prestasi Prima &copy; 2026
    </div>
    
    <a href="#" class="help-btn" title="Bantuan">
        <i class="bi bi-question-lg"></i>
    </a>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
