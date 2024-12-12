<?php

namespace Database\Seeders;

use App\Models\Assign;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'All'],
        ];

        foreach ($data as $item) {
            Assign::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
