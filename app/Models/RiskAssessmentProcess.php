<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RiskAssessmentProcess extends Model
{
    use HasFactory;

    protected $fillable = [
        'risk_assessment_id',
        'process_name',
        'is_custom',
        'sort_order',
    ];

    protected $casts = [
        'is_custom' => 'boolean',
    ];

    /**
     * 이 공정이 속한 위험성 평가
     */
    public function riskAssessment(): BelongsTo
    {
        return $this->belongsTo(RiskAssessment::class);
    }

    /**
     * 이 공정에 속한 위험성 평가 항목들
     */
    public function items(): HasMany
    {
        return $this->hasMany(RiskAssessmentItem::class);
    }
} 