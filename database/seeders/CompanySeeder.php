<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
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
            Company::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }
    }
}
