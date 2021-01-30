@auth
    <form id="logoutForm" class="navbar-light" action="{{ route('logout') }}" method="post">
        @csrf
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="{{ route('user.manage') }}" title="Manage Account">Hello {{ Auth::user()->username }}</a>
            </li>
            <li><a href="javascript:document.getElementById('logoutForm').submit()">Log off</a></li>
        </ul>
    </form>
@else
    <ul class="nav navbar-nav navbar-right">
        <li><a id="loginLink" href="{{ route('login') }}">Log In</a></li>
    </ul>
@endauth