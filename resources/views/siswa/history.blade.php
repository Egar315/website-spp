@extends('layouts.siswa')

@section('title', 'Riwayat Pembayaran')

@section('content')
<style>
    .page-title {
        font-weight: 700;
        color: #1e293b;
        font-size: 1.4rem;
        margin-bottom: 1.5rem;
        letter-spacing: -0.5px;
    }

    .history-card {
        background: white;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        overflow: hidden;
    }

    .table-custom {
        width: 100%;
        margin-bottom: 0;
    }

    .table-custom th {
        font-size: 0.75rem;
        text-transform: uppercase;
        color: #94a3b8;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 16px 24px;
        border-bottom: 1px solid #e2e8f0;
        background: #fafafa;
        border-top: none;
    }

    .table-custom td {
        padding: 20px 24px;
        border-bottom: 1px solid #f1f5f9;
        font-weight: 600;
        font-size: 0.9rem;
        color: #334155;
        vertical-align: middle;
    }

    .table-custom tr:last-child td {
        border-bottom: none;
    }

    
    .status-badge {
        padding: 6px 16px;
        border-radius: 50rem;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        border: 1px solid transparent;
        text-align: center;
        min-width: 90px;
    }

    .badge-success {
        background: #f0fdf4;
        color: #16a34a;
        border-color: #bbf7d0;
    }

    .badge-warning {
        background: #fffbeb;
        color: #d97706;
        border-color: #fde68a;
    }

    .badge-danger {
        background: #fef2f2;
        color: #ef4444;
        border-color: #fecaca;
    }

    .text-date {
        color: #64748b;
        font-weight: 500;
    }

    .view-reason {
        color: #ef4444;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        transition: opacity 0.2s;
        cursor: pointer;
    }
    .view-reason:hover {
        opacity: 0.8;
        color: #ef4444;
    }

    .table-footer {
        padding: 16px 24px;
        border-top: 1px solid #e2e8f0;
        background: #fafafa;
        color: #64748b;
        font-size: 0.85rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

<div>
    <h2 class="page-title">Riwayat Transaksi</h2>

    <div class="history-card">
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>BULAN</th>
                        <th>JUMLAH</th>
                        <th>TANGGAL KIRIM</th>
                        <th>STATUS</th>
                        <th>TANGGAL VERIFIKASI</th>
                        <th>DETAIL</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $p)
                    <tr>
                        <td>{{ $p->month }}</td>
                        <td>Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                        <td class="text-date">{{ $p->created_at->format('Y-m-d') }}</td>
                        <td>
                            @if($p->status === 'diterima')
                                <span class="status-badge badge-success">Berhasil</span>
                            @elseif($p->status === 'menunggu')
                                <span class="status-badge badge-warning">Menunggu</span>
                            @else
                                <span class="status-badge badge-danger">Ditolak</span>
                            @endif
                        </td>
                        <td class="text-date">{{ $p->paid_at ? $p->paid_at->format('Y-m-d') : '-' }}</td>
                        <td>
                            @if($p->status === 'ditolak')
                                <a href="#" class="view-reason">
                                    <i class="bi bi-eye"></i> Lihat Alasan
                                </a>
                            @elseif($p->status === 'diterima')
                                <a href="{{ route('petugas.invoice', $p) }}" target="_blank" class="btn btn-sm btn-outline-success" style="border-radius: 8px; font-weight: 600; font-size: 0.8rem;">
                                    <i class="bi bi-printer-fill me-1"></i> Cetak Bukti
                                </a>
                            @else
                                <span class="text-muted" style="font-size: 0.8rem;">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox" style="font-size:2rem; display:block; margin-bottom:8px;"></i>
                            Belum ada riwayat transaksi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div>Menampilkan {{ $payments->count() }} transaksi</div>
            @if($payments->hasPages())
                <div class="pagination-custom m-0">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
