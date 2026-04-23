<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    /**
     * PUBLIC: List and search projects.
     * Supports:
     * - Search by title or start_date
     * - Filter by phase
     * - Sort by start_date
     * - Pagination with preserved filters
     *
     * Performance:
     * - Eager loads user to avoid N+1 queries
     */
    public function index(Request $request)
    {
        $query = Project::with('user'); // eager loading

        // Search by title or exact start date
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('start_date', $search);
            });
        }

        // Filter by phase
        if ($request->filled('phase')) {
            $query->where('phase', $request->phase);
        }

        // Sort by start date
        if ($request->filled('sort')) {
            $query->orderBy('start_date', $request->sort);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        // Keep filters when paginating
        $projects = $query->paginate(10)->withQueryString();

        return view('projects.index', compact('projects'));
    }

    /**
     * AUTH: Show create form.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * AUTH: Store new project.
     *
     * Security:
     * - Form Request Validation (StoreProjectRequest)
     * - CSRF protection (Blade)
     * - SQL injection protection (Eloquent)
     */
    public function store(StoreProjectRequest $request)
    {
        Project::create([
            'uid'               => auth()->id(),
            'title'             => $request->title,
            'short_description' => $request->short_description,
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
            'phase'             => $request->phase,
        ]);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * PUBLIC: Show project details.
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * AUTH: Edit form (owner only).
     *
     * Security:
     * - Authorisation via ProjectPolicy
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }

    /**
     * AUTH: Update project.
     *
     * Security:
     * - Form Request Validation (UpdateProjectRequest)
     * - Authorisation via ProjectPolicy
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);

        $project->update([
            'title'             => $request->title,
            'short_description' => $request->short_description,
            'start_date'        => $request->start_date,
            'end_date'          => $request->end_date,
            'phase'             => $request->phase,
        ]);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * AUTH: Delete project.
     *
     * Security:
     * - Authorisation via ProjectPolicy
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
