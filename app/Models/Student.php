<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'nisn', 
        'name', 
        'class_name', 
        'academic_year', 
        'payment_status'
    ];

    /**
     * Get list of unpaid months with fee and penalty details.
     */
    public function getUnpaidMonths()
    {
        $startYear = (int) $this->academic_year - 1; // Assuming 2026 means 2025/2026
        $startMonth = \Carbon\Carbon::create($startYear, 7, 1); // July
        $currentMonth = now()->startOfMonth();
        
        // Find fee setting
        $gradeKey = null;
        if (str_starts_with($this->class_name, 'X '))   $gradeKey = 'Grade X';
        elseif (str_starts_with($this->class_name, 'XI '))  $gradeKey = 'Grade XI';
        elseif (str_starts_with($this->class_name, 'XII ')) $gradeKey = 'Grade XII';

        $setting = SppSetting::where('grade_level', $gradeKey)->first();
        $feeAmount = $setting ? $setting->monthly_fee : 500000;
        $penaltyPercent = $setting ? $setting->late_penalty : 0;
        $deadlineDay = $setting ? $setting->payment_deadline : 10;

        $unpaid = [];
        $temp = clone $startMonth;

        while ($temp->lte($currentMonth)) {
            $monthStr = $temp->locale('id')->isoFormat('MMMM YYYY');
            
            $exists = Payment::where('nisn', $this->nisn)
                ->where('month', $monthStr)
                ->where('status', 'diterima')
                ->exists();

            if (!$exists) {
                // Calculate penalty if past deadline
                $penalty = 0;
                $isLate = false;
                
                // If it's a previous month, it's definitely late
                // If it's current month, check the day
                if ($temp->lt($currentMonth) || now()->day > $deadlineDay) {
                    $penalty = ($feeAmount * $penaltyPercent) / 100;
                    $isLate = true;
                }

                $unpaid[] = [
                    'month' => $monthStr,
                    'year' => $temp->year,
                    'month_num' => $temp->month,
                    'fee' => $feeAmount,
                    'penalty' => $penalty,
                    'total' => $feeAmount + $penalty,
                    'is_late' => $isLate
                ];
            }
            $temp->addMonth();
        }

        return $unpaid;
    }

    public function getTotalDebt()
    {
        return collect($this->getUnpaidMonths())->sum('total');
    }
}
