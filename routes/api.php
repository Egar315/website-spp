<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController; // Pastikan ini tanpa \Api

// Jangan gunakan string seperti 'Api\StudentController@store'
Route::post('/students/add', [StudentController::class, 'store']);