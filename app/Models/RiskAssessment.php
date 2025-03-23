<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiskAssessment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'risk_level',
        'project_id',
    ];

    /**
     * Get the project that owns the risk assessment.
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
} 