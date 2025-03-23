<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();
        
        if ($user) {
            Project::create([
                'name' => '안전관리 시스템 구축',
                'description' => '건설현장 위험성 평가 시스템',
                'status' => 'active',
                'user_id' => $user->id
            ]);

            Project::create([
                'name' => '근로자 관리 플랫폼',
                'description' => '출입 통제와 기록 관리 연동',
                'status' => 'active',
                'user_id' => $user->id
            ]);
        }
    }
} 