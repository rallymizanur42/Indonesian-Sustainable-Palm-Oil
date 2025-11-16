<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" href="{{ asset('image/logo-ispo.jpg') }}" type="jpg">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <style>
        /* CSS Styling */
        :root {
            --primary-color: #2c7c3d; /* Green for sustainability */
            --secondary-color: #f5a623; /* Gold for palm oil */
            --light-bg: #f8fafc;
            --card-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            --hover-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            --footer-bg: #1a3e23;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-bg);
            color: #2d3748;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        /* Navbar Styling */
        .navbar {
            background: rgba(255, 255, 255, 0.98) !important;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
            padding: 0.8rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .navbar-brand i {
            margin-right: 10px;
            font-size: 1.3rem;
            color: var(--primary-color);
        }
        
        .navbar-brand:hover {
            transform: translateY(-2px);
            color: var(--secondary-color);
        }
        
        /* Common Nav Link Styling */
        .nav-link, .dropdown-toggle {
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: #4a5568 !important;
            margin: 0 0.2rem;
        }
        
        .nav-link:hover, .dropdown-toggle:hover {
            color: white !important;
            background: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .nav-link.active, .dropdown-toggle.active {
            color: white !important;
            background: var(--primary-color);
            box-shadow: 0 4px 15px rgba(44, 124, 61, 0.3);
        }
        
        /* Main Content */
        #app {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        main {
            flex: 1;
            padding: 2rem 0;
        }
        
        /* Dropdown Menu */
        .dropdown-menu {
            border: none;
            border-radius: 10px;
            box-shadow: var(--card-shadow);
            padding: 0.5rem;
        }
        
        .dropdown-item {
            border-radius: 6px;
            padding: 0.5rem 1rem;
            transition: all 0.2s ease;
            color: #333;
        }
        
        .dropdown-item:hover {
            background: var(--primary-color);
            color: white !important;
            transform: translateX(5px);
        }
        
        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.3rem;
            }
            
            .nav-link {
                margin: 0.2rem 0;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="fas fa-leaf"></i>
                    ISPO
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        @auth
                        @if (Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                                   href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-chart-line me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/informasi*') ? 'active' : '' }}" 
                                   href="{{ route('admin.informasi.index') }}"> 
                                    <i class="fa-solid fa-file me-1"></i> Informasi
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/pemetaan*') ? 'active' : '' }}"
                                   href="{{ route('admin.pemetaan.index') }}">
                                    <i class="fa-solid fa-globe me-1"></i> Pemetaan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('admin/kriteria*') ? 'active' : '' }}"
                                   href="{{ route('admin.kriteria.index') }}">
                                    <i class="fa-solid fa-clipboard-list me-1"></i> Kriteria ISPO
                                </a>
                            </li>
                        @elseif (Auth::user()->isPekebun())
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('pekebun/dashboard') ? 'active' : '' }}"
                                   href="{{ route('pekebun.dashboard') }}">
                                    <i class="fas fa-chart-line me-1"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('pekebun/pemetaan/*-all') ? 'active' : '' }}"
                                   href="{{ route('pekebun.pemetaan.map-all') }}">
                                    <i class="fa-solid fa-globe me-1"></i> Pemetaan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('pekebun/dss*') ? 'active' : '' }}"
                                   href="{{ route('pekebun.dss.index') }}">
                                    <i class="fa-solid fa-brain me-1"></i> Sistem Pendukung Keputusan
                                </a>
                            </li>
                        @endif
                        @endauth
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('login') ? 'active' : '' }}" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt me-1"></i> {{ __('Login') }}
                                    </a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->is('register') ? 'active' : '' }}" href="{{ route('register') }}">
                                        <i class="fas fa-user-plus me-1"></i> {{ __('Register') }}
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> {{ __('Logout') }}
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

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    
    <!-- Custom JavaScript (optional) -->
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>