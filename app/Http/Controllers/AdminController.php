<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $totalStudents = \App\Models\Student::count();
        $totalStaff = \App\Models\User::where('role', 'petugas')->count();
        
        $incomeThisMonth = \App\Models\Payment::where('status', 'diterima')
            ->whereMonth('paid_at', now()->month)
            ->whereYear('paid_at', now()->year)
            ->sum('amount');

        // Estimate outstanding (unpaid students * average fee)
        $unpaidCount = \App\Models\Student::where('payment_status', 'unpaid')->count();
        $totalOutstanding = $unpaidCount * 500000;

        $recentPayments = \App\Models\Payment::where('status', 'diterima')
            ->latest('paid_at')
            ->take(3)
            ->get();

        $currentMonthStr = now()->locale('id')->isoFormat('MMMM YYYY');
        
        $paidCount = \App\Models\Payment::where('status', 'diterima')->where('month', $currentMonthStr)->count();
        $pendingCount = \App\Models\Payment::where('status', 'menunggu')->where('month', $currentMonthStr)->count();
        $unpaidThisMonth = max(0, $totalStudents - $paidCount - $pendingCount);

        $paidPerc = $totalStudents > 0 ? round(($paidCount / $totalStudents) * 100) : 0;
        $pendingPerc = $totalStudents > 0 ? round(($pendingCount / $totalStudents) * 100) : 0;
        $unpaidPerc = $totalStudents > 0 ? round(($unpaidThisMonth / $totalStudents) * 100) : 0;

        return view('admin.dashboard', compact(
            'totalStudents', 'totalStaff', 'incomeThisMonth', 'totalOutstanding', 
            'recentPayments', 'paidPerc', 'pendingPerc', 'unpaidPerc'
        ));
    }

    public function users(Request $request)
    {
        $query = \App\Models\User::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10)->withQueryString();
        return view('admin.users', compact('users'));
    }

    /**
     * Store new user to the database.
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,petugas,siswa',
            'status' => 'required|in:active,inactive',
        ]);

        \App\Models\User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
            'status' => $validated['status'],
        ]);

        // Sync to students table if role is siswa
        if ($validated['role'] === 'siswa') {
            \App\Models\Student::create([
                'nisn' => $validated['username'],
                'name' => $validated['name'],
                'class_name' => 'Belum Ditentukan',
                'academic_year' => date('Y') . '/' . (date('Y') + 1),
                'payment_status' => 'unpaid'
            ]);
        }

        return redirect()->back()->with('success', 'Pengguna baru bernama '.$validated['name'].' berhasil ditambahkan!');
    }

    /**
     * Update existing user.
     */
    public function updateUser(Request $request, \App\Models\User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,petugas,siswa',
            'status' => 'required|in:active,inactive',
        ]);

        $oldUsername = $user->username;
        
        $user->name = $validated['name'];
        $user->username = $validated['username'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->status = $validated['status'];

        if ($request->filled('password')) {
            $request->validate(['password' => 'string|min:6']);
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // Sync to students table if role is siswa
        if ($user->role === 'siswa') {
            $student = \App\Models\Student::where('nisn', $oldUsername)->first();
            if ($student) {
                $student->nisn = $user->username;
                $student->name = $user->name;
                $student->save();
            } else {
                \App\Models\Student::create([
                    'nisn' => $user->username,
                    'name' => $user->name,
                    'class_name' => 'Belum Ditentukan',
                    'academic_year' => date('Y') . '/' . (date('Y') + 1),
                    'payment_status' => 'unpaid'
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data pengguna '.$user->name.' berhasil diperbarui!');
    }

    /**
     * Delete user.
     */
    public function deleteUser(\App\Models\User $user)
    {
        $name = $user->name;
        
        if ($user->role === 'siswa') {
            \App\Models\Student::where('nisn', $user->username)->delete();
        }
        
        $user->delete();
        return redirect()->back()->with('success', 'Pengguna '.$name.' berhasil dihapus!');
    }

    /**
     * Display the student data master page.
     */
    public function students(Request $request)
    {
        $query = \App\Models\Student::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class') && $request->class !== 'all') {
            $query->where('class_name', 'like', $request->class . '%');
        }

        if ($request->filled('year') && $request->year !== 'all') {
            $query->where('academic_year', $request->year);
        }

        $students = $query->paginate(6)->withQueryString();
        return view('admin.students', compact('students'));
    }

    /**
     * Update student details (like class).
     */
    public function updateStudent(Request $request, \App\Models\Student $student)
    {
        $validated = $request->validate([
            'class_name' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
            'payment_status' => 'required|in:paid,unpaid',
        ]);

        $student->update($validated);

        return redirect()->back()->with('success', 'Data siswa '.$student->name.' berhasil diperbarui!');
    }

    /**
     * Display all payments history.
     */
    public function payments(Request $request)
    {
        $query = \App\Models\Payment::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('student_name', 'like', "%{$search}%")
                  ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $payments = $query->latest('paid_at')->paginate(10)->withQueryString();
        return view('admin.payments', compact('payments'));
    }

    /**
     * Display the SPP configuration page.
     */
    public function settings()
    {
        $settings = \App\Models\SppSetting::all()->keyBy('grade_level');
        // Use defaults if not found
        return view('admin.settings', compact('settings'));
    }

    /**
     * Save the SPP configuration.
     */
    public function saveSettings(Request $request)
    {
        $grades = ['Grade X', 'Grade XI', 'Grade XII'];

        foreach ($grades as $grade) {
            $key = str_replace(' ', '_', strtolower($grade)); // grade_x, grade_xi, grade_xii
            \App\Models\SppSetting::updateOrCreate(
                ['grade_level' => $grade],
                ['monthly_fee' => $request->input("monthly_fee_{$key}")]
            );
        }

        \App\Models\SppSetting::whereIn('grade_level', $grades)
            ->update([
                'late_penalty' => $request->input('late_penalty'),
                'payment_deadline' => $request->input('payment_deadline'),
            ]);

        return redirect()->back()->with('success', 'Konfigurasi SPP berhasil disimpan!');
    }
}
