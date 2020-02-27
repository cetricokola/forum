<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Forum') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        Browse
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="/threads" class="dropdown-item">All Threads</a>
                        @if (auth()->check())
                            <a href="/threads?by={{ auth()->user()->name }}" class="dropdown-item">My Threads</a>
                        @endif
                        <a href="/threads?popular=1" class="dropdown-item">Popular Threads</a>
                        <a href="/threads?unanswered=1" class="dropdown-item">Unanswered Threads</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        Channels
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach ($channels as $channel)
                            <a href="/threads/{{ $channel->slug }}" class="dropdown-item">{{ $channel->name }}</a>
                        @endforeach
                    </div>
                </li>
                <li class="nav-item">
                    <a href="/threads/create" class="nav-link">New Thread</a>
                </li>
            </ul>
            <ul class="nav navbar-nav">
                @if (Auth::guest())
                    <li class="nav-item"><a href="{{ route('login') }}" class="mr-5">Login</a></li>
                    <li class="nav-item"><a href="{{ route('register') }}" class="btn-primary btn btn-sm">Register</a></li>
                @else
                    <user-notifications></user-notifications>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                           data-toggle="dropdown"
                           aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                            <a href="{{ route('profile', Auth::user()) }}" class="dropdown-item">My Profile</a>

                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                               class="dropdown-item">
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
