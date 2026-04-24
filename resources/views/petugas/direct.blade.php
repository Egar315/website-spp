@extends('layouts.petugas')

@section('title', 'Pembayaran Langsung')

@section('content')
<style>
    .page-title    { font-weight: 800; color: #0f172a; margin-bottom: 0.25rem; font-size: 1.6rem; }
    .page-subtitle { color: #64748b; font-size: 0.9rem; margin-bottom: 2rem; }

    .search-card {
        background: white;
        border-radius: 16px;
        padding: 28px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    .search-label {
        font-size: 0.8rem; font-weight: 700; color: #64748b;
        text-transform: uppercase; letter-spacing: 0.8px;
        margin-bottom: 12px;
    }
    .search-row { display: flex; gap: 12px; align-items: center; }
    .nisn-input {
        flex-grow: 1;
        border: 1.5px solid #e2e8f0; border-radius: 10px;
        padding: 11px 16px; font-size: 0.95rem; color: #1e293b;
        outline: none; transition: border-color 0.2s, box-shadow 0.2s;
        background: #f8fafc;
    }
    .nisn-input:focus { border-color: #93c5fd; box-shadow: 0 0 0 3px rgba(147,197,253,0.2); background: white; }
    .btn-search {
        background: linear-gradient(135deg, #1e3a8a, #2563eb);
        color: white; border: none; border-radius: 10px;
        padding: 11px 24px; font-weight: 700; font-size: 0.9rem;
        display: flex; align-items: center; gap: 8px;
        white-space: nowrap; transition: opacity 0.2s;
    }
    .btn-search:hover { opacity: 0.9; }

    
    .student-card {
        background: white; border-radius: 16px; padding: 24px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        margin-bottom: 20px; display: none;
    }
    .student-avatar {
        width: 52px; height: 52px;
        background: linear-gradient(135deg, #3b82f6, #1d4ed8);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 1.4rem; flex-shrink: 0;
    }
    .student-name  { font-size: 1.1rem; font-weight: 800; color: #0f172a; margin: 0; }
    .student-nisn  { font-size: 0.82rem; color: #64748b; }
    .info-chip {
        background: #f1f5f9; border-radius: 8px;
        padding: 6px 14px; font-size: 0.82rem; color: #475569; font-weight: 600;
        display: inline-flex; align-items: center; gap: 5px;
    }

    
    .form-card {
        background: white; border-radius: 16px; padding: 28px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        display: none;
    }
    .section-label {
        font-size: 0.75rem; font-weight: 700; color: #94a3b8;
        text-transform: uppercase; letter-spacing: 0.8px;
        margin-bottom: 14px; padding-bottom: 8px;
        border-bottom: 1px solid #f1f5f9;
    }
    .lbl { font-size: 0.82rem; font-weight: 600; color: #475569; margin-bottom: 6px; display: block; }
    .inp {
        border: 1.5px solid #e2e8f0; border-radius: 10px;
        padding: 10px 14px; width: 100%; font-size: 0.9rem; color: #1e293b;
        outline: none; transition: border-color 0.2s, box-shadow 0.2s;
    }
    .inp:focus { border-color: #93c5fd; box-shadow: 0 0 0 3px rgba(147,197,253,0.2); }
    .inp[readonly] { background: #f8fafc; color: #64748b; }

    .nominal-box {
        background: linear-gradient(135deg, #eff6ff, #dbeafe);
        border: 1px solid #bfdbfe; border-radius: 12px;
        padding: 14px 20px; margin-bottom: 20px;
        display: flex; align-items: center; justify-content: space-between;
    }
    .nominal-label { font-size: 0.78rem; color: #1e40af; font-weight: 600; }
    .nominal-value { font-size: 1.4rem; font-weight: 800; color: #1e3a8a; }

    .btn-submit {
        background: linear-gradient(135deg, #1e3a8a, #2563eb); color: white;
        border: none; border-radius: 10px; padding: 12px 28px;
        font-weight: 700; font-size: 0.95rem;
        display: inline-flex; align-items: center; gap: 8px;
        transition: opacity 0.2s;
    }
    .btn-submit:hover { opacity: 0.9; color: white; }

    
    .not-found-box {
        display: none;
        background: #fef2f2; border: 1px solid #fecaca; border-radius: 12px;
        padding: 14px 20px; color: #ef4444; font-weight: 600;
        font-size: 0.88rem; align-items: center; gap: 8px;
    }

    
    .spinner { display: none; width: 20px; height: 20px; border: 2px solid rgba(255,255,255,0.4); border-top-color: white; border-radius: 50%; animation: spin 0.7s linear infinite; }
    @keyframes spin { to { transform: rotate(360deg); } }
</style>

<div>
    <h2 class="page-title">Pembayaran Langsung</h2>
    <p class="page-subtitle">Cari siswa berdasarkan NISN, lalu catat pembayaran SPP secara tunai.</p>

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

    
    <div class="search-card">
        <p class="search-label"><i class="bi bi-search me-1"></i>Cari Siswa Berdasarkan NISN</p>
        <div class="search-row">
            <input type="text" id="nisn-input" class="nisn-input"
                   placeholder="Masukkan NISN siswa..."
                   maxlength="20" autofocus>
            <button type="button" class="btn-search" onclick="searchStudent()">
                <div class="spinner" id="spinner"></div>
                <i class="bi bi-search" id="search-icon"></i>
                Cari
            </button>
        </div>

        
        <div class="not-found-box mt-3" id="not-found-box">
            <i class="bi bi-exclamation-circle"></i>
            <span id="not-found-msg">Siswa tidak ditemukan.</span>
        </div>
    </div>

    
    <div class="student-card" id="student-card">
        <div class="d-flex align-items-center gap-3 mb-3">
            <div class="student-avatar"><i class="bi bi-person-fill"></i></div>
            <div>
                <p class="student-name" id="res-name">-</p>
                <span class="student-nisn">NISN: <strong id="res-nisn">-</strong></span>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <span class="info-chip"><i class="bi bi-mortarboard"></i> <span id="res-class">-</span></span>
            <span class="info-chip"><i class="bi bi-calendar3"></i> Tahun <span id="res-year">-</span></span>
        </div>
    </div>

    
    <div class="form-card" id="form-card">
        <div class="nominal-box" id="nominal-box" style="display:none;">
            <div>
                <div class="nominal-label"><i class="bi bi-info-circle me-1"></i>Total Tunggakan</div>
                <div class="nominal-value" id="total-debt-display">-</div>
            </div>
            <i class="bi bi-cash-stack text-primary" style="font-size: 1.8rem; opacity: 0.6;"></i>
        </div>

        <div id="unpaid-section" style="display:none; margin-bottom: 24px;">
            <p class="section-label">Bulan Yang Belum Dibayar</p>
            <div id="unpaid-list" class="d-flex flex-wrap gap-2"></div>
        </div>

        <form action="{{ route('petugas.direct') }}" method="POST">
            @csrf
            <input type="hidden" name="nisn" id="f-nisn">
            <input type="hidden" name="student_name" id="f-name">
            <input type="hidden" name="class_name" id="f-class">

            <p class="section-label">Detail Pembayaran</p>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="lbl">Nama Siswa</label>
                    <input type="text" id="display-name" class="inp" readonly>
                </div>
                <div class="col-md-6">
                    <label class="lbl">Kelas</label>
                    <input type="text" id="display-class" class="inp" readonly>
                </div>
                <div class="col-md-6">
                    <label class="lbl">Bulan Pembayaran</label>
                    <input type="text" name="month" id="f-month" class="inp" readonly>
                </div>
                <div class="col-md-6">
                    <label class="lbl">Jumlah Bayar (Rp)</label>
                    <input type="number" name="amount" id="f-amount" class="inp" required min="1"
                           placeholder="Masukkan nominal...">
                </div>
                <div class="col-md-6">
                    <label class="lbl">Metode / Bank</label>
                    <select name="bank" class="inp" required>
                        <option value="" disabled selected>Pilih metode</option>
                        <option value="Tunai">Tunai (Cash)</option>
                        <option value="BCA">Transfer - BCA</option>
                        <option value="Mandiri">Transfer - Mandiri</option>
                        <option value="BRI">Transfer - BRI</option>
                        <option value="BNI">Transfer - BNI</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="lbl">Nama Penyetor</label>
                    <input type="text" name="sender_name" id="f-sender" class="inp" required
                           placeholder="Nama penyetor...">
                </div>
            </div>

            <div class="d-flex gap-3">
                <button type="button" class="btn btn-light" style="border-radius:10px; font-weight:600; padding:11px 22px;"
                        onclick="resetForm()">
                    <i class="bi bi-arrow-left me-1"></i> Cari Siswa Lain
                </button>
                <button type="submit" class="btn-submit">
                    <i class="bi bi-check-circle"></i> Catat Pembayaran
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const searchUrl = '{{ route("petugas.search-student") }}';

    function searchStudent() {
        const nisn = document.getElementById('nisn-input').value.trim();
        if (!nisn) return;

        
        document.getElementById('spinner').style.display = 'block';
        document.getElementById('search-icon').style.display = 'none';
        document.getElementById('not-found-box').style.display = 'none';
        document.getElementById('student-card').style.display = 'none';
        document.getElementById('form-card').style.display = 'none';

        fetch(`${searchUrl}?nisn=${encodeURIComponent(nisn)}`)
            .then(r => r.json())
            .then(data => {
                document.getElementById('spinner').style.display = 'none';
                document.getElementById('search-icon').style.display = 'block';

                if (!data.found) {
                    document.getElementById('not-found-msg').textContent = data.message;
                    document.getElementById('not-found-box').style.display = 'flex';
                    return;
                }

                
                document.getElementById('res-name').textContent  = data.name;
                document.getElementById('res-nisn').textContent  = data.nisn;
                document.getElementById('res-class').textContent = data.class_name;
                document.getElementById('res-year').textContent  = data.academic_year;
                document.getElementById('student-card').style.display = 'block';

                
                document.getElementById('f-nisn').value  = data.nisn;
                document.getElementById('f-name').value  = data.name;
                document.getElementById('f-class').value = data.class_name;
                document.getElementById('display-name').value  = data.name;
                document.getElementById('display-class').value = data.class_name;
                document.getElementById('f-sender').value = data.name;

                
                // Debt info
                document.getElementById('total-debt-display').textContent = 
                    'Rp ' + parseInt(data.total_debt).toLocaleString('id-ID');
                document.getElementById('nominal-box').style.display = 'flex';

                // Unpaid months list
                const list = document.getElementById('unpaid-list');
                list.innerHTML = '';
                
                if (data.unpaid_months.length > 0) {
                    data.unpaid_months.forEach((m, index) => {
                        const btn = document.createElement('button');
                        btn.type = 'button';
                        btn.className = 'btn btn-outline-primary btn-sm rounded-pill px-3';
                        if (index === 0) btn.className += ' active';
                        btn.innerHTML = `${m.month} ${m.penalty > 0 ? '<span class="badge bg-danger ms-1">Denda</span>' : ''}`;
                        btn.onclick = () => selectMonth(m, btn);
                        list.appendChild(btn);
                    });

                    // Auto select first month
                    selectMonth(data.unpaid_months[0]);
                    document.getElementById('unpaid-section').style.display = 'block';
                } else {
                    document.getElementById('unpaid-section').style.display = 'none';
                }

                document.getElementById('form-card').style.display = 'block';
            })
            .catch(() => {
                document.getElementById('spinner').style.display = 'none';
                document.getElementById('search-icon').style.display = 'block';
                document.getElementById('not-found-msg').textContent = 'Terjadi kesalahan jaringan, coba lagi.';
                document.getElementById('not-found-box').style.display = 'flex';
            });
    }

    function selectMonth(data, btn = null) {
        if (btn) {
            document.querySelectorAll('#unpaid-list button').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }
        document.getElementById('f-month').value = data.month;
        document.getElementById('f-amount').value = data.total;
        
        // Update display or add info about penalty
        if (data.penalty > 0) {
            // Optional: show penalty info
        }
    }

    
    document.getElementById('nisn-input').addEventListener('keydown', function(e) {
        if (e.key === 'Enter') searchStudent();
    });

    function resetForm() {
        document.getElementById('nisn-input').value = '';
        document.getElementById('nisn-input').focus();
        document.getElementById('student-card').style.display = 'none';
        document.getElementById('form-card').style.display = 'none';
        document.getElementById('not-found-box').style.display = 'none';
    }
</script>
@endsection
