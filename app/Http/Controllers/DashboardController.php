<?php

namespace App\Http\Controllers;

use App\Models\Project;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with basic project statistics
     * for the authenticated user.
     */
    public function index()
    {
        $userId = auth()->id();

        // Total projects for this user
        $totalProjects = Project::where('uid', $userId)->count();

        // Completed projects
        $completedProjects = Project::where('uid', $userId)
            ->where('phase', 'complete')
            ->count();

        return view('dashboard', compact('totalProjects', 'completedProjects'));
    }
}

