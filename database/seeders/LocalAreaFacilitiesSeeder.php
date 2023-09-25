<?php

namespace Database\Seeders;

use App\Models\FiscalYear;
use App\Models\LocalAreaFacilities;
use Illuminate\Database\Seeder;

class LocalAreaFacilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'GYM',
            ],
            [
                'name' => 'Swimming Pool',
            ],
            [
                'name' => 'Hospital',
            ],
            [
                'name' => 'School',
            ],
            [
                'name' => 'Montessori Nursery',
            ],
            [
                'name' => 'Temple',
            ],
            [
                'name' => 'Restaurants',
            ],
            [
                'name' => 'Super Market',
            ],
            [
                'name' => 'Bus Stops',
            ],
            [
                'name' => 'Taxi Stands',
            ],
            [
                'name' => 'Police Stations',
            ],
            [
                'name' => 'Banquet Hall',
            ],
            [
                'name' => 'Gas Station',
            ],

        ];

        foreach ($data as $res_data) {
            $localAreaFacility = LocalAreaFacilities::where('name', $res_data['name'])->first();
            if (!isset($localAreaFacility->id)) {
                LocalAreaFacilities::create($res_data);
            }
        }
    }
}
