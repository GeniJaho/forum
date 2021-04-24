<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>


        <a class="navbar-brand" href="{{ route('threads.create') }}">
            New Thread
        </a>

        <div class="dropdown show">
            <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                Browse
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="{{ route('threads.index') }}">
                    All Threads
                </a>
                @if(auth()->check())
                    <a class="dropdown-item" href="{{ route('threads.index', ['by' => auth()->user()->name]) }}">
                        My Threads
                    </a>
                @endif

                <a class="dropdown-item" href="{{ route('threads.index', ['popular' => 1]) }}">
                    Popular Threads
                </a>

                <a class="dropdown-item" href="{{ route('threads.index', ['unanswered' => 1]) }}">
                    Unanswered Threads
                </a>
            </div>
        </div>

        <div class="dropdown show">
            <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
               aria-haspopup="true" aria-expanded="false">
                Channels
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                @foreach($channels as $channel)
                    <a class="dropdown-item" href="{{ route('threads.channel', ['channel' => $channel->slug]) }}">
                        {{ $channel->name }}
                    </a>
                @endforeach
            </div>
        </div>


        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ auth()->user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('profile', auth()->user()) }}">
                                {{ __('My Profile') }}
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
