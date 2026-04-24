<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SppSetting;
use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'role' => 'admin',
            'status' => 'active',
            'email' => 'admin@sekolah.sch.id',
            'password' => bcrypt('password'),
        ]);

        User::create(['name' => 'Dewi Sartika', 'username' => 'dewi', 'role' => 'petugas', 'status' => 'active', 'email' => 'dewi.sartika@school.ac.id', 'password' => bcrypt('password')]);
        User::create(['name' => 'Bambang Wijaya', 'username' => 'bambang', 'role' => 'petugas', 'status' => 'active', 'email' => 'bambang.w@school.ac.id', 'password' => bcrypt('password')]);
        User::create(['name' => 'Ratna Dewi', 'username' => 'ratna', 'role' => 'petugas', 'status' => 'active', 'email' => 'ratna.d@school.ac.id', 'password' => bcrypt('password')]);
        User::create(['name' => 'Andi Pratama', 'username' => 'andi', 'role' => 'petugas', 'status' => 'inactive', 'email' => 'andi.p@school.ac.id', 'password' => bcrypt('password')]);

        User::create([
            'name' => 'Ahmad Rizki Maulana',
            'username' => '1234567890',
            'role' => 'siswa',
            'status' => 'active',
            'email' => 'ahmad.rizki@sekolah.sch.id',
            'password' => bcrypt('password'),
        ]);

        $students = [
            ['nisn' => '1234567890', 'name' => 'Ahmad Rizki Maulana', 'class_name' => 'X IPA 1', 'academic_year' => '2026', 'payment_status' => 'paid'],
            ['nisn' => '1234567891', 'name' => 'Siti Nurhaliza', 'class_name' => 'X IPA 1', 'academic_year' => '2026', 'payment_status' => 'paid'],
            ['nisn' => '1234567892', 'name' => 'Budi Santoso', 'class_name' => 'XI IPS 2', 'academic_year' => '2026', 'payment_status' => 'unpaid'],
            ['nisn' => '1234567893', 'name' => 'Dewi Kusuma', 'class_name' => 'XI IPA 3', 'academic_year' => '2026', 'payment_status' => 'paid'],
            ['nisn' => '1234567894', 'name' => 'Rudi Hermawan', 'class_name' => 'XII IPA 1', 'academic_year' => '2026', 'payment_status' => 'unpaid'],
            ['nisn' => '1234567895', 'name' => 'Maya Anggraini', 'class_name' => 'XII IPS 1', 'academic_year' => '2026', 'payment_status' => 'paid'],
            ['nisn' => '1234567896', 'name' => 'Andi Darmawan', 'class_name' => 'X IPA 2', 'academic_year' => '2026', 'payment_status' => 'paid'],
            ['nisn' => '1234567897', 'name' => 'Lestari Ayu', 'class_name' => 'X IPS 1', 'academic_year' => '2026', 'payment_status' => 'paid'],
            ['nisn' => '1234567898', 'name' => 'Bagas Maulana', 'class_name' => 'XI IPA 1', 'academic_year' => '2026', 'payment_status' => 'unpaid'],
            ['nisn' => '1234567899', 'name' => 'Chika Putri', 'class_name' => 'XI IPS 1', 'academic_year' => '2026', 'payment_status' => 'paid'],
            ['nisn' => '1234567800', 'name' => 'Deni Setiawan', 'class_name' => 'XII IPA 2', 'academic_year' => '2026', 'payment_status' => 'unpaid'],
            ['nisn' => '1234567801', 'name' => 'Eka Yulianti', 'class_name' => 'XII IPS 2', 'academic_year' => '2026', 'payment_status' => 'paid'],
            ['nisn' => '1234567802', 'name' => 'Fajar Alamsyah', 'class_name' => 'X IPA 3', 'academic_year' => '2026', 'payment_status' => 'paid'],
            ['nisn' => '1234567803', 'name' => 'Gita Gutawa', 'class_name' => 'XI IPS 3', 'academic_year' => '2026', 'payment_status' => 'paid'],
            ['nisn' => '1234567804', 'name' => 'Hadi Sucipto', 'class_name' => 'XII IPA 3', 'academic_year' => '2026', 'payment_status' => 'unpaid'],
        ];

        foreach ($students as $student) {
            \App\Models\Student::create($student);
        }

        // SPP Settings
        SppSetting::create(['grade_level' => 'Grade X',   'monthly_fee' => 500000, 'late_penalty' => 5, 'payment_deadline' => 10]);
        SppSetting::create(['grade_level' => 'Grade XI',  'monthly_fee' => 550000, 'late_penalty' => 5, 'payment_deadline' => 10]);
        SppSetting::create(['grade_level' => 'Grade XII', 'monthly_fee' => 600000, 'late_penalty' => 5, 'payment_deadline' => 10]);

        // Dummy payment submissions for petugas verification
        $payments = [
            ['nisn'=>'1234567890','student_name'=>'Ahmad Rizki Maulana','class_name'=>'XII IPA 1','month'=>'April 2026','amount'=>500000,'bank'=>'BCA','sender_name'=>'Ahmad Rizki','status'=>'menunggu','paid_at'=>now()->subDays(3)->setTime(14,30)],
            ['nisn'=>'1234567891','student_name'=>'Siti Nurhaliza Putri','class_name'=>'XI IPS 2','month'=>'April 2026','amount'=>500000,'bank'=>'Mandiri','sender_name'=>'Siti Nurhaliza','status'=>'menunggu','paid_at'=>now()->subDays(2)->setTime(9,15)],
            ['nisn'=>'1234567892','student_name'=>'Budi Santoso','class_name'=>'XI IPS 2','month'=>'April 2026','amount'=>550000,'bank'=>'BRI','sender_name'=>'Budi Santoso','status'=>'menunggu','paid_at'=>now()->subDays(1)->setTime(11,0)],
            ['nisn'=>'1234567893','student_name'=>'Dewi Kusuma','class_name'=>'XI IPA 3','month'=>'Maret 2026','amount'=>500000,'bank'=>'BNI','sender_name'=>'Dewi Kusuma','status'=>'diterima','paid_at'=>now()->subDays(10)->setTime(8,20)],
            ['nisn'=>'1234567894','student_name'=>'Rudi Hermawan','class_name'=>'XII IPA 1','month'=>'Maret 2026','amount'=>600000,'bank'=>'BCA','sender_name'=>'Rudi Hermawan','status'=>'ditolak','paid_at'=>now()->subDays(8)->setTime(16,45)],
            ['nisn'=>'1234567895','student_name'=>'Maya Anggraini','class_name'=>'XII IPS 1','month'=>'April 2026','amount'=>600000,'bank'=>'Mandiri','sender_name'=>'Maya Anggraini','status'=>'menunggu','paid_at'=>now()->subHours(5)],
        ];
        foreach ($payments as $p) {
            Payment::create($p);
        }
    }
}
