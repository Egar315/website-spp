<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Sistem SPP</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f9fc;
            overflow-x: hidden;
        }
        
        
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #1a2035;
            color: #ffffff;
            display: flex;
            flex-direction: column;
            z-index: 1000;
        }

        .sidebar-brand {
            padding: 24px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand-logo {
            width: 40px;
            height: 40px;
            background-color: #009cff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.2rem;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 156, 255, 0.4);
        }

        .brand-text h4 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .brand-text p {
            margin: 0;
            font-size: 0.75rem;
            color: #009cff;
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        .sidebar-menu li {
            padding: 4px 16px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            color: #a0aec0;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            font-size: 0.95rem;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .sidebar-menu a:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .sidebar-menu a i {
            font-size: 1.25rem;
        }

        .sidebar-menu a.active {
            background: linear-gradient(to right, #007bff, #00d2ff);
            color: white;
            box-shadow: 0 4px 15px rgba(0, 156, 255, 0.3);
        }

        .sidebar-footer {
            padding: 20px;
        }
        .version-box {
            background-color: #242a42;
            padding: 12px;
            border-radius: 12px;
            font-size: 0.75rem;
            color: #a0aec0;
        }

        
        .main-content {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background-color: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            padding: 15px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        .welcome-text p { margin: 0; font-size: 0.85rem; color: #64748b; }
        .welcome-text h5 { margin: 0; font-size: 1.1rem; font-weight: 700; color: #1e293b; }

        .topbar-right { display: flex; align-items: center; gap: 20px; }

        .notif-btn {
            background: none; border: none; position: relative;
            color: #64748b; font-size: 1.25rem; padding: 0;
        }
        .notif-badge {
            position: absolute;
            top: -6px;
            right: -8px;
            background-color: #ef4444;
            color: white;
            font-size: 0.65rem;
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 10px;
            border: 2px solid #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 18px;
            height: 18px;
        }

        .role-badge {
            background-color: #f3e8ff;
            color: #a855f7;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .logout-btn {
            color: #ef4444;
            background: none;
            border: none;
            font-weight: 500;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }
        .logout-btn:hover {
            color: #dc2626;
        }

        .content-area {
            padding: 30px;
            flex-grow: 1;
        }

        /* --- ✨ Smooth Premium Loader ✨ --- */
        .page-loader {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: #f7f9fc; z-index: 99999;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            transition: opacity 0.5s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.5s;
            opacity: 1; visibility: visible;
        }
        .page-loader.hidden { opacity: 0; visibility: hidden; }
        .spinner-container { position: relative; width: 60px; height: 60px; }
        .spinner-ring {
            position: absolute; width: 100%; height: 100%;
            border: 4px solid transparent; border-top-color: #009cff; border-radius: 50%;
            animation: spin 1s cubic-bezier(0.55, 0.15, 0.45, 0.85) infinite;
        }
        .spinner-ring:nth-child(2) {
            border-top-color: #a855f7; width: 70%; height: 70%; top: 15%; left: 15%;
            animation: spin 1.2s cubic-bezier(0.55, 0.15, 0.45, 0.85) infinite reverse;
        }
        .loader-text {
            margin-top: 20px; font-weight: 700; color: #1e293b; font-size: 0.85rem; letter-spacing: 2px;
            animation: pulse 1.5s infinite;
        }
        @keyframes spin { 0% {transform:rotate(0deg);} 100% {transform:rotate(360deg);} }
        @keyframes pulse { 0%, 100% {opacity:1;} 50% {opacity:0.5;} }
        
        .main-content {
            animation: fadeInContent 0.6s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }
        @keyframes fadeInContent {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: none; }
        }

        /* --- ✨ Responsive Mobile Enhancements ✨ --- */
        @media (max-width: 991.98px) {
            .sidebar { transform: translateX(-100%); transition: transform 0.3s ease; }
            .sidebar.show { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .topbar { padding: 12px 20px; }
            .content-area { padding: 20px 15px; }
            .welcome-text p { display: none; }
            .welcome-text h5 { font-size: 0.95rem; }
            .role-badge { display: none !important; }
        }
        .sidebar-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(15, 23, 42, 0.6); z-index: 999;
            display: none; opacity: 0; transition: opacity 0.3s;
            backdrop-filter: blur(3px);
        }
        .sidebar-overlay.show { display: block; opacity: 1; }
    </style>
</head>
<body>

    <!-- Page Loader -->
    <div id="page-loader" class="page-loader">
        <div class="spinner-container">
            <div class="spinner-ring"></div>
            <div class="spinner-ring"></div>
        </div>
        <div class="loader-text">MEMUAT...</div>
    </div>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    
    <div class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo">S</div>
            <div class="brand-text">
                <h4>Sistem SPP</h4>
                <p>Administrator</p>
            </div>
        </div>

        <ul class="sidebar-menu mt-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users') }}" class="{{ request()->is('admin/users') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i> Kelola Pengguna
                </a>
            </li>
            <li>
                <a href="{{ route('admin.students') }}" class="{{ request()->is('admin/students') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-person"></i> Data Siswa
                </a>
            </li>
            <li>
                <a href="{{ route('admin.payments') }}" class="{{ request()->is('admin/payments') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i> Riwayat Pembayaran
                </a>
            </li>
            <li>
                <a href="{{ route('admin.settings') }}" class="{{ request()->is('admin/settings') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i> Konfigurasi SPP
                </a>
            </li>
        </ul>

        <div class="sidebar-footer">
            <div class="version-box">
                Versi Sistem<br>
                <strong class="text-white mt-1 d-block">v2.0.1</strong>
            </div>
        </div>
    </div>

    
    <div class="main-content">
        
        <div class="topbar">
            <div class="d-flex align-items-center">
                <button class="d-lg-none" id="mobileToggle" style="background:none; border:none; font-size:1.6rem; color:#1e293b; padding:0; margin-right:15px;">
                    <i class="bi bi-list"></i>
                </button>
                <div class="welcome-text">
                    <p>Selamat datang kembali,</p>
                    <h5>{{ Auth::user() ? Auth::user()->name : 'Dr. Soekarno' }}</h5>
                </div>
            </div>
            
            <div class="topbar-right">
                <div class="dropdown">
                    <button class="notif-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="notifDropdownBtn">
                        <i class="bi bi-bell"></i>
                        <span class="notif-badge d-none" id="notifBadge"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0" style="width: 320px; border-radius: 16px; padding: 0; overflow: hidden; margin-top: 15px;" id="notifDropdownMenu">
                        <li><div class="dropdown-header text-center py-3 bg-light border-bottom fw-bold" style="color: #1e293b;">Notifikasi Sistem</div></li>
                        <div id="notifList" style="max-height: 350px; overflow-y: auto;">
                            <li><div class="dropdown-item text-center text-muted py-4"><div class="spinner-border spinner-border-sm text-primary" role="status"></div><br><small class="mt-2 d-block">Memuat notifikasi...</small></div></li>
                        </div>
                        <li><a href="{{ route('admin.payments') }}" class="dropdown-item text-center py-2 bg-light border-top text-primary fw-bold" style="font-size: 0.8rem;">Lihat Semua Pembayaran</a></li>
                    </ul>
                </div>
                
                <div class="role-badge">
                    <i class="bi bi-person"></i> Administrator
                </div>
                
                <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="bi bi-box-arrow-right"></i> Keluar
                    </button>
                </form>
            </div>
        </div>

        
        <div class="content-area">
            @yield('content')
        </div>
    </div>

    <!-- Modals -->
    @yield('modals')

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3500,
                timerProgressBar: true,
                background: '#ffffff',
                color: '#1e293b',
                iconColor: '#38bdf8',
                customClass: { popup: 'rounded-4 shadow-sm border border-slate-100' },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            @if(session('success'))
                Toast.fire({ icon: 'success', title: '{{ session('success') }}', iconColor: '#10b981' });
            @endif

            @if(session('error') || $errors->any())
                Toast.fire({ icon: 'error', title: '{{ session('error') ?? "Periksa kembali isian form Anda!" }}', iconColor: '#ef4444' });
            @endif

            
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn && !submitBtn.hasAttribute('data-no-loading')) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...';
                    }
                });
            });

            // --- ✨ Custom Premium JS Enhancements ✨ ---
            
            // 1. Dynamic Greeting (Pagi/Siang/Sore/Malam)
            const updateGreeting = () => {
                const hour = new Date().getHours();
                let greeting = 'Selamat datang kembali';
                if (hour >= 5 && hour < 12) greeting = 'Selamat pagi';
                else if (hour >= 12 && hour < 15) greeting = 'Selamat siang';
                else if (hour >= 15 && hour < 18) greeting = 'Selamat sore';
                else greeting = 'Selamat malam';
                
                const greetingEl = document.querySelector('.welcome-text p');
                if(greetingEl) greetingEl.innerHTML = greeting + ', <span style="font-size:1.2rem;">👋</span>';
            };
            updateGreeting();

            // 2. Live Digital Clock in Topbar
            const createClock = () => {
                const topbarRight = document.querySelector('.topbar-right');
                if(topbarRight) {
                    const clockDiv = document.createElement('div');
                    clockDiv.style.cssText = 'background: rgba(0, 156, 255, 0.1); color: #009cff; padding: 6px 14px; border-radius: 20px; font-weight: 700; font-size: 0.85rem; letter-spacing: 0.5px; display:flex; align-items:center; gap:6px;';
                    topbarRight.insertBefore(clockDiv, topbarRight.firstChild);

                    const tick = () => {
                        const now = new Date();
                        clockDiv.innerHTML = '<i class="bi bi-clock-history"></i> ' + now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
                    };
                    tick();
                    setInterval(tick, 1000);
                }
            };
            createClock();

            // 3. Smooth Page Transitions Logic
            const loader = document.getElementById('page-loader');
            
            window.addEventListener('load', () => {
                if(loader) loader.classList.add('hidden');
            });
            setTimeout(() => { if(loader) loader.classList.add('hidden'); }, 1500); // Failsafe

            // Show loader when clicking sidebar links
            document.querySelectorAll('.sidebar-menu a').forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    if(href && href !== '#' && !this.hasAttribute('target')) {
                        e.preventDefault();
                        if(loader) loader.classList.remove('hidden');
                        setTimeout(() => {
                            window.location.href = href;
                        }, 400); // Give loader time to fade in
                    }
                });
            });

            // 4. Mobile Sidebar Toggle
            const mobileToggle = document.getElementById('mobileToggle');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');

            if(mobileToggle && sidebar && overlay) {
                mobileToggle.addEventListener('click', () => {
                    sidebar.classList.add('show');
                    overlay.classList.add('show');
                });
                overlay.addEventListener('click', () => {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                });
            }

            // 5. Interactive Sidebar Hover Effect
            document.querySelectorAll('.sidebar-menu a').forEach(link => {
                link.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                link.addEventListener('mouseenter', function() {
                    if(!this.classList.contains('active')) {
                        this.style.transform = 'translateX(6px)';
                        this.style.backgroundColor = 'rgba(255, 255, 255, 0.08)';
                    }
                });
                link.addEventListener('mouseleave', function() {
                    if(!this.classList.contains('active')) {
                        this.style.transform = 'translateX(0)';
                        this.style.backgroundColor = 'transparent';
                    }
                });
            });

            // 6. Notification System 🚀
            const fetchNotifications = () => {
                fetch('{{ route("notifications.get") }}')
                    .then(res => res.json())
                    .then(data => {
                        const badge = document.getElementById('notifBadge');
                        const list = document.getElementById('notifList');
                        
                        if(data.count > 0) {
                            badge.classList.remove('d-none');
                            badge.textContent = data.count > 9 ? '9+' : data.count;
                        } else {
                            badge.classList.add('d-none');
                        }
                        
                        let html = '';
                        if(data.notifications.length === 0) {
                            html = '<li><div class="dropdown-item text-center text-muted py-4" style="font-size: 0.85rem;"><i class="bi bi-bell-slash fs-3 d-block mb-2 text-light"></i>Tidak ada notifikasi.</div></li>';
                        } else {
                            data.notifications.forEach(item => {
                                html += `
                                    <li>
                                        <a class="dropdown-item py-3 border-bottom d-flex align-items-start gap-3" href="${item.link}" style="white-space: normal; transition: background 0.2s;">
                                            <div class="bg-${item.color} bg-opacity-10 text-${item.color} rounded-circle d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; flex-shrink: 0;">
                                                <i class="bi ${item.icon} fs-5"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark mb-1" style="font-size: 0.9rem;">${item.title}</div>
                                                <div class="text-muted mb-1" style="font-size: 0.8rem; line-height: 1.4;">${item.message}</div>
                                                <div class="text-muted" style="font-size: 0.7rem;"><i class="bi bi-clock me-1"></i>${item.time}</div>
                                            </div>
                                        </a>
                                    </li>
                                `;
                            });
                        }
                        if(list) list.innerHTML = html;
                    })
                    .catch(err => console.error('Gagal mengambil notifikasi:', err));
            };

            fetchNotifications();
            setInterval(fetchNotifications, 60000); // 1 menit
            
            const notifDropdownBtn = document.getElementById('notifDropdownBtn');
            if(notifDropdownBtn) {
                notifDropdownBtn.addEventListener('show.bs.dropdown', fetchNotifications);
            }

        });
    </script>
</body>
</html>
