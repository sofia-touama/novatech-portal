@extends('layouts.app')

@section('title', 'Create Project')

@section('containerClass', 'form-narrow')

@section('content')

<h1>Create Project</h1>

<div class="form-container">

    <form method="POST" action="{{ route('projects.store') }}" novalidate>
        @csrf

        <label for="title">Title</label>
        <input 
            type="text" 
            id="title" 
            name="title" 
            value="{{ old('title') }}" 
            required
        >

        <label for="short_description">Short Description</label>
        <textarea 
            id="short_description" 
            name="short_description" 
            required
        >{{ old('short_description') }}</textarea>

        <label for="start_date">Start Date</label>
        <input 
            type="date" 
            id="start_date" 
            name="start_date" 
            value="{{ old('start_date') }}" 
            required
        >

        <label for="end_date">End Date</label>
        <input 
            type="date" 
            id="end_date" 
            name="end_date" 
            value="{{ old('end_date') }}"
        >

        <label for="phase">Phase</label>
        <select id="phase" name="phase" required>
            <option value="design"      {{ old('phase') == 'design' ? 'selected' : '' }}>Design</option>
            <option value="development" {{ old('phase') == 'development' ? 'selected' : '' }}>Development</option>
            <option value="testing"     {{ old('phase') == 'testing' ? 'selected' : '' }}>Testing</option>
            <option value="deployment"  {{ old('phase') == 'deployment' ? 'selected' : '' }}>Deployment</option>
            <option value="complete"    {{ old('phase') == 'complete' ? 'selected' : '' }}>Complete</option>
        </select>

        <button type="submit">Create</button>
    </form>

</div>

@endsection
