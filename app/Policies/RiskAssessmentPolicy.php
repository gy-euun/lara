<?php

namespace App\Policies;

use App\Models\RiskAssessment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RiskAssessmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, RiskAssessment $assessment)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, RiskAssessment $assessment)
    {
        return $user->id === $assessment->user_id;
    }

    public function delete(User $user, RiskAssessment $assessment)
    {
        return $user->id === $assessment->user_id;
    }

    public function edit(User $user, RiskAssessment $assessment)
    {
        return $user->id === $assessment->user_id;
    }
} 