<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiskAssessmentEquipment extends Model
{
    use HasFactory;

    protected $table = 'risk_assessment_equipments';

    protected $fillable = [
        'risk_assessment_id',
        'equipment_name',
        'is_custom',
    ];

    protected $casts = [
        'is_custom' => 'boolean',
    ];

    /**
     * 이 장비가 속한 위험성 평가
     */
    public function riskAssessment(): BelongsTo
    {
        return $this->belongsTo(RiskAssessment::class);
    }
} 