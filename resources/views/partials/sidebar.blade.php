<div class="sidebar">
    <h2>NovaTech Portal</h2>

    {{-- Guest navigation (public users) --}}
    @guest
        <a href="{{ route('projects.index') }}"
           class="{{ request()->routeIs('projects.index') ? 'active' : '' }}">
            All Projects
        </a>

        <a href="{{ route('login') }}"
           class="{{ request()->routeIs('login') ? 'active' : '' }}">
            Login
        </a>

        <a href="{{ route('register') }}"
           class="{{ request()->routeIs('register') ? 'active' : '' }}">
            Register
        </a>
    @endguest

    {{-- Authenticated navigation --}}
    @auth
        <a href="{{ route('dashboard') }}"
           class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            Dashboard
        </a>

        <a href="{{ route('projects.index') }}"
           class="{{ request()->routeIs('projects.index') ? 'active' : '' }}">
            All Projects
        </a>

        <a href="{{ route('projects.create') }}"
           class="new-project {{ request()->routeIs('projects.create') ? 'active' : '' }}">
            New Project
        </a>

        <a href="{{ route('reports.index') }}"
           class="{{ request()->routeIs('reports.index') ? 'active' : '' }}">
            Project Reports
        </a>

        <form action="{{ route('logout') }}" method="POST" class="logout-link">
            @csrf
            <button>
                <span class="logout-icon">⏻</span>
                Logout
            </button>
        </form>
    @endauth
</div>
