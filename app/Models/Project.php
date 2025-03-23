<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'user_id',
    ];

    /**
     * Get the user that owns the project.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the risk assessments for the project.
     */
    public function riskAssessments()
    {
        return RiskAssessment::where('project_name', $this->name)
            ->where('user_id', $this->user_id);
    }

    public function workers(): HasMany
    {
        return $this->hasMany(Worker::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
} 