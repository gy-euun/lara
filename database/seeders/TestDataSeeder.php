<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\RiskAssessment;
use App\Models\Worker;
use App\Models\Document;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestDataSeeder extends Seeder
{
    public function run(): void
    {
        // 테스트 사용자 생성 또는 조회
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]
        );

        // 프로젝트 생성
        $project = Project::create([
            'name' => '테스트 프로젝트',
            'description' => '이것은 테스트 프로젝트입니다.',
            'user_id' => $user->id,
        ]);

        // 위험성 평가 데이터 생성
        for ($i = 1; $i <= 3; $i++) {
            RiskAssessment::create([
                'user_id' => $user->id,
                'industry_id' => 1,
                'project_name' => "테스트 프로젝트 {$i}",
                'assessment_no' => "RA-" . date('Ymd') . "-" . str_pad($i, 3, '0', STR_PAD_LEFT),
                'assessment_date' => now(),
                'status' => 'draft'
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