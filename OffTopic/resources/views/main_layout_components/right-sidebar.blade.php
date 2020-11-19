<div class="right-sidebar-wrapper col-3 px-0 m-0">
    <div class="first-row-user-buttons row  p-0 m-0 border-bottom">
        @guest
            <div class="col d-flex align-items-center justify-content-around">
                <a href="{{ route('login') }}" class="btn btn-light">Login</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-light">Register</a>
                @endif
            </div>
        @else
            <div class="col d-flex align-items-center justify-content-around">
                <a href="{{ url('users/profile', Auth::user()->id) }}" class="btn btn-light">{{ Auth::user()->name }} Profile</a>
                <a href="{{ route('logout') }}" class="btn btn-light" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        @endguest
    </div>
    <div class="second-row-tables row text-center">

    </div>
</div>