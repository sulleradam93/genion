<?php

namespace App\Services;

use App\Models\JobPosition;
use App\Models\CompanyJob;

class AppService
{
    public function calculateSalary($workDateBegin, $workDateEnd, $baseSalary, $nightSalary, $weekendSalary)
    {
        $workBeginTime = new \DateTime($workDateBegin);
        $workEndTime = new \DateTime($workDateEnd);

        $totalSalary = 0;
        $weekendHour = 0;
        $nightHour = 0;
        $baseHour = 0;

        while ($workBeginTime < $workEndTime) {
            $currentHour = (int) $workBeginTime->format('H');  // Jelenlegi óra (0-23)
            $currentDay = $workBeginTime->format('N');  // A hét napja (1-7: hétfő=1, vasárnap=7)

            if ($currentDay == 6 || $currentDay == 7) {  // Ha hétvége van
                $weekendHour++;
            } elseif ($currentHour >= 22 || $currentHour < 6) {  // Ha éjszaka van (22:00 - 06:00)
                $nightHour++;
            } else {  // Egyébként hétköznapi nappali munkavégzés
                $baseHour++;
            }

            // Növeljük az időt egy órával
            $workBeginTime->modify('+1 hour');
        }

        $totalSalary += $weekendHour * $weekendSalary;
        $totalSalary += $nightHour * $nightSalary;
        $totalSalary += $baseHour * $baseSalary;

        $calculated = json_encode([
            'base_hours' => $baseHour,
            'base_salary' => $baseSalary,
            'night_hours' => $nightHour,
            'night_salary' => $nightSalary,
            'weekend_hours' => $weekendHour,
            'weekend_salary' => $weekendSalary,
        ]);

        return [
            'total_salary' => $totalSalary,
            'calculated' => $calculated,
        ];
    }

    public function getJobPositionsByCompany($companyId, $type)
    {
        if ($type == 'related') {
            return JobPosition::join('company_jobs', 'company_jobs.job_id', '=', 'job_positions.id')
                ->where('company_jobs.company_id', $companyId)
                ->get(['job_positions.id', 'job_positions.title']);
        }

        if ($type == 'unrelated') {
            return JobPosition::whereNotIn('id', function($query) use ($companyId) {
                    $query->select('job_id')
                        ->from('company_jobs')
                        ->where('company_id', $companyId);
                })
                ->get(['id', 'title']);
        }

        return collect();
    }
}
