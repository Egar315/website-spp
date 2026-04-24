<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\SiswaController;

$amount = 550000;
$terbilang = SiswaController::terbilang($amount);

echo "Testing Terbilang Helper:\n";
echo "Amount: Rp " . number_format($amount, 0, ',', '.') . "\n";
echo "Words: " . trim($terbilang) . " Rupiah\n";
