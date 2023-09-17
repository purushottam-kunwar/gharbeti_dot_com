<?php

namespace Database\Seeders;

use App\Models\FiscalYear;
use Illuminate\Database\Seeder;

class FiscalYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fiscalYears = [
            [
                'name' => '2079/2080',
                'bs_start_date' => '2079-04-01',
                'bs_end_date' => '2080-03-31',
                'ad_start_date' => '2022-07-17',
                'ad_end_date' => '2023-07-15',
                'status' => 'deactivate',
            ],
            [
                'name' => '2080/2081',
                'bs_start_date' => '2080-04-01',
                'bs_end_date' => '2081-03-31',
                'ad_start_date' => '2023-07-17',
                'ad_end_date' => '2024-07-15',
                'status' => 'active',
            ], [
                'name' => '2081/2082',
                'bs_start_date' => '2082-04-01',
                'bs_end_date' => '2083-03-31',
                'ad_start_date' => '2024-07-16',
                'ad_end_date' => '2025-07-15',
                'status' => 'deactivate',
            ], [
                'name' => '2082/2083',
                'bs_start_date' => '2082-04-01',
                'bs_end_date' => '2083-03-31',
                'ad_start_date' => '2025-07-17',
                'ad_end_date' => '2026-07-15',
                'status' => 'deactivate',
            ],
        ];

        foreach ($fiscalYears as $res_fy) {
            $fiscalYearsData = FiscalYear::where('name', $res_fy['name'])->first();
            if (!isset($fiscalYearsData->id)) {
                FiscalYear::create($res_fy);
            }
        }
    }
}
