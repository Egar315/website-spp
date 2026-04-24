@extends('layouts.admin')

@section('title', 'Semua Pembayaran')

@section('content')
<style>
    .page-title {
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 1.5rem;
    }
    
    .main-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .filters-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        gap: 16px;
    }

    .search-input-group {
        position: relative;
        flex-grow: 1;
        max-width: 500px;
    }
    .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
    }
    .search-input {
        border-radius: 50rem;
        padding-left: 44px;
        border: 1px solid #e2e8f0;
        background-color: #fff;
    }
    .search-input:focus {
        border-color: #cbd5e1;
        box-shadow: none;
    }

    .filter-selects {
        display: flex;
        gap: 12px;
    }
    .form-select-custom {
        border-radius: 50rem;
        border: 1px solid #e2e8f0;
        padding-left: 16px;
        padding-right: 36px;
        color: #475569;
        background-color: #fff;
    }
    
    .table-custom {
        width: 100%;
        margin: 0;
    }
    .table-custom th {
        color: #64748b;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 16px;
        border-bottom: 1px solid #f1f5f9;
        border-top: none;
        background-color: #f8fafc;
    }
    .table-custom td {
        padding: 16px;
        vertical-align: middle;
        color: #334155;
        font-weight: 600;
        font-size: 0.9rem;
        border-bottom: 1px solid #f1f5f9;
    }

    .val-text {
        font-weight: 400;
        color: #64748b;
    }
    
    .status-pill {
        padding: 4px 16px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
    }
    .pill-diterima {
        background-color: #dcfce7;
        color: #16a34a;
    }
    .pill-menunggu {
        background-color: #fef3c7;
        color: #d97706;
    }
    .pill-ditolak {
        background-color: #fee2e2;
        color: #ef4444;
    }
    
    .table-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 24px;
    }
    .showing-text {
        color: #64748b;
        font-size: 0.85rem;
    }
    .pagination-custom {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .pagination-custom .pagination {
        margin: 0;
        gap: 8px;
    }
    .pagination-custom .page-item .page-link {
        border-radius: 50rem;
        color: #475569;
        font-weight: 600;
        border: 1px solid #e2e8f0;
        padding: 6px 14px;
        transition: all 0.2s;
    }
    .pagination-custom .page-item.active .page-link {
        background-color: #1e3a8a;
        border-color: #1e3a8a;
        color: white;
    }
    .pagination-custom .page-item:not(.active) .page-link:hover {
        background-color: #f8fafc;
        color: #0f172a;
    }
</style>

<div>
    <h2 class="page-title">Riwayat Semua Pembayaran</h2>

    <div class="main-card">
        <form action="{{ route('admin.payments') }}" method="GET" class="filters-wrapper">
            <div class="search-input-group">
                <i class="bi bi-search search-icon"></i>
                <input type="text" name="search" class="form-control py-2 search-input" placeholder="Cari berdasarkan NISN atau nama siswa..." value="{{ request('search') }}">
            </div>
            
            <div class="filter-selects">
                <select name="status" class="form-select py-2 form-select-custom" style="width: auto;" onchange="this.form.submit()">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                    <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                    <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>WAKTU</th>
                        <th>SISWA</th>
                        <th>PEMBAYARAN</th>
                        <th>NOMINAL</th>
                        <th>METODE</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td class="val-text">{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d M Y, H:i') : '-' }}</td>
                        <td>
                            <div>{{ $payment->student_name }}</div>
                            <div style="font-size: 0.75rem; color: #64748b; font-weight: 400;">NISN: {{ $payment->nisn }}</div>
                        </td>
                        <td class="val-text">SPP {{ $payment->month }}</td>
                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td class="val-text">{{ $payment->bank }}</td>
                        <td>
                            @if($payment->status === 'diterima')
                                <span class="status-pill pill-diterima"><i class="bi bi-check-circle me-1"></i> Diterima</span>
                            @elseif($payment->status === 'menunggu')
                                <span class="status-pill pill-menunggu"><i class="bi bi-clock-history me-1"></i> Menunggu</span>
                            @else
                                <span class="status-pill pill-ditolak"><i class="bi bi-x-circle me-1"></i> Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if($payment->status === 'diterima')
                                <a href="{{ route('petugas.invoice', $payment) }}" target="_blank" class="btn btn-sm btn-light border" title="Cetak Kwitansi">
                                    <i class="bi bi-printer text-primary"></i>
                                </a>
                            @else
                                <button class="btn btn-sm btn-light border" disabled title="Hanya untuk pembayaran yang diterima">
                                    <i class="bi bi-printer text-muted"></i>
                                </button>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Belum ada riwayat pembayaran.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div class="showing-text">
                Menampilkan {{ $payments->firstItem() ?? 0 }} sampai {{ $payments->lastItem() ?? 0 }} dari {{ $payments->total() }} pembayaran
            </div>
            
            <div class="pagination-custom">
                {{ $payments->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
