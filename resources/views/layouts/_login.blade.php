@auth
    <form id="logoutForm" class="navbar-light" action="{{ route('logout') }}" method="post">
        @csrf
        <ul class="nav navbar-nav navbar-right">
            <li><a href="#">{{ Auth::user()->Name }}</a></li>
            <li><a href="javascript:document.getElementById('logoutForm').submit()">خروج</a></li>
        </ul>
    </form>
@else
    <ul class="nav navbar-nav navbar-right">
        <li><a id="loginLink" href="{{ route('login') }}">دخول</a></li>
    </ul>
@endauth

