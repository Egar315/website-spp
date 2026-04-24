<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Student;
use App\Models\SppSetting;

class PetugasController extends Controller
{
    /**
     * Verifikasi Pembayaran - tampilkan semua pembayaran yang perlu diverifikasi
     */
    public function verification()
    {
        $pending  = Payment::where('status', 'menunggu')->latest('paid_at')->get();
        $total_pending = $pending->count();
        return view('petugas.verification', compact('pending', 'total_pending'));
    }

    /**
     * Setujui pembayaran
     */
    public function approve(Payment $payment)
    {
        $payment->update(['status' => 'diterima']);
        return redirect()->back()
            ->with('success', 'Pembayaran '.$payment->student_name.' berhasil disetujui!')
            ->with('payment_id', $payment->id);
    }

    /**
     * Tolak pembayaran
     */
    public function reject(Payment $payment)
    {
        $payment->update(['status' => 'ditolak']);
        return redirect()->back()->with('warning', 'Pembayaran '.$payment->student_name.' telah ditolak.');
    }

    /**
     * Pembayaran Langsung (entry manual)
     */
    public function direct()
    {
        return view('petugas.direct');
    }

    /**
     * Simpan pembayaran langsung
     */
    public function storeDirect(Request $request)
    {
        $validated = $request->validate([
            'nisn'         => 'required|string',
            'student_name' => 'required|string',
            'class_name'   => 'required|string',
            'month'        => 'required|string',
            'amount'       => 'required|integer|min:1',
            'bank'         => 'required|string',
            'sender_name'  => 'required|string',
        ]);

        $payment = Payment::create(array_merge($validated, [
            'status'  => 'diterima',
            'paid_at' => now(),
        ]));

        return redirect()->route('petugas.direct')
               ->with('success', 'Pembayaran langsung atas nama '.$validated['student_name'].' berhasil dicatat!')
               ->with('payment_id', $payment->id);
    }

    /**
     * Cari siswa berdasarkan NISN (AJAX).
     */
    public function searchStudent(Request $request)
    {
        $nisn    = trim($request->query('nisn'));
        $student = Student::where('nisn', $nisn)->first();

        if (!$student) {
            return response()->json(['found' => false, 'message' => 'Siswa dengan NISN tersebut tidak ditemukan.']);
        }

        // Cari tarif sesuai kelas
        $gradeKey = null;
        if (str_starts_with($student->class_name, 'XII ')) $gradeKey = 'Grade XII';
        elseif (str_starts_with($student->class_name, 'XI '))  $gradeKey = 'Grade XI';
        elseif (str_starts_with($student->class_name, 'X '))   $gradeKey = 'Grade X';

        $fee = $gradeKey ? SppSetting::where('grade_level', $gradeKey)->value('monthly_fee') : null;

        return response()->json([
            'found'       => true,
            'nisn'        => $student->nisn,
            'name'        => $student->name,
            'class_name'  => $student->class_name,
            'academic_year' => $student->academic_year,
            'unpaid_months' => $student->getUnpaidMonths(),
            'total_debt'  => $student->getTotalDebt(),
        ]);
    }

    /**
     * Tampilkan invoice / bukti pembayaran
     */
    public function invoice(Payment $payment)
    {
        return view('petugas.invoice', compact('payment'));
    }
}
