@extends('layouts.admin')

@section('title', 'Konfigurasi SPP')

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
        padding: 28px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }

    .config-subtitle {
        font-size: 0.9rem;
        color: #64748b;
        margin-bottom: 2rem;
        line-height: 1.7;
    }
    .config-subtitle span {
        color: #f97316;
        font-weight: 500;
    }

    
    .grade-row {
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 16px;
        transition: box-shadow 0.2s;
    }
    .grade-row:hover {
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }

    .form-label-custom {
        font-size: 0.75rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
        display: block;
    }

    .form-input-custom {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 16px;
        width: 100%;
        font-size: 0.95rem;
        color: #0f172a;
        background-color: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
    }
    .form-input-custom:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 3px rgba(147, 197, 253, 0.2);
    }
    .form-input-custom[readonly] {
        background-color: #f8fafc;
        color: #64748b;
    }

    
    .additional-box {
        background-color: #eff6ff;
        border-radius: 12px;
        padding: 24px;
        margin-top: 24px;
        border: 1px solid #dbeafe;
    }
    .additional-title {
        font-size: 1rem;
        font-weight: 700;
        color: #1e3a8a;
        margin-bottom: 16px;
    }

    
    .actions-row {
        display: flex;
        gap: 12px;
        margin-top: 28px;
    }
    .btn-reset {
        background: white;
        border: 1px solid #e2e8f0;
        color: #475569;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 8px;
        transition: all 0.2s;
    }
    .btn-reset:hover {
        background-color: #f8fafc;
    }
    .btn-save {
        background-color: #1e3a8a;
        color: white;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 8px;
        border: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background-color 0.2s;
    }
    .btn-save:hover {
        background-color: #172554;
        color: white;
    }
</style>

<div>
    <h2 class="page-title">Konfigurasi Biaya SPP Bulanan</h2>

    <div class="main-card">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <p class="config-subtitle">
            Tetapkan tarif SPP <span>bulanan</span> untuk <span>setiap jenjang kelas</span>. Perubahan akan berlaku bagi semua siswa di kelas yang bersangkutan.
        </p>

        <form action="{{ route('admin.settings') }}" method="POST">
            @csrf

            
            @php
                $gradeX   = $settings->get('Grade X');
                $gradeXI  = $settings->get('Grade XI');
                $gradeXII = $settings->get('Grade XII');
                $latePenalty  = $gradeX ? $gradeX->late_penalty : 5;
                $deadline     = $gradeX ? $gradeX->payment_deadline : 10;
            @endphp

            <div class="grade-row">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label-custom">Jenjang Kelas</label>
                        <input type="text" class="form-input-custom" value="Kelas X" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Biaya Bulanan (Rp)</label>
                        <input type="number" name="monthly_fee_grade_x" class="form-input-custom"
                               value="{{ $gradeX ? $gradeX->monthly_fee : 500000 }}" required>
                    </div>
                </div>
            </div>

            <div class="grade-row">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label-custom">Jenjang Kelas</label>
                        <input type="text" class="form-input-custom" value="Kelas XI" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Biaya Bulanan (Rp)</label>
                        <input type="number" name="monthly_fee_grade_xi" class="form-input-custom"
                               value="{{ $gradeXI ? $gradeXI->monthly_fee : 550000 }}" required>
                    </div>
                </div>
            </div>

            <div class="grade-row">
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label-custom">Jenjang Kelas</label>
                        <input type="text" class="form-input-custom" value="Kelas XII" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Biaya Bulanan (Rp)</label>
                        <input type="number" name="monthly_fee_grade_xii" class="form-input-custom"
                               value="{{ $gradeXII ? $gradeXII->monthly_fee : 600000 }}" required>
                    </div>
                </div>
            </div>

            
            <div class="additional-box">
                <p class="additional-title">Pengaturan Biaya Tambahan</p>
                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label-custom">Denda Keterlambatan (%)</label>
                        <input type="number" name="late_penalty" class="form-input-custom"
                               value="{{ $latePenalty }}" min="0" max="100" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Batas Tanggal Pembayaran (Tanggal per Bulan)</label>
                        <input type="number" name="payment_deadline" class="form-input-custom"
                               value="{{ $deadline }}" min="1" max="31" required>
                    </div>
                </div>
            </div>

            
            <div class="actions-row">
                <button type="reset" class="btn btn-reset">Batalkan Perubahan</button>
                <button type="submit" class="btn btn-save">
                    <i class="bi bi-floppy"></i> Simpan Konfigurasi
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
