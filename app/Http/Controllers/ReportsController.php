<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportsController extends Controller
{
    /**
     * Display project statistics and breakdowns for the authenticated user.
     */
    public function index()
    {
        $userId = auth()->id();

        // Total projects
        $total = Project::where('uid', $userId)->count();

        // Completed projects
        $completed = Project::where('uid', $userId)
            ->where('phase', 'complete')
            ->count();

        // Overdue projects (end_date < today AND not complete)
        $overdue = Project::where('uid', $userId)
            ->whereNotNull('end_date')
            ->where('end_date', '<', Carbon::today())
            ->where('phase', '!=', 'complete')
            ->count();

        // High priority — removed from schema, kept for compatibility
        $highPriority = 0;

        // In progress (design, development, testing, deployment)
        $inProgress = Project::where('uid', $userId)
            ->whereIn('phase', ['design', 'development', 'testing', 'deployment'])
            ->count();

        // Next upcoming deadline
        $nextDeadline = Project::where('uid', $userId)
            ->whereNotNull('end_date')
            ->where('end_date', '>=', Carbon::today())
            ->orderBy('end_date', 'asc')
            ->first();

        // Breakdown by phase
        $statusBreakdown = Project::select('phase', DB::raw('COUNT(*) as total'))
            ->where('uid', $userId)
            ->groupBy('phase')
            ->get();

        return view('reports.index', compact(
            'total',
            'completed',
            'overdue',
            'highPriority',
            'inProgress',
            'nextDeadline',
            'statusBreakdown'
        ));
    }
}
