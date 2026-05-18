<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;

class StudentController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Manual
        $validator = Validator::make($request->all(), [
            'nisn'           => 'required|unique:students,nisn',
            'name'           => 'required',
            'class_name'     => 'required',
            'academic_year'  => 'required',
            'payment_status' => 'required',
        ]);

        // 2. Jika ada data kosong/salah, kirim error 422
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Ada data yang kosong atau format salah!',
                'errors'  => $validator->errors()
            ], 422);
        }

        try {
            // Mapping data dari Android untuk payment_status agar sesuai dengan enum database
            $data = $request->all();
            if (isset($data['payment_status'])) {
                $status = strtolower($data['payment_status']);
                if (in_array($status, ['lunas', 'paid'])) {
                    $data['payment_status'] = 'paid';
                } else {
                    $data['payment_status'] = 'unpaid';
                }
            }

            // 3. Jika aman, simpan ke database
            $student = Student::create($data);

            return response()->json([
                'success' => true,
                'message' => 'Data Siswa Berhasil Disimpan',
                'data'    => $student
            ], 201);

        } catch (Exception $e) {
            // 4. Jika database menolak, kirim error
            return response()->json([
                'success' => false,
                'message' => 'Gagal simpan: ' . $e->getMessage(),
                'error_detail' => $e->getMessage()
            ], 500);
        }
    }
}