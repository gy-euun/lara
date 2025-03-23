<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Industry extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function processTemplates()
    {
        return $this->hasMany(ProcessTemplate::class);
    }

    public function riskAssessments()
    {
        return $this->hasMany(RiskAssessment::class);
    }
} 