<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $user = Auth::user();
        if (!$user) return response()->json(['count' => 0, 'notifications' => []]);

        $notifications = [];
        $count = 0;

        if ($user->role === 'admin' || $user->role === 'petugas') {
            $pendingPayments = Payment::where('status', 'menunggu')
                ->latest()
                ->take(5)
                ->get();
            
            $count = Payment::where('status', 'menunggu')->count();

            foreach ($pendingPayments as $payment) {
                $notifications[] = [
                    'title' => 'Menunggu Verifikasi',
                    'message' => 'Pembayaran ' . $payment->student_name . ' (' . $payment->month . ')',
                    'time' => $payment->created_at->diffForHumans(),
                    'icon' => 'bi-hourglass-split',
                    'color' => 'warning',
                    'link' => route($user->role === 'admin' ? 'admin.payments' : 'petugas.verification')
                ];
            }
            
            // If empty, add a default message
            if (count($notifications) === 0) {
                $notifications[] = [
                    'title' => 'Semua Selesai',
                    'message' => 'Tidak ada pembayaran yang tertunda.',
                    'time' => 'Sekarang',
                    'icon' => 'bi-check-all',
                    'color' => 'success',
                    'link' => '#'
                ];
            }
        } elseif ($user->role === 'siswa') {
            $recentUpdates = Payment::where('nisn', $user->username)
                ->whereIn('status', ['diterima', 'ditolak'])
                ->latest('updated_at')
                ->take(5)
                ->get();
            
            $count = Payment::where('nisn', $user->username)
                ->whereIn('status', ['diterima', 'ditolak'])
                ->where('updated_at', '>=', now()->subDays(3))
                ->count();

            foreach ($recentUpdates as $payment) {
                $isApproved = $payment->status === 'diterima';
                $notifications[] = [
                    'title' => $isApproved ? 'Pembayaran Berhasil' : 'Pembayaran Ditolak',
                    'message' => 'SPP bulan ' . $payment->month . ($isApproved ? ' telah diverifikasi.' : ' ditolak.'),
                    'time' => $payment->updated_at->diffForHumans(),
                    'icon' => $isApproved ? 'bi-check-circle-fill' : 'bi-x-circle-fill',
                    'color' => $isApproved ? 'success' : 'danger',
                    'link' => route('siswa.history')
                ];
            }
            
            if (count($notifications) === 0) {
                $notifications[] = [
                    'title' => 'Selamat Datang',
                    'message' => 'Belum ada notifikasi untuk Anda.',
                    'time' => 'Sekarang',
                    'icon' => 'bi-info-circle',
                    'color' => 'info',
                    'link' => '#'
                ];
            }
        }

        return response()->json([
            'count' => $count,
            'notifications' => $notifications
        ]);
    }
}
