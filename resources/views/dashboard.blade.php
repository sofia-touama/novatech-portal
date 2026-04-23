@extends('layouts.app')

@section('title', 'Dashboard')

@section('containerClass', 'wide-container')

@section('content')

<h1>Dashboard</h1>

<div class="form-container">

    <div class="dashboard-header">
        <h2>Welcome back, {{ auth()->user()->name }}.</h2>
        <p>You can manage your projects using the navigation on the left.</p>
    </div>

    <div class="inside-container">

        <div class="dashboard-cards">

            <div class="card">
                <h3>{{ $totalProjects }}</h3>
                <p>Total Projects</p>
            </div>

            <div class="card">
                <h3>{{ $completedProjects }}</h3>
                <p>Completed</p>
            </div>

        </div>

        <a href="{{ route('projects.index') }}" class="view-link">
            View all projects →
        </a>

    </div>

</div>

@endsection

