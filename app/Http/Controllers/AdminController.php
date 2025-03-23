<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_projects' => Project::count(),
            'recent_users' => User::latest()->take(5)->get(),
            'recent_projects' => Project::latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }

    public function projects()
    {
        $projects = Project::with('user')->latest()->paginate(10);
        return view('admin.projects', compact('projects'));
    }
} 