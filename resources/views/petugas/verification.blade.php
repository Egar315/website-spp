@extends('layouts.petugas')

@section('title', 'Verifikasi Pembayaran')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }
    .page-title { font-weight: 800; color: #0f172a; margin: 0; font-size: 1.6rem; }
    .page-subtitle { color: #64748b; font-size: 0.9rem; margin-top: 4px; }

    .pending-badge {
        background: linear-gradient(135deg, #f97316, #fb923c);
        color: white;
        border-radius: 14px;
        padding: 10px 18px;
        text-align: center;
        font-weight: 700;
        box-shadow: 0 6px 20px rgba(249,115,22,0.35);
        min-width: 90px;
    }
    .pending-badge .label { font-size: 0.75rem; opacity: 0.9; font-weight: 500; }
    .pending-badge .count { font-size: 1.75rem; line-height: 1; }

    
    .filter-row {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        align-items: center;
    }
    .search-group { flex-grow: 1; position: relative; }
    .search-group i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
    .search-group input {
        border: 1px solid #e2e8f0;
        border-radius: 50rem;
        padding: 10px 16px 10px 44px;
        width: 100%;
        font-size: 0.9rem;
        outline: none;
        transition: border-color 0.2s;
    }
    .search-group input:focus { border-color: #93c5fd; }
    .btn-filter {
        background: white;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-weight: 600;
        font-size: 0.88rem;
        padding: 9px 20px;
        border-radius: 50rem;
        display: flex; align-items: center; gap: 6px;
        transition: background 0.2s;
    }
    .btn-filter:hover { background: #f8fafc; }

    
    .payment-card {
        background: white;
        border-radius: 16px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        padding: 0;
        margin-bottom: 16px;
        overflow: hidden;
        display: flex;
        align-items: stretch;
        transition: box-shadow 0.2s;
    }
    .payment-card:hover { box-shadow: 0 6px 20px rgba(0,0,0,0.08); }

    
    .receipt-thumb {
        width: 120px;
        min-height: 140px;
        background: #f8fafc;
        border-right: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
        position: relative;
    }
    .receipt-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .receipt-thumb .no-img {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        color: #cbd5e1; font-size: 2rem; gap: 4px;
    }
    .receipt-thumb .no-img span { font-size: 0.65rem; color: #94a3b8; font-weight: 500; }
    .receipt-icon-badge {
        position: absolute;
        top: 8px; left: 8px;
        background: #3b82f6;
        color: white;
        border-radius: 50%;
        width: 24px; height: 24px;
        display: flex; align-items: center; justify-content: center;
        font-size: 0.75rem;
    }

    
    .card-body-custom {
        flex-grow: 1;
        padding: 20px 24px;
        display: grid;
        grid-template-columns: 1.8fr 1.2fr 1.5fr auto;
        gap: 16px;
        align-items: center;
    }

    .info-label {
        font-size: 0.7rem;
        color: #94a3b8;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
    }
    .info-value.amount {
        font-size: 1rem;
        font-weight: 800;
        color: #16a34a;
    }
    .student-avatar {
        width: 36px; height: 36px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 1rem;
        flex-shrink: 0;
    }
    .timestamp {
        display: flex; align-items: center; gap: 4px;
        font-size: 0.75rem;
        color: #94a3b8;
        margin-top: 6px;
    }
    .bank-icon {
        color: #3b82f6;
        font-size: 0.9rem;
    }

    
    .action-col {
        display: flex;
        flex-direction: column;
        gap: 8px;
        min-width: 110px;
    }
    .btn-approve {
        background: #16a34a;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 0.85rem;
        display: flex; align-items: center; justify-content: center; gap: 6px;
        transition: background 0.2s;
    }
    .btn-approve:hover { background: #15803d; color: white; }
    .btn-reject {
        background: white;
        color: #ef4444;
        border: 1.5px solid #fca5a5;
        border-radius: 8px;
        padding: 7px 16px;
        font-weight: 600;
        font-size: 0.85rem;
        display: flex; align-items: center; justify-content: center; gap: 6px;
        transition: all 0.2s;
    }
    .btn-reject:hover { background: #fef2f2; border-color: #ef4444; }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #94a3b8;
    }
    .empty-state i { font-size: 3rem; margin-bottom: 12px; display: block; }
</style>

<div>
    
    <div class="page-header">
        <div>
            <h2 class="page-title">Verifikasi Pembayaran</h2>
            <p class="page-subtitle">Tinjau dan verifikasi bukti pembayaran siswa</p>
        </div>
        <div class="pending-badge">
            <div class="label">Menunggu</div>
            <div class="count">{{ $total_pending }}</div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4 p-4" role="alert" style="border-radius: 16px; border: none; background: #ecfdf5; color: #065f46; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                        <i class="bi bi-check-lg" style="font-size: 1.2rem;"></i>
                    </div>
                    <div>
                        <h4 class="alert-heading mb-1" style="font-weight: 800; font-size: 1.1rem;">Berhasil!</h4>
                        <p class="mb-0" style="font-size: 0.9rem; opacity: 0.9;">{{ session('success') }}</p>
                    </div>
                </div>
                @if(session('payment_id'))
                    <a href="{{ route('petugas.invoice', session('payment_id')) }}" 
                       target="_blank"
                       class="btn btn-success d-flex align-items-center gap-2" 
                       style="border-radius: 10px; font-weight: 700; padding: 10px 20px;">
                        <i class="bi bi-printer-fill"></i> Cetak Kwitansi
                    </a>
                @endif
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" style="top: 1.2rem; right: 1.2rem;"></button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show mb-3" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    
    <div class="filter-row">
        <div class="search-group">
            <i class="bi bi-search"></i>
            <input type="text" placeholder="Cari nama siswa atau NISN...">
        </div>
        <button class="btn btn-filter">
            <i class="bi bi-funnel"></i> Filter
        </button>
    </div>

    
    @forelse($pending as $payment)
    <div class="payment-card">
        
        <div class="receipt-thumb">
            @if($payment->receipt_img)
                <span class="receipt-icon-badge"><i class="bi bi-image"></i></span>
                <img src="{{ asset('storage/'.$payment->receipt_img) }}"
                     alt="Bukti"
                     style="width:100%;height:100%;object-fit:cover;cursor:pointer;"
                     data-bs-toggle="modal" data-bs-target="#lightboxModal"
                     data-img="{{ asset('storage/'.$payment->receipt_img) }}"
                     title="Klik untuk perbesar">
            @else
                <span class="receipt-icon-badge"><i class="bi bi-file-earmark-image"></i></span>
                <div class="no-img">
                    <i class="bi bi-receipt"></i>
                    <span>Tidak Ada Foto</span>
                </div>
            @endif
        </div>

        
        <div class="card-body-custom">

            
            <div>
                <div class="info-label">Siswa</div>
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="student-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div>
                        <div class="info-value">{{ $payment->student_name }}</div>
                        <div style="font-size: 0.78rem; color: #64748b;">{{ $payment->class_name }}</div>
                    </div>
                </div>
                <div class="info-label mt-2">NISN</div>
                <div style="font-size: 0.85rem; font-weight: 600; color: #475569;">{{ $payment->nisn }}</div>
            </div>

            
            <div>
                <div class="info-label">Pembayaran</div>
                <div style="font-size: 0.78rem; color: #64748b; margin-bottom: 4px;">Bulan</div>
                <div class="info-value mb-1">{{ $payment->month }}</div>
                <div style="font-size: 0.78rem; color: #64748b; margin-bottom: 4px;">Jumlah</div>
                <div class="info-value amount">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
            </div>

            
            <div>
                <div class="info-label">Detail Transfer</div>
                <div style="font-size: 0.78rem; color: #64748b;">Bank</div>
                <div class="d-flex align-items-center gap-1 mb-1">
                    <i class="bi bi-credit-card bank-icon"></i>
                    <div class="info-value">{{ $payment->bank }}</div>
                </div>
                <div style="font-size: 0.78rem; color: #64748b;">Pengirim</div>
                <div class="info-value mb-1">{{ $payment->sender_name }}</div>
                <div class="timestamp">
                    <i class="bi bi-clock"></i>
                    {{ $payment->paid_at ? $payment->paid_at->format('d M Y • H:i') : '-' }}
                </div>
            </div>

            
            <div class="action-col">
                <form action="{{ route('petugas.approve', $payment) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-approve w-100">
                        <i class="bi bi-check-lg"></i> Setujui
                    </button>
                </form>
                <form action="{{ route('petugas.reject', $payment) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-reject w-100">
                        <i class="bi bi-x-lg"></i> Tolak
                    </button>
                </form>
            </div>

        </div>
    </div>
    @empty
    <div class="empty-state">
        <i class="bi bi-inbox"></i>
        <h5 style="color: #64748b; font-weight: 700;">Tidak ada pembayaran yang menunggu verifikasi</h5>
        <p style="font-size: 0.9rem;">Semua pembayaran sudah diproses.</p>
    </div>
    @endforelse
</div>


@section('modals')
<div class="modal fade" id="lightboxModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content" style="background: transparent; border: none; box-shadow: none;">
      <div class="modal-body text-center p-0">
        <img id="lightbox-img" src="" alt="Bukti Transfer"
             style="max-width:100%; max-height:80vh; border-radius: 16px; box-shadow: 0 24px 60px rgba(0,0,0,0.6);">
        <div class="mt-3">
            <button type="button" class="btn btn-light rounded-pill px-4 fw-600" data-bs-dismiss="modal">
                <i class="bi bi-x-lg me-1"></i> Tutup
            </button>
        </div>
      </div>
    </div>
  </div>
</div>

</div>
@endsection

<script>
    document.getElementById('lightboxModal').addEventListener('show.bs.modal', function(e) {
        const img = e.relatedTarget;
        document.getElementById('lightbox-img').src = img.dataset.img;
    });
</script>
@endsection
