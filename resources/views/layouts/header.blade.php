<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
      <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
          <a href="{{ url('/home') }}" class="nav-link {{ ($activeMenu == 'home') ? 'active' : '' }}">Home</a>
      </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
      <!-- User profile dropdown -->
      <li class="nav-item dropdown user-menu">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
              <img
                  src="{{ auth()->user()->photo_profile ? asset('storage/' . auth()->user()->photo_profile) : asset('adminlte/dist/img/default-profile.jpg') }}"
                  class="user-image img-circle elevation-1" alt="User Image">
              <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
          </a>
          <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
              <!-- User image -->
              <li class="user-header bg-primary">
                  <img
                      src="{{ auth()->user()->photo_profile ? asset('storage/' . auth()->user()->photo_profile) : asset('adminlte/dist/img/default-profile.jpg') }}"
                      class="img-circle elevation-2" alt="User Image">
                  <p>
                      {{ auth()->user()->name }}
                      <small>{{ auth()->user()->level->level_kode ?? 'User' }}</small>
                  </p>
              </li>
              <!-- Menu Footer -->
              <li class="user-footer">
                  <a href="#" class="btn btn-warning btn-flat float-right"
                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      Logout
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
              </li>
          </ul>
      </li>
  </ul>
</nav>