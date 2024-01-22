@php 
  use App\Http\Controllers\HelperController;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard 2</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="{{ asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback') }}">
  <!-- Font Awesome Icons -->
  {{-- <link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css') }}"> --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('/dist/css/adminlte.min.css') }}">
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.16.22/dist/css/uikit.min.css" />

  <!-- UIkit JS -->
  <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.22/dist/js/uikit.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/uikit@3.16.22/dist/js/uikit-icons.min.js"></script>
  @vite(['resources/scss/app.scss'])
  @vite(['resources/scss/admin/app.scss'])
  @stack('styles')
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__wobble" src="{{ asset('/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="/" class="nav-link">Go to site</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <!-- <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li> -->

        <!-- todo -->
        <!-- Messages Dropdown Menu -->
        <!-- <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-comments"></i>
            <span class="badge badge-danger navbar-badge">3</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <a href="#" class="dropdown-item">
              
              <div class="media">
                <img src="{{ asset('/dist/img/user1-128x128.jpg') }}" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Brad Diesel
                    <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">Call me whenever you can...</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              
              <div class="media">
                <img src="{{ asset('/dist/img/user8-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    John Pierce
                    <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">I got your message bro</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              
              <div class="media">
                <img src="{{ asset('/dist/img/user3-128x128.jpg') }}" alt="User Avatar" class="img-size-50 img-circle mr-3">
                <div class="media-body">
                  <h3 class="dropdown-item-title">
                    Nora Silvester
                    <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                  </h3>
                  <p class="text-sm">The subject goes here</p>
                  <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                </div>
              </div>
              
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
          </div>
        <!-- </li> --> 
        <!-- todo -->
        <!-- Notifications Dropdown Menu -->
        <!-- <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge">15</span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li> -->
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{ route('admin.index') }}" class="brand-link">
        <img src="{{ asset('/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <!-- <img src="{{ asset('/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image"> -->
            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="img-circle elevation-2"
            height="100px" width="100px" version="1.1" id="Capa_1" viewBox="0 0 16.377 16.377" xml:space="preserve">
              <g>
                <g>
                  <path style="fill:#030104;" d="M4.331,5.043c0.042,0.256,0.141,0.417,0.238,0.52c0.231,1.54,1.521,2.97,2.698,2.97    c1.373,0,2.623-1.547,2.865-2.967c0.098-0.101,0.199-0.264,0.242-0.522c0.078-0.289,0.18-0.791,0.002-1.025    c-0.01-0.012-0.02-0.023-0.029-0.034c0.166-0.606,0.377-1.858-0.375-2.711C9.906,1.188,9.486,0.686,8.585,0.42L8.158,0.271    C7.45,0.052,7.004,0.004,6.986,0.001c-0.031-0.003-0.065,0-0.096,0.008C6.865,0.016,6.782,0.038,6.716,0.03    C6.547,0.006,6.293,0.093,6.248,0.11c-0.06,0.023-1.43,0.573-1.846,1.849C4.363,2.063,4.197,2.605,4.418,3.936    C4.385,3.958,4.355,3.985,4.33,4.019C4.152,4.253,4.252,4.754,4.331,5.043z M4.869,2.141C4.872,2.135,4.874,2.128,4.877,2.12    c0.339-1.052,1.541-1.538,1.549-1.542c0.055-0.021,0.162-0.051,0.219-0.051c0.118,0.016,0.254-0.005,0.328-0.022    C7.094,0.522,7.47,0.583,8.001,0.747l0.432,0.148c0.801,0.237,1.141,0.681,1.143,0.684c0.006,0.007,0.012,0.013,0.016,0.019    c0.695,0.783,0.338,2.079,0.211,2.457C9.774,4.144,9.795,4.242,9.86,4.308c0.033,0.034,0.072,0.057,0.115,0.069    C9.977,4.5,9.942,4.725,9.887,4.922C9.885,4.931,9.883,4.941,9.881,4.95C9.86,5.089,9.813,5.19,9.75,5.236    c-0.053,0.04-0.09,0.101-0.1,0.167c-0.166,1.19-1.268,2.629-2.382,2.629c-0.938,0-2.055-1.325-2.213-2.624    C5.047,5.34,5.012,5.279,4.956,5.238c-0.063-0.048-0.11-0.15-0.131-0.287c-0.001-0.01-0.003-0.02-0.006-0.029    C4.768,4.739,4.735,4.53,4.732,4.404c0.047-0.005,0.094-0.021,0.134-0.053c0.074-0.058,0.11-0.152,0.092-0.245    C4.683,2.662,4.869,2.141,4.869,2.141z"/>
                  <path style="fill:#030104;" d="M12.224,9.363c-0.738-0.487-1.855-0.84-1.855-0.84C9.248,8.127,9.24,7.733,9.24,7.733    c-2.203,4.344-3.876,0.014-3.876,0.014C5.21,8.333,2.941,9.021,2.941,9.021C2.278,9.275,1.998,9.657,1.998,9.657    c-0.98,1.454-1.096,4.689-1.096,4.689c0.013,0.739,0.332,0.816,0.332,0.816c2.254,1.006,5.792,1.185,5.792,1.185    c0.985,0.021,1.894-0.047,2.701-0.154c-0.773-0.723-1.262-1.748-1.262-2.887C8.464,11.192,10.134,9.465,12.224,9.363z"/>
                  <path style="fill:#030104;" d="M12.269,9.963c-1.768,0-3.207,1.438-3.207,3.207c0,1.771,1.439,3.207,3.207,3.207    c1.77,0,3.207-1.437,3.207-3.207C15.476,11.402,14.038,9.963,12.269,9.963z M12.058,14.747c-0.068,0.067-0.178,0.067-0.246,0    l-1.543-1.555c-0.068-0.066-0.068-0.178,0-0.245l0.369-0.369c0.068-0.067,0.178-0.067,0.246,0l1.053,1.061l2.045-2.044    c0.066-0.068,0.178-0.068,0.246,0l0.367,0.367c0.068,0.068,0.068,0.18,0,0.248L12.058,14.747z"/>
                </g>
              </g>
            </svg>
          </div>
          <div class="info">
            <a href="#" class="d-block">{{ HelperController::getAdminUser()['name'] }}</a>
          </div>
        </div>

        <!-- todo -->
        <!-- SidebarSearch Form -->
        <!-- <div class="form-inline">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-sidebar">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div> -->

        <!-- Sidebar Menu -->
        @include('inc.admin.sidebar')
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">