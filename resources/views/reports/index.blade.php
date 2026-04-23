@extends('layouts.app')

@section('title', 'Project Reports')
@section('containerClass', 'wide-container')

@section('content')

<div class="fade-in">

    <h1>Project Reports</h1>

    <div class="form-container">

        {{-- ============================
             OVERVIEW CARDS
        ============================ --}}
        <h2>Overview</h2>

        <div class="overview-cards">

            <div class="card">
                <h3>{{ $total }}</h3>
                <p>Total Projects</p>
            </div>

            <div class="card">
                <h3>{{ $completed }}</h3>
                <p>Completed</p>
            </div>

            <div class="card overdue">
                <h3>{{ $overdue }}</h3>
                <p>Overdue</p>
            </div>

            <div class="card">
                <h3>{{ $inProgress }}</h3>
                <p>In Development/Testing</p>
            </div>

            <div class="card">
                @if($nextDeadline)
                    <h3>{{ \Carbon\Carbon::parse($nextDeadline->end_date)->format('d M Y') }}</h3>
                    <p>Next Deadline</p>
                @else
                    <h3>—</h3>
                    <p>Next Deadline</p>
                @endif
            </div>

        </div>

        {{-- ============================
             PHASE BREAKDOWN TABLE
        ============================ --}}
        <h2>Phase Breakdown</h2>

        <table class="projects-table">
            <thead>
                <tr>
                    <th>Phase</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                @foreach($statusBreakdown as $row)
                    <tr>
                        <td>{{ ucfirst($row->phase) }}</td>
                        <td>{{ $row->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ============================
             VISUAL BREAKDOWN (CHARTS)
             — placed last for better flow
        ============================ --}}
        <h2>Visual Breakdown</h2>

        <div class="chart-row">

            <div class="chart-box-small">
                <canvas id="phaseChart"></canvas>
            </div>

            <div class="chart-box-medium">
                <canvas id="completionChart"></canvas>
            </div>

        </div>

    </div>

</div>

{{-- ============================
     CHART.JS SCRIPT
============================ --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const phaseLabels = @json($statusBreakdown->pluck('phase')->map(fn($p) => ucfirst($p)));
    const phaseData = @json($statusBreakdown->pluck('total'));

    const phaseColors = [
        '#C68B59', '#A06A3B', '#E8C7A1', '#D6B08C', '#8C6A59'
    ];

    new Chart(document.getElementById('phaseChart'), {
        type: 'pie',
        data: {
            labels: phaseLabels,
            datasets: [{
                data: phaseData,
                backgroundColor: phaseColors,
                borderWidth: 1,
                borderColor: '#fff'
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Projects by Phase',
                    font: { size: 18 }
                }
            }
        }
    });

    new Chart(document.getElementById('completionChart'), {
        type: 'bar',
        data: {
            labels: ['Completed', 'Overdue', 'In Progress'],
            datasets: [{
                label: 'Project Count',
                data: [{{ $completed }}, {{ $overdue }}, {{ $inProgress }}],
                backgroundColor: ['#2E7D32', '#B55252', '#1565C0']
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Completion Status Overview',
                    font: { size: 18 }
                }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

@endsection


