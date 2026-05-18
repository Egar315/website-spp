<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
try {
    $student = App\Models\Student::create([
        'nisn' => '999888',
        'name' => 'Tester',
        'class_name' => 'X RPL',
        'academic_year' => '2025/2026',
        'payment_status' => 'Belum Lunas'
    ]);
    print_r($student->toArray());
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
