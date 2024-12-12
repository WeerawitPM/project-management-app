<?php

namespace Database\Seeders;

use App\Models\ProjectPhase;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectPhaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Phase1'],
            ['name' => 'Phase2'],
            ['name' => 'Phase3'],
            ['name' => 'Phase4'],
        ];

        foreach ($data as $item) {
            ProjectPhase::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
