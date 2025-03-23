<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiskAssessmentItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'risk_assessment_id',
        'risk_assessment_process_id',
        'detail_process',
        'hazard_type',
        'hazard_cause',
        'risk_factor',
        'probability',
        'severity',
        'risk_score',
        'reduction_measures',
        'manager',
        'is_ai_generated',
    ];

    protected $casts = [
        'probability' => 'integer',
        'severity' => 'integer',
        'risk_score' => 'integer',
        'is_ai_generated' => 'boolean',
    ];

    /**
     * 이 항목이 속한 위험성 평가
     */
    public function riskAssessment(): BelongsTo
    {
        return $this->belongsTo(RiskAssessment::class);
    }

    /**
     * 이 항목이 속한 공정
     */
    public function process(): BelongsTo
    {
        return $this->belongsTo(RiskAssessmentProcess::class, 'risk_assessment_process_id');
    }

    /**
     * 위험등급 계산
     */
    public function getRiskGradeAttribute(): string
    {
        return RiskAssessment::calculateRiskGrade($this->risk_score);
    }
} 