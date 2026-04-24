<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran - {{ $payment->student_name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        .invoice-container {
            max-width: 800px;
            margin: 40px auto;
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }

        /* Decoration */
        .invoice-container::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 8px;
            background: linear-gradient(90deg, #2563eb, #3b82f6);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 40px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 30px;
        }

        .school-logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: #2563eb;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .school-info h1 {
            font-size: 1.5rem;
            font-weight: 800;
            margin: 0;
            color: #0f172a;
            letter-spacing: -0.5px;
        }

        .school-info p {
            font-size: 0.85rem;
            color: #64748b;
            margin: 2px 0 0 0;
        }

        .invoice-label {
            text-align: right;
        }

        .invoice-label h2 {
            font-size: 1.8rem;
            font-weight: 800;
            color: #2563eb;
            margin: 0;
            text-transform: uppercase;
        }

        .invoice-label p {
            font-size: 0.9rem;
            color: #64748b;
            margin: 5px 0 0 0;
            font-weight: 600;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 40px;
        }

        .info-section h3 {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            margin-bottom: 15px;
        }

        .info-item {
            margin-bottom: 8px;
            display: flex;
            font-size: 0.95rem;
        }

        .info-item span:first-child {
            width: 120px;
            color: #64748b;
            flex-shrink: 0;
        }

        .info-item span:last-child {
            font-weight: 600;
            color: #1e293b;
        }

        .payment-table {
            width: 100%;
            margin-bottom: 40px;
            border-collapse: separate;
            border-spacing: 0;
        }

        .payment-table th {
            background: #f8fafc;
            padding: 15px 20px;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
        }

        .payment-table td {
            padding: 20px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.95rem;
        }

        .amount-row {
            background: #f1f5f9;
        }

        .amount-row td {
            font-weight: 800;
            font-size: 1.2rem;
            color: #0f172a;
            border: none;
        }

        .footer {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-top: 60px;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            border-bottom: 1px solid #cbd5e1;
            margin-bottom: 10px;
            height: 80px;
        }

        .signature-name {
            font-weight: 700;
            font-size: 0.95rem;
        }

        .signature-title {
            font-size: 0.8rem;
            color: #64748b;
        }

        .no-print-zone {
            max-width: 800px;
            margin: 20px auto 0;
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        @media print {
            body { background: white; }
            .invoice-container {
                margin: 0;
                padding: 0;
                box-shadow: none;
                max-width: 100%;
            }
            .no-print-zone { display: none; }
        }

        .btn-print {
            background: #2563eb;
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 10px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }

        .btn-print:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
            color: white;
        }

        .btn-back {
            background: white;
            color: #64748b;
            border: 1px solid #e2e8f0;
            padding: 10px 25px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-back:hover {
            background: #f8fafc;
            color: #1e293b;
        }
    </style>
</head>
<body>

<div class="no-print-zone">
    <a href="{{ url()->previous() }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
    <button onclick="window.print()" class="btn-print">
        <i class="bi bi-printer-fill"></i> Cetak Kwitansi
    </button>
</div>

<div class="invoice-container">
    <div class="header">
        <div class="school-logo">
            <div class="logo-icon"><i class="bi bi-mortarboard-fill"></i></div>
            <div class="school-info">
                <h1>Prestasi Prima</h1>
                <p>Sistem Informasi Pembayaran SPP Sekolah</p>
            </div>
        </div>
        <div class="invoice-label">
            <h2>Kwitansi</h2>
            <p>#SPP-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>
        </div>
    </div>

    <div class="info-grid">
        <div class="info-section">
            <h3>Informasi Siswa</h3>
            <div class="info-item">
                <span>Nama Siswa</span>
                <span>{{ $payment->student_name }}</span>
            </div>
            <div class="info-item">
                <span>NISN</span>
                <span>{{ $payment->nisn }}</span>
            </div>
            <div class="info-item">
                <span>Kelas</span>
                <span>{{ $payment->class_name }}</span>
            </div>
        </div>
        <div class="info-section">
            <h3>Detail Pembayaran</h3>
            <div class="info-item">
                <span>Tanggal</span>
                <span>{{ $payment->paid_at->format('d F Y') }}</span>
            </div>
            <div class="info-item">
                <span>Waktu</span>
                <span>{{ $payment->paid_at->format('H:i') }} WIB</span>
            </div>
            <div class="info-item">
                <span>Metode</span>
                <span>{{ $payment->bank }}</span>
            </div>
        </div>
    </div>

    <table class="payment-table">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th class="text-end">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>Pembayaran SPP Bulan {{ $payment->month }}</strong><br>
                    <small class="text-muted">Pembayaran iuran bulanan sekolah</small>
                </td>
                <td class="text-end">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
            </tr>
            <tr class="amount-row">
                <td class="text-end">TOTAL BAYAR</td>
                <td class="text-end text-primary">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="mb-5">
        <p style="font-size: 0.9rem; color: #64748b;">
            <strong>Terbilang:</strong><br>
            <span style="font-style: italic; color: #1e293b; font-weight: 600;">
                # {{ ucwords(\App\Http\Controllers\SiswaController::terbilang($payment->amount)) }} Rupiah #
            </span>
        </p>
    </div>

    <div class="footer">
        <div>
            <p style="font-size: 0.8rem; color: #94a3b8; max-width: 300px;">
                Bukti pembayaran ini sah dan dikeluarkan secara sistem oleh SMK Prestasi Prima. Simpan sebagai bukti transaksi yang valid.
            </p>
        </div>
        <div class="signature-box">
            <p class="signature-title">Jakarta, {{ $payment->paid_at->format('d F Y') }}</p>
            <div class="signature-line"></div>
            <p class="signature-name">{{ auth()->user()->name }}</p>
            <p class="signature-title">Petugas Administrasi</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
