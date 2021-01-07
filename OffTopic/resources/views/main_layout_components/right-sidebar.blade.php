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
                <a href="{{ url('users/profile', Auth::user()->id) }}" class="btn btn-light">{{ Auth::user()->name }} Profile <span class="notifications-count badge bg-success">{{ $notificationsCount }}</span></a>
                <a href="{{ url('/users/profile') }}" class="btn btn-danger"><i class="fas fa-search"></i></a>
                <a href="{{ route('logout') }}" class="btn btn-light" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        @endguest
    </div>
    <div class="second-row-tables row p-0 m-0">
        @if(count($friends) > 0)
            <p class="mx-auto pt-1">Friends ( <span class="friends-count">{{ count($friends) }}</span> )</p>
            <div class="friends-card w-100">
                <ul class="friend-list list-group list-group-flush">
                    @foreach($friends as $friend)
                        <li class="list-group-item d-flex align-items-center justify-content-between text-white bg-dark">
                            <a href="{{ url('/users/profile', $friend->id) }}" class="text-info">{{ $friend->name }}</a>
                            <button id="{{ $friend->id }}" class="unfriend-btn btn btn-danger">Unfriend</button>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            @if(Auth::check())
                <p class="w-100 d-flex justify-content-center mt-4">You still dont have friends.</p>
            @else
                <p class="w-100 d-flex justify-content-center mt-4">Login and create some friends :)</p>
            @endif
        @endif
    </div>
    <input type="hidden" value="{{url('/')}}" id="url" name="url">
</div>