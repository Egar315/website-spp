@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('content')
<style>
    .section-title { font-weight: 700; color: #1e293b; font-size: 1.4rem; margin-bottom: 1.5rem; letter-spacing: -0.5px; }

    
    .overview-card {
        background: white;
        border-radius: 8px;
        padding: 24px;
        border: 1px solid #e2e8f0;
        height: 100%;
        position: relative;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .overview-label { font-size: 0.85rem; color: #94a3b8; font-weight: 500; margin-bottom: 8px; }
    .overview-value { font-size: 1.5rem; font-weight: 600; color: #0f172a; margin-bottom: 28px; }
    .overview-value.text-red { color: #dc2626; }
    
    .status-badge {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 12px 16px; border-radius: 8px;
        font-size: 0.85rem; font-weight: 600; width: 100%;
    }
    .status-badge.verified { background: #f0fdf4; color: #16a34a; }
    .status-badge.unverified { background: #fef2f2; color: #ef4444; }
    
    .icon-circle {
        position: absolute; right: 24px; top: 24px;
        width: 32px; height: 32px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; border: 2px solid;
    }
    .icon-circle.green { color: #10b981; border-color: #10b981; }
    .icon-circle.red { color: #ef4444; border-color: #ef4444; }

    .bottom-text { font-size: 0.8rem; color: #64748b; margin-top: 28px; }

    
    .history-container {
        background: white;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        margin-top: 24px;
        padding: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }
    .history-title { font-weight: 600; color: #334155; font-size: 1.05rem; margin-bottom: 20px; }

    .table th { font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; letter-spacing: 0.5px; padding: 16px 8px; border-bottom: 1px solid #f1f5f9; background: transparent; }
    .table td { padding: 18px 8px; border-bottom: 1px solid #f8fafc; font-weight: 500; font-size: 0.9rem; color: #334155; vertical-align: middle; }
    
    .badge-paid { background: #dcfce7; color: #16a34a; padding: 6px 16px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block;}
    .badge-unpaid { background: #fee2e2; color: #ef4444; padding: 6px 16px; border-radius: 20px; font-size: 0.75rem; font-weight: 600; display: inline-block;}
</style>

<div>
    <h2 class="section-title">Ringkasan Tagihan</h2>

    <div class="row g-4">
        
        <div class="col-md-6">
            <div class="overview-card">
                <div class="overview-label">Status Bulan Ini</div>
                <div class="overview-value">{{ $currentMonth }}</div>
                
                @if($paymentThisMonth && $paymentThisMonth->status === 'diterima')
                    <div class="icon-circle green">
                        <i class="bi bi-check"></i>
                    </div>
                    <div class="status-badge verified mt-4">
                        <i class="bi bi-check2"></i> Pembayaran Terverifikasi
                    </div>
                @else
                    <div class="icon-circle red">
                        <i class="bi bi-exclamation"></i>
                    </div>
                    <div class="status-badge unverified mt-4">
                        <i class="bi bi-info-circle"></i> Belum Lunas / Menunggu
                    </div>
                @endif
            </div>
        </div>

        
        <div class="col-md-6">
            <div class="overview-card">
                <div class="overview-label">Total Tunggakan</div>
                <div class="overview-value text-red">Rp {{ number_format($totalOutstanding, 0, ',', '.') }}</div>
                
                <div class="icon-circle red">
                    <i class="bi bi-calendar-x"></i>
                </div>
                
                <div style="max-height: 120px; overflow-y: auto;">
                    <p style="font-size: 0.75rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; margin-bottom: 8px;">Daftar Tunggakan:</p>
                    <div class="d-flex flex-wrap gap-1">
                        @forelse($unpaidMonthsList as $m)
                            <span class="badge bg-light text-dark border" style="font-size: 0.7rem;">
                                {{ $m['month'] }} 
                                @if($m['penalty'] > 0)
                                    <span class="text-danger" title="Denda">+Denda</span>
                                @endif
                            </span>
                        @empty
                            <span class="text-success" style="font-size: 0.8rem;">Sempurna! Tidak ada tunggakan.</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="history-container">
        <div class="history-title">Riwayat Pembayaran ({{ now()->year }})</div>
        <table class="table mb-0">
            <thead>
                <tr>
                    <th class="border-0 border-bottom">BULAN</th>
                    <th class="border-0 border-bottom">JUMLAH</th>
                    <th class="border-0 border-bottom">STATUS</th>
                </tr>
            </thead>
            <tbody>
                @if($history->count() > 0)
                    @foreach($history as $h)
                    <tr>
                        <td class="border-0 border-bottom">{{ $h->month }}</td>
                        <td class="border-0 border-bottom">Rp {{ number_format($h->amount, 0, ',', '.') }}</td>
                        <td class="border-0 border-bottom">
                            @if($h->status === 'diterima')   
                                <span class="badge-paid">Lunas</span>
                            @else 
                                <span class="badge-unpaid">Belum Lunas</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="3" class="text-center text-muted py-4">Belum ada riwayat pembayaran</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>
@endsection
