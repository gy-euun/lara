<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\RiskAssessment;
use App\Models\Worker;
use App\Models\Document;
use App\Models\User;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // 테스트 유저 생성 (이미 있다면 건너뜀)
        $user = User::where('email', 'test@example.com')->first();
        if (!$user) {
            $user = User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'password' => bcrypt('password'),
            ]);
        }

        // 프로젝트 생성
        $project = Project::create([
            'name' => '테스트 프로젝트',
            'description' => '이것은 테스트 프로젝트입니다.',
            'user_id' => $user->id,
        ]);

        // 위험성 평가 데이터 생성
        for ($i = 1; $i <= 3; $i++) {
            RiskAssessment::create([
                'title' => "위험성 평가 #$i",
                'description' => "위험성 평가 설명 #$i",
                'risk_level' => ['low', 'medium', 'high'][rand(0, 2)],
                'project_id' => $project->id,
            ]);
        }

        // 근로자 데이터 생성
        $positions = ['현장소장', '안전관리자', '근로자'];
        for ($i = 1; $i <= 3; $i++) {
            Worker::create([
                'name' => "근로자 $i",
                'position' => $positions[rand(0, 2)],
                'project_id' => $project->id,
            ]);
        }

        // 문서 데이터 생성
        for ($i = 1; $i <= 3; $i++) {
            Document::create([
                'title' => "문서 #$i",
                'description' => "문서 설명 #$i",
                'file_path' => "documents/test-$i.pdf",
                'project_id' => $project->id,
            ]);
        }
    }
} 