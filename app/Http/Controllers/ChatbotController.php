<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ChatbotController extends Controller
{
    use AuthorizesRequests;

    public function index(Project $project)
    {
        $this->authorize('view', $project);
        
        return view('chatbot.index', [
            'project' => $project,
            'showSidebarB' => true
        ]);
    }
} 