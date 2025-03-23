<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'project_id',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
} 