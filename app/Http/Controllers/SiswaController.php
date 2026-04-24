<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Payment;
use App\Models\SppSetting;

class SiswaController extends Controller
{
    /**
     * Ambil data siswa berdasarkan NISN (username).
     */
    private function getStudent()
    {
        $nisn = Auth::user()->username;
        return Student::where('nisn', $nisn)->first();
    }

    /**
     * Dashboard siswa - tampilkan status pembayaran bulan ini.
     */
    public function dashboard()
    {
        $student  = $this->getStudent();
        $currentMonth = now()->locale('id')->isoFormat('MMMM YYYY');

        $paymentThisMonth = null;
        $history = collect();

        if ($student) {
            $paymentThisMonth = Payment::where('nisn', $student->nisn)
                ->where('month', $currentMonth)
                ->latest()->first();

            $history = Payment::where('nisn', $student->nisn)
                ->latest('paid_at')->take(5)->get();
        }

        // Calculate fee based on student class
        $feeAmount = 500000;
        if ($student) {
            $gradeKey = null;
            if (str_starts_with($student->class_name, 'X '))   $gradeKey = 'Grade X';
            elseif (str_starts_with($student->class_name, 'XI '))  $gradeKey = 'Grade XI';
            elseif (str_starts_with($student->class_name, 'XII ')) $gradeKey = 'Grade XII';

            if ($gradeKey) {
                $setting = SppSetting::where('grade_level', $gradeKey)->first();
                if ($setting) $feeAmount = $setting->monthly_fee;
            }
        }

        // Determine if they paid for the current month
        $hasPaidThisMonth = false;
        if ($student) {
            $hasPaidThisMonth = Payment::where('nisn', $student->nisn)
                ->where('month', $currentMonth)
                ->where('status', 'diterima')
                ->exists();
        }

        $unpaidMonthsList = $student ? $student->getUnpaidMonths() : [];
        $unpaidMonths = count($unpaidMonthsList);
        $totalOutstanding = $student ? $student->getTotalDebt() : 0;

        return view('siswa.dashboard', compact('student', 'currentMonth', 'paymentThisMonth', 'history', 'unpaidMonths', 'totalOutstanding', 'unpaidMonthsList'));
    }

    /**
     * Tampilkan form pembayaran SPP.
     */
    public function payForm()
    {
        $student = $this->getStudent();

        // Cari tarif SPP sesuai kelas siswa
        $gradeKey = null;
        if ($student) {
            if (str_starts_with($student->class_name, 'X '))   $gradeKey = 'Grade X';
            if (str_starts_with($student->class_name, 'XI '))  $gradeKey = 'Grade XI';
            if (str_starts_with($student->class_name, 'XII ')) $gradeKey = 'Grade XII';
        }

        $unpaidMonths = $student ? $student->getUnpaidMonths() : [];
        
        // Take the oldest unpaid month
        $nextMonth = count($unpaidMonths) > 0 ? $unpaidMonths[0] : null;

        return view('siswa.pay', compact('student', 'nextMonth'));
    }

    /**
     * Proses submit pembayaran + upload bukti.
     */
    public function submitPayment(Request $request)
    {
        $request->validate([
            'month'       => 'required|string',
            'amount'      => 'required|integer|min:1',
            'bank'        => 'required|string',
            'sender_name' => 'required|string|max:255',
            'receipt'     => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $student = $this->getStudent();

        // Cek apakah sudah ada pembayaran bulan ini yang menunggu atau diterima
        $exists = Payment::where('nisn', Auth::user()->username)
            ->where('month', $request->month)
            ->whereIn('status', ['menunggu', 'diterima'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah memiliki pembayaran yang sedang diproses atau sudah lunas untuk bulan ini.');
        }

        // Upload foto bukti
        $path = $request->file('receipt')->store('receipts', 'public');

        // Calculate penalty if past deadline
        $gradeKey = null;
        if ($student) {
            if (str_starts_with($student->class_name, 'X '))   $gradeKey = 'Grade X';
            elseif (str_starts_with($student->class_name, 'XI '))  $gradeKey = 'Grade XI';
            elseif (str_starts_with($student->class_name, 'XII ')) $gradeKey = 'Grade XII';
        }

        $setting = SppSetting::where('grade_level', $gradeKey)->first();
        $deadlineDay = $setting ? $setting->payment_deadline : 10;
        $penaltyPercent = $setting ? $setting->late_penalty : 0;
        
        $paymentMonth = \Carbon\Carbon::parse($request->month);
        $currentMonth = now()->startOfMonth();
        
        $amount = $request->amount;
        if ($paymentMonth->lt($currentMonth) || now()->day > $deadlineDay) {
            // Penalty already included in the form's hidden input, 
            // but we should re-verify here for security.
            $baseFee = $setting ? $setting->monthly_fee : 500000;
            $calculatedPenalty = ($baseFee * $penaltyPercent) / 100;
            $amount = $baseFee + $calculatedPenalty;
        }

        Payment::create([
            'nisn'         => Auth::user()->username,
            'student_name' => Auth::user()->name,
            'class_name'   => $student ? $student->class_name : '-',
            'month'        => $request->month,
            'amount'       => $amount,
            'bank'         => $request->bank,
            'sender_name'  => $request->sender_name,
            'receipt_img'  => $path,
            'status'       => 'menunggu',
            'paid_at'      => now(),
        ]);

        return redirect()->route('siswa.dashboard')
            ->with('success', 'Pembayaran berhasil dikirim! Tunggu verifikasi dari petugas.');
    }

    /**
     * Riwayat semua pembayaran siswa.
     */
    public function history()
    {
        $student = $this->getStudent();
        $payments = Payment::where('nisn', Auth::user()->username)
            ->latest('paid_at')->paginate(10);

        return view('siswa.history', compact('student', 'payments'));
    }
    /**
     * Helper to convert number to Indonesian words (Terbilang).
     */
    public static function terbilang($nilai) {
        $nilai = abs($nilai);
        $huruf = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = self::terbilang($nilai - 10). " belas";
        } else if ($nilai < 100) {
            $temp = self::terbilang($nilai / 10). " puluh". self::terbilang($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . self::terbilang($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = self::terbilang($nilai / 100) . " ratus" . self::terbilang($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . self::terbilang($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = self::terbilang($nilai / 1000) . " ribu" . self::terbilang($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = self::terbilang($nilai / 1000000) . " juta" . self::terbilang($nilai % 1000000);
        }
        return $temp;
    }
}
