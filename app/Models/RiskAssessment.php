<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RiskAssessment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'industry_id',
        'project_name',
        'assessment_no',
        'assessment_date',
        'status'
    ];

    protected $casts = [
        'assessment_date' => 'date'
    ];

    /**
     * Get the project that owns the risk assessment.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function industry()
    {
        return $this->belongsTo(Industry::class);
    }

    public function processes()
    {
        return $this->hasMany(RiskAssessmentProcess::class);
    }

    public function equipments()
    {
        return $this->hasMany(RiskAssessmentEquipment::class);
    }

    public function items()
    {
        return $this->hasMany(RiskAssessmentItem::class);
    }

    public function signatures()
    {
        return $this->hasMany(RiskAssessmentSignature::class);
    }

    // 위험성평가 번호 자동 생성
    public static function generateAssessmentNo()
    {
        $today = now()->format('Ymd');
        
        // 삭제된 레코드를 포함하여 오늘 생성된 모든 번호 중 가장 큰 번호 찾기
        $lastNo = static::withTrashed()
            ->whereDate('created_at', today())
            ->max('assessment_no');
        
        if (!$lastNo) {
            return $today . '001';
        }

        // 마지막 3자리 추출하여 1 증가
        $sequence = (int)substr($lastNo, -3);
        $newSequence = $sequence + 1;

        // 새로운 번호가 이미 존재하는지 확인
        while (static::withTrashed()->where('assessment_no', $today . str_pad($newSequence, 3, '0', STR_PAD_LEFT))->exists()) {
            $newSequence++;
        }

        return $today . str_pad($newSequence, 3, '0', STR_PAD_LEFT);
    }

    // 위험등급 계산
    public static function calculateRiskGrade($score)
    {
        if ($score >= 15) return '상';
        if ($score >= 8) return '중';
        return '하';
    }
} 