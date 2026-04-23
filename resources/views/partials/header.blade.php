<div class="topbar">
    <div class="topbar-left">
        <span class="app-title">NovaTech Portal</span>
    </div>

    <div class="topbar-right">
        <span class="welcome-text">Welcome {{ auth()->user()->name }}</span>

        <button class="logout-button"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </button>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>
</div>
