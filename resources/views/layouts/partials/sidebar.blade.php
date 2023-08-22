<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{route('dashboard')}}" class="brand-link">
    <img src="{{ asset('') }}dist/img/AdminLTELogo.png" alt="Website Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
    <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('') }}dist/img/avatar.png" class="img-circle elevation-2" alt="User Image">
        {{-- <img src="{{ asset('') }}dist/img/profile-avatar-placeholder.jpg" class="img-circle elevation-2"
          alt="User Image"> --}}
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ Auth::guard('web')->user()->name }}</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2 text-capitalize">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="{{route('dashboard')}}" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              dashboard
            </p>
          </a>
        </li>
        {{--all category --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              category
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right">4</span>
            </p>
          </a>
          {{-- category --}}
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{route('category.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('sub-category.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>sub category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="pages/layout/boxed.html" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>child category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{route('brand.index')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>brand</p>
              </a>
            </li>
          </ul>
        </li>

        {{-- Website setting --}}

        {{-- @if(Auth::user()->setting==1) --}}
        <li class="nav-item">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Settings
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('seo.setting') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>SEO Settings</p>
              </a>
            </li>
            <li class="nav-item">
              {{-- <a href="{{ route('website.setting') }}" class="nav-link"> --}}
                <i class="far fa-circle nav-icon"></i>
                <p>Website Setting</p>
              </a>
            </li>
            <li class="nav-item">
              {{-- <a href="{{ route('page.index') }}" class="nav-link"> --}}
                <i class="far fa-circle nav-icon"></i>
                <p>Page Create</p>
              </a>
            </li>
            <li class="nav-item">
              {{-- <a href="{{ route('smtp.setting') }}" class="nav-link"> --}}
                <i class="far fa-circle nav-icon"></i>
                <p>SMTP Setting</p>
              </a>
            </li>
            <li class="nav-item">
              {{-- <a href="{{ route('payment.gateway') }}" class="nav-link"> --}}
                <i class="far fa-circle nav-icon"></i>
                <p>Payment Gateway</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- @endif --}}

        <li class="nav-item menu-open">
          <a href="#" class="nav-link">
            <i class="fa-solid fa-triangle-exclamation text-warning"></i>
            <p>
              important
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right">3</span>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">

              <form id="logout-form" method="POST" action="{{ route('user.logout') }}">
                @csrf
                <a href="#" id="logout" class="nav-link">
                  {{-- Add this code when you are not working with swal --}}
                  {{-- onclick="event.preventDefault();
                  this.closest('form').submit(); --}}
                  <i class="nav-icon far fa-circle text-danger"></i>
                  <p class="text">{{ __('Log Out') }}</p>
                </a>
              </form>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-circle text-warning"></i>
                <p>Warning</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon far fa-circle text-info"></i>
                <p>Informational</p>
              </a>
            </li>
          </ul>

        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>