<?php

namespace Database\Seeders;

use App\Models\ProjectDetailStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectDetailStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'ยังไม่ดำเนินการ', 'status' => 0],
            ['name' => 'กำลังดำเนินการ', 'status' => 1],
            ['name' => 'ดำเนินการเสร็จสิ้น', 'status' => 2],
        ];

        foreach ($data as $item) {
            ProjectDetailStatus::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
