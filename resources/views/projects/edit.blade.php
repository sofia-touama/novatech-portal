@extends('layouts.app')

@section('title', 'Edit Project')

@section('containerClass', 'form-narrow')

@section('content')

<h1>Edit Project</h1>

<div class="form-container">

    <form method="POST" action="{{ route('projects.update', $project) }}" novalidate>
        @csrf
        @method('PUT')

        <label for="title">Title</label>
        <input 
            type="text" 
            id="title" 
            name="title" 
            value="{{ old('title', $project->title) }}" 
            required
        >

        <label for="short_description">Short Description</label>
        <textarea 
            id="short_description" 
            name="short_description" 
            required
        >{{ old('short_description', $project->short_description) }}</textarea>

        <label for="start_date">Start Date</label>
        <input 
            type="date" 
            id="start_date" 
            name="start_date" 
            value="{{ old('start_date', $project->start_date) }}" 
            required
        >

        <label for="end_date">End Date</label>
        <input 
            type="date" 
            id="end_date" 
            name="end_date" 
            value="{{ old('end_date', $project->end_date) }}"
        >

        <label for="phase">Phase</label>
        <select id="phase" name="phase" required>
            @foreach(['design','development','testing','deployment','complete'] as $phase)
                <option 
                    value="{{ $phase }}" 
                    {{ old('phase', $project->phase) === $phase ? 'selected' : '' }}
                >
                    {{ ucfirst($phase) }}
                </option>
            @endforeach
        </select>

        <button type="submit">Update</button>
    </form>

</div>

@endsection

