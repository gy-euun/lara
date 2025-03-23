<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // 업종 마스터 테이블
        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // 공정 템플릿 테이블
        Schema::create('process_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industry_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        // 장비 마스터 테이블
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // 공정-장비 매핑 테이블
        Schema::create('process_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('process_template_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        // 위험성평가 메인 테이블
        Schema::create('risk_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('industry_id')->constrained();
            $table->string('project_name');
            $table->string('assessment_no')->unique();
            $table->date('assessment_date');
            $table->string('status')->default('draft'); // draft, completed, approved
            $table->timestamps();
            $table->softDeletes();
        });

        // 위험성평가 공정 상세
        Schema::create('risk_assessment_processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_assessment_id')->constrained()->onDelete('cascade');
            $table->string('process_name');
            $table->boolean('is_custom')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // 위험성평가 장비 상세
        Schema::create('risk_assessment_equipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_assessment_id')->constrained()->onDelete('cascade');
            $table->string('equipment_name');
            $table->boolean('is_custom')->default(false);
            $table->timestamps();
        });

        // 위험성평가 항목 상세
        Schema::create('risk_assessment_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_assessment_id')->constrained()->onDelete('cascade');
            $table->foreignId('risk_assessment_process_id')->constrained('risk_assessment_processes');
            $table->string('detail_process');
            $table->string('hazard_type');
            $table->text('hazard_cause');
            $table->text('risk_factor');
            $table->integer('probability')->comment('가능성: 1-5');
            $table->integer('severity')->comment('중대성: 1-5');
            $table->integer('risk_score')->comment('위험성지수');
            $table->text('reduction_measures');
            $table->string('manager');
            $table->boolean('is_ai_generated')->default(false);
            $table->timestamps();
        });

        // 서명 정보
        Schema::create('risk_assessment_signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('risk_assessment_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained();
            $table->string('position');
            $table->string('signature_path')->nullable();
            $table->timestamp('signed_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('risk_assessment_signatures');
        Schema::dropIfExists('risk_assessment_items');
        Schema::dropIfExists('risk_assessment_equipments');
        Schema::dropIfExists('risk_assessment_processes');
        Schema::dropIfExists('risk_assessments');
        Schema::dropIfExists('process_equipment');
        Schema::dropIfExists('equipments');
        Schema::dropIfExists('process_templates');
        Schema::dropIfExists('industries');
    }
}; 