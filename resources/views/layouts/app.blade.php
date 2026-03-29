<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'EUVerify | The Digital Notary')</title>
    <link rel="stylesheet" href="/css/app.css">
    @if(request()->is('admin*'))
        <link rel="stylesheet" href="/css/dashboard.css">
    @endif
    @if(auth()->check() && auth()->user()->role === \App\Enums\UserRole::Manufacturer)
        <link rel="stylesheet" href="/css/manufacturer_dashboard.css">
    @endif
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="{{ request()->is('admin*') ? 'admin-dashboard' : (auth()->check() && auth()->user()->role === \App\Enums\UserRole::Manufacturer ? 'manufacturer-portal' : '') }}">
    @if(auth()->check() && auth()->user()->role === \App\Enums\UserRole::Admin && request()->is('admin*'))
        <div class="admin-layout">
            <!-- Admin Sidebar -->
            <aside class="admin-sidebar">
                <div class="sidebar-brand">
                    <h2>EUVerify</h2>
                    <span>ADMIN PORTAL</span>
                </div>
                
                <nav class="sidebar-menu">
                    <a href="{{ route('admin.dashboard') }}" class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i data-lucide="layout-grid"></i> Dashboard
                    </a>
                    <a href="{{ route('admin.products.queue') }}" class="menu-item">
                        <i data-lucide="box"></i> Products Queue
                    </a>

                    <a href="{{ route('admin.categories.index') }}" class="menu-item">
                        <i data-lucide="layers"></i> Categories
                    </a>
                    <a href="{{ route('admin.ar-addresses.index') }}" class="menu-item">
                        <i data-lucide="map-pin"></i> AR Addresses
                    </a>
                    <a href="#" class="menu-item">
                        <i data-lucide="clipboard-list"></i> Audit Log
                    </a>
                </nav>



                <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
                    @csrf
                    <button type="submit" class="menu-item" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer; color: #EF4444; opacity: 0.8;">
                        <i data-lucide="log-out"></i> Sign Out
                    </button>
                </form>
            </aside>

            <!-- Admin Main -->
            <div class="admin-container">
                <header class="admin-header">
                    <div class="header-title">
                        <h1>@yield('header')</h1>
                    </div>
                    <div class="header-actions">
                        <div class="action-icons">
                            <button class="icon-btn">
                                <i data-lucide="bell"></i>
                                <span class="dot"></span>
                            </button>
                            <button class="icon-btn">
                                <i data-lucide="help-circle"></i>
                            </button>
                        </div>
                        <div class="user-profile">
                            <div class="user-info">
                                <span class="user-name">{{ auth()->user()->name }}</span>
                                <span class="user-role">Global Admin</span>
                            </div>
                            <img src="/images/admin_avatar.png" alt="Avatar" class="user-avatar">
                        </div>
                    </div>
                </header>

                <main class="admin-main">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-error">{{ session('error') }}</div>
                    @endif
                    
                    @yield('content')
                </main>
            </div>
        </div>
    @elseif(auth()->check() && auth()->user()->role === \App\Enums\UserRole::Manufacturer)
        <div class="manufacturer-layout">
            <!-- Modern Manufacturer Sidebar -->
            <aside class="manufacturer-sidebar">
                <div class="sidebar-brand-box">
                    <div class="brand-icon">
                        <i data-lucide="shield-check" style="width: 24px; height: 24px;"></i>
                    </div>
                    <div class="brand-text">
                        <h2>EUVerify</h2>
                        <span>MANUFACTURER PORTAL</span>
                    </div>
                </div>
                
                <nav class="sidebar-nav-list">
                    @if(auth()->user()->company && auth()->user()->company->status == 1)
                        <a href="{{ route('app.dashboard') }}" class="nav-link {{ request()->routeIs('app.dashboard') ? 'active' : '' }}">
                            <div class="nav-link-content">
                                <i data-lucide="layout-grid"></i> Dashboard
                            </div>
                        </a>
                        
                        <a href="{{ route('app.products.index') }}" class="nav-link {{ request()->routeIs('app.products.*') ? 'active' : '' }}">
                            <div class="nav-link-content">
                                <i data-lucide="package"></i> My Products
                            </div>
                        </a>
                        <a href="{{ route('app.brands.index') }}" class="nav-link {{ request()->routeIs('app.brands.*') ? 'active' : '' }}">
                            <div class="nav-link-content">
                                <i data-lucide="award"></i> Brands
                            </div>
                        </a>

                        <a href="{{ route('app.subscription.index') }}" class="nav-link {{ request()->routeIs('app.subscription.*') ? 'active' : '' }}">
                            <div class="nav-link-content">
                                <i data-lucide="credit-card"></i> Subscription
                            </div>
                        </a>
                        
                        <a href="{{ route('app.notifications.index') }}" class="nav-link {{ request()->routeIs('app.notifications.index') ? 'active' : '' }}">
                            <div class="nav-link-content">
                                <i data-lucide="bell"></i> Notifications
                            </div>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="nav-badge">{{ auth()->user()->unreadNotifications->count() }}</span>
                            @endif
                        </a>
                    @endif

                    <a href="{{ auth()->user()->company ? route('app.company.edit', auth()->user()->company->id) : route('app.company.create') }}" class="nav-link {{ request()->routeIs('app.company.*') ? 'active' : '' }}">
                        <div class="nav-link-content">
                            <i data-lucide="building-2"></i> Company Profile
                        </div>
                    </a>
                </nav>

                <div class="sidebar-user-card" style="margin-top: auto;">
                    <div class="user-card-main">
                        <div class="company-logo">
                            {{ substr(auth()->user()->company->name ?? auth()->user()->name, 0, 2) }}
                        </div>
                        <div class="user-card-info">
                            <h5 style="margin: 0; font-size: 13px;">{{ auth()->user()->company->name ?? auth()->user()->name }}</h5>
                            <p style="margin: 0; font-size: 11px; color: #64748B;">Standard Partner</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" style="margin-top: 12px;">
                        @csrf
                        <button type="submit" class="logout-link" style="background: none; border: none; padding: 0; cursor: pointer; color: #0052D1; font-weight: 600; font-size: 12px;">Logout</button>
                    </form>
                </div>
            </aside>

            <!-- Modern Manufacturer Main Container -->
            <div style="flex: 1; display: flex; flex-direction: column; overflow-y: auto; background: #F8FAFC; height: 100vh;">
                <!-- Top Bar -->
                <header class="top-bar" style="padding: 24px 48px; display: flex; justify-content: space-between; align-items: center; background: transparent;">
                    <div class="welcome-msg">
                        <h1 style="font-size: 20px; font-weight: 700; color: #00183F; margin: 0;">Welcome back, {{ auth()->user()->company->name ?? auth()->user()->name }}</h1>
                    </div>
                    <div class="top-actions" style="display: flex; align-items: center; gap: 24px;">
                        <div class="top-icons" style="display: flex; gap: 16px; color: #64748B;">
                            <i data-lucide="search" style="width: 20px; height: 20px; cursor: pointer;"></i>
                            <div class="top-icon-btn" style="position: relative;">
                                <i data-lucide="bell" style="width: 20px; height: 20px; cursor: pointer;"></i>
                                <span class="indicator-dot" style="position: absolute; top: -2px; right: -2px; width: 6px; height: 6px; background: #EF4444; border-radius: 50%; border: 2px solid #F8FAFC;"></span>
                            </div>
                            <i data-lucide="help-circle" style="width: 20px; height: 20px; cursor: pointer;"></i>
                        </div>
                        <div class="user-profile">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=00183F&color=fff" alt="Profile" style="width: 32px; height: 32px; border-radius: 8px;">
                        </div>
                    </div>
                </header>

                <main class="manufacturer-main" style="padding: 0 48px 48px 48px;">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-error">{{ session('error') }}</div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    @else
        <div class="app-layout">
            <!-- Standard Sidebar (Legacy/Fallback) -->
            <aside class="sidebar">
                <div class="sidebar-logo">
                    EUVerify
                </div>
                
                <nav class="sidebar-nav">
                    @if(auth()->check() && auth()->user()->role === \App\Enums\UserRole::Admin)
                        <div class="label-sm mt-4">Admin Controls</div>
                        <a href="{{ route('admin.dashboard') }}" class="nav-item">Dashboard</a>
                        <a href="{{ route('admin.products.queue') }}" class="nav-item">Review Queue</a>

                        <a href="{{ route('admin.categories.index') }}" class="nav-item">Categories</a>
                        <a href="{{ route('admin.ar-addresses.index') }}" class="nav-item">AR Addresses</a>
                    @elseif(auth()->check())
                        <div class="label-sm mt-4">Workspace</div>
                        <a href="{{ route('app.dashboard') }}" class="nav-item {{ request()->routeIs('app.dashboard') ? 'active' : '' }}">Overview</a>
                        
                        @if(auth()->user()->company)
                            <a href="{{ route('app.products.index') }}" class="nav-item {{ request()->routeIs('app.products.*') ? 'active' : '' }}">Products</a>
                            <a href="{{ route('app.brands.index') }}" class="nav-item {{ request()->routeIs('app.brands.*') ? 'active' : '' }}">Brands</a>
                            <a href="{{ route('app.company.edit', auth()->user()->company->id) }}" class="nav-item {{ request()->routeIs('app.company.*') ? 'active' : '' }}">Company Profile</a>
                        @endif

                        <div class="label-sm mt-4">Account</div>
                        <a href="{{ route('app.subscription.index') }}" class="nav-item {{ request()->routeIs('app.subscription.*') ? 'active' : '' }}">Subscription</a>
                        <a href="{{ route('app.notifications.index') }}" class="nav-item {{ request()->routeIs('app.notifications.*') ? 'active' : '' }}">
                            Notifications 
                            @if(auth()->user()->unreadNotifications->count() > 0)
                                <span class="badge badge-warning" style="margin-left: 8px;">{{ auth()->user()->unreadNotifications->count() }}</span>
                            @endif
                        </a>
                    @endif
                    
                    @if(auth()->check())
                    <form action="{{ route('logout') }}" method="POST" style="margin-top: auto;">
                        @csrf
                        <button type="submit" class="nav-item" style="background: none; border: none; width: 100%; text-align: left; cursor: pointer;">
                            Sign Out
                        </button>
                    </form>
                    @endif
                </nav>
            </aside>

            <!-- Standard Main Content -->
            <main class="main-content">
                <header class="flex justify-between items-center mb-4">
                    <h1>@yield('header')</h1>
                    @if(auth()->check())
                    <div class="user-meta text-muted">
                        {{ auth()->user()->name }}
                        <div class="label-sm">{{ \App\Enums\UserRole::from(auth()->user()->role->value ?? auth()->user()->role)->name }}</div>
                    </div>
                    @endif
                </header>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error">{{ session('error') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    @endif

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
