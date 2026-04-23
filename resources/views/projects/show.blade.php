@extends('layouts.app')

@section('title', $project->title)

@section('containerClass', 'wide-container')

@section('content')

<h1>Project Details</h1>

<div class="form-container">

    <h2>{{ $project->title }}</h2>
    <p>{{ $project->short_description }}</p>

    <p><strong>Created by:</strong> {{ $project->user->email }}</p>

    <p><strong>Start Date:</strong> {{ $project->start_date }}</p>
    <p><strong>End Date:</strong> {{ $project->end_date ?? 'Not set' }}</p>

    <p><strong>Phase:</strong>
        <span class="badge
            {{ $project->phase == 'design' ? 'badge-pending' : '' }}
            {{ in_array($project->phase, ['development','testing','deployment']) ? 'badge-progress' : '' }}
            {{ $project->phase == 'complete' ? 'badge-completed' : '' }}">
            {{ ucfirst($project->phase) }}
        </span>
    </p>

    <div style="margin-top:20px; display:flex; gap:10px;">

        {{-- Only show Edit/Delete if logged in AND owner --}}
        @auth
            @if(auth()->id() === $project->uid)

                <a href="{{ route('projects.edit', $project) }}">
                    <button>Edit Project</button>
                </a>

                <form action="{{ route('projects.destroy', $project) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button 
                        type="submit" 
                        class="delete-btn"
                        onclick="return confirm('Are you sure you want to delete this project? This action cannot be undone.')"
                    >
                        Delete
                    </button>
                </form>

            @endif
        @endauth

        <a href="{{ route('projects.index') }}">
            <button>Back to Projects</button>
        </a>

    </div>

</div>

@endsection
