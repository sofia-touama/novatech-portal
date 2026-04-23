@extends('layouts.app')

@section('title', 'All Projects')
@section('containerClass', 'wide-container')

@section('content')

<div class="fade-in">

    <h1 class="page-title">All Projects</h1>

    <div class="form-container">

        {{-- Filters --}}
        <div class="filters-bar">
            <form action="{{ route('projects.index') }}" method="GET" class="filters-form">

                <input 
                    type="text" 
                    name="search" 
                    placeholder="Search by title or start date…" 
                    value="{{ request('search') }}"
                    class="filter-input"
                >

                <select name="phase" class="filter-select">
                    <option value="">Phase</option>
                    <option value="design"      {{ request('phase') == 'design' ? 'selected' : '' }}>Design</option>
                    <option value="development" {{ request('phase') == 'development' ? 'selected' : '' }}>Development</option>
                    <option value="testing"     {{ request('phase') == 'testing' ? 'selected' : '' }}>Testing</option>
                    <option value="deployment"  {{ request('phase') == 'deployment' ? 'selected' : '' }}>Deployment</option>
                    <option value="complete"    {{ request('phase') == 'complete' ? 'selected' : '' }}>Complete</option>
                </select>

                <select name="sort" class="filter-select">
                    <option value="">Sort by Start Date</option>
                    <option value="asc"  {{ request('sort') == 'asc' ? 'selected' : '' }}>Earliest First</option>
                    <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Latest First</option>
                </select>

                <button type="submit" class="filter-apply">Apply</button>
            </form>
        </div>
        {{-- End Filters --}}

        {{-- Empty State --}}
        @if ($projects->isEmpty())
            <div class="empty-state text-center py-5 text-muted">
                <h5 class="fw-semibold mb-1">No projects found</h5>
                <p class="mb-3">Try adjusting your filters.</p>

                @auth
                    <a href="{{ route('projects.create') }}" class="btn btn-primary">
                        Add Your First Project
                    </a>
                @endauth
            </div>
        @else

            {{-- Projects Table --}}
            <table class="projects-table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Start Date</th>
                        <th>Description</th>
                        <th>Phase</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($projects as $project)
                        <tr>
                            <td>{{ $project->title }}</td>

                            <td>{{ $project->formatted_start_date }}</td>

                            <td>{{ $project->short_description }}</td>

                            <td>
                                <span class="badge
                                    {{ $project->phase == 'design' ? 'badge-pending' : '' }}
                                    {{ in_array($project->phase, ['development','testing','deployment']) ? 'badge-progress' : '' }}
                                    {{ $project->phase == 'complete' ? 'badge-completed' : '' }}">
                                    {{ $project->status_label }}
                                </span>
                            </td>

                            <td class="table-actions text-end">

                                {{-- Everyone can view --}}
                                <a href="{{ route('projects.show', $project) }}" class="action-btn view-btn">
                                    View
                                </a>

                                {{-- Only owner can edit/delete --}}
                                @can('update', $project)
                                    <a href="{{ route('projects.edit', $project) }}" class="action-btn edit-btn">
                                        Edit
                                    </a>

                                    <form action="{{ route('projects.destroy', $project) }}"
                                          method="POST"
                                          class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')

                                        <button 
                                            type="submit" 
                                            class="action-btn delete-btn"
                                            onclick="return confirm('Are you sure you want to delete this project? This action cannot be undone.')"
                                        >
                                            Delete
                                        </button>
                                    </form>
                                @endcan

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination --}}
            <div class="pagination-container">
                {{ $projects->links() }}
            </div>

        @endif

    </div>

</div>

@endsection


