@extends('layouts.admin')

@section('title', 'Ringkasan Dashboard')

@section('content')
<style>
    .page-title {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.25rem;
    }
    .page-subtitle {
        color: #64748b;
        font-size: 0.95rem;
        margin-bottom: 2rem;
    }

    
    .summary-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    
    .card-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
    }
    .icon-blue { background-color: #009cff; }
    .icon-purple { background-color: #d946ef; }
    .icon-green { background-color: #22c55e; }
    .icon-orange { background-color: #f59e0b; }

    .trend-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .trend-up { background-color: #ecfdf5; color: #10b981; }
    .trend-down { background-color: #ecfdf5; color: #10b981;  }

    .summary-label {
        font-size: 0.85rem;
        color: #64748b;
        margin-top: 1.5rem;
        margin-bottom: 0.25rem;
    }
    .summary-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    
    .section-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        height: 100%;
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
    }
    
    
    .payment-item {
        display: flex;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    .payment-item:last-child {
        border-bottom: none;
    }
    .avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .avatar-1 { background-color: #009cff; }
    .avatar-2 { background-color: #0ea5e9; }
    .avatar-3 { background-color: #0284c7; }
    
    
    .progress-wrapper {
        margin-bottom: 1.25rem;
    }
    .progress-label {
        display: flex;
        justify-content: space-between;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }
    .progress-bar-custom {
        height: 8px;
        border-radius: 4px;
        background-color: #f1f5f9;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        border-radius: 4px;
    }
    .fill-green { background-color: #10b981; width: 78%; }
    .fill-orange { background-color: #f59e0b; width: 12%; }
    .fill-red { background-color: #ef4444; width: 10%; }

    .alert-card {
        background-color: #eff6ff;
        border-radius: 12px;
        padding: 16px;
        display: flex;
        gap: 12px;
        margin-top: 1rem;
    }
    .alert-icon {
        width: 32px;
        height: 32px;
        background-color: #3b82f6;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
</style>

<div>
    <h2 class="page-title">Ringkasan Dashboard</h2>
    <p class="page-subtitle">Selamat datang kembali! Berikut yang terjadi hari ini.</p>

    
    <div class="row g-4 mb-4">
        
        <div class="col-md-6 col-xl-3">
            <div class="summary-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="card-icon icon-blue">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="trend-badge trend-up">
                        <i class="bi bi-arrow-up-right"></i>+12.5%
                    </div>
                </div>
                <div class="summary-label">Total Siswa</div>
                <div class="summary-value">{{ number_format($totalStudents, 0, ',', '.') }}</div>
            </div>
        </div>
        
        
        <div class="col-md-6 col-xl-3">
            <div class="summary-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="card-icon icon-purple">
                        <i class="bi bi-person-badge"></i>
                    </div>
                    <div class="trend-badge trend-up">
                        <i class="bi bi-arrow-up-right"></i>+2 baru
                    </div>
                </div>
                <div class="summary-label">Jumlah Petugas</div>
                <div class="summary-value">{{ $totalStaff }}</div>
            </div>
        </div>

        
        <div class="col-md-6 col-xl-3">
            <div class="summary-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="card-icon icon-green">
                        <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="trend-badge trend-up">
                        <i class="bi bi-arrow-up-right"></i>+18.2%
                    </div>
                </div>
                <div class="summary-label">Pendapatan Bulan Ini</div>
                <div class="summary-value">Rp {{ number_format($incomeThisMonth / 1000000, 1, ',', '.') }} Juta</div>
            </div>
        </div>

        
        <div class="col-md-6 col-xl-3">
            <div class="summary-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="card-icon icon-orange">
                        <i class="bi bi-exclamation-lg"></i>
                    </div>
                    <div class="trend-badge trend-down">
                        <i class="bi bi-arrow-down-right"></i>-8.1%
                    </div>
                </div>
                <div class="summary-label">Tunggakan</div>
                <div class="summary-value">Rp {{ number_format($totalOutstanding / 1000000, 1, ',', '.') }} Juta</div>
            </div>
        </div>
    </div>

    
    <div class="row g-4">
        
        
        <div class="col-lg-6">
            <div class="section-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="section-title m-0">Pembayaran Terbaru</h5>
                    <a href="{{ route('admin.payments') }}" class="text-primary text-decoration-none" style="font-size: 0.85rem; font-weight: 500;">
                        Lihat semua <i class="bi bi-arrow-up-right"></i>
                    </a>
                </div>
                
                <div class="payment-list">
                    @forelse($recentPayments as $i => $payment)
                    @php
                        
                        $words = explode(' ', $payment->student_name);
                        $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                        
                        $avatarClass = 'avatar-' . (($i % 3) + 1);
                    @endphp
                    <div class="payment-item">
                        <div class="avatar {{ $avatarClass }}">{{ $initials }}</div>
                        <div class="ms-3 flex-grow-1">
                            <h6 class="m-0 mb-1" style="font-size: 0.95rem; font-weight: 600;">{{ $payment->student_name }}</h6>
                            <p class="m-0 text-muted" style="font-size: 0.75rem;">{{ $payment->paid_at ? $payment->paid_at->diffForHumans() : '-' }}</p>
                        </div>
                        <div class="text-success fw-bold">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-3" style="font-size: 0.85rem;">
                        Belum ada pembayaran masuk.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        
        <div class="col-lg-6">
            <div class="section-card">
                <h5 class="section-title mb-4">Status Pembayaran</h5>
                
                <div class="progress-wrapper">
                    <div class="progress-label">
                        <span class="text-secondary">Lunas Bulan Ini</span>
                        <span class="text-success">{{ $paidPerc }}%</span>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill fill-green" style="width: {{ $paidPerc }}%;"></div>
                    </div>
                </div>

                <div class="progress-wrapper">
                    <div class="progress-label">
                        <span class="text-secondary">Menunggu Verifikasi</span>
                        <span class="text-warning">{{ $pendingPerc }}%</span>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill fill-orange" style="width: {{ $pendingPerc }}%;"></div>
                    </div>
                </div>

                <div class="progress-wrapper">
                    <div class="progress-label">
                        <span class="text-secondary">Belum Lunas</span>
                        <span class="text-danger">{{ $unpaidPerc }}%</span>
                    </div>
                    <div class="progress-bar-custom">
                        <div class="progress-fill fill-red" style="width: {{ $unpaidPerc }}%;"></div>
                    </div>
                </div>

                
                <div class="alert-card mt-4">
                    <div class="alert-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div>
                        <h6 class="m-0 mb-1" style="color: #1e3a8a; font-weight: 700; font-size: 0.95rem;">Kemajuan Bagus!</h6>
                        <p class="m-0" style="color: #3b82f6; font-size: 0.8rem;">Tingkat pengumpulan pembayaran meningkat 15% dibanding bulan lalu.</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
