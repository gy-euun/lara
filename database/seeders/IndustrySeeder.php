<?php

namespace Database\Seeders;

use App\Models\Industry;
use Illuminate\Database\Seeder;

class IndustrySeeder extends Seeder
{
    public function run(): void
    {
        $industries = [
            '건설업',
            '제조업',
            '서비스업',
            '운수업',
            '도소매업',
        ];

        foreach ($industries as $industry) {
            Industry::create(['name' => $industry]);
        }
    }
} 