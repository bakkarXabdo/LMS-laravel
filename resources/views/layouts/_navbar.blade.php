<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Application') }}
        </a>
        <div class="btn-group">
            @auth
                <button type="button" class="btn btn-transparent btn-outline-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}
                </button>
                <div class="dropdown-menu">
                    <form action="{{ route('logout') }}" method="post">@csrf<button type="submit" class="dropdown-item">خروج</button></form>
                    <a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a>
                    <a class="dropdown-item" href="{{ route('settings') }}">Settings</a>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-transparent mr-1">
                    دخول
                </a>
            @endauth
        </div>
    </div>
</nav>
