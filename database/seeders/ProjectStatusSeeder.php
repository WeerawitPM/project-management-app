<?php

namespace Database\Seeders;

use App\Models\ProjectStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'รอการอนุมัติ', 'status' => 0],
            ['name' => 'อนุมัติแล้ว', 'status' => 1],
        ];

        foreach ($data as $item) {
            ProjectStatus::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
