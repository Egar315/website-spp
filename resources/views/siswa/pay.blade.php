@extends('layouts.siswa')

@section('title', 'Kirim Pembayaran')

@section('content')
<style>
    .section-title { font-weight: 700; color: #1e293b; font-size: 1.4rem; margin-bottom: 1.5rem; letter-spacing: -0.5px; }

    .main-container {
        background: white; border-radius: 8px; padding: 24px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0,0,0,0.02);
    }

    
    .section-label {
        font-size: 0.9rem; font-weight: 600; color: #1e293b; margin-bottom: 12px;
    }
    .bank-box {
        background: #f8fafc; border-radius: 8px; padding: 16px;
    }
    .bank-label { font-size: 0.75rem; color: #94a3b8; margin-bottom: 4px; }
    .bank-value { font-size: 0.95rem; font-weight: 600; color: #0f172a; }

    
    .lbl { font-size: 0.85rem; font-weight: 500; color: #475569; margin-bottom: 8px; display: block; }
    .inp {
        border: 1px solid #cbd5e1; border-radius: 8px;
        padding: 10px 14px; width: 100%; font-size: 0.9rem; color: #334155;
        outline: none; transition: border-color 0.2s; background: white;
    }
    .inp:focus { border-color: #94a3b8; }
    .inp::placeholder { color: #94a3b8; }

    
    .upload-box {
        border: 1.5px dashed #cbd5e1;
        border-radius: 8px;
        padding: 40px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }
    .upload-box:hover { border-color: #94a3b8; }
    .upload-box input[type=file] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .upload-icon { font-size: 2rem; color: #64748b; margin-bottom: 12px; }
    .upload-text  { font-size: 0.95rem; color: #1e293b; font-weight: 600; }
    .upload-text span { color: #3b82f6; }
    .upload-hint  { font-size: 0.8rem; color: #64748b; margin-top: 6px; }

    #preview-area { display: none; }
    #preview-img  { max-height: 150px; border-radius: 8px; object-fit: cover; }

    
    .btn-reset {
        background: white; border: 1px solid #cbd5e1; color: #475569;
        border-radius: 8px; padding: 10px 24px; font-weight: 600; font-size: 0.9rem;
        transition: background 0.2s;
    }
    .btn-reset:hover { background: #f8fafc; }
    
    .btn-submit {
        background: #8b9ab5; color: white;
        border: none; border-radius: 8px; padding: 10px 24px;
        font-weight: 600; font-size: 0.9rem;
        display: inline-flex; align-items: center; gap: 8px;
        transition: opacity 0.2s;
    }
    .btn-submit:hover { opacity: 0.9; color: white; }

    
    .custom-select-wrapper { position: relative; width: 100%; user-select: none; }
    .custom-select-display {
        border: 1px solid #cbd5e1; border-radius: 8px; padding: 10px 14px;
        background: white; cursor: pointer; display: flex; justify-content: space-between;
        align-items: center; color: #334155; font-size: 0.9rem; transition: all 0.2s;
    }
    .custom-select-display:hover { border-color: #94a3b8; }
    .custom-select-display.active { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.1); }
    .custom-select-options {
        position: absolute; top: 100%; left: 0; right: 0; margin-top: 8px;
        background: white; border-radius: 8px; border: 1px solid #e2e8f0;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); z-index: 100;
        display: none; overflow: hidden;
    }
    .custom-select-options.show { display: block; animation: fadeInDown 0.2s ease; }
    .custom-option {
        padding: 12px 16px; cursor: pointer; font-size: 0.9rem; color: #475569;
        transition: background 0.15s; border-bottom: 1px solid #f8fafc;
    }
    .custom-option:last-child { border-bottom: none; }
    .custom-option:hover { background: #f8fafc; color: #1e293b; }
    .custom-option.selected { background: #eff6ff; color: #2563eb; font-weight: 600; }
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-8px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div>
    <h2 class="section-title">Kirim Pembayaran</h2>

    <div class="main-container">
        
        @if(session('error'))
            <div class="alert alert-danger mb-4">{{ session('error') }}</div>
        @endif

        <div class="section-label">Detail Rekening Sekolah</div>
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <div class="bank-box">
                    <div class="bank-label">Nama Bank</div>
                    <div class="bank-value">Bank Mandiri</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bank-box">
                    <div class="bank-label">Nomor Rekening</div>
                    <div class="bank-value">1234567890</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="bank-box">
                    <div class="bank-label">Atas Nama</div>
                    <div class="bank-value">Sekolah Menengah Atas 1</div>
                </div>
            </div>
        </div>

        <form action="{{ route('siswa.pay') }}" method="POST" enctype="multipart/form-data" id="payment-form">
            @csrf

            <div class="mb-3">
                <label class="lbl">Bulan Pembayaran</label>
                @if($nextMonth)
                    <div class="inp bg-light d-flex justify-content-between align-items-center">
                        <span>{{ $nextMonth['month'] }}</span>
                        @if($nextMonth['is_late'])
                            <span class="badge bg-danger rounded-pill">Terlambat</span>
                        @endif
                    </div>
                    <input type="hidden" name="month" value="{{ $nextMonth['month'] }}">
                @else
                    <div class="alert alert-success d-flex align-items-center gap-2" style="border-radius: 8px;">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>Anda tidak memiliki tunggakan SPP!</span>
                    </div>
                @endif
            </div>

            @if($nextMonth)
            <div class="mb-3">
                <label class="lbl">Jumlah Pembayaran</label>
                <div class="p-3 border rounded-8 bg-light mb-2">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="text-muted">Biaya SPP Pokok:</span>
                        <span class="fw-bold">Rp {{ number_format($nextMonth['fee'], 0, ',', '.') }}</span>
                    </div>
                    @if($nextMonth['penalty'] > 0)
                        <div class="d-flex justify-content-between text-danger mb-1">
                            <span>Denda Keterlambatan:</span>
                            <span>+ Rp {{ number_format($nextMonth['penalty'], 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <hr class="my-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold text-dark">Total Bayar:</span>
                        <span class="fw-bold text-primary" style="font-size: 1.2rem;">Rp {{ number_format($nextMonth['total'], 0, ',', '.') }}</span>
                    </div>
                </div>
                <input type="hidden" name="amount" value="{{ $nextMonth['total'] }}">
            </div>
            @endif

            <div class="mb-3">
                <label class="lbl">Nama Bank (Asal Transfer)</label>
                <input type="text" name="bank" class="inp @error('bank') border-danger @enderror"
                       placeholder="Contoh: BCA, Mandiri, BNI..." value="{{ old('bank') }}" required>
                @error('bank')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label class="lbl">Nama Pengirim (Sesuai di Resi)</label>
                <input type="text" name="sender_name" class="inp @error('sender_name') border-danger @enderror"
                       placeholder="Masukkan nama pengirim..." value="{{ old('sender_name') }}" required>
                @error('sender_name')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>

            <div class="mb-4">
                <label class="lbl">Tanggal Transfer</label>
                <input type="text" class="inp" placeholder="dd/mm/yyyy">
                
            </div>

            <label class="lbl">Unggah Bukti Transfer</label>
            <div class="mb-4">
                <div class="upload-box" id="upload-box">
                    <input type="file" name="receipt" id="receipt-input" accept="image/*,.pdf" required>
                    <div id="upload-placeholder">
                        <div class="upload-icon"><i class="bi bi-upload"></i></div>
                        <div class="upload-text"><span>Klik untuk unggah</span> atau seret ke sini</div>
                        <div class="upload-hint">JPG, PNG, atau PDF (maks 5MB)</div>
                    </div>
                    <div id="preview-area">
                        <img id="preview-img" src="#" alt="Preview bukti">
                        <div class="upload-hint mt-2" id="preview-name"></div>
                    </div>
                </div>
                @error('receipt')<div class="text-danger small mt-2">{{ $message }}</div>@enderror
            </div>

            <div class="d-flex gap-3">
                <button type="button" class="btn-reset" onclick="document.getElementById('payment-form').reset(); document.getElementById('preview-area').style.display='none'; document.getElementById('upload-placeholder').style.display='block';">
                    Atur Ulang
                </button>
                <button type="submit" class="btn-submit">
                    <i class="bi bi-upload"></i> Kirim Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const input = document.getElementById('receipt-input');
    const placeholder = document.getElementById('upload-placeholder');
    const previewArea = document.getElementById('preview-area');
    const previewImg = document.getElementById('preview-img');
    const previewName = document.getElementById('preview-name');

    input.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            
            previewName.textContent = file.name;
            placeholder.style.display = 'none';
            previewArea.style.display = 'block';

            
            if(file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewImg.src = e.target.result;
                    previewImg.style.display = 'inline-block';
                };
                reader.readAsDataURL(file);
            } else {
                
                previewImg.style.display = 'none';
            }
        }
    });

    
    const display = document.getElementById('month-select-display');
    const optionsBox = document.getElementById('month-select-options');
    const monthInput = document.getElementById('month-input');
    const customOptions = document.querySelectorAll('.custom-option');

    display.addEventListener('click', (e) => {
        e.stopPropagation();
        optionsBox.classList.toggle('show');
        display.classList.toggle('active');
    });

    customOptions.forEach(opt => {
        opt.addEventListener('click', () => {
            const val = opt.getAttribute('data-value');
            display.querySelector('span').textContent = opt.textContent;
            monthInput.value = val;
            
            customOptions.forEach(o => o.classList.remove('selected'));
            opt.classList.add('selected');
            
            optionsBox.classList.remove('show');
            display.classList.remove('active');
        });
    });

    document.addEventListener('click', () => {
        optionsBox.classList.remove('show');
        display.classList.remove('active');
    });
</script>
@endsection
