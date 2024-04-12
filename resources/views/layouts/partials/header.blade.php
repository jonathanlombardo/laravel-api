<header class="py-3 bg-primary text-white">
  <div class="container d-flex justify-content-between align-items-center">

    <a class="h4" href="{{ route('guest.index') }}">{{ env('APP_NAME', 'NewProject') }}</a>
    <nav>
      <ul class="d-flex align-items-center gap-3">
        <li><a href="{{ route('guest.index') }}">Home</a></li>
        @guest
          <li class="nav-item">
            <a class="nav-link" href="{{ route('login') }}">Login</a>
          </li>
          @if (Route::has('register'))
            <li class="nav-item">
              <a class="nav-link" href="{{ route('register') }}">Register</a>
            </li>
          @endif
        @else
          <li><a href="{{ route('admin.projects.index') }}">Projects</a></li>
          <li><a href="{{ route('admin.types.index') }}">Types</a></li>
          <li><a href="{{ route('admin.technologies.index') }}">Technologies</a></li>

          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
              {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
              <a class="dropdown-item" href="{{ route('auth.profile.edit') }}">Profile</a>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
    </nav>
  </div>
</header>
